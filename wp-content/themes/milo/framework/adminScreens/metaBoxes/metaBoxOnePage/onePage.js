(function($){
	
	jQuery(document).ready(function(){

/**********************************************************************************************************************/
/* INITIAL LOADING
/**********************************************************************************************************************/
        var specification = {};
        specification.metaboxClass = 'ffMetaBoxOnePage';
        var data = {};
        data.action = 'getOptions';
        data.postId = $('.ff-post-id-holder').html();
        frslib.ajax.frameworkRequest( 'ffMetaBoxManager', specification, data, function( response ){

            $('#OnePage .ff-metabox-normalize-options').html( response) ;

            var $toInit = $('#OnePage .ff-metabox-normalize-options .ff-options-js-wrapper ');
            frslib.options.functions.initOptionsJS();

            var url      = window.location.href;
            if( url.indexOf('post-new.php') == -1 ) {

                $('.ff-onepage-save-ajax').css('display', 'block');

            }

        });

/**********************************************************************************************************************/
/* PAGE TEMPLATE - switching to one page
/**********************************************************************************************************************/
		var pageTemplateValue = $('#page_template').val();
	
		if( pageTemplateValue == 'page-onepage.php' ) {
			$('#postdivrich').hide(500);
		}
		
		var url      = window.location.href; 
		
		if( url.indexOf('post-new.php') == -1 ) {
			
			$('.ff-onepage-save-ajax').css('display', 'block');
			
		}
		
		$('#page_template').change(function(){
 
			var value = $(this).val();
			
			if( value == 'page-onepage.php' ) {
				$('#postdivrich').hide(500);
			} else {
				$('#postdivrich').show(500);
			}
			
		});
		

/**********************************************************************************************************************/
/* SAVING ONE PAGE
/**********************************************************************************************************************/

		$(document).on('click','.ff-onepage-save-ajax', function(){

            $('#publish').prop('disabled', true);

			var data = {};
			data.postId = $('.ff-post-id').html();
			
			var $form = $('.ff-metabox-normalize-options .ff-options-js');
			
			
			
			var $normalizedForm = frslib.options.template.functions.normalize( $form, false );

			//console.log( $normalizedForm.html() );

            //return false;
			var serialised = $('<form>'+$normalizedForm.html()+'</form>').serialize();

			data.serialised = serialised;
		
			var specification = {};
			specification.metaboxClass = 'ffMetaBoxOnePage';
				$('#OnePage').animate({opacity:0.5},500);
				frslib.ajax.frameworkRequest( 'ffMetaBoxManager', specification, data, function( response ){
					//console.log( response );
					$('#OnePage').animate({opacity:1},500);
				
					$('#publish').prop('disabled', false);

                    $('.ff-revision-list-content').html( response );
				});
				
			//frslib.ajax.frameworkRequest = function( owner, specification, data, callback ) {
			return false;
			
		});


/**********************************************************************************************************************/
/* REVISION SWITCH
/**********************************************************************************************************************/
        $(document).on('click', '.ff-revision-switch', function(){

            var revisionNumber = $(this).attr('data-revision-number');

            if( revisionNumber == 'current' ) {
                return false;
            }

            if( !confirm('You are rolling back to different revision. All your unsaved changes will be lost!' ) ) {
                return false;
            }


            var specification = {};
            specification.metaboxClass = 'ffMetaBoxOnePage';
            var data = {};
            data.action = 'setRevision';
            data.postId = $('.ff-post-id-holder').html();
            data.revisionNumber = revisionNumber;
            $('#publish').prop('disabled', true);
            $('#OnePage').animate({opacity:0.5},500);
            frslib.ajax.frameworkRequest( 'ffMetaBoxManager', specification, data, function( response ){
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