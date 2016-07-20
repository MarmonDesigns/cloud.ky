(function($){
    jQuery(document).ready(function($){

         var specification = {};
        specification.metaboxClass = 'ffMetaBoxLayoutContent';
        var data = {};
        data.action = 'getOptions';
        data.postId = $('.ff-post-id-holder').html();
        frslib.ajax.frameworkRequest( 'ffMetaBoxManager', specification, data, function( response ){
            $('.ff-repeatable-spinner').hide(500);

            setTimeout(function() {
                $('#Layout .ff-metabox-normalize-options').html(response);
                //setTimeout()
                frslib.options.functions.initOptionsJS();
            }, 500);
        });



/**********************************************************************************************************************/
/* CHECK BEFORE SAVING
/**********************************************************************************************************************/

        if( $('#original_publish').val() == 'Publish' ) {
            return false;
        }


        // create save ajax button
        var saveAjaxHtml = '<input type="submit" name="save-ajax" id="ff-layout-save-ajax" class="button button-primary button-large" value="Save Ajax" accesskey="p">';
        $('#publish').after('<br><br>'+ saveAjaxHtml );

/**********************************************************************************************************************/
/* SAVING CLICK FUNCTION
/**********************************************************************************************************************/
        $(document).on('click', '#ff-layout-save-ajax', function() {
            $('#publishing-action .spinner').css('display', 'block');
            $('#Layout, #LayoutConditions, #LayoutPlacement').animate({opacity:0.2}, 500);

            var $contentForm = $('#Layout .ff-metabox-normalize-options .ff-options-js');
            var $conditionsForm = $('#LayoutConditions .ff-metabox-normalize-options');
            var $placementForm = $('#LayoutPlacement .ff-metabox-normalize-options');

            var $normalizedContentForm = frslib.options.template.functions.normalize( $contentForm, false );
            var $normalizedConditionsForm = frslib.options.template.functions.normalize( $conditionsForm, false );
            var $normalizedPlacementForm = frslib.options.template.functions.normalize( $placementForm, false );

            //function( owner, specification, data, callback ) {
            var specification = {};
			specification.metaboxClass = 'ffMetaBoxLayoutContent';

            var data = {};

            data.serialisedContent = $('<form>' + $normalizedContentForm.html() + '</form>').serialize();
            data.serialisedConditions = $('<form>' + $normalizedConditionsForm.html() + '</form>').serialize();
            data.serialisedPlacement = $('<form>' + $normalizedPlacementForm.html() + '</form>').serialize();
            data.postId = $('#post_ID').val();

            data.action = 'save';


            frslib.ajax.frameworkRequest('ffMetaBoxManager', specification, data, function( response ){

                $('#publishing-action .spinner').css('display', 'none');
                $('#Layout, #LayoutConditions, #LayoutPlacement').animate({opacity:1}, 500);

                $('.ff-revision-list-content').html( response );
            });

            return false;

        });
/**********************************************************************************************************************/
/* REVISION SETTING FUNCTION
/**********************************************************************************************************************/
        $(document).on('click', '.ff-revision-switch', function(){

            var revisionNumber = $(this).attr('data-revision-number');

            if( revisionNumber == 'current'  ) {
                return false;
            }

            if( !confirm('You are rolling back to different revision. All your unsaved changes will be lost!' ) ) {
                return false;
            }


            var specification = {};
            specification.metaboxClass = 'ffMetaBoxLayoutContent';
            var data = {};
            data.action = 'rollbackToRevision';
            data.postId = $('.ff-post-id-holder').html();
            data.revisionNumber = revisionNumber;
            $('#publish, #ff-layout-save-ajax').prop('disabled', true);
            $('#Layout').animate({opacity:0.5},500);
            frslib.ajax.frameworkRequest( 'ffMetaBoxManager', specification, data, function( response ){

                 $('.ff-repeatable-spinner').hide(500);

                setTimeout(function() {
                    $('#Layout .ff-metabox-normalize-options').html(response);
                    //setTimeout()
                    frslib.options.functions.initOptionsJS();

                    $('#publish, #ff-layout-save-ajax').prop('disabled', false);
                    $('#Layout').animate({opacity:1},500);
                }, 500);




                return;
                $('#OnePage .ff-metabox-normalize-options').html( response) ;

                $('#OnePage').animate({opacity:1},500);

                $('#publish').prop('disabled', false);

                var $toInit = $('#OnePage .ff-metabox-normalize-options .ff-options-js-wrapper ');
                //frslib.options.functions.initOneOptionSet( $toInit );
                //frslib.options.functions.initOneOptionSet( $(this) );
                frslib.options.functions.initOptionsJS();

                var url      = window.location.href;

                if( url.indexOf('post-new.php') == -1 ) {

                    $('.ff-onepage-save-ajax').css('display', 'block');

                }
            });

            return false;

        });


    });
})(jQuery);