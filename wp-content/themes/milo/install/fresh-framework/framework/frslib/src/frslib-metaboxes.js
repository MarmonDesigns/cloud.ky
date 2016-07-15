(function($) {
	
	frslib.provide('frslib.metaboxes');
	frslib.provide('frslib.metaboxes.names');
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// METABOXES
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################	
	// selectors and names
	frslib.metaboxes.names.action_publishPost = 'action_publish_post';
	frslib.metaboxes.names.postForm = '#post';
	
	frslib.metaboxes.names.normalize_options_class = '.ff-metabox-normalize-options';
	
	
	$( frslib.metaboxes.names.postForm ).submit(function(){
		frslib.callbacks.doCallback( frslib.metaboxes.names.action_publishPost );
        //return false;
	});
	
	var $normalizeMetaboxes = $( frslib.metaboxes.names.normalize_options_class );

	if( $normalizeMetaboxes.length > 0 ) {
		
		frslib.callbacks.addCallback( frslib.metaboxes.names.action_publishPost, function(){
		
		$normalizeMetaboxes.each(function(i, o){

			var $normalizedContent = frslib.options.template.functions.normalize( $(o) );

			$(this).find('*').attr('name', '');

			$normalizedContent.css('display','none');

			$(this).after( $normalizedContent );

        });
		
		});
	}
	
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// VISIBILITIES
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################

//##############################################################################
//# PAGE TEMPLATE
//##############################################################################
	$('#page_template').change(function( value ) {
		var selectValue = $(this).val();
		var pageTemplateType = 'visibility_page_template';
		
		$('.ff-one-visibility').each(function() {
			if( $(this).attr('data-type') == pageTemplateType ) {
				var $parent = $(this).parents('.postbox:first');
				var hasSelectedPageTemplate = false;
				
				$(this).find('.ff-one-visibility-item').each(function(){
					var html = $(this).html();
					if( html == selectValue ) {
						hasSelectedPageTemplate = true;
					}
				});
				
				if( hasSelectedPageTemplate ) {
					$parent.show(500);
				} else {
					$parent.hide(500);
				}
			}
		});
		
		
		
		/*
		$('.ff-one-visibility-item').each(function(){
			var html = $(this).html();
			if( html == selectValue ) {
				console.log( 'YES');
			}
		})*/
	});
	$(document).ready(function() {
		$('#page_template').change();
	});
})(jQuery);