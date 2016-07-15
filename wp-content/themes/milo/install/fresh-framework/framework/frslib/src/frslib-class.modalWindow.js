"use strict";

(function($){

	frslib.provide('frslib._classes');
	frslib.provide('frslib._instances.modalWindow');

	frslib._classes.modalWindow = function() {


//##############################################################################
//# INHERITANCE
//##############################################################################


		// itself
		var _ = {};
		_._className = 'modalWindow';


//##############################################################################
//#	PARAMS
//##############################################################################


		_.variables = {};

		// jquery $ objects
		_.jquery = {};
		_.jquery.$modalWindow = null;
		_.jquery.$openingButton = null;

		// css selectors
		_.selectors = {
			  modalWindowOpener : '.ff-open-library-button'
			, modalWindow : '.ff-media-modal.ff-modal-library'
			, modalWindowInner : '.media-modal'
			, modalWindowTitle: 'h1'

			, mediaButtonSubmit : '.ff-submit-library-button'
			, mediaButtonCancel : '.ff-cancel-library-button'
			, modalWindowCloserX : '.media-modal-close'
			, modalWindowCloserBG : '.media-modal-backdrop'
		};

		_.classes = {
			  modalOpened : 'ff-modal-opened'
			, modalClosed : 'ff-modal-closed'
		};

		// popups for modal windows
		_.selectors.modalGroupPopupContainer= '.ff-popup-container';
		_.selectors.modalGroupPopupBackdrop = '.ff-popup-backdrop';
		_.selectors.modalGroupPopup         = '.ff-popup';
		_.selectors.modalGroupPopupOpen     = '.ff-popup-open';
		_.classes.modalGroupPopupOpen       = 'ff-popup-open';



//##############################################################################
//# HOOKS
//##############################################################################


		_.hooks = {};

		_.hooks.beforeOpenWindow = {};
		_.hooks.afterOpenWindow = {};

		_.hooks.beforeSubmitWindow = {};
		_.hooks.afterSubmitWindow = {};

		_.hooks.beforeCloseWindow = {};
		_.hooks.afterCloseWindow = {};

		_.hooks.removeValue = {};

//##############################################################################
//# Class Actions
//##############################################################################


		_.initAction = {};
		_.initJqueryAction = {};
		_.bindAction = {};


//##############################################################################
//# INITIALIZATION
//##############################################################################


		// Initializate the object

		_.init = function(){

			frslib._instances.modalWindow[ _._className ] = _;

			$(window).load(function(){
				frslib.callbacks.callAllFunctionsFromArray( _.initAction       );
				frslib.callbacks.callAllFunctionsFromArray( _.initJqueryAction );
				if( 0 == _.jquery.$modalWindow.size() ){
					return;
				}
				frslib.callbacks.callAllFunctionsFromArray( _.bindAction       );
			});
		};


		_.initJqueryAction.modalWindow_initJquery = function() {
			_.jquery.$modalWindow = $( _.selectors.modalWindow );
			_.jquery.$modalWindowTitle = _.jquery.$modalWindow.find('h1');
		};


//##############################################################################
//# EXECUTIVE FUNCTIONS ( OPEN, CLOSE, ETC )
//##############################################################################



		// Function With callbacks

		_.openWindow = function() {
			frslib.callbacks.callAllFunctionsFromArray( _.hooks.beforeOpenWindow );
			frslib.callbacks.callAllFunctionsFromArray( _.hooks.afterOpenWindow );
		};

		_.closeWindow = function() {
			frslib.callbacks.callAllFunctionsFromArray( _.hooks.beforeCloseWindow );
			frslib.callbacks.callAllFunctionsFromArray( _.hooks.afterCloseWindow );
		};

		_.submitWindow = function() {
			frslib.callbacks.callAllFunctionsFromArray( _.hooks.beforeSubmitWindow );
			frslib.callbacks.callAllFunctionsFromArray( _.hooks.afterSubmitWindow );
		};



		// Set Opening Button

		_.setOpeningButton = function( $openingButton ) {
			_.jquery.$openingButton = $openingButton;
		};



		// Default Hooks: Open

		_.hooks.afterOpenWindow.addClassModalOpen = function(){
			_.jquery.$modalWindow.removeClass( _.classes.modalClosed );
			_.jquery.$modalWindow.addClass( _.classes.modalOpened );
		}

		_.hooks.afterOpenWindow.resizeWindow = function(){
			$(window).resize();
		}

		_.hooks.afterOpenWindow.changeTitle = function(){
			if( _.jquery.$openingButton ) {
				var button_title = _.jquery.$openingButton.attr('data-modal-title');
				if( button_title ){
					_.setModalTitle( button_title );
				}
			}
		}



		// Default Hooks: Close

		_.hooks.afterCloseWindow.removeClassModalOpen = function(){
			_.jquery.$modalWindow.removeClass( _.classes.modalOpened );
			_.jquery.$modalWindow.addClass( _.classes.modalClosed );
		}



		// Default Hooks: Submit

		_.hooks.afterSubmitWindow.removeClassModalOpen = function(){
			_.jquery.$modalWindow.removeClass( _.classes.modalOpened );
			_.jquery.$modalWindow.addClass( _.classes.modalClosed );
		}


//##############################################################################
//# BIND ACTIONS
//##############################################################################


		// Open Modal Window

		_.bindAction.Open_Modal_By_Open_Button = function() {

			$('body').on( 'click', _.selectors.modalWindowOpener, function(){
				_.setOpeningButton( $(this) );
				_.openWindow();
				return false;
			});
		};


	
		
		
		// Close Modal Window

		_.bindAction.Close_Modal_By_Xtop_Button = function() {
			$('body').on( 'click', _.selectors.modalWindow + ' ' + _.selectors.modalWindowCloserX, function(){
				_.closeWindow();
				return false;
			});
		};

		_.bindAction.Close_Modal_By_Background = function() {
			$('body').on( 'click', _.selectors.modalWindow + ' ' + _.selectors.modalWindowCloserBG, function(){
				_.closeWindow();
				return false;
			});
		};

		_.bindAction.Close_Modal_By_Cancel_Button = function() {
			$('body').on( 'click', _.selectors.modalWindow + ' ' + _.selectors.mediaButtonCancel, function(){
				_.closeWindow();
				return false;
			});
		};

		_.bindAction.Close_Modal_By_ESC_Key = function() {
			$(document).keyup(function(e) {
				if( 0 == $(_.selectors.modalGroupPopupOpen).size() ){
					if( _.jquery.$modalWindow.hasClass( _.classes.modalOpened ) ){
						if (e.keyCode == 27) {


							var this_z_index = _.jquery.$modalWindow.find( _.selectors.modalWindowInner ).css('z-index');
							var max_z_index = this_z_index;
							var act_z_index = 0;

							$( _.selectors.modalWindowInner ).each(function(){
								if( $(this).parents( '.ff-media-modal' ).hasClass( _.classes.modalOpened ) ){
									act_z_index = $( this ).css('z-index');
									if( act_z_index ){
										if( act_z_index > max_z_index ){
											max_z_index = act_z_index;
										}
									}
								}
							});

							if( this_z_index == max_z_index ){
								window.setTimeout(function(){
									_.closeWindow();
								}, 10);
							}
						}
					}
				}
			});
		};


		// Submit Modal Window

		_.bindAction.Submit_Modal_By_Submit_Button = function() {
			$('body').on( 'click', _.selectors.modalWindow + ' ' + _.selectors.mediaButtonSubmit, function(){
				_.submitWindow();
				return false;
			});
		};


		// Popup Menus

		_.hidePopupGroups = function(){
			$( _.selectors.modalWindow + ' ' + _.selectors.modalGroupPopupContainer ).removeClass( _.classes.modalGroupPopupOpen );
		}

		_.openPopupGroup = function( popupMenuSelector, popupMenuCreateHtmlFunction, popupForSelector ){
			if( 0 == $( popupMenuSelector ).size() ){
				popupMenuCreateHtmlFunction();
			}
			$( popupMenuSelector ).attr('data-for', popupForSelector );
			$( popupMenuSelector ).addClass( _.classes.modalGroupPopupOpen );
		}

		_.bindAction.groupPopupGroup_click = function(){
			// Click on anything in popup
			$('body').on( 'click', _.selectors.modalWindow + ' ' + _.selectors.modalGroupPopupContainer, function(){
				_.hidePopupGroups();
			});
		}

		_.bindAction.groupPopupGroup_ESC_Key = function() {
			$(document).keyup(function(e) {
				if (e.keyCode == 27) {
					_.hidePopupGroups();
				}
			});
		}

//##############################################################################
//# FUNCTIONS
//##############################################################################

		_.setModalTitle = function( title ){
			_.jquery.$modalWindowTitle.html( title );
		}


//##############################################################################
//# RETURN ITSELF;
//##############################################################################


		return _;


	};


})(jQuery);









