(function($){
frslib.provide('frslib.options');
frslib.provide('frslib.options.template');




/**********************************************************************************************************************/
/* JAVASCRIPT OPTIONS (refactoring)
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/* JAVASCRIPT OPTIONS (refactoring)
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/* JAVASCRIPT OPTIONS (refactoring)
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/* JAVASCRIPT OPTIONS (refactoring)
/**********************************************************************************************************************/



    frslib.provide('frslib.options');
    frslib.provide('frslib.options.walkers');


    frslib.provide('frslib.options.functions');


    frslib.options.functions.initOneOptionSet = function( $optionsJSWrapper ) {

        if( $optionsJSWrapper.hasClass('ff-do-not-init-options-at-frontend') ) {
            return false;
        }

        var $dataWrapper = $optionsJSWrapper.find('.ff-options-js-data-wrapper');
        var structure = $dataWrapper.find('.ff-options-structure-js').html();
        var data = $dataWrapper.find('.ff-options-data-js').html();
        var prefix = $dataWrapper.find('.ff-options-prefix').html();

        //console.log( data );
        //console.log( '---------------');

        var printerBoxed = frslib.options.walkers.printerBoxed();

        //printerBoxed.walker.ignoreData = false;

        printerBoxed.setStructureString( structure );
        printerBoxed.setDataString( data );
        printerBoxed.setPrefix( prefix );



        var output = printerBoxed.walk();


        $optionsJSWrapper.find('.ff-options-js').hide(0);

        $optionsJSWrapper.find('.ff-options-js').html( output );

        $optionsJSWrapper.find('.ff-options-js').show(500);

    }

    frslib.options.functions.initParticularOptions = function() {
        frslib.options.template.init_sortable();
        frslib.options.select2.init();


        if( $('.ff-revolution-slider-select-content').size() > 0 ) {
                var htmlContent = $('.ff-revolution-slider-select-content').html();

                $('.ff-revolution-slider-selector').html( htmlContent );

                $('.ff-repeatable').children('.ff-repeatable-item').find('.ff-revolution-slider-selector').each(function(){

                    var value = $(this).attr('our-value');

                    $(this).find('option').each(function() {
                        var currentVal = ( $(this).attr('value') );
                        if( value == currentVal ) {
                            $(this). attr('selected', 'selected');
                        }
                    });

                })
        }

        setTimeout(function(){
            $('.ff-datepicker').datepicker();
            //$('.datepicker_label').find('input').datepicker();
            //$('.datepicker_label').find('input').not('.hasDatepicker').css('opacity', 0.1);
            //jQuery(".ff-default-wp-color-picker").wpColorPicker();


            	$(".ff-default-wp-color-picker").each(function(){
						var $this_parent = $(this).parent();
						var this_text = $this_parent.text();
						$(this).wpColorPicker();
						$this_parent.find('a').attr('title', this_text);
						$this_parent.contents().filter(function() {
							return this.nodeType == 3; //Node.TEXT_NODE
						}).remove();

					});

        }, 2000);


    }

    frslib.options.functions.initOptionsJS = function() {

        $('.ff-options-js-wrapper').each(function(){
            frslib.options.functions.initOneOptionSet( $(this) );
        });

        frslib.options.functions.initParticularOptions();
    }


    $(document).on('click', '.ff-repeatable-js-duplicate-above', function( e ){

        e.stopPropagation();

        $(this).parents('.ff-popup-container').removeClass('ff-popup-open');


        var $parentLi = $(this).parents('.ff-repeatable-item:first');

        var $parentLiClone = $parentLi.clone(true);

        $parentLi.after( $parentLiClone );

        //



        //var $parentLiClonned = $parentLi.clone();

        //$parentLiClonned.after( $parentLi );

    });





    $(document).on('click', '.ff-repeatable-add-above-js', function(){
        var $liParent = $(this).parents('.ff-repeatable-item-js:first');
        var $parent = $(this).parents('.ff-repeatable-js:first');

        var sectionRoute = $parent.attr('data-current-section-route');

        var $optionsJSWrapper = $(this).parents('.ff-options-js-wrapper');

        if( false || $optionsJSWrapper.data('stored-structure-html') == undefined ) {

            var $dataWrapper = $optionsJSWrapper.find('.ff-options-js-data-wrapper');
            var structure = $dataWrapper.find('.ff-options-structure-js').html();
            var data = $dataWrapper.find('.ff-options-data-js').html();
            var prefix = $dataWrapper.find('.ff-options-prefix').html();


            var printerBoxed = frslib.options.walkers.printerBoxed();

            printerBoxed.setStructureString( structure );
            printerBoxed.setDataString( data );
            printerBoxed.setPrefix( prefix );
            printerBoxed.walker.ignoreData = true;
            printerBoxed.walker.ignoreHideDefault = true;

            printerBoxed.walk();

            $optionsJSWrapper.data('stored-structure-html', printerBoxed );
        } else {
            var printerBoxed = $optionsJSWrapper.data('stored-structure-html');
        }






        var $parentUl = printerBoxed.getChildSectionsParentUl( sectionRoute );


        var insertTemplate = function( $li ) {


                frslib.callbacks.doCallback( frslib.options.template.callbacks.duplicate_before_clone.replace('.',''), $li );
                $li.hide();

                $liParent.after( $li );

                $li.addClass('ff-repeatable-add-animation').animate({ height: 'toggle' }, 300, 'swing', function(){
                    $(this).removeClass('ff-repeatable-add-animation');
                });

                frslib.options.template.init_sortable();
                //$('.hasDatepicker').removeClass('hasDatepicker');
                setTimeout(function(){
                    $('.ff-datepicker').datepicker();
                    //$('.datepicker_label').find('input').datepicker();
                    //$('.datepicker_label').find('input').not('.hasDatepicker').css('opacity', 0.1);


            	$(".ff-default-wp-color-picker").wpColorPicker();
                }, 2000);


             if( $('.ff-revolution-slider-select-content').size() > 0 ) {
                var htmlContent = $('.ff-revolution-slider-select-content').html();

                $('.ff-revolution-slider-selector').html( htmlContent );

                $('.ff-repeatable').children('.ff-repeatable-item').find('.ff-revolution-slider-selector').each(function(){

                    var value = $(this).attr('our-value');

                    $(this).find('option').each(function() {
                        var currentVal = ( $(this).attr('value') );
                        if( value == currentVal ) {
                            $(this). attr('selected', 'selected');
                        }
                    });

                })
            }
        }

        /*----------------------------------------------------------*/
        /* ADVANCED SECTION PICKER
        /*----------------------------------------------------------*/
        if( $parentUl.hasClass('ff-section-picker-advanced') ) {

            $parentUl.children('li').each(function(){
                $advancedSectionInfo = $(this).children('.ff-repeatable-section-info');

                var oneSectionData = {};
                oneSectionData.sectionName = $advancedSectionInfo.find('.ff-advanced-section-name').html();
                oneSectionData.sectionId = $advancedSectionInfo.find('.ff-advanced-section-id').html();
                oneSectionData.sectionImage = $advancedSectionInfo.find('.ff-advanced-section-image').html();

                oneSectionData.menuTitle = $advancedSectionInfo.find('.ff-advanced-menu-title').html();
                oneSectionData.menuId = $advancedSectionInfo.find('.ff-advanced-menu-id').html();



                frslib._classes.modalWindowColorSectionPicker.addOneSection( oneSectionData );
            });



            frslib._classes.modalWindowColorSectionPicker.open( function( selectedSectionID ){

                var $li = $parentUl.children('li[data-section-id="' + selectedSectionID + '"]');
                insertTemplate( $li );

            });
        /*----------------------------------------------------------*/
        /* NORMAL SECTION PICKER
        /*----------------------------------------------------------*/
        } else {
            var childSections = printerBoxed.getChildSections( sectionRoute );

            var buttons = '';

            if( childSections.length == 1 ) {
               var section = childSections[0];
                var $li = printerBoxed.getSection( section.route, section.id );
                insertTemplate( $li );


            } else {

                for( var i in childSections ) {
                    var section = childSections[i];
                    buttons += '<li class="ff-popup-button-wrapper" data-route = "' + section.route + '" data-id="'+section.id+'">';
                    buttons += '<div class="ff-popup-button">'+section.name+'</div>'
                    buttons += '</li>'
                }
                var $repeatVar =$(this).parent();
                $repeatVar.find('.ff-popup-container:first').css('display','block');
                $repeatVar.find('.ff-popup-container').css('position','absolute');
                $repeatVar.find('.ff-repeatable-add-variation-selector-popup').html( buttons);


                $repeatVar.find('.ff-popup-button-wrapper').click(function() {
                    $repeatVar.find('.ff-popup-container').css('display','none');

                    var dataRoute = $(this).attr('data-route');
                    var dataId = $(this).attr('data-id');

                    var $li = printerBoxed.getSection( dataRoute, dataId );
                    insertTemplate( $li );

                });

                $repeatVar.find('.ff-popup-backdrop').click(function(){
                    $repeatVar.find('.ff-popup-container').css('display','none');
                });

            }
        }

    });

jQuery( document). ready(function(){
    frslib.options.functions.initOptionsJS();
});

/**********************************************************************************************************************/
/* END -----  JAVASCRIPT OPTIONS (refactoring)
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/* END -----  JAVASCRIPT OPTIONS (refactoring)
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/* END -----  JAVASCRIPT OPTIONS (refactoring)
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/* END -----  JAVASCRIPT OPTIONS (refactoring)
/**********************************************************************************************************************/







//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// TEMPLATING SYSTEM
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// here we manage all the templating stuff, like add, duplicate, formate
// delete, get ready for sending and other things

/******************************************************************************/
/** SELECTORS
/******************************************************************************/
frslib.provide('frslib.options.template.selectors');
frslib.provide('frslib.options.template.callbacks');
frslib.provide('frslib.options.template.functions');
// - BUTTONS
frslib.options.template.selectors.repeatable_button_add_above              = '.ff-repeatable-add-above';
frslib.options.template.selectors.repeatable_button_add_below              = '.ff-repeatable-add-below';
frslib.options.template.selectors.repeatable_button_duplicate_above        = '.ff-repeatable-duplicate-above';
frslib.options.template.selectors.repeatable_button_duplicate_below        = '.ff-repeatable-duplicate-below';
frslib.options.template.selectors.repeatable_button_remove                 = '.ff-repeatable-remove';
frslib.options.template.selectors.repeatable_button_handle                 = '.ff-repeatable-handle';
frslib.options.template.selectors.repeatable_button_settings               = '.ff-repeatable-settings';
frslib.options.template.selectors.repeatable_button_settings_overlay       = '.ff-popup-backdrop';
frslib.options.template.selectors.repeatable_button_drag                   = '.ff-repeatable-drag';
// - BUTTONS END

// - CLASSES
frslib.options.template.selectors.repeatable_parent_ul                     = '.ff-repeatable';
frslib.options.template.selectors.repeatable_parent_ul_first               = '.ff-repeatable:first';
frslib.options.template.selectors.repeatable_template                      = '.ff-repeatable-template';
frslib.options.template.selectors.repeatable_item                          = '.ff-repeatable-item';
frslib.options.template.selectors.repeatable_item_first                    = '.ff-repeatable-item:first';
frslib.options.template.selectors.repeatable_item_popup_opened             = '.ff-repeatable-item-popup-opened'
frslib.options.template.selectors.repeatable_item_hover                    = '.ff-repeatable-item-hover'
frslib.options.template.selectors.repeatable_item_opened                   = '.ff-repeatable-item-opened';
frslib.options.template.selectors.repeatable_item_closed                   = '.ff-repeatable-item-closed';
frslib.options.template.selectors.repeatable_content_first                 = '.ff-repeatable-content:first';
frslib.options.template.selectors.repeatable_header                        = '.ff-repeatable-header';
// - CLASSES END

// - POPUP MENU ON COGWHEEL
frslib.options.template.selectors.repeatable_popup_menu                    = '.ff-popup-container';
frslib.options.template.selectors.repeatable_popup_menu_open               = '.ff-popup-open';
// - POPUP MENU ON COGWHEEL END

// - HOVERS
frslib.options.template.selectors.repeatable_button_remove_hover           = '.ff-repeatable-remove-hover';
frslib.options.template.selectors.repeatable_button_add_above_hover        = '.ff-repeatable-add-above-hover';
frslib.options.template.selectors.repeatable_button_add_below_hover        = '.ff-repeatable-add-below-hover';
frslib.options.template.selectors.repeatable_button_duplicate_above_hover  = '.ff-repeatable-duplicate-above-hover ff-repeatable-duplicate-hover';
frslib.options.template.selectors.repeatable_button_duplicate_below_hover  = '.ff-repeatable-duplicate-below-hover ff-repeatable-duplicate-hover';
frslib.options.template.selectors.repeatable_button_handle_hover           = '.ff-repeatable-handle-hover';
frslib.options.template.selectors.ff_repeatable_top_hover                  = '.ff-repeatable-top-hover';
frslib.options.template.selectors.ff_repeatable_bottom_hover               = '.ff-repeatable-bottom-hover';
frslib.options.template.divider 										   = '--||--';
// - HOVERS END

frslib.options.template.callbacks.duplicate_before_clone                   = '.duplicate_before_clone';
frslib.options.template.callbacks.duplicate_after_clone                    = 'ff_duplicate_after_clone';

/******************************************************************************/
/** INITIALIZATION
/******************************************************************************/
// all things
frslib.options.template.init = function() {




    // COPY CONTENT FOR REVOLUTION SLIDER SELECT

    if( $('.ff-revolution-slider-select-content').size() > 0 ) {
        var htmlContent = $('.ff-revolution-slider-select-content').html();

        $('.ff-revolution-slider-selector').html( htmlContent );

        $('.ff-repeatable').children('.ff-repeatable-item').find('.ff-revolution-slider-selector').each(function(){

            var value = $(this).attr('our-value');

            $(this).find('option').each(function() {
                var currentVal = ( $(this).attr('value') );
                if( value == currentVal ) {
                    $(this). attr('selected', 'selected');
                }
            });

        })
    }

	$(document).on('mousedown', frslib.options.template.selectors.repeatable_button_settings, function( e ){
		$(this).mouseup();
	});

	$(document).on('mousedown', frslib.options.template.selectors.repeatable_button_handle+'>'+frslib.options.template.selectors.repeatable_button_handle, function( e ){
		$(this).mouseup();
	});

	// $(document).on('mousedown', '.ff-repeatable-handle', function( e ){
	// 	var $parent = $(this).parent('.' + frslib.options.template.selectors.repeatable_item_opened.replace('.',''));
	// 	$parent.children(frslib.options.template.selectors.repeatable_content_first).slideUp(1, function() {
	// 		$parent.removeClass( frslib.options.template.selectors.repeatable_item_opened.replace('.','') );
	// 		$parent.addClass( frslib.options.template.selectors.repeatable_item_closed.replace('.','') );
	// 	});		
	// 	return false;
	// });

	$(document).on('mousedown', frslib.options.template.selectors.repeatable_popup_menu_open, function( e ){
		$(this).mouseup();
	});

	$(document).on('click', frslib.options.template.selectors.repeatable_button_settings, function( e ){
		var $settings_popup = $( this ).siblings(frslib.options.template.selectors.repeatable_popup_menu);
		$settings_popup.css('top',  'auto' );
		$settings_popup.css('left', 'auto' );
		$(frslib.options.template.selectors.repeatable_popup_menu).css('z-index',999999);

		var menu_width = $(this).siblings(frslib.options.template.selectors.repeatable_popup_menu).width();
		var menu_height = $(this).siblings(frslib.options.template.selectors.repeatable_popup_menu).height();

		var window_width = $(window).width();
		var window_height = $(window).height() + $(window).scrollTop();;

		var window_padding_left = 10;
		var window_padding_bottom = 10;

		var relX = 0;

		if( e.pageX > window_width - menu_width - window_padding_left){
			relX = 1 * e.pageX - menu_width - 1;
		}else{
			relX = 1 * e.pageX;
		}

		var relY = 0;
		if( e.pageY > window_height - menu_height - window_padding_bottom){
			relY = 1 * e.pageY - menu_height - 1;
		}else{
			relY = 1 * e.pageY + 1;
		}

		if( $('body').hasClass('post-php') ){
			$settings_popup.css('top',  '30px' );
			$settings_popup.css('left', 'calc(100% - 160px)' );
			$settings_popup.css('position', 'absolute' );
		}else{
			$settings_popup.css('top',  relY + 'px' );
			$settings_popup.css('left', relX + 'px' );
		}

		$settings_popup.addClass(frslib.options.template.selectors.repeatable_popup_menu_open.replace('.',''));

		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( 'ff-repeatable-item-popup-opened' );
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( 'ff-repeatable-item-hover' );

		e.stopPropagation();
		return false;
	});

	$(document).on('click', frslib.options.template.selectors.repeatable_button_settings_overlay, function( e ){
		// $( this ).hide();
		$(frslib.options.template.selectors.repeatable_popup_menu_open).removeClass(frslib.options.template.selectors.repeatable_popup_menu_open.replace('.',''));

		$( '.ff-repeatable-item-popup-opened' ).removeClass( 'ff-repeatable-item-popup-opened' )
		$( '.ff-repeatable-item-hover' ).removeClass( 'ff-repeatable-item-hover' )
		//$( frslib.options.template.selectors.repeatable_item_hover ).removeClass( frslib.options.template.selectors.repeatable_item_hover.replace('.','') );
		e.stopPropagation();
		return false;
	});


	// REMOVE
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_remove, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_remove_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_remove, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_remove_hover.replace('.','') );
	});
	
	// ADD ABOVE
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_add_above, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_add_above_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_add_above, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_add_above_hover.replace('.','') );
	});
	
	// ADD BELOW
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_add_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_add_below_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_add_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_add_below_hover.replace('.','') );
	});
	
	//DUPLICATE ABOVE
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_duplicate_above, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_duplicate_above_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_duplicate_above, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_duplicate_above_hover.replace('.','') );
	});
	
	//DUPLICATE BELOW
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_duplicate_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_duplicate_below_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_duplicate_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_duplicate_below_hover.replace('.','') );
	});
	
	//HANDLE
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_duplicate_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_duplicate_below_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_duplicate_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_duplicate_below_hover.replace('.','') );
	});

	// TEXT TITLE

	$(document).on("change", ".edit-repeatable-item-title", function() {
		var _val = $(this).val();
		if( '' == _val ){
			if( $(this).attr('placeholder') ){
				_val = $(this).attr('placeholder');
			}
 		}
		$(this).parents( '.ff-repeatable-item:first' ).children( '.ff-repeatable-header' ).find('.ff-repeatable-title').html(
			_val
		);
	});
	$(document).on("keypress", ".edit-repeatable-item-title", function(event) { $(this).change(); });
	$(document).on("keydown", ".edit-repeatable-item-title", function(event) { $(this).change(); });
	$(document).on("keyup", ".edit-repeatable-item-title", function(event) { $(this).change(); });

	// TEXT DESCRIPTION

	$(document).on("change", ".edit-repeatable-item-description", function() {
		var _val = $(this).val();
		if( '' == _val ){
			if( $(this).attr('placeholder') ){
				_val = $(this).attr('placeholder');
			}
		}
		$(this).parents( '.ff-repeatable-item:first' ).children( '.ff-repeatable-header' ).find('.ff-repeatable-description').html(
			_val
		);
	});
	$(document).on("keypress", ".edit-repeatable-item-description", function(event) { $(this).change(); });
	$(document).on("keydown", ".edit-repeatable-item-description", function(event) { $(this).change(); });
	$(document).on("keyup", ".edit-repeatable-item-description", function(event) { $(this).change(); });

	// INIT SORTABLES
	$(document).ready(function(){
		frslib.options.template.init_sortable();
		$('.edit-repeatable-item-title').change();
		$('.edit-repeatable-item-description').change();
	});

};

