"use strict";

(function($){

	frslib.provide('frslib._classes.shortcodes');
	frslib.provide('frslib._instances.shortcodes');

	frslib._classes.tinyShortcodeManager = function() {

//##############################################################################
//# INHERITANCE
//##############################################################################


		// itself
		var _ = {};


//##############################################################################
//#	PARAMS
//##############################################################################


		_.scFunction = {};
		_.scIsSingle = {};
		_.scIsInline = {};


//##############################################################################
//# INIT
//##############################################################################


		_.init = function(){
			tinymce.create('tinymce.plugins.freshFaceShortcodes', {
				init : function(ed, url) {
					ed.on( 'BeforeSetContent', function( e ) {
						e.content = _.BeforeSetContent( e.content );
					});
					ed.on( 'PostProcess', function( e ) {
						e.content = _.PostProcess( e.content );
					});
					ed.on("Click", function( e ) {
						_.EditorClick( e );
					});
				}
			});

			tinymce.PluginManager.add('freshFaceShortcodes', tinymce.plugins.freshFaceShortcodes);

			frslib._instances.tinyShortcodeManager = _ ;

			_.initHelpers();
		}

		_.registerShortcode = function( settings ){
			if( (typeof settings != "object") && (settings === null) ){
				console.log('Error in registerShortcode in parameter settings:');
				console.log( settings );
				return;
			}

			if( settings.name ) {} else {
				console.log('Error in registerShortcode in parameter { settings.name: value }');
				console.log( settings );
				return;
			}

			if( settings.onedit ) {} else {
				settings.onedit = function( $shortcodeHTML ){ alert( $shortcodeHTML.attr('data-shortcode') );}
			}

			_.scFunction[ settings.name ] = settings.onedit;
			_.scIsSingle[ settings.name ] = ( settings.single ) ? 1 : 0;
			_.scIsInline[ settings.name ] = ( settings.inline ) ? 1 : 0;
		}


//##############################################################################
//# EXECUTIVE FUNCTIONS For editing
//##############################################################################


		// Click on something in editor
		_.EditorClick = function( e ){
			var $button = $( e.target );
			if( $button.hasClass('ff_sc_edit') ){
				var $shortcodeContainer = $button.parents('.ff_sc:first');
				_.Edit( $shortcodeContainer );
			}
			if( $button.hasClass('ff_sc_delete') ){
				var $shortcodeContainer = $button.parents('.ff_sc:first');
				_.Delete( $shortcodeContainer );
			}
		}

		_.Delete = function( $shortcodeHTML ){
			$shortcodeHTML.remove();
		}

		_.Edit = function( $shortcodeHTML ){
			var scSlug = $shortcodeHTML.attr('data-shortcode');
			if( scSlug ){
				if( _.scFunction[ scSlug ] ){
					_.scFunction[ scSlug ]( $shortcodeHTML );
				}else{
					alert( 'undefined shortcode: ' + scSlug );
				}
			}
		}


//##############################################################################
//# CLEANING MESS FROM HELPERS
//##############################################################################

		_.initHelpers = function(){
			_.html = {};
			_.preg = {};

			// ButtonWrapper
			_.preg.buttonsWrapper = /<span class="ff_sc_buttons"><\/span>/g ;

			// Edit button
			_.html.buttonEdit = '<span class="ff_sc_edit">X</span>' ;
			_.preg.buttonEdit = /<span class="ff_sc_edit">X<\/span>/g ;

			// Delete button
			_.html.buttonDelete = '<span class="ff_sc_delete">X</span>';
			_.preg.buttonDelete = /<span class="ff_sc_delete">X<\/span>/g ;
		}

		_.replaceFreshFaceShortcodeClass = function( content ){
			content = content.replace( /class="ff_sc"/g, '' );
			return content;
		}

		_.replaceFreshFaceShortcodeAttributes = function( content ){
			return content;
		}

		_.cleanMessFromHelpers = function( content ){
			content = content.replace( _.preg.buttonEdit, '' );
			content = content.replace( _.preg.buttonDelete, '' );
			content = content.replace( _.preg.buttonsWrapper, '' );
			content = content.replace( /class="ff_sc"/g, '' );
			content = content.replace( /data-ff-helper-display="inline"/g, '' );
			content = content.replace( /data-ff-helper-display="block"/g, '' );
			return content;
		}


//##############################################################################
//# EXECUTIVE FUNCTIONS Swap to HTML, Swap to Text
//##############################################################################


		// Swap into text mode
		_.PostProcess = function( content ){
			content = _.cleanMessFromHelpers( content );

			// Single
			content = content.replace(/<span( [^\>]*)data-shortcode="ff_([a-zA-Z0-9_]+)"([^\>]*)><\/span>/g, '[ff_$2$1$3]');

			// Dual
			content = content.replace(/<span( [^\>]*)data-shortcode="ff_([a-zA-Z0-9_]+)"([^\>]*)>\s*<span\s+class="ff_sc_content">/g, '[ff_$2$1$3]');
			content = content.replace(/<\/span>\s*<span\s+class="ff_sc_end"\s+data-shortcode="ff_([a-zA-Z0-9_]+)"\s*>X<\/span>\s*<\/span>/g, '[/ff_$1]');

			// Cleaning
			content = content.replace(/\[ff_([a-zA-Z0-9_]+)\s+([^\]]*)\]/g, '[ff_$1 $2]');

			return content;
		}


		// Swap into HTML mode
		_.BeforeSetContent = function( content ){

			var key;
			var regex;
			var to_replace;

			for( key in _.scIsSingle ) {
				regex = new RegExp('\\\[(\\\/?)('+key+')(\\\s|\\\]|\\\/)', "g");
				to_replace = "[$1";
				to_replace += ( _.scIsSingle[ key ] ) ? 'single_' : 'dual_';
				to_replace += '$2';
				to_replace += ( _.scIsInline[ key ] ) ? ' data-ff-helper-display="inline"' : ' data-ff-helper-display="block"';
				to_replace += '$3';

				console.log( regex );
				console.log( to_replace );

				content = content.replace(regex, to_replace);
			}

			// Single

			// data-mce-placeholder="1" data-mce-resize="false" data-mce-selected="1"
			// content = content.replace(/\[single_(ff_[a-zA-Z0-9_]+)\s*([^\]]*)\]/g, '<span class="ff_sc" data-shortcode="$1"$2 ><span class="ff_sc_buttons">' + _.html.buttonEdit + _.html.buttonDelete + '</span></span>');
			content = content.replace(/\[single_(ff_[a-zA-Z0-9_]+)\s*([^\]]*)\]/g, '<img src="' + tinymce.Env.transparentSrc + '" ' +
				'class="wp-more-tag ff_sc" data-mce-resize="false" data-mce-placeholder="1" data-shortcode=ff_column />');


			// Dual
			content = content.replace(/\[dual_(ff_[a-zA-Z0-9_]+)\s*([^\]]*)\]/g, '<span class="ff_sc" data-shortcode="$1"$2><span class="ff_sc_buttons">' + _.html.buttonEdit + _.html.buttonDelete + '</span><span class="ff_sc_content">');
			content = content.replace(/\[\/dual_(ff_[a-zA-Z0-9_]+)\s*([^\]]*)\]/g, '</span><span class="ff_sc_end" data-shortcode="$1"$2>X</span></span>');

			return content;
		}


//##############################################################################
//# RETURN ITSELF;
//##############################################################################


		return _;


	};


})(jQuery);





