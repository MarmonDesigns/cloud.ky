"use strict";

(function($){

	frslib.provide('frslib._classes');

	frslib._classes.modalWindowIconPicker = function(){


//##############################################################################
//# INHERITANCE
//##############################################################################


		// modalWindow_aPicker is parent class
		var _ = frslib._classes.modalWindow_aPicker();
		_._className = 'modalWindowIconPicker';


//##############################################################################
//#	PARAMS
//##############################################################################


		_.selectors.modalWindowOpener = '.ff-open-library-icon-button';
		_.selectors.modalWindow = '#ff-modal-library-icon-picker';
		_.selectors.sidebar = '.media-sidebar .attachment-details';

		_.selectors.openingButtonInner = '.ff-open-library-button-preview';
		_.selectors.openingButtonIcon  = 'i';
		_.selectors.openingButtonValue = 'input';
		_.selectors.openingButtonPreview = '.ff-open-library-button-preview-icon-large';

		_.selectors.oneLibraryItem = 'i';
		_.classes.oneLibraryItemActive = 'active';

//##############################################################################
//# INITIALIZATION jQuery selectors
//##############################################################################


		_.initJqueryAction.initSidebar = function() {
			_.jquery.$sidebar = _.jquery.$modalWindow.find( _.selectors.sidebar );
		};

//##############################################################################
//# HOOKS: EXECUTIVE FUNCTIONS ( OPEN, CLOSE, ETC )
//##############################################################################


		_.hooks.beforeOpenWindow.initOpeningButtonInner = function() {
			_.jquery.$openingButtonInner = _.jquery.$openingButton.find( _.selectors.openingButtonInner );
			_.jquery.$openingButtonIcon  = _.jquery.$openingButton.find( _.selectors.openingButtonIcon );
			_.jquery.$openingButtonValue = _.jquery.$openingButton.find( _.selectors.openingButtonValue );
			_.jquery.$openingButtonPreview = _.jquery.$openingButton.find( _.selectors.openingButtonPreview );

			if( _.jquery.$openingButtonValue.attr('data-autofilter') ){
				_.addSearchFilter = _.jquery.$openingButtonValue.attr('data-autofilter');
			}else{
				_.addSearchFilter = '';
			}

			var sel = _.jquery.$openingButtonValue.val();
			if( sel ){
				sel = sel.replace( / /g, '.' );
				sel = '.' + sel;
				var $sel = $(sel);
				_.hooks.libraryItemChosen.saveChosenItem( $sel );
				_.hooks.libraryItemChosen.addHtmlClassChosen( $sel );
				_.hooks.libraryItemChosen.enableSubmitButton();
			}
		};

		_.hooks.afterSubmitWindow.saveChosen = function(){
			var _class = _.jquery.$currentSelectedItem.attr('class').replace( _.classes.oneLibraryItemActive, '' ).trim();
			var _i_ = '<i class="'+_class+'"></i>';
			_.jquery.$openingButtonInner.html( _i_ );
			_.jquery.$openingButtonPreview.html( _i_ );
			_.jquery.$openingButtonValue.val( _class );
		};

		_.hooks.oneLibraryItemHooverIn.oneLibraryItem_itemMouseEnter = function( $what ) {
			_.changeSidebar( $what );
		};

		_.hooks.oneLibraryItemHooverOut.oneLibraryItem_itemMouseLeave = function( $what ) {
			_.changeSidebar( _.jquery.$currentSelectedItem );
		};


//##############################################################################
//# HOOKS: BIND jQuery ACTIONS
//##############################################################################


		_.bindAction.sidebarTagClick = function(){
			$('body').on( 'click', _.selectors.modalWindow + ' ' + '.description-tags p a', function(){
				_.jquery.$search.val( $(this).html() );
				_.searchFilter();
			});
		};

		_.bindAction.focusOnSelectedIcon = function(){
			$('.thumbnail.icon-info').click(function(){
				_.scrollToChosenItem();
			});
		};

//##############################################################################
//# FUNCTIONS
//##############################################################################


		_.changeSidebar = function( $ico ) {

			if( $ico ) {
				_.jquery.$sidebar.removeClass('hidden');
			} else {
				_.jquery.$sidebar.addClass('hidden');
				return;
			}

			var _tags    =  $ico.attr('data-tags');
			var _content =  $ico.attr('data-content');
			var _font    =  $ico.attr('data-font');
			var _class   =  $ico.attr('class');

			_class = _class.replace( _.classes.oneLibraryItemActive, '' );

			var _name    = _class.split(' ')[1].replace( 'icon-', '' ).replace( '-', ' ' );

			var _tags_html = _.getTagsHtmlFromString( _tags );

			_.jquery.$sidebar.find('.thumbnail.icon-info i'         ).attr('class', _class );
			_.jquery.$sidebar.find('.description-name p'            ).html( _name );
			_.jquery.$sidebar.find('.description-font p'            ).html( _font );
			_.jquery.$sidebar.find('.description-tags p'            ).html( _tags_html );
			_.jquery.$sidebar.find('.description-class p'           ).html( _class );
			_.jquery.$sidebar.find('.description-glyph-escaped p'   ).html( "&amp;#x" + _content + ";" );
			_.jquery.$sidebar.find('.description-css p'             ).html( "\\" + _content + "" );
			_.jquery.$sidebar.find('.description-glyph-character p' ).html( "&#x" + _content + ";" );

		};


//##############################################################################
//# RETURN ITSELF;
//##############################################################################


		return _;

	};

})(jQuery);




