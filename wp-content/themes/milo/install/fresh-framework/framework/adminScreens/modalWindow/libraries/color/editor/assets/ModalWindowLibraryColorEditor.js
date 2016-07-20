jQuery(document).ready(function($){
(function(){
	
	return;
	$('#ff-modal-library-color-editor .media-toolbar-primary .button-primary').click(function(){
		var color = getColor();
		
		data.currentCallback( color );
		
		$('#ff-modal-library-color-editor').css('display', 'none');
	});
	
	
	
	frslib.provide('frslib.modal.library.color.editor');
	
	
	frslib.modal.library.color.editor.setValue = function( value, callback) {
		setColor( value );
		data.currentCallback = callback;
	}
	
	var setColor = function( value ) {
		data.currentEditedColorInfo = value;

		selectors.$colorEditorMinicolors.minicolors('value', value.hex );
		selectors.$colorEditorMinicolors.minicolors('opacity', value.opacity );
		
		selectors.$previewBefore.css('background-color', value.rgba);
		selectors.$previewAfter.css('background-color', value.rgba);
		
		selectors.$title.val( value.name );
		selectors.$tags.val( value.tags );
	}
	
	var getColor = function() {
		var currentColor = data.currentEditedColorInfo;
		currentColor.hex = selectors.$hexcode.val();
		currentColor.opacity = selectors.$opacity.val();
		
		var rgb = frslib.colors.convert.toArray( currentColor.hex );
		
		currentColor.rgba = 'rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b +','+ currentColor.opacity+')';
		if( currentColor.opacity < 1 ) {
			currentColor.color = currentColor.rgba;
		} else {
			currentColor.color = currentColor.hex;
		}
		
		currentColor.title = currentColor.name =  selectors.$title.val();
		currentColor.tags = selectors.$tags.val();
		return currentColor;
	}
	
	
	var data = {};
	
	data.currentEditedColorInfo = null;
	data.currentCallback = null;
	
//##############################################################################
//## SELECTORS
//##############################################################################
	// important for binding the change function
	var selectors = {};
	
	
	
	selectors.$colorEditor = $('#ff-modal-library-color-editor');
	selectors.$colorEditorMinicolors = selectors.$colorEditor.find('.minicolors');
	
	selectors.$hexcode = selectors.$colorEditor.find('.ff-colorlib-color-hexcode');
	
	selectors.$opacity = selectors.$colorEditor.find('.ff-colorlib-color-opacity');
	
	selectors.$rgb_r = selectors.$colorEditor.find('.ff-colorlib-color-rgb-r');
	selectors.$rgb_g = selectors.$colorEditor.find('.ff-colorlib-color-rgb-g');
	selectors.$rgb_b = selectors.$colorEditor.find('.ff-colorlib-color-rgb-b');
	selectors.$hsb_h = selectors.$colorEditor.find('.ff-colorlib-color-hsb-h');
	selectors.$hsb_s = selectors.$colorEditor.find('.ff-colorlib-color-hsb-s');
	selectors.$hsb_b = selectors.$colorEditor.find('.ff-colorlib-color-hsb-b');
	
	selectors.$previewBefore = selectors.$colorEditor.find('.ff-colorlib-color-preview-before');
	selectors.$previewAfter = selectors.$colorEditor.find('.ff-colorlib-color-preview-after');
	
	selectors.$title = selectors.$colorEditor.find('.ff-modal-library-item-details-settings-title');
	selectors.$tags = selectors.$colorEditor.find('.ff-modal-library-item-details-settings-tags');
	
//##############################################################################
//## Minicolors RE-INIT
//##############################################################################
	// important for binding the change function	
	selectors.$colorEditorMinicolors.minicolors({
		opacity: true,
		change: function( hex, opacity) {
			var hexWithoutSharp = hex.replace('#', '');
			var rgb = $(this).minicolors('rgbObject');
			var hsb = frslib.colors.convert.rgbToHsl( rgb.r, rgb.g, rgb.b );
			
			selectors.$hexcode.val( hex );
			selectors.$opacity.val( opacity );
			
			selectors.$rgb_r.val( rgb.r );
			selectors.$rgb_g.val( rgb.g );
			selectors.$rgb_b.val( rgb.b );
			
			selectors.$hsb_h.val( hsb.h );
			selectors.$hsb_s.val( hsb.s );
			selectors.$hsb_b.val( hsb.b );
			
			selectors.$previewAfter.css('background-color', 'rgba('+rgb.r+','+rgb.g+','+rgb.b+','+opacity+')');
		}
	});
	
//##############################################################################
//## CHANGE hex code
//##############################################################################
	// important for binding the change function
	selectors.$hexcode.change(function(){
		selectors.$colorEditorMinicolors.minicolors('value', $(this).val() )
	});

	
	
	var rgb_change = function() {
		var r = selectors.$rgb_r.val();
		var g = selectors.$rgb_g.val();
		var b = selectors.$rgb_b.val();
		
		console.log( r);
		console.log( r.toString(16));
		
		return;
		var hex = frslib.colors.convert.rgbToHex(r, g, b);
		
		
		selectors.$colorEditorMinicolors.minicolors('value', hex );
	}
	
	selectors.$rgb_r.change( rgb_change );
	selectors.$rgb_g.change( rgb_change );
	selectors.$rgb_b.change( rgb_change );
	
})();	
	/*				
					hex<input type="text" class="ff-colorlib-color-hexcode">					
					opacity<input type="text" class="ff-colorlib-color-opacity">
						
					r<input type="text" class="ff-colorlib-color-rgb-r">
					g<input type="text" class="ff-colorlib-color-rgb-g">
					b<input type="text" class="ff-colorlib-color-rgb-b">
					
					h<input type="text" class="ff-colorlib-color-hsb-h">
					s<input type="text" class="ff-colorlib-color-hsb-s">
					b<input type="text" class="ff-colorlib-color-hsb-b">
	
	
	
	selectors.$colorEditorMinicolors.minicolors({
		opacity: true,
		change: function( hex, opacity) {
			//$('.ff-colorlib-color-hexcode').val( hex );
			
			//$('.ff-colorlib-color-opacity').val(opacity);
			//console.log( opacity );
			//var rgb = hexToRgb( hex );
			
			//var rgb = $(this).minicolors('rgbObject');
			
			//var hsl = frslib.colors.convert.rgbToHsl( rgb.r,rgb.g,rgb.b );
		}
	});
			//console.log( hsl );
			/*
			r<input type="text" class="ff-colorlib-color-rgb-r">
			g<input type="text" class="ff-colorlib-color-rgb-g">
			b<input type="text" class="ff-colorlib-color-rgb-b">
			
			h<input type="text" class="ff-colorlib-color-hsb-h">
			s<input type="text" class="ff-colorlib-color-hsb-s">
			b<input type="text" class="ff-colorlib-color-hsb-b">*/
			
		/*	//console.log( $(this).minicolors('opacity') );
		}
	
	/*
	$('#ff-modal-library-color-editor').find('.minicolors').minicolors({
		opacity: true,
		change: function( hex, opacity) {
			$('.ff-colorlib-color-hexcode').val( hex );
			
			$('.ff-colorlib-color-opacity').val(opacity);
			console.log( opacity );
			//var rgb = hexToRgb( hex );
			
			var rgb = $(this).minicolors('rgbObject');
			
			var hsl = frslib.colors.convert.rgbToHsl( rgb.r,rgb.g,rgb.b );
			
			//console.log( hsl );
			/*
			r<input type="text" class="ff-colorlib-color-rgb-r">
			g<input type="text" class="ff-colorlib-color-rgb-g">
			b<input type="text" class="ff-colorlib-color-rgb-b">
			
			h<input type="text" class="ff-colorlib-color-hsb-h">
			s<input type="text" class="ff-colorlib-color-hsb-s">
			b<input type="text" class="ff-colorlib-color-hsb-b">*/
			
		/*	//console.log( $(this).minicolors('opacity') );
		}
	});*/
	
});