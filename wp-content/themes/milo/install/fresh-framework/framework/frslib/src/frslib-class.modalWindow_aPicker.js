"use strict";

(function($){

	frslib.provide('frslib._classes');

	frslib._classes.modalWindow_aPicker = function(){


//##############################################################################
//# INHERITANCE
//##############################################################################


		// modalWindow is parent class
		var _ = frslib._classes.modalWindow();
		_._className = 'modalWindow_aPicker';


//##############################################################################
//#	PARAMS
//##############################################################################


		_.useFixedHeaders = true;
		_.useSizeSlider = true;


		// FOR: Wrapping, Items, Titles

		_.selectors.itemsContainer          = '.ff-modal-library-items-container';
		_.selectors.itemsWrapper            = '.ff-modal-library-items';
		_.selectors.itemsGroups             = '.ff-modal-library-items-group';
		_.selectors.itemsTitles             = '.ff-modal-library-items-group-title';

		_.selectors.oneLibraryItem          = '.ff-modal-library-items-group-item';
		_.classes.oneLibraryItemActive      = 'ff-modal-library-items-group-item-active';

		_.selectors.modalGroupSettings      = '.ff-modal-library-items-group-settings';


		// FOR: List / Mansory view

		_.selectors.typeViewListButton      = '.ff-modal-library-items-group-view-list-toggle';
		_.selectors.typeViewMansoryButton   = '.ff-modal-library-items-group-view-masonry-toggle';

		_.classes.typeViewList              = 'ff-modal-library-items-group-view-list';
		_.classes.typeViewMansory           = 'ff-modal-library-items-group-view-masonry';


		// FOR: Search input focus

		_.selectors.search                  = '.search';

		_.classes.oneLibraryItemHidden      = 'hidden-force';
		_.classes.itemsGroupsHidden         = 'hidden-force';

		_.useTitlesHiding                   = true;
		_.searchFilterClickTimeout          = null;
		_.addSearchFilter                   = ''; // Default no filter


		// FOR: Fixed-Like Headers

		_.selectors.placeholdersContainer   = '.ff-modal-library-items-groups-titles-container';
		_.selectors.placeholdersWrapper     = '.ff-modal-library-items-groups-titles-wrapper';
		_.selectors.placeholders            = '.ff-modal-library-items-groups-titles';


		// FOR: Size Slider

		_.selectors.sizeSlider              = '.ff-modal-library-size-slider';
		_.selectors.sizeSliderValue         = '.ff-modal-library-size-slider-value';
		_.selectors.sizeSliderControlsLeft  = '.ff-modal-library-size-slider-control-left';
		_.selectors.sizeSliderControlsRight = '.ff-modal-library-size-slider-control-right';


		// FOR: Selecting items


		_.jquery.$currentSelectedItem = null;
		_.jquery.$allItems = null;


//##############################################################################
//# HOOKS
//##############################################################################


		_.hooks.oneLibraryItemHooverIn = {};
		_.hooks.oneLibraryItemHooverOut = {};


//##############################################################################
//# INITIALIZATION jQuery selectors
//##############################################################################


		// FOR: Wrapping, Items, Titles

		_.initJqueryAction.aPicker_init = function() {
			_.jquery.$itemsContainer = _.jquery.$modalWindow.find( _.selectors.itemsContainer );
			_.jquery.$itemsWrapper   = _.jquery.$itemsContainer.find( _.selectors.itemsWrapper );
			_.jquery.$itemsGroups    = _.jquery.$itemsWrapper.find( _.selectors.itemsGroups );
			_.jquery.$itemsTitles    = _.jquery.$itemsGroups.find( _.selectors.itemsTitles );
		};


		// FOR: List / Mansory view

		_.initJqueryAction.aPicker_init_ListAndMansorySwitching = function() {
			_.jquery.$typeViewListButton    = _.jquery.$modalWindow.find( _.selectors.typeViewListButton    );
			_.jquery.$typeViewMansoryButton = _.jquery.$modalWindow.find( _.selectors.typeViewMansoryButton );
		};


		// FOR: Search input focus

		_.initJqueryAction.aPicker_init_search = function() {
			_.jquery.$search = _.jquery.$modalWindow.find( _.selectors.search );
		};


		// FOR: Fixed-Like Headers

		_.initJqueryAction.aPicker_init_fixed_like_headers = function() {

			if( ! _.useFixedHeaders ) return;

			_.jquery.$placeholdersContainer = _.jquery.$itemsContainer.find( _.selectors.placeholdersContainer );
			_.jquery.$placeholdersWrapper   = _.jquery.$placeholdersContainer.find( _.selectors.placeholdersWrapper );
			_.jquery.$placeholders          = _.jquery.$placeholdersWrapper.find( _.selectors.placeholders );
		};


		// FOR: Size Slider

		_.initJqueryAction.aPicker_init_size_slider = function() {

			if( ! _.useSizeSlider ) return;

			_.jquery.$sizeSlider               = _.jquery.$modalWindow.find( _.selectors.sizeSlider );
			_.jquery.$sizeSliderValue          = _.jquery.$modalWindow.find( _.selectors.sizeSliderValue );
			_.jquery.$sizeSliderControlsLeft   = _.jquery.$sizeSlider.find( _.selectors.sizeSliderControlsLeft  );
			_.jquery.$sizeSliderControlsRight  = _.jquery.$sizeSlider.find( _.selectors.sizeSliderControlsRight );
		};


		// FOR: Item manipulation in Picker

		_.initJqueryAction.modalWindowAdvanced_initJquery = function() {
			_.jquery.$allItems = _.jquery.$modalWindow.find( _.selectors.oneLibraryItem );
		};

		_.initJqueryAction.getItemGroups = function() {
			_.groups.getAllGroupsInfo();
		}


//##############################################################################
//# HOOKS: EXECUTIVE FUNCTIONS ( OPEN, CLOSE, ETC )
//##############################################################################


		_.hooks.libraryItemChosen = {};

		_.hooks.libraryItemChosen.saveChosenItem = function( $clickedItem ) {
			_.jquery.$currentSelectedItem = $clickedItem;
		}

		_.hooks.libraryItemChosen.removeHtmlClassChosen = function( $clickedItem ) {
			// $clickedItem = null
			_.jquery.$allItems.removeClass( _.classes.oneLibraryItemActive );
		}

		_.hooks.libraryItemChosen.addHtmlClassChosen = function( $clickedItem ) {
			$clickedItem.addClass( _.classes.oneLibraryItemActive );
		}

		_.hooks.libraryItemChosen.enableSubmitButton = function(){
			_.jquery.$modalWindow.find( _.selectors.mediaButtonSubmit ).removeAttr('disabled');
		}


		// Before Open Modal Window

		_.hooks.beforeOpenWindow.addClassModalOpen = function(){
			_.hooks.libraryItemChosen.removeHtmlClassChosen();
		}

		_.hooks.beforeOpenWindow.clearCurrentSelectedItem = function(){
			_.jquery.$currentSelectedItem = null;
		}

		_.hooks.beforeOpenWindow.disableSubmitButton = function(){
			_.jquery.$modalWindow.find( _.selectors.mediaButtonSubmit ).attr('disabled', 'disabled');
		}


		// After Open Modal Window - search

		_.hooks.afterOpenWindow.searchAutoFocus = function() {
			_.jquery.$search.focus();
		}

		_.hooks.afterOpenWindow.searchAutoClean = function() {
			_.jquery.$search.val('');
			_.searchFilter();
		}

		// After Open Modal Window - scroll to chosen item

		_.hooks.afterOpenWindow.scrollToChosenItem = function(){
			_.scrollToChosenItem();
		}

		// Delay for CSS animation during opening
		_.hooks.afterOpenWindow.cssAnimationFix = function() {
			window.setTimeout(function(){
				$(window).resize();
			}, 333)
		}




//##############################################################################
//# HOOKS: BIND jQuery ACTIONS
//##############################################################################


		// Size Slider - initialization

		_.bindAction.SizeSliderInit_Slider = function() {

			if( ! _.useSizeSlider ) return;

			var _size = _.jquery.$itemsContainer.attr('data-size');
			if( _size ){ } else { _size = 5; }

			_.jquery.$itemsContainer.addClass('ff-modal-library-items-group-item-size-' + _size );
			_.jquery.$itemsContainer.attr('data-size', _size );
			return;

		};

		_.bindAction.SizeSliderInit_PlusButton = function() {

			if( ! _.useSizeSlider ) return;

			_.jquery.$sizeSliderControlsRight.click(function(){
				var _val = _.jquery.$sizeSliderValue.val();
				_val++;
				_.jquery.$sizeSlider.val(_val);
				_.jquery.$sizeSlider.change();
			});
		};

		_.bindAction.SizeSliderInit_MinusButton = function() {

			if( ! _.useSizeSlider ) return;

			_.jquery.$sizeSliderControlsLeft.click(function(){
				var _val = _.jquery.$sizeSliderValue.val();
				_val--;
				_.jquery.$sizeSlider.val(_val);
				_.jquery.$sizeSlider.change();
			});
		};


		// Fixed Like Headers - Initialization

		_.bindAction.placeholdersCopy = function(){

			if( ! _.useFixedHeaders ) return;

			// Empty first
			_.jquery.$placeholders.html('');

			// Add placeholders item into placeholder wrapper
			_.jquery.$itemsTitles.each(function( index ){
				$(this).attr('data-title-index', index);
				$(this).addClass('ff-modal-library-items-group-title-' + index);
				_.jquery.$placeholders.append( $(this).clone() );
			});

			_.jquery.$placeholders.find(_.selectors.modalGroupPopupContainer).remove();
		};

		_.bindAction.placeholdersScrolling = function(){

			if( ! _.useFixedHeaders ) return;

			_.jquery.$itemsContainer.scroll(function(){

				var _scrollTop = _.jquery.$itemsContainer.scrollTop();

				// Container Scrolling

				_.jquery.$placeholdersContainer.css( 'margin-top', _scrollTop + 'px' );

				// Wrapper Scrolling

				var MAX_HEIGHT = 47;
				var new_margin = 0;

				var index_repair = 0;

				_.jquery.$itemsTitles.each(function( index ){
					if( $(this).hasClass( _.classes.itemsGroupsHidden ) ){
						index_repair ++;
						return;
					}
					var placeholderTopAttr = 1 * $(this).attr('data-top');

					if( placeholderTopAttr < _scrollTop + MAX_HEIGHT ){
						if( placeholderTopAttr < _scrollTop ){
							new_margin = (index_repair - index ) * MAX_HEIGHT;
						}else{
							new_margin = ( (index_repair - index) * MAX_HEIGHT) - _scrollTop + placeholderTopAttr;
						}
					}

				});

				_.jquery.$placeholdersWrapper.css('margin-top', new_margin + 'px' );
			});

		};

		_.bindAction.placeholdersResizing = function(){

			if( ! _.useFixedHeaders ) return;

			$(window).resize(function(){
				var scroll_top = $(document).scrollTop();
				var wrapper_scroll_top = _.jquery.$itemsContainer.scrollTop();
				var wrapper_top = _.jquery.$itemsContainer.offset().top;

				_.jquery.$itemsTitles.each(function(){
					var placeholder_top = $(this).offset().top - wrapper_top + wrapper_scroll_top;
					var val_selector = '.ff-modal-library-items-group-title-' + $(this).attr('data-title-index');

					_.jquery.$placeholdersContainer.find( val_selector ).attr('data-top', placeholder_top);
					$(this).attr('data-top', placeholder_top);
				});
			});
		};


		// Lib Item - Initialization

		_.bindAction.libraryItemClicked = function() {
			$('body').on( 'click', _.selectors.modalWindow + ' ' + _.selectors.oneLibraryItem, function(){
				frslib.callbacks.callAllFunctionsFromArray(_.hooks.libraryItemChosen, $(this) );
				return false;
			});
		}

		_.bindAction.oneLibraryItemHooverIn = function() {
			$('body').on( 'mouseenter', _.selectors.modalWindow + ' ' + _.selectors.oneLibraryItem, function(){
				frslib.callbacks.callAllFunctionsFromArray(_.hooks.oneLibraryItemHooverIn, $(this) );
				return false;
			});
		};

		_.bindAction.oneLibraryItemHooverOut = function() {
			$('body').on( 'mouseleave', _.selectors.modalWindow + ' ' + _.selectors.oneLibraryItem, function(){
				frslib.callbacks.callAllFunctionsFromArray(_.hooks.oneLibraryItemHooverOut, $(this) );
				return false;
			});
		};

		// Mansory / List view
		_.bindAction.searchFilter_MansoryAndListSwitch = function(){
			_.jquery.$typeViewListButton.click(function(){
				_.jquery.$itemsContainer.addClass(_.classes.typeViewList);
				_.jquery.$itemsContainer.removeClass(_.classes.typeViewMansory);
				_.jquery.$sizeSlider.hide();
				return false;
			});

			_.jquery.$typeViewMansoryButton.click(function(){
				_.jquery.$itemsContainer.removeClass(_.classes.typeViewList);
				_.jquery.$itemsContainer.addClass(_.classes.typeViewMansory);
				_.jquery.$sizeSlider.show();
				return false;
			});
		};

		// Search Filter

		_.bindAction.searchFilter_KeyUp = function(){
			_.jquery.$search.keyup(function(){
				if( _.searchFilterClickTimeout ){
					// User typed something before
					window.clearTimeout( _.searchFilterClickTimeout );
				}
				_.searchFilterClickTimeout = window.setTimeout(function(){
					_.searchFilter();
				},333);
			});
		};

		_.bindAction.searchFilter_Click = function(){
			_.jquery.$search.click(function(){
				window.setTimeout(function(){
					_.searchFilter();
				},10);
			});
		};


//##############################################################################
//# FUNCTIONS
//##############################################################################


		_.groups = {};

		_.groups.getAllGroupsInfo = function() {

			var groupInfo = new Array();
			var $itemsGroups = _.groups.getCurrentGroupsSelector();
			$itemsGroups.each(function() {

				var oneGroupInfo = {};
				// data-group-name   -nice

				oneGroupInfo.slug = $(this).attr('data-group-name');
				oneGroupInfo.name = $(this).attr('data-group-name-nice');

				groupInfo.push(oneGroupInfo);
			});

			return groupInfo;

		};

		_.groups.getCurrentGroupsSelector = function() {
			return _.jquery.$itemsWrapper.find( _.selectors.itemsGroups );
		}

		_.groups.getUserGroupsInfo = function() {
			var groupInfo = new Array();
			var $itemsGroups = _.groups.getCurrentGroupsSelector();
			$itemsGroups.each(function() {

				if( $(this).attr('data-group-type') == 'user' ) {
					var oneGroupInfo = {};
					// data-group-name   -nice

					oneGroupInfo.slug = $(this).attr('data-group-name');
					oneGroupInfo.name = $(this).attr('data-group-name-nice');

					groupInfo.push(oneGroupInfo);
				}
			});

			return groupInfo;
		};

		_.groups.groupExistBySlug = function( slug ) {
			var allGroups = _.groups.getAllGroupsInfo();
			var key;
			for( key in allGroups ) {
				var oneGroup = allGroups[key];

				if( oneGroup.slug == slug ) {
					return true;
				}
			}

			return false;
		};


		// UBER search MEGA filter

		_.searchFilter = function(){

			// alert( _.addSearchFilter );
			var filter_value;
			filter_value = ' ' + _.jquery.$search.val().toLowerCase();
			// filter_value = filter_value.replace('@',' ');
			// filter_value = filter_value.replace('-',' ');
			filter_value = filter_value.replace(',',' ');

			filter_value = filter_value.split(' ');

			var _global_icon_group_count_filtered = 0;
			var _global_icon_group_count_total = 0;

			_.jquery.$itemsGroups.each(function(){

				var icon_group_count_filtered = 0;
				var icon_group_count_total = 0;

				$(this).find( _.selectors.oneLibraryItem ).each(function(){
					var index;
					var show = true;
					for (index = 0; index < filter_value.length; index ++ ) {
						if( '' !== filter_value[index] ){
							if ($(this).attr('data-tags').toLowerCase().indexOf(filter_value[index]) == -1) {
								show = false;
							}
						}
					}

					icon_group_count_total ++;
					if(show){
						if( $(this).hasClass( _.classes.oneLibraryItemHidden ) ){
							$(this).removeClass( _.classes.oneLibraryItemHidden );
						}
						icon_group_count_filtered ++;
					}else{
						if( ! $(this).hasClass( _.classes.oneLibraryItemHidden ) ){
							$(this).addClass( _.classes.oneLibraryItemHidden );
						}
					}
				});

				// Counts

				var titleIndex = $(this).find( _.selectors.itemsTitles ).attr('data-title-index');

				var $titles = _.jquery.$modalWindow.find( _.selectors.itemsTitles + '-' + titleIndex );

				$titles.find('.ff-modal-library-items-group-counter-filtered').html( icon_group_count_filtered );
				$titles.find('.ff-modal-library-items-group-counter-total').html( icon_group_count_total );

				if( ! _.useTitlesHiding ){
					return;
				}

				if( 0 === 1*icon_group_count_filtered ){
					if( ! $titles.hasClass( _.classes.itemsGroupsHidden ) ){
						$titles.addClass( _.classes.itemsGroupsHidden );
						$titles.parent( _.selectors.itemsGroups ).addClass( _.classes.itemsGroupsHidden );
					}
				}else{
					if( $titles.hasClass( _.classes.itemsGroupsHidden ) ){
						$titles.removeClass( _.classes.itemsGroupsHidden );
						$titles.parent( _.selectors.itemsGroups ).removeClass( _.classes.itemsGroupsHidden );
					}
				}

			});

			// $(window).resize();
		};

		_.getTagsHtmlFromString = function( text ){

			var singleTag;
			var arr = text.split(',');
			var index;
			var html = '';

			for (index = 0; index < arr.length; index ++ ) {
				singleTag = arr[index];
				if( '' !== singleTag ){
					html = html + "<a href='#"+singleTag+"' data-value='"+singleTag+"'>"+singleTag+'</a>';
					if ( index < arr.length - 1 ) {
						html = html + ', ';
					}
				}
			}

			return html;
		};

		_.scrollToChosenItem = function(){
			window.setTimeout(function(){
				var scroll_top = $(document).scrollTop();
				var $active_item = _.jquery.$modalWindow.find( _.selectors.oneLibraryItem + '.' + _.classes.oneLibraryItemActive );

				_.jquery.$itemsContainer.scrollTop( 0 );

				if( 0 == $active_item.size() ){
					return;
				}

				var item_top = $active_item.offset().top - scroll_top;

				var scroll_to = item_top - _.jquery.$itemsContainer.offset().top - Math.round( _.jquery.$itemsContainer.height() / 2 ) + $('body').scrollTop();

				_.jquery.$itemsContainer.scrollTop( scroll_to );
			},10);
		};

		_.reinit = function(){
			_.initJqueryAction.aPicker_init();
			_.bindAction.placeholdersCopy();
			_.bindAction.placeholdersResizing();
			_.jquery.$search.val('');
			_.searchFilter();
			_.jquery.$itemsContainer.scroll();
			_.initJqueryAction.modalWindowAdvanced_initJquery();
		}

		_.getNowTimestamp = function(){
			if ( ! Date.now) {
				return new Date().getTime();
			}else{
				return Date.now();
			}
		}


//##############################################################################
//# RETURN ITSELF;
//##############################################################################


		return _;


	};

})(jQuery);