// sortable
frslib.options.template.init_sortable = function() {
	var $firstLevels = $(document).findButNotInside('.ff-repeatable');
	
	$firstLevels.each(function(){
		
		frslib.options.template.init_one_sortable( $(this) );
		
	});
	/*$('.ff-repeatable').sortable({
		handle: '.ff-repeatable-handle',
		items: '.ff-repeatable-item'
	});
		/*
	$(frslib.options.template.selectors.repeatable_parent_ul).each(function(){
		$(this).sortable({
			handle:frslib.options.template.selectors.repeatable_button_handle
		});
	});*/
};
frslib.options.template.init();


frslib.options.template.init_one_sortable = function( $ul_ff_repeatable ) {
	$ul_ff_repeatable.sortable({
		handle: '.ff-repeatable-handle',
		items: '.ff-repeatable-item'
	});
	
	var $potentialChildrens = $ul_ff_repeatable.children('.ff-repeatable-item').findButNotInside('.ff-repeatable');
	
	if( $potentialChildrens.size() > 0  ) {
		frslib.options.template.init_one_sortable( $potentialChildrens );
	}
	
}

/******************************************************************************/
/** TEMPLATING FUNCTIONS - DUPLICATE
/******************************************************************************/
/*
 * Add a new section before / after the header. It's feeded from the template
 * selector
 */
