/**
 * Adding our uptions into WP admin menu by javascript
 *
 */
(function($){


    $(document).ready(function(){

/**********************************************************************************************************************/
/* HIJACK WP ACTIONS
/**********************************************************************************************************************/
        if( !wpNavMenu ) {
            return false;
        }



        var backupAddMenuItemToBottom = wpNavMenu.addMenuItemToBottom;
        var backupAddMenuItemToTop = wpNavMenu.addMenuItemToTop;

        // from wordpress callbacks we can have the HTML markup of newly added item
        // where unique is DataBase ID of the menu post
        var findItemBasedOnItsHTMLMarkup = function( htmlMarkup ) {
            var dbId = $(htmlMarkup).find('.menu-item-data-db-id').val();
            var $newItem = $('.menu-item-data-db-id[value="'+dbId+'"]').parents('li.menu-item:first');

            return $newItem;
        }

        wpNavMenu.addMenuItemToTop = function( menuMarkup ) {
            backupAddMenuItemToTop( menuMarkup );

            var $newItem = findItemBasedOnItsHTMLMarkup( menuMarkup );
            addOurOptionsToMenuItem( $newItem );

            frslib.options.functions.initParticularOptions();
        }

        wpNavMenu.addMenuItemToBottom = function( menuMarkup ) {
            backupAddMenuItemToBottom( menuMarkup );

            var $newItem = findItemBasedOnItsHTMLMarkup( menuMarkup );
            addOurOptionsToMenuItem( $newItem );

            frslib.options.functions.initParticularOptions();
        }




/**********************************************************************************************************************/
/* ADDING OPTIONS TO THE MENU ITEM
/**********************************************************************************************************************/
        var printerBoxed = frslib.options.walkers.printerBoxed();
        var structure = $('.ff-menu-options-holder .ff-options-structure-js').html();
        var currentMenuId = parseInt($('#menu').val());

        var data = null;

        if( $('.ff-menu-options-wrapper').find('.ff-menu-data-holder').html() != '' ) {
            data = JSON.parse($('.ff-menu-options-wrapper').find('.ff-menu-data-holder').html());
        }

        printerBoxed.setStructureString( structure );

        var addOurOptionsToMenuItem = function( $menuItem ) {

            var currentItemDBID = $menuItem.find('.menu-item-data-db-id').val();
            var dataJSON = null;

            if( data != undefined && data[ currentMenuId ] && data[ currentMenuId ][ currentItemDBID ] ) {
                dataJSON = ( data[ currentMenuId ][ currentItemDBID ] );
                dataJSON = dataJSON;
                printerBoxed.setDataJSON( dataJSON );
            }

            var $html = '<div class="ff-menu-options-holder">' +  printerBoxed.walk() + '</div>';

            $menuItem.find('.field-description').after(  $html );
        }

        // add our options to all existing items
        $('ul.menu').find('.menu-item').each(function(){
            addOurOptionsToMenuItem( $(this) );
        });
        frslib.options.functions.initParticularOptions();

/**********************************************************************************************************************/
/* SAVING OPTIONS
/**********************************************************************************************************************/

        $('#save_menu_header, #save_menu_footer').click( function() {

            $('ul.menu').find('.menu-item').each(function(){
                var $form = $(this).find('.ff-menu-options-holder');

                $form = frslib.options.template.functions.normalize( $form );
                $form = $('<form>' + $form.html() + '</form>');

                var formSerialized = $form.serializeObject();
                var formJson = JSON.stringify( formSerialized );
                var menuItemDBId = $(this).find('.menu-item-data-db-id').val();

                var textArea = '<textarea name="ff-menu-item-settings['+menuItemDBId + ']" style="display:none;">' + formJson + '</textarea>';

                // add invisible textarea with jsoned options
                $(this).find('.ff-menu-options-holder').after( textArea );

                // delete the original unused options, so they wont take a place for other menu items
                $(this).find('.ff-menu-options-holder').find('*').removeAttr('name');
            });

        });




    });










})(jQuery);