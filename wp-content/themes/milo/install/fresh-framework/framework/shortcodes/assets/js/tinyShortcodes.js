"use strict";

jQuery(document).ready(function($) {

	var sc = frslib._classes.tinyShortcodeManager();

	sc.init();

	// Dual vs Single

	// xxx multiple xxx

	// Inline vs InlineBlock vs Block

	sc.registerShortcode({
		  'name':   'ff_twitter'
		// , 'onedit': function( $shortcodeHTML ){ alert( $shortcodeHTML.attr('data-shortcode') ); }
		, 'single': true
		, 'inline': false
	});

	sc.registerShortcode({
		  'name':   'ff_column'
		// , 'onedit': function( $shortcodeHTML ){ alert( $shortcodeHTML.attr('data-shortcode') ); }
		, 'single': true
		, 'inline': false
	});

	sc.registerShortcode({
		  'name':   'ff_button'
		, 'onedit': function( $shortcodeHTML ){ $shortcodeHTML.find('.ff_sc_content').html('<button class="btn btn-success" type="button">Success</button>'); }
		, 'inline': true
	});

});