$(document).on('click', frslib.options.template.selectors.repeatable_button_duplicate_above + ',' + frslib.options.template.selectors.repeatable_button_duplicate_below, function(){

	// Click on menu background overlay -> hides menu
	$( frslib.options.template.selectors.repeatable_button_settings_overlay ).click();

	var $parent = $(this).parents(frslib.options.template.selectors.repeatable_item_first);
	frslib.callbacks.doCallback( frslib.options.template.callbacks.duplicate_before_clone.replace('.',''), $parent );
	
	frslib.htmlforms.writeValueToCode( $parent );
	var $newItem = $parent.clone(true);
	$newItem.removeClass('ff-repeatable-item-opened').addClass('ff-repeatable-item-closed').find('.ff-repeatable-content').css('display','none');
	
	// ADD ABOVE
	if( $(this).hasClass( frslib.options.template.selectors.repeatable_button_duplicate_above.replace('.','') ) ) {
		$parent.before( $newItem );
		
	// ADD BELOW
	} else {
		$parent.after( $newItem );	
	}
	
	
	
	frslib.callbacks.doCallback( frslib.options.template.callbacks.duplicate_after_clone.replace('.',''), $newItem, $parent );
	
	$newItem.hide();

	$newItem.addClass('ff-repeatable-duplicate-animation').animate({ height: 'show', opacity: 'show' }, 400, 'swing', function(){
		$(this).removeClass('ff-repeatable-duplicate-animation');
	});
	//frslib.htmlforms.writeValueToCode
	frslib.options.template.init_sortable();
	return false;
});

/******************************************************************************/
/** TEMPLATING FUNCTIONS - ADD
/******************************************************************************/
/*
 * Add a new section before / after the header. It's feeded from the template
 * selector
 */
// ADD VARIATION SELECTOR
var add_variation_node_show_selector = function( $parent, $parent_ul, $buttonClicked, callback ) {
	

	

	if ( $parent_ul.hasClass('ff-section-picker-advanced')) {
		var $templates = $parent_ul.children('.ff-repeatable-template-holder');
		$templates.each(function() {
			/*var sectionId = $(this).attr('data-section-id');
			var sectionName = $(this).attr('data-section-name');
			
			
			buttons += '<li class="ff-popup-button-wrapper" data-id="'+sectionId+'">';
	        	buttons += '<div class="ff-popup-button">'+sectionName+'</div>'
	        buttons += '</li>'/*/
			
			$advancedSectionInfo = $(this).find('.ff-repeatable-section-info');
			
			
			
			var oneSectionData = {};
			oneSectionData.sectionName = $advancedSectionInfo.find('.ff-advanced-section-name').html();
			oneSectionData.sectionId = $advancedSectionInfo.find('.ff-advanced-section-id').html();
			oneSectionData.sectionImage = $advancedSectionInfo.find('.ff-advanced-section-image').html();
			
			oneSectionData.menuTitle = $advancedSectionInfo.find('.ff-advanced-menu-title').html();
			oneSectionData.menuId = $advancedSectionInfo.find('.ff-advanced-menu-id').html();
			
			
			frslib._classes.modalWindowColorSectionPicker.addOneSection( oneSectionData );
			
		});
		//console.log( 'a ');
		frslib._classes.modalWindowColorSectionPicker.open( callback );
		
	} else {
		var $templates = $parent_ul.children('.ff-repeatable-template-holder').children('.ff-repeatable-template');
		var buttons = '';
		
		$templates.each(function() {
			var sectionId = $(this).attr('data-section-id');
			var sectionName = $(this).attr('data-section-name');
			
			
			buttons += '<li class="ff-popup-button-wrapper" data-id="'+sectionId+'">';
	        	buttons += '<div class="ff-popup-button">'+sectionName+'</div>'
	        buttons += '</li>'
		});
		
		console.log( 'click');
		
		var $repeatVar =$buttonClicked.parent();// $parent.children('.ff-repeatable-variation-selector');
		
		$repeatVar.find('.ff-popup-container:first').css('display','block');
		$repeatVar.find('.ff-popup-container').css('position','absolute');
		$repeatVar.find('.ff-repeatable-add-variation-selector-popup').html( buttons);
		
		
		$repeatVar.find('.ff-popup-button-wrapper').click(function() {
			$repeatVar.find('.ff-popup-container').css('display','none');
			callback( $(this).attr('data-id'));
		});
		
		$repeatVar.find('.ff-popup-backdrop').click(function(){
			$repeatVar.find('.ff-popup-container').css('display','none');
		});
		
	}
	/*
	$parent.find('.ff-repeatable-variation-selector .ff-popup-container:first').css('display','block');
	$parent.find('.ff-repeatable-variation-selector .ff-popup-container').css('position','relative');
	$parent.find('.ff-repeatable-variation-selector .ff-repeatable-add-variation-selector-popup').html( buttons);
	
	$parent.find('.ff-repeatable-variation-selector .ff-popup-button-wrapper').click(function() {
		$parent.find('.ff-repeatable-variation-selector .ff-popup-container').css('display','none');
		callback( $(this).attr('data-id'));
	});
	
	$parent.find('.ff-repeatable-variation-selector .ff-popup-backdrop').click(function(){
		$parent.find('.ff-repeatable-variation-selector .ff-popup-container').css('display','none');
	});
	*/
};

$(document).on('click', frslib.options.template.selectors.repeatable_button_add_above + ',' + frslib.options.template.selectors.repeatable_button_add_below, function(){

    if( $(this).hasClass('ff-repeatable-add-above-js') || $(this).hasClass('ff-repeatable-add-below-js') ) {
        return;
    }



	$('.ff-datepicker').datepicker('destroy');
	$('.ff-datepicker').attr('id', '');

	$('.has-variation-ff-popup-opened').removeClass('has-variation-ff-popup-opened');
	$(this).parents('.ff-repeatable-variation-selector:first').addClass('has-variation-ff-popup-opened');
	
	var $parent = $(this).parents(frslib.options.template.selectors.repeatable_item_first);
	var $parent_ul = $parent.parents( frslib.options.template.selectors.repeatable_parent_ul_first );
	
	var $template = null;

	
	if( $parent.attr('data-section-id') != undefined ) {
		
		var $templates = $parent_ul.children('.ff-repeatable-template-holder').children('.ff-repeatable-template');
		
		if( $templates.size() > 1 ) {
			
			
			//alert('a');
			add_variation_node_show_selector($parent, $parent_ul, $(this), function( selectedNodeId ){
				$template = $parent_ul.children('.ff-repeatable-template-holder').children(frslib.options.template.selectors.repeatable_template+'[data-section-id="'+selectedNodeId+'"]:first');
				insertTemplate();
			});
			
			return;
		
		} else {
			var template_name = $parent.attr('data-section-id');
	
			$template = $parent_ul.children('.ff-repeatable-template-holder').children(frslib.options.template.selectors.repeatable_template+'[data-section-id="'+template_name+'"]:first');
			
			insertTemplate();
		}
	
	} else {
		$template = $parent_ul.find(frslib.options.template.selectors.repeatable_template);
		insertTemplate();
	}
	
	function insertTemplate() {
		//console.log( $template);
	
		frslib.callbacks.doCallback( frslib.options.template.callbacks.duplicate_before_clone.replace('.',''), $template );
		
		var $newItem = $($template.html());
		$newItem.hide();
		$newItem.find('.ff-repeatable').children('.ff-repeatable-item-hide-default').remove();
		// ADD ABOVE
		if( $(this).hasClass( frslib.options.template.selectors.repeatable_button_add_above.replace('.','') ) ) {
			$parent.before( $newItem );
			
		// ADD BELOW
		} else {
			$parent.after( $newItem );	
		}
		
		//frslib.options.template.callbacks.duplicate_after_clone.replace('.','')
		//frslib.options.template.callbacks.duplicate_after_clone.replace('.','')
		frslib.callbacks.doCallback( 'kkff_duplicate_after_clone', $newItem, $template );
		
		$newItem.addClass('ff-repeatable-add-animation').animate({ height: 'toggle' }, 300, 'swing', function(){
			$(this).removeClass('ff-repeatable-add-animation');
		});
		frslib.options.template.init_sortable();
		//$('.hasDatepicker').datepicker('destroy');
		//$('.hasDatepicker').removeClass('hasDatepicker');
		setTimeout(function(){
			$('.ff-datepicker').datepicker();
			//$('.datepicker_label').find('input').datepicker();
			//$('.datepicker_label').find('input').not('.hasDatepicker').css('opacity', 0.1);
		}, 2000);
		return false;
	
	}
	
	return false;
});


/******************************************************************************/
/** TEMPLATING FUNCTIONS - REMOVE
/******************************************************************************/
/*
 * remove the clicked option
 */
$(document).on('click',frslib.options.template.selectors.repeatable_button_remove, function(){
	
	// TODO - fix it with another way, it's not workin
	// Click on menu background overlay -> hides menu
	/*( frslib.options.template.selectors.repeatable_button_settings_overlay ).click();
	$( frslib.options.template.selectors.repeatable_button_settings_overlay ).click();
	$( frslib.options.template.selectors.repeatable_button_settings_overlay ).click();
	$( frslib.options.template.selectors.repeatable_button_settings_overlay ).click();*/

	var $parent = $(this).parents(frslib.options.template.selectors.repeatable_item_first);
	var $parent_ul = $parent.parents( frslib.options.template.selectors.repeatable_parent_ul_first );
	
	var number_of_siblings_li = $parent_ul.children(frslib.options.template.selectors.repeatable_item).length;

	var enable_delete_all_repeatable_items = $(this).parents('.ff-repeatable:first').hasClass('enable-delete-all-repeatable-items');

	if( ( number_of_siblings_li == 1 ) && ! enable_delete_all_repeatable_items ) {
		$parent.animate({ left:-10},200).animate({ left:10},200).animate({ left:0},200);
		return false;
	}

	$parent.animate({ height: 'toggle', opacity: 'toggle' }, 400, function(){
		$parent.remove();
	});

	return false;
});

/* REPEATABLE LOGIC remove */
$(document).on('click','.ff-repeatable-logic-button-remove', function(){

	var $parent = $(this).parents(frslib.options.template.selectors.repeatable_item_first);
	var $parent_ul = $parent.parents( frslib.options.template.selectors.repeatable_parent_ul_first );
	
	var number_of_siblings_li = $parent_ul.children(frslib.options.template.selectors.repeatable_item).length;
	
	if( number_of_siblings_li == 1 ) {
		var $main_parent = $(this).parents(frslib.options.template.selectors.repeatable_item+':eq(1)');//.remove();
		var length = $main_parent.siblings(frslib.options.template.selectors.repeatable_item).length;
		if( length > 0 ) {
			$main_parent.animate({ height: 'toggle', opacity: 'toggle' }, 300, function(){
				$main_parent.remove();
			});
		} else {
			$parent.animate({ left:-10},200).animate({ left:10},200).animate({ left:0},200);
		}
		//console.log( $main_parent);
		//alert( $main_parent.siblings('.ff-repeatable-item').length);
		//$parent.animate({ left:-10},200).animate({ left:10},200).animate({ left:0},200);
		return;
	}
	
	$parent.animate({ height: 'toggle', opacity: 'toggle' }, 300, function(){
		$parent.remove();
	});
	
	return false;
});


/******************************************************************************/
/** TEMPLATING FUNCTIONS - OPEN & CLOSE
/******************************************************************************/
/*
 * Open/close clicked handle and close all the siblings
 */
$(document).on('click',frslib.options.template.selectors.repeatable_button_handle, function(){
	var $parent = $(this).parents(frslib.options.template.selectors.repeatable_item_first);
	
	var $parent_ul = $parent.parents( frslib.options.template.selectors.repeatable_parent_ul_first );
	
	$parent_ul.children('li').css({opacity:1});
	var speed = 200;
	if( $parent.hasClass(frslib.options.template.selectors.repeatable_item_opened.replace('.','')) ) {
		$parent.children(frslib.options.template.selectors.repeatable_content_first).slideUp(speed, function() {
			$parent.removeClass( frslib.options.template.selectors.repeatable_item_opened.replace('.','') );
			$parent.addClass( frslib.options.template.selectors.repeatable_item_closed.replace('.','') );
		});
	} else {
		
		
		
		$parent.children(frslib.options.template.selectors.repeatable_content_first).slideDown(speed, function() {
			$parent.removeClass(frslib.options.template.selectors.repeatable_item_closed.replace('.',''));
			$parent.addClass(frslib.options.template.selectors.repeatable_item_opened.replace('.',''));
		});

		var $siblings = $parent.siblings( );
		$siblings.each(function(i,o){
			$(o).children(frslib.options.template.selectors.repeatable_content_first).slideUp(speed, function() {
				$(this).parents(frslib.options.template.selectors.repeatable_item_first).removeClass(frslib.options.template.selectors.repeatable_item_opened.replace('.',''));
				$(this).parents(frslib.options.template.selectors.repeatable_item_first).addClass(frslib.options.template.selectors.repeatable_item_closed.replace('.',''));
			});
		});
	}
	return false;	
});

/******************************************************************************/
/** TEMPLATING FUNCTIONS - NORMALIZE
/******************************************************************************/

frslib.options.template.functions.normalize = function( $form, submit ) {
	// first write the values directly to the attributes, so it get copied also.
	// frslib.options.template.selectors.repeatable_parent_ul

	// NORMALIZING THE CONDITIONAL LOGIC FORMS
	$form.find('.ff-option-conditional-logic').each(function(i,o) {
		var $normalizedConditionalLogic = frslib.options.template.functions.normalize( $(this) );
		//var $normalizedConditionalLogic = $normalizedConditionalLogic.wrap('<form></form>');

		var serialised = $('<form>').append( $normalizedConditionalLogic ).serialize()
		$(this).parent().find('.ff-hidden-input').val( serialised );
	});



	// NORMALIZING THE INPUT VALUES
	//$form.find( frslib.options.template.selectors.repeatable_parent_ul ).find('input, select, textarea').each(function(i, o){
	$form.find('input, select, textarea').each(function(i, o){


		// DONT normalize SELECT2 - we will do it in other loop, it gaves us lot of problems
		if( $(this).parents('.ff-select2-real-wrapper').length > 0 ) {
			return;
		}



		// important for clonning the values
		var val = $(this).val();
		$(this).attr('value', val);

		// NORMALIZING INPUTS
		if( $(this).is('input') ) {

			// CHECKBOXES
			if( $(this).attr('type') == 'checkbox' ) {
				var checked = $(this).is(':checked');

				if( checked ) {
					$(this).attr('checked', 'checked');
				}
				else {
					$(this).prop('checked', false);
					$(this).removeAttr('checked');
				}

			}

            if( $(this).attr('type') == 'radio' ) {
                var checked = $(this).is(':checked');

                if( checked ) {
                    var $parent = $(this).parents('.ff-radio-group:first');

                    $parent.find('input').removeAttr('checked');
                    $(this).attr('checked', 'checked');
                }
            }
		}
		// NORMALIZING SELECTS
		else if( $(this).is('select') ) {

			// MULTIPLE
			if( $(this).attr('multiple') == 'multiple' ) {

			}
			// SINGULAR
			else {
				var currentValue =  $(this).val();

				$(this).find('option').removeAttr('selected');
				$(this).find('option').each(function(){
					if( $(this).attr('value') == currentValue ) {
						$(this).attr('selected', 'selected');
						$(this).prop('selected', 'selected');
					}
				});
			}
		}


		else if( $(this).is('textarea') ) {
			$(this).html( $(this).val() );

		}
	});
	// SELECT 2
	$form.find('.ff-select2').each(function(i,o){

		if( $(o).parents('.ff-select2-real-wrapper').length > 0 && $(o).hasClass('select2-container') ) {
			var selectedValues = $(o).select2('val');

			if( !$.isArray( selectedValues ) ) {
				selectedValues = new Array();
			}

			var $inputHidden = $(o).parents('.ff-select2-wrapper:first').find('.ff-select2-value-wrapper').find('input');
			var $parent =  $(o).parents('.ff-select2-wrapper:first');

			$inputHidden.val(selectedValues.join( frslib.options.template.divider  ));
			$inputHidden.attr('value', $inputHidden.val() );

			//$(o).select2('destroy');
		}
	});

	// NORMALIZING THE NAME VALUES
	var $formClonned = $form.clone(true,true);
	var number_of_sections = $formClonned.find('.ff-repeatable').size();

	$formClonned.find('.ff-repeatable-template-holder').remove();
	$formClonned.find('.ff-select2').remove();
	$formClonned.find('.ff-option-conditional-logic').remove();
	$formClonned.find('.ff-select2-value-wrapper').css('display', 'block');
	$formClonned.find('textarea').each(function(){
        //console.log( $(this).val() + 'xxx' );
        //console.log( $(this).html() + 'hhh');

		//$(this).val( $(this).html() );
	});


	for( var i = 0; i < number_of_sections; i++) {
		var $repeat = $formClonned.find('.ff-repeatable:eq('+i+')');

		var currentLevel = $repeat.attr('data-current-level');

		var toReplace = '-_-'+currentLevel+'-TEMPLATE-_-';

		var indexCounter = 0;

		$repeat.children('.ff-repeatable-item').each(function(){

			var replaced = $(this).clone().outerHtml().replace( new RegExp( toReplace,'g'), indexCounter);
			$(this).outerHtml( replaced );
			indexCounter++;
		});
	}
	$formClonned.find('input[type="submit"]').remove();


    $formClonned.find('input[type="checkbox"]').each(function(){
        if( $(this).is(':checked') ) {
            $(this).parent().find('.ff-checkbox-shadow').remove();
        }
    });
	//$form.submit();

	// add special option which flag normalization

	var normalizationFlagger = '<input type="hidden" name="has-been-normalized" value="1" />';

	$formClonned.append( normalizationFlagger );

	if( submit == true ) {
		$formClonned.css('display','none').appendTo('body');


		$formClonned.submit();
	} else {
		return $formClonned
	}
};


$(document).ready(function(){


/*	$('.ff-testing-option-form').submit(function(){
		var $form = frslib.options.template.functions.normalize( $('.ff-testing-option-form') );
		
		$form.appendTo('body');
		
		return false;
	});*/
	
	$('.ff-form-submit').click(function(){
		var form = frslib.options.template.functions.normalize( $(this).parents('form:first'), true );
		
		//form.appendTo('body');
		return false;
	});

	
$('.fftestform').find('.sbmt').click(function(){;
    return;
	var form = frslib.options.template.functions.normalize( $(this).parents('form:first') );
	//console.log( form.serialize() );
	return false;
	
});

////////////// WIDGETS
$(document).on('widget-updated', function( event, $selector ){
    //alert(' updated ');
	//console.log( a,b ,c );
//	frslib.options.template.init();

	$selector.find('.ff-select2-wrapper').each(function(){
		
		var value = $(this).find('.ff-select2-value-wrapper').find('input').val();
		var valueSplitted = value.split('--||--');
		
		frslib.options.select2.create( $(this).find('.ff-select2-real-wrapper').find('.ff-select2'), valueSplitted );
		//console.log( valueSplitted );
		 //$(this).find('.ff-select2-real-wrapper').find('.ff-select2').select2('val', 'sidebar-1');
		 //$(this).find('.ff-select2-real-wrapper').find('.ff-select2').css('opacity',0.1);
	});


	  //$(document).ready(function(){
            $('.ff-repeatable').css('display', 'block');
            frslib.options.functions.initParticularOptions();

	  //});


	//frslib.options.select2.init();
});

    $(document).on('widget-added', function( event, $selector ){
        //alert('pica');
	//console.log( a,b ,c );
//	frslib.options.template.init();
    console.log( $selector );
	$selector.find('.ff-select2-wrapper').each(function(){

        var $shadowWrapper = $(this).find('.ff-select2-shadow-wrapper');
        $(this).find('.ff-select2-real-wrapper').html( $shadowWrapper.html() );


		var value = $(this).find('.ff-select2-value-wrapper').find('input').val();
		var valueSplitted = value.split('--||--');

		frslib.options.select2.create( $(this).find('.ff-select2-real-wrapper').find('.ff-select2'), valueSplitted );

		//console.log( valueSplitted );
		//$(this).find('.ff-select2-real-wrapper').find('.ff-select2').select2('val', 'sidebar-1');
		//$(this).find('.ff-select2-real-wrapper').find('.ff-select2').css('opacity',0.1);
	});


	//frslib.options.select2.init();
});


$('.widget-control-actions').find('input[type="submit"]').click(function(){
	var $form = $(this).parents('form:first').find('.ff-widget-options-wrapper');
	
	var $normalizedForm = frslib.options.template.functions.normalize( $form );
	$form.html('').html( $normalizedForm.html() );
	
	$form.css('opacity', 0);
	
	//return false;
	
	//frslib.options.template.functions.normalize
	//alert('aaa');
	//return false;
});

});
/*
$('#xxxxxxxx').click(function(){
		$(this).parents('form:first').find('.ff-repeatable-template').remove();
		//$(this).parents('form:first').find('.ff-repeatable-item')
		//console.log($(this).parents('form:first').serialize());
		//return false;
		//return false;
		
		var $form = $('.ff-repeatable').parents('form:first');
		
		
		var number_of_sections = $form.find('.ff-repeatable').size();
		
		$('.ff-repeatable').find('input').each(function(){
			var val = $(this).val();
			$(this).attr('value', val);
			
			if( $(this).attr('type') == 'checkbox' ) {
				var checked = $(this).is(':checked');
				
				if( checked ) {
					$(this).attr('checked', 'checked');
				}
				else {
					$(this).prop('checked', false);
					$(this).removeAttr('checked');
				}
				
			}
		});
		
		
		for( var i = 0; i < number_of_sections; i++) {
			var $repeat = $form.find('.ff-repeatable:eq('+i+')');
			
			var currentLevel = $repeat.attr('data-current-level');
			
			var toReplace = '-_-'+currentLevel+'-TEMPLATE-_-';
			
			var indexCounter = 0;
			
			$repeat.children('.ff-repeatable-item').each(function(){
				var replaced = $(this).clone().outerHtml().replace( new RegExp( toReplace,'g'), indexCounter);
				$(this).outerHtml( replaced );
				indexCounter++;
			});
		}
		
		if( $('.ffsend').is(':checked')) {
			
		} else {
			return false;
		}
	});
});
*/
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// SELECT 2
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################

frslib.provide('frslib.options.select2');
frslib.provide('frslib.options.select2.selectors');

frslib.options.select2.selectors.main_wrapper = '.ff-select2-wrapper';
frslib.options.select2.selectors.real_wrapper = '.ff-select2-real-wrapper';
frslib.options.select2.selectors.shadow_wrapper = '.ff-select2-shadow-wrapper';
frslib.options.select2.selectors.select2_class = '.ff-select2';

/******************************************************************************/
/** INITIALIZE SELECT2
/******************************************************************************/
frslib.options.select2.init = function() {
	$(document).ready(function(){
		
		$('.ff-select2-wrapper').each(function(){
			
			var value = $(this).find('.ff-select2-value-wrapper').find('input').val();
			var valueSplitted = value.split('--||--');
			
			frslib.options.select2.create( $(this).find('.ff-select2-real-wrapper').find('select.ff-select2'), valueSplitted );
			//console.log( valueSplitted );
			 //$(this).find('.ff-select2-real-wrapper').find('.ff-select2').select2('val', 'sidebar-1');
			 //$(this).find('.ff-select2-real-wrapper').find('.ff-select2').css('opacity',0.1);
		});
	});
}
frslib.options.select2.init();
/******************************************************************************/
/** CREATE OPTION
/******************************************************************************/
/**
 * Initialize select 2 on a SELECT option. Here we also have needed classes to
 * perform this action.
 */
frslib.options.select2.create = function( $selector, value ) {
	$(document).ready(function(){
		if( value == undefined ) {
			value = '';
		}
		$selector.each(function(){
			$(this).select2({
				containerCssClass	: frslib.options.select2.selectors.select2_class.replace('.',''),
				dropdownCssClass	: frslib.options.select2.selectors.select2_class.replace('.','')+' select2-hidden',
				placeholder : 'All',

			});
		
		});
	});
};


/******************************************************************************/
/** CALLBACK - DUPLICATE - BEFORE CLONE
/******************************************************************************/
frslib.callbacks.addCallback( frslib.options.template.callbacks.duplicate_before_clone.replace('.',''), function( $parent ) {

	$parent.find( frslib.options.select2.selectors.main_wrapper ).each(function(i,o){
		var data = $(o).find(frslib.options.select2.selectors.real_wrapper).find( frslib.options.select2.selectors.select2_class ).select2('data');
		$(o).find(frslib.options.select2.selectors.real_wrapper).data('select2-data', data);
	});
});

/******************************************************************************/
/** CALLBACK - DUPLICATE - AFTER CLONE
/******************************************************************************/
//console.log(frslib.options.template.callbacks.duplicate_after_clone.replace('.',''));
frslib.callbacks.addCallback( 'kkff_duplicate_after_clone', function( $newItem, $parent ){
 
	
	
	$newItem.find( frslib.options.select2.selectors.main_wrapper ).each(function(i,o){
		var data = $(o).find(frslib.options.select2.selectors.real_wrapper).data('select2-data');
		var newHtml = $(o).find(frslib.options.select2.selectors.shadow_wrapper).html();
		$(o).find(frslib.options.select2.selectors.real_wrapper).html(newHtml);
		
		
		frslib.options.select2.create( $(o).find(frslib.options.select2.selectors.real_wrapper).find('select') );
		
		if( data == null ) {
			return;
		}
		
		if( data.length == null ) {
			$(o).find(frslib.options.select2.selectors.real_wrapper).find( frslib.options.select2.selectors.select2_class ).select2('val',data.id);
		} else {
			var newValues = new Array();
			
			for( var key in data ) {
				newValues.push(data[ key ].id);
			}
			
			$(o).find(frslib.options.select2.selectors.real_wrapper).find( frslib.options.select2.selectors.select2_class ).select2('val',newValues);
		}
	});
	
	$newItem.find(frslib.options.select_content_type.selectors.ff_select_content_type).change(); // for preloading the conditional logic
});

/******************************************************************************/
/** ADD VALUES
/******************************************************************************/

/**
 * Add realtime values to the select2 by destryoing it, adding values and
 * creating again.
 * 
 * format of values is HTML options
 * 
 * The selector mus thave class main_wrappers
 */
frslib.options.select2.setValuesHtml = function( $select2_main_wrapper, values ) {
	if( !$select2_main_wrapper.hasClass( frslib.options.select2.selectors.main_wrapper.replace('.','') ) ) {
		console.log('ERROR - frslib.options.select2.addValues SELECTOR MUST HAVE CLASS "'+frslib.options.select2.selectors.main_wrapper+'"');
		return;
	}
	// destroy the select 2 ( otherwise we cant add data )
	$select2_main_wrapper.find( frslib.options.select2.selectors.real_wrapper ).find( '.ff-select2' ).select2('destroy');
	$select2_main_wrapper.find( frslib.options.select2.selectors.real_wrapper ).find( '.select2-container-multi' ).remove();
	// add data to both selects
	$select2_main_wrapper.find( frslib.options.select2.selectors.real_wrapper ).find( frslib.options.select2.selectors.select2_class ).html( values );
	// find the select which should be select 2 and then set the values
	var $select2_to_initialize = $select2_main_wrapper.find( frslib.options.select2.selectors.real_wrapper ).find( 'select' );
	
	
	frslib.options.select2.create( $select2_to_initialize );
};

/**
 * Add realtime values to the select2 by destryoing it, adding values and
 * creating again.
 * 
 * format of values is array
 * values [ name ] = value
 * 
 * The selector mus thave class main_wrappers
 */
frslib.options.select2.setValuesArray = function( $select2_main_wrapper, values ) {
	if( !$select2_main_wrapper.hasClass( frslib.options.select2.selectors.main_wrapper.replace('.','') ) ) {
		console.log('ERROR - frslib.options.select2.addValues SELECTOR MUST HAVE CLASS "'+frslib.options.select2.selectors.main_wrapper+'"');
		return;
	}
	// destroy the select 2 ( otherwise we cant add data )
	$select2_main_wrapper.find( frslib.options.select2.selectors.real_wrapper ).find( frslib.options.select2.selectors.select2_class ).select2('destroy');
	// add data to both selects
	
	var newValues = '';
	for( var key in values ) {
		newValues += '<option value="'+values[key]+'">'+key+'</option>';
	}
	$select2_main_wrapper.find( frslib.options.select2.selectors.select2_class ).html( newValues );
	// find the select which should be select 2 and then set the values
	var $select2_to_initialize = $select2_main_wrapper.find( frslib.options.select2.selectors.real_wrapper ).find( frslib.options.select2.selectors.select2_class );
	frslib.options.select2.initialize( $select2_to_initialize );
};

frslib.options.select2.hasValue = function( $select2_main_wrapper, value ) {
	if( !$select2_main_wrapper.hasClass( frslib.options.select2.selectors.main_wrapper.replace('.','') ) ) {
		console.log('ERROR - frslib.options.select2.addValues SELECTOR MUST HAVE CLASS "'+frslib.options.select2.selectors.main_wrapper+'"');
		return;
	}
	
	$select2_main_wrapper.find( frslib.options.sleect2.selectors.shadow_wrapper).find('option').each(function(){
		//console.log( 'shit ');
	});
};

//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//SELECT CONTENT TYPE
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
frslib.provide('frslib.options.select_content_type');
frslib.provide('frslib.options.select_content_type.selectors');
frslib.provide('frslib.options.select_content_type.fetched_data');

frslib.options.select_content_type.selectors.ff_select_content_type = '.ff-select-content-type';
frslib.options.select_content_type.selectors.ff_select_content_type_data = '.ff-select-content-type-data';

frslib.options.select_content_type.init = function() {
	$(document).ready(function(){
		var data = $(frslib.options.select_content_type.selectors.ff_select_content_type_data).html();
		
		$('.ff-select-content-type').each(function(){
		
			//var value = $(this).attr('data-value');
			var $select = $(this);
			$(frslib.options.select_content_type.selectors.ff_select_content_type).html( data );
			

		});

		$('.ff-select-content-type').each(function(){
			var value = $(this).attr('data-value');
			
			if( value != undefined && value != '' ) {
				 $(this).attr('data-value', '');
				var $select = $(this);
				$(this).find('option').each(function(i,o){
				
				    if( $(this).attr('value') == value ) {
				         $(this).attr('selected','selected');   
				         //$(o).remove();
				         
				         $select.val( value );
				    }
				});
			}
		});

		
		
		
		$(frslib.options.select_content_type.selectors.ff_select_content_type).trigger('change');
		
	});
	
};
//ffOptionsPrinterDataBoxGenerator
$(document).on('change', frslib.options.select_content_type.selectors.ff_select_content_type, function(){

	var current_value = $(this).val();
	var $changed_select = $(this);
	
	
	$changed_select.parents('table:first').find('.ff-select2-wrapper').find('.ff-select2').hide();
	var $spinner=  $('<div class="spinner"></div>').css('display','block');
	$changed_select.parents('table:first').find('.ff-select2-wrapper').parent().before( $spinner );
	
	
	var continue_with_change = function() {
		var new_values = frslib.options.select_content_type.fetched_data[ current_value ];
		
		//console.log( new_values );
		
		
		
		frslib.options.select2.setValuesHtml($changed_select.parents('table:first').find('.ff-select2-wrapper'), new_values);
		$spinner.remove();
		$changed_select.parents('table:first').find('.ff-select2-wrapper').find('.ff-select2').show();
		
		var selected_value = $changed_select.parents('table:first').find('.ff-select2-wrapper').find('.ff-select2-value-wrapper input').val();
		
		
		if( selected_value != undefined && selected_value != '' ) {
			var value_new = ( selected_value.split('--||--'));
			$changed_select.parents('table:first').find('.ff-select2-real-wrapper').find('.ff-select2').val( value_new );
			$changed_select.parents('table:first').find('.ff-select2-real-wrapper').find('.ff-select2').select2('val', value_new);
			$changed_select.parents('table:first').find('.ff-select2-wrapper').find('.ff-select2-value-wrapper input').val('');
			
			//$changed_select.parents('table:first').find('.select2-container-multi').css('display', 'none');
			//}, 500);
		}
		
		
	};
	
	if( frslib.options.select_content_type.fetched_data[ current_value ] == undefined ) {
		frslib.ajax.frameworkRequest( 'ffOptionsPrinterDataBoxGenerator', {'type':'select_content_type'}, { 'select_value' : current_value }, function( response ){
			frslib.options.select_content_type.fetched_data[ current_value ] = response;
			continue_with_change();
		});
	} else {
		continue_with_change();
	}
});


frslib.options.select_content_type.init();



//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// CONDITIONAL LOGIC
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
frslib.provide( 'frslib.conditional_logic');
$(document).on('click','.ff-logic',function(){
	
	frslib.modal.conditional_logic.set_content( $(this).val() );
	frslib.modal.conditional_logic.current_input = $(this);

});

// enabling / disabling the custom logic
$(document).on('click', '.ff-conditional-logic-checkbox', function(){
	//1$(this).parent().parent().find('.ff-conditional-logic-options').;
	 //ff-repeatable-logic-disabled
	
	frslib.conditional_logic.disable_options( $(this ) );
});

frslib.conditional_logic.disable_options = function( $checkbox ) {
	if( $checkbox.attr('checked') == 'checked' ) {
		$checkbox.parent().parent().find('.ff-conditional-logic-options').removeClass('ff-repeatable-logic-disabled');
	} else {
		$checkbox.parent().parent().find('.ff-conditional-logic-options').addClass('ff-repeatable-logic-disabled');
	}
};
$(document).ready(function(){
	$('.ff-conditional-logic-checkbox').each(function(){
		frslib.conditional_logic.disable_options( $(this ) );
	});
});

//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//IMAGE
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
(function(){

	$(document).on('click','.ff-open-image-library-button',function(e){

		$('.ff-open-image-library-button-opened').removeClass('ff-open-image-library-button-opened');
		$(this).addClass('ff-open-image-library-button-opened');

		e.preventDefault();

		// http://codecanyon.net/forums/thread/wordpress-35-media-uploader-api/83117

		var custom_uploader = wp.media({
			title: 'Select Image',
			button: { text: 'Select Image' },
			library : { type : 'image'},
			// id: 103,
			multiple: false  // Set this to true to allow multiple files to be selected
		});




		// Multiple
		// custom_uploader.on('open',function() {
		// 	var selection = custom_uploader.state().get('selection');
		// 	ids = jQuery('#my_field_id').val().split(',');
		// 	ids.forEach(function(id) {
		// 		attachment = wp.media.attachment(id);
		// 		attachment.fetch();
		// 		selection.add( attachment ? [ attachment ] : [] );
		// 	});
		// });

		// Single
		custom_uploader.on('open',function() {
			var selection = custom_uploader.state().get('selection');
			var jsoned_value = $('.ff-open-image-library-button-opened').find('input').val();
			if( jsoned_value ){ ; } else { return; }

			try {
				obj = JSON.parse( jsoned_value );
			} catch(err) {
    			return;
    		}

			if( obj ){ ; } else { return; }
			var id = obj.id;

			var attachment = wp.media.attachment(id);
			attachment.fetch();
			selection.add( attachment ? [ attachment ] : [] );
		});

		custom_uploader.on('select', function() {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			$('.ff-open-image-library-button-opened').find('.custom_media_image').attr('src', attachment.url);

			// $('.ff-open-image-library-button-opened').find('.custom_media_url').val(attachment.url);
			// $('.ff-open-image-library-button-opened').find('.custom_media_id').val(attachment.id);

			j = { "id":attachment.id, "url":attachment.url, "width":attachment.width, "height":attachment.height };

			$('.ff-open-image-library-button-opened').find('input').val( JSON.stringify( j ) );
			$('.ff-open-image-library-button-opened').find('input').change();

			$('.ff-open-image-library-button-opened').find('.ff-open-library-button-preview-image').css('background-image', 'url(' + attachment.url + ')');
			$('.ff-open-image-library-button-opened').parents('.ff-open-image-library-button-wrapper').removeClass('ff-empty');

			libraryImageCheckSizes( $('.ff-open-image-library-button-opened') );
			//$('.ff-open-image-library-button-opened').find('.ff-open-library-button-preview-image-large').css('background-image', 'url(' + attachment.url + ')').css('width', attachment.width + 'px').css('height', attachment.height + 'px').css('right', '-' + attachment.width + 'px');

			var $largeImg = $('.ff-open-image-library-button-opened .ff-open-library-button-preview-image-large');
			$largeImg.attr('src', attachment.url);
			$largeImg.attr('width', attachment.width);
			$largeImg.attr('height', attachment.height);

			$largeImg.each(function(){
				libraryImagePreviewLarge($(this));
			});
		})
		.open();
	});

	function libraryImageCheckSizes( $button ){

		$button.removeClass('ff-bad-resolution');

		var forced_width  = $button.attr('data-forced-width');
		if( forced_width ){ }else{ return; }

		var forced_height = $button.attr('data-forced-height');
		if( forced_height ){ }else{ return; }

		var val_JSON = $button.find('input').val();
		if( val_JSON ){ }else{ return; }

		if( $button.parents('.ff-open-image-library-button-wrapper').hasClass('ff-empty') ){
			return;
		}

		var val = JSON.parse( val_JSON );

		if( forced_height != val.height ){
			$button.addClass('ff-bad-resolution');
			return;
		}

		if( forced_width != val.width ){
			$button.addClass('ff-bad-resolution');
			return;
		}
	}

	function libraryImagePreviewLarge($largeImg){
		var WIDTHLIMIT = 600;
		var HEIGHTLIMIT = 300;

		var width = 0;
		var height = 0;

		//var $largeImg = $(largeImgSelector);

		var realWidth = $largeImg.attr('width');
		var realHeight = $largeImg.attr('height');

		if ( realWidth > realHeight ){
			if ( realWidth > WIDTHLIMIT ) {
				width = WIDTHLIMIT + 'px';
			} else {
				width = realWidth + 'px';
			}
			height = 'auto';
		} else if ( realWidth == realHeight ){
			if ( realWidth > WIDTHLIMIT ) {
				width = HEIGHTLIMIT + 'px';
				height = HEIGHTLIMIT + 'px';
			} else {
				width = realWidth + 'px';
				height = realHeight + 'px';
			}
		} else 	{
			if ( realHeight > HEIGHTLIMIT ) {
				height = HEIGHTLIMIT;
			} else {
				height = realHeight;
			}
			width = (height / realHeight ) * realWidth;
			width = width + 'px';
			height = height + 'px';
		}

		$largeImg.css('width', width);
		$largeImg.css('height', height);
		var right = parseInt(width)+2 + 'px';
		$largeImg.parents('.ff-open-library-button-preview-image-large-wrapper').css('right', '-' + right);

		if( '' == $largeImg.attr('src') ){
			$largeImg.parents('.ff-open-image-library-button-wrapper').addClass('ff-empty');
		}else{
			$largeImg.parents('.ff-open-image-library-button-wrapper').removeClass('ff-empty');
		}
	}

	$(document).ready(function(){
		
		
		
		$('.ff-repeatable>.ff-repeatable-item .ff-open-image-library-button .ff-open-library-button-preview-image-large').each(function(){
			libraryImagePreviewLarge($(this));
			$('.ff-open-image-library-button').each(function(){
				libraryImageCheckSizes( $(this) );
			});
		});
	});


	$(document).on('click','.ff-open-library-remove',function(e){
		var $button = $(this).parents('.ff-open-image-library-button-wrapper').find('.ff-open-image-library-button');
		if( $button ){
			$button.removeClass('ff-bad-resolution');
			$button.find('input').val( '' );
			$button.find('input').change( );
			$button.find('.ff-open-library-button-preview-image').css('background-image', 'none');
			$button.parents('.ff-open-image-library-button-wrapper').addClass('ff-empty');
			$button.parents('.ff-open-image-library-button-wrapper').find('.ff-open-library-button-preview-image-large').attr('src','');
		}
	});


	return;


	// wp.media.freshfaceLib = {

	// 		library: { type : 'image'},

	// 		frame: function() {
	// 		    if ( this._frame )
	// 		        return this._frame;

	// 		    this._frame = wp.media({
	// 		        id:         'my-frame',
	// 		        frame:      'post',
	// 		        state:      'gallery-edit',
	// 		        title:      wp.media.view.l10n.editGalleryTitle,
	// 		        editing:    true,
	// 		        multiple:   true
	// 		    });
	// 		    return this._frame;
	// 		},

	// 		init: function() {
	// 		    $('.ff-open-image-library-button').click( function( event ) {
	// 		        event.preventDefault();

	// 				// Set the post ID to what we want
	// 				// file_frame.uploader.uploader.param( 'post_id', set_to_post_id );

	// 		        wp.media.freshfaceLib.frame().open();

	// 		    });
	// 		}
	// 	};

	// 	$(document).ready(function(){
	// 	    $( wp.media.freshfaceLib.init );
	// 	});


/*	var sendAttachmentBackup = wp.media.editor.send.attachment;
	var firedFromUs = false;
	
	
	$(document).on('click','.ff-open-image-library-button',function(){
		firedFromUs = true;
		
		 wp.media.editor.send.attachment = function(props, attachment){
			    /* //	console.log( attachment );
			      if ( _custom_media ) {
			        $("#"+id).val(attachment.url);
			      } else {
			        return _orig_send_attachment.apply( this, [props, attachment] );
			      };* /
		 }
		 
		 wp.media.editor.open('x');
	});*/
})();
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//DATEPICKER
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
(function(){
	if( 0 < $('.ff-datepicker').size() ){
		$('.ff-datepicker').datepicker();
	}
})(jQuery);


(function($) {

	$(document).on('change', 'select[data-enables]', function( e ){
		enableSections( $(this) );
		
		//console.log( '.'+enablesClass );
		///console.log( '.'+enabledGroupClass+'x' );
	});
	
	$('select[data-enables]').each(function(){
			enableSections( $(this) );
		});
	
	
	frslib.callbacks.addCallback( frslib.options.template.callbacks.duplicate_after_clone.replace('.',''),function( $newItem, $template ) {
		$newItem.find('select[data-enables]').each(function(){
			enableSections( $(this) );
		});
	});
	
	function enableSections( $select ) {
		var enablesClass = $select.attr('data-enables');
		var value = $select.val();
		
		var enabledGroupClass = ( enablesClass + '-' + value);
		
		$('.'+enablesClass).addClass('ff-disabled');
		$('.'+enabledGroupClass).removeClass('ff-disabled');
	}
	
	  $(document).ready(function(){
		  $('.ff-repeatable').css('display', 'block');
		  
	  });
	
})(jQuery);
/*
var _custom_media = true,
_orig_send_attachment = wp.media.editor.send.attachment;
$(document).on('click','.ff-test-button',function(){
	 var send_attachment_bkp = wp.media.editor.send.attachment;
	    var button = $(this);
	    var id = button.attr('id').replace('_button', '');
	    _custom_media = true;
	    wp.media.editor.send.attachment = function(props, attachment){
	    //	console.log( attachment );
	      if ( _custom_media ) {
	        $("#"+id).val(attachment.url);
	      } else {
	        return _orig_send_attachment.apply( this, [props, attachment] );
	      };
	    }

	    wp.media.editor.open(button);
	    
	    window.send_to_editor = function(a, b, c, d ) {
	    	console.log( 'xx' );
	    	//console.log( a );
	    	//console.log( b );
	    	console.log( c );
	    }
	    
	 
	    
	    frame = wp.media({
	        title : 'My Gallery Title',
	        multiple : true,
	        library : { type : 'image'},
	        button : { text : 'Insert' },
	      });
	    
	    frame.on('open',function() {
	    	  var selection = frame.state().get('selection');
	    	  ids = jQuery('#my_field_id').val().split(',');
	    	    ids.forEach(function(id) {
	    	  attachment = wp.media.attachment(id);
	    	  attachment.fetch();
	    	  selection.add( attachment ? [ attachment ] : [] );
	    	});
	    	});
	    
	    return false;
}); */

// console.log( window.send_to_editor + 'x');

//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// HELPERs
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################


(function($) {
	  'use strict';
	  
	  
	  var hasNativeOuterHTML = !!('outerHTML' in $('<div></div>').get(0));
	  
	  // Prefer the native `outerHTML` property when possible
	  var getterFn = function() {
	    var target = this.get(0);

	    // If the browser supports the `outerHTML` property on elements AND if `target` is an element node
	    if (hasNativeOuterHTML && target.nodeType === 1) {
	      return target.outerHTML;
	    }
	    else {
	      return $('<div></div>').append(this.eq(0).clone()).html();
	    }
	  };
	  
	  var setterFn = function(value) {
	    // Do not attempt to replace anything using the native `outerHTML` property setter
	    // even if it exists: it is riddled with bugs!
	    return $('<div id="jquery-outerHtml-transformer"></div>').append(value).contents().replaceAll(this);
	  };

	  // Detect jQuery 1.8.x bug (for which the value here is `false`)
	  var doesNotLeaveTempParentOnDetachedDomElement = true;

	  $.fn.outerHtml = function(value) {
	    if (arguments.length) {
	      if (doesNotLeaveTempParentOnDetachedDomElement) {
	        return setterFn.call(this, value);
	      }
	      else {
	        // Fix for jQuery 1.8.x bug: https://github.com/JamesMGreene/jquery.outerHtml/issues/1
	        var parentsOfThis = (function() {
	          var parents = new Array(this.length);
	          this.each(function(i) {
	            parents[i] = this.parentNode || null;
	          });
	          return parents;
	        }).call(this);
	        
	        return setterFn.call(this, value).map(function(i) {
	          if (!parentsOfThis[i]) {
	            if (this.parentNode) {
	              return this.parentNode.removeChild(this);
	            }
	          }
	          else if (parentsOfThis[i] !== this.parentNode) {
	            // Appending to the end: this doesn't seem right but it should cover the detached DOM scenarios
	            return parentsOfThis[i].appendChild(this);
	          }
	          return this;
	        });
	      }
	    }
	    else {
	      return getterFn.call(this);
	    }
	  };
	  
	  // Detect jQuery 1.8.x bug (for which the value here is `false`)
	  doesNotLeaveTempParentOnDetachedDomElement = (function() {
	    var parent = $('<s>bad</s>').outerHtml('<div>good</div>').get(0).parentNode;
	    return (parent.nodeName === '#document-fragment' && parent.nodeType === 11);
	  })();
	  


	}(jQuery));










return;
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


})(jQuery);