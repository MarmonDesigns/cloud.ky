"use strict";

(function($){
	
	frslib.provide('frslib._classes');
	frslib._classes.modalWindowColorEditor = function(){
//##############################################################################
//# INHERITANCE
//##############################################################################


		// modalWindow_aPicker is parent class
		var _ = frslib._classes.modalWindow_aBasic();
		_._className = 'modalWindowColorEditor';


//##############################################################################
//# PARAMS
//##############################################################################


		_.selectors.modalWindowOpener = '.nothing';
		_.selectors.modalWindow = '#ff-modal-library-color-editor';
		//_.selectors.sidebar = '.media-sidebar';
/*
		_.variables.currentColorObject = {};
		_.variables.addGroupWindow = {};
		_.variables.deleteGroupWindow = {};

		_.jquery.$sidebar = {};

*/
		
		_.variables.currentSelectedColor = null;
		_.variables.userColorGroups = null;
//##############################################################################
//# INITIALIZATION jQuery selectors
//##############################################################################


		_.initJqueryAction.initDefaultSelectors = function() {
			_.jquery.$colorEditorMinicolors = _.jquery.$modalWindow.find('.minicolors');
			
			_.jquery.$hexcode = _.jquery.$modalWindow.find('.ff-colorlib-color-hexcode');
			
			_.jquery.$opacity = _.jquery.$modalWindow.find('.ff-colorlib-color-opacity');
			
			_.jquery.$rgb_r = _.jquery.$modalWindow.find('.ff-colorlib-color-rgb-r');
			_.jquery.$rgb_g = _.jquery.$modalWindow.find('.ff-colorlib-color-rgb-g');
			_.jquery.$rgb_b = _.jquery.$modalWindow.find('.ff-colorlib-color-rgb-b');
			_.jquery.$hsb_h = _.jquery.$modalWindow.find('.ff-colorlib-color-hsb-h');
			_.jquery.$hsb_s = _.jquery.$modalWindow.find('.ff-colorlib-color-hsb-s');
			_.jquery.$hsb_b = _.jquery.$modalWindow.find('.ff-colorlib-color-hsb-b');
			
			_.jquery.$previewBefore = _.jquery.$modalWindow.find('.ff-colorlib-color-preview-before');
			_.jquery.$previewAfter = _.jquery.$modalWindow.find('.ff-colorlib-color-preview-after');
			
			_.jquery.$title = _.jquery.$modalWindow.find('.ff-modal-library-item-details-settings-title');
			_.jquery.$tags = _.jquery.$modalWindow.find('.ff-modal-library-item-details-settings-tags');
			
			_.jquery.$groups = _.jquery.$modalWindow.find('.ff-modal-library-item-details-settings-groups');
			
			_.jquery.$colorEditorMinicolors.minicolors({
				opacity: true,
				change: function( hex, opacity) {
					_.changeValues(hex, opacity);
				},
				inline: true
			});
			//_.jquery.$sidebar = _.jquery.$modalWindow.find( _.selectors.sidebar );
		};
		
		
//##############################################################################
//# CHANGES - HEX
//##############################################################################		
		
		
		_.initJqueryAction.initChanges_HEX_opacity = function() {
			_.jquery.$previewBefore.click(function() {
				
				var color = $(this).css('background-color');
				var colorArray = frslib.colors.convert.toArray( color );
				
				var colorHex = frslib.colors.convert.rgbToHex( colorArray.r, colorArray.g, colorArray.b );
				

				_.jquery.$colorEditorMinicolors.minicolors('value', colorHex);
				_.jquery.$colorEditorMinicolors.minicolors('opacity', colorArray.a );
				return false;
			});
			
			
			
			_.jquery.$hexcode.change(function() {
				var value = $(this).val();
				// frslib.colors.convert.invalid;
				if( frslib.colors.convert.toArray( value ) != frslib.colors.convert.invalid ) {
					value = '000000';
					$(this).val(value);
				}
				
				_.changes_HEX_and_Opacity();
			});
			
			_.jquery.$opacity.change(function() {
				var value = $(this).val();
				// frslib.colors.convert.invalid;
				if( value > 100 || value < 0 ) {
					value = 100;
					$(this).val(value);
				}
				
				_.changes_HEX_and_Opacity();
			});
		};
		
				
		_.changes_HEX_and_Opacity = function() {
			var hex = '#'+_.jquery.$hexcode.val();
			var opacity = parseInt(_.jquery.$opacity.val());
			
			var colorValid =  frslib.colors.convert.toArray( hex );
			
			if( colorValid == frslib.colors.convert.invalid ) {
				hex = '#ffffff';
			}
			
			if( opacity > 100 || opacity < 0 ) {
				opacity = 100;
			}
			
			_.jquery.$colorEditorMinicolors.minicolors('value', hex);
			_.jquery.$colorEditorMinicolors.minicolors('opacity', opacity / 100 );
		};
		
		
//##############################################################################
//# CHANGES - RGB
//##############################################################################	
		
		
		_.initJqueryAction.initChanges_RGB = function() {
			_.jquery.$rgb_r.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 255 ) {
					value = 0;
					$(this).val(0);
				}
				
				_.changes_RGB();
			});
			
			_.jquery.$rgb_g.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 255 ) {
					value = 0;
					$(this).val(0);
				}
				
				_.changes_RGB();
			});
			
			_.jquery.$rgb_b.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 255 ) {
					value = 0;
					$(this).val(0);
				}
				
				_.changes_RGB();
			});
		}
		
		_.changes_RGB = function() {
			var r = _.jquery.$rgb_r.val();
			var g = _.jquery.$rgb_g.val();
			var b = _.jquery.$rgb_b.val();
			
			var hex = frslib.colors.convert.rgbToHex(r, g, b);
			var opacity = _.jquery.$opacity.val();
			
			//_this_.changeValues(hex, opacity);
			_.jquery.$colorEditorMinicolors.minicolors('value', hex);
			_.jquery.$colorEditorMinicolors.minicolors('opacity', opacity / 100 );
		};
		
		
//##############################################################################
//# CHANGES - HSB
//##############################################################################
		
		
		_.initJqueryAction.initChanges_HSB = function() {
			_.jquery.$hsb_h.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 360 ) {
					value = 0;
					$(this).val(0);
				}
				
				_.changes_HSB();
			});
			
			_.jquery.$hsb_s.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 100 ) {
					value = 0;
					$(this).val(0);
				}
				
				_.changes_HSB();
			});
			
			_.jquery.$hsb_b.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 100 ) {
					value = 0;
					$(this).val(0);
				}
				
				_.changes_HSB();
			});
		}
		
		_.changes_HSB = function() {
			var h = _.jquery.$hsb_h.val();
			var s = _.jquery.$hsb_s.val();
			var b = _.jquery.$hsb_b.val();
		
			var rgb = frslib.colors.convert.hslToRgb(h, s,b);
			var hex = frslib.colors.convert.rgbToHex(rgb.r, rgb.g, rgb.b);
			var opacity = _.jquery.$opacity.val();
			
			
		//	_this_.changeValues(hex, opacity);
			_.jquery.$colorEditorMinicolors.minicolors('value', hex);
			_.jquery.$colorEditorMinicolors.minicolors('opacity', opacity / 100 );
		}
		


//##############################################################################
//# HOOKS: EXECUTIVE FUNCTIONS ( OPEN, CLOSE, ETC )
//##############################################################################


 
		


//##############################################################################
//# FUNCTIONS
//##############################################################################

		_.setInformations = function( currentSelectedColor, userColorGroups ) {
			_.variables.currentSelectedColor = currentSelectedColor;
			_.variables.userColorGroups = userColorGroups;
		};
	 
		
		_.getColorObject = function() {
			var hex = '#'+ _.jquery.$hexcode.val();
			var opacity = _.jquery.$opacity.val();
			var title = _.jquery.$title.val();
			var tags = _.jquery.$tags.val();
			var group = _.jquery.$groups.val();
			
			_.variables.currentSelectedColor.setColor( hex );
			_.variables.currentSelectedColor.setOpacity(opacity / 100);
			_.variables.currentSelectedColor.setTags( tags );
			_.variables.currentSelectedColor.setName( title );
			_.variables.currentSelectedColor.description.group = group;
			return _.variables.currentSelectedColor;
		}
		
		
		_.hooks.beforeOpenWindow.initColors = function() {
			//console.log( _.variables.currentSelectedColor.colors.hex, _.variables.currentSelectedColor.colors.opacity  );
			//_.changeValues( _.variables.currentSelectedColor.colors.hex, _.variables.currentSelectedColor.colors.opacity );
			
			_.jquery.$colorEditorMinicolors.minicolors('value', _.variables.currentSelectedColor.colors.hex);
			_.jquery.$colorEditorMinicolors.minicolors('opacity', _.variables.currentSelectedColor.colors.opacity);
			
			_.jquery.$title.val(_.variables.currentSelectedColor.description.name);
			_.jquery.$tags.val(_.variables.currentSelectedColor.description.tags);
			
			_.jquery.$previewBefore.css('background-color', 'rgba('+_.variables.currentSelectedColor.colors.rgb.r+','+_.variables.currentSelectedColor.colors.rgb.g+','+_.variables.currentSelectedColor.colors.rgb.b+','+_.variables.currentSelectedColor.colors.opacity+')');
			
			var groups = '';
			var key;
			
			for( key in _.variables.userColorGroups ) {
				var oneGroup = _.variables.userColorGroups[ key ];
				
				var selected = '';
				
				if( _.variables.currentSelectedColor.description.group == oneGroup.slug ) {
					
					selected = ' selected="selected" ';
				}
				
				groups += '<option '+selected+' value="'+oneGroup.slug+'">'+oneGroup.name+'</option>';
				
			}
			
			_.jquery.$groups.html( groups );
			
			//_.jquery.$groups.val( _.variables.currentSelectedColor.description.group );
		}
		
		
//##############################################################################
//# FUNCTIONS - CHANGING VALUES
//##############################################################################		
		
		
		_.changeValues = function( hex, opacity) {
			var hexWithoutSharp = hex.replace('#', '');
			//var rgb = $(this).minicolors('rgbObject');
			var rgb = frslib.colors.convert.toArray( hex );
			
			var hsb = frslib.colors.convert.rgbToHsl( rgb.r, rgb.g, rgb.b );
			
			_.jquery.$hexcode.val( hex.replace('#','') );
			_.jquery.$opacity.val( parseInt( opacity * 100) );
			
			_.jquery.$rgb_r.val( rgb.r );
			_.jquery.$rgb_g.val( rgb.g );
			_.jquery.$rgb_b.val( rgb.b );
			
			_.jquery.$hsb_h.val( hsb.h );
			_.jquery.$hsb_s.val( hsb.s );
			_.jquery.$hsb_b.val( hsb.b );
			
			_.jquery.$previewAfter.css('background-color', 'rgba('+rgb.r+','+rgb.g+','+rgb.b+','+opacity+')');
		};
		

//##############################################################################
//# RETURN ITSELF
//##############################################################################


		return _;

	};
	
	
	return;
	

	frslib.provide('frslib._classes');

	frslib._classes.modalWindowColorEditor = function(){

		var _this_ = frslib._classes.modalWindow();

		// Propeties
		
		_this_.currentSelectedItem = {};
		_this_.openedMod = '';
		_this_.jquerySelectors = {};

		_this_.modalWindowColorEditor_selectors = {
			  modalWindowOpener: '.edit-attachment, .duplicate-attachment'
			, modalWindow: '#ff-modal-library-color-editor'
		};

		// Constructor

		_this_.initSelectors = _this_.modalWindowColorEditor_initSelectors = function(){
			_this_.modalWindow_initSelectors();
			_this_.updateSelectors( _this_.modalWindowColorEditor_selectors );
		};

		_this_.init = _this_.modalWindowColorEditor_init = function(){
			_this_.modalWindowColorEditor_initSelectors();
			_this_.modalWindow_init();
			_this_.initJquerySelectors();
			_this_.hookActions();
		
			
		};
		
		_this_.initJquerySelectors = function() {
			//_this_.$selectors.$colorEditor = _this_.$modalWindow.find('#ff-modal-library-color-editor');
			_this_.jquerySelectors.$colorEditorMinicolors = _this_.$modalWindow.find('.minicolors');
			
			_this_.jquerySelectors.$hexcode = _this_.$modalWindow.find('.ff-colorlib-color-hexcode');
			
			_this_.jquerySelectors.$opacity = _this_.$modalWindow.find('.ff-colorlib-color-opacity');
			
			_this_.jquerySelectors.$rgb_r = _this_.$modalWindow.find('.ff-colorlib-color-rgb-r');
			_this_.jquerySelectors.$rgb_g = _this_.$modalWindow.find('.ff-colorlib-color-rgb-g');
			_this_.jquerySelectors.$rgb_b = _this_.$modalWindow.find('.ff-colorlib-color-rgb-b');
			_this_.jquerySelectors.$hsb_h = _this_.$modalWindow.find('.ff-colorlib-color-hsb-h');
			_this_.jquerySelectors.$hsb_s = _this_.$modalWindow.find('.ff-colorlib-color-hsb-s');
			_this_.jquerySelectors.$hsb_b = _this_.$modalWindow.find('.ff-colorlib-color-hsb-b');
			
			_this_.jquerySelectors.$previewBefore = _this_.$modalWindow.find('.ff-colorlib-color-preview-before');
			_this_.jquerySelectors.$previewAfter = _this_.$modalWindow.find('.ff-colorlib-color-preview-after');
			
			_this_.jquerySelectors.$title = _this_.$modalWindow.find('.ff-modal-library-item-details-settings-title');
			_this_.jquerySelectors.$tags = _this_.$modalWindow.find('.ff-modal-library-item-details-settings-tags');
		}
		
		_this_.hookActions = function() {
			frslib.callbacks.addCallback(_this_.callbackSelectors.windowOpened, _this_.afterWindowOpen );
			frslib.callbacks.addCallback(_this_.callbackSelectors.windowSubmitted, _this_.afterWindowSubmit );

			_this_.jquerySelectors.$colorEditorMinicolors.minicolors({
				opacity: true,
				change: function( hex, opacity) {
					_this_.changeValues(hex, opacity);
				},
				inline: true
			});
			
			_this_.changes_HSB_Hooks();
			_this_.changes_RGB_Hooks();
			_this_.changes_HEX_Hooks();
			_this_.changes_preview_Hooks();
			//_this_.callbackSelectors.windowOpened
		}

//##############################################################################
//# AFTER OPEN / SUBMIT
//##############################################################################
		_this_.afterWindowSubmit = function() {
			var hex = '#'+ _this_.jquerySelectors.$hexcode.val();
			var opacity = _this_.jquerySelectors.$opacity.val();
			var title = _this_.jquerySelectors.$title.val();
			var tags = _this_.jquerySelectors.$tags.val();
	
			_this_.currentSelectedItem.setColor( hex );
			_this_.currentSelectedItem.setOpacity(opacity / 100);
			_this_.currentSelectedItem.setTags( tags );
			_this_.currentSelectedItem.setName( title );
			
			frslib.callbacks.doCallback( frslib.modal.colorLibrary.events.setCurrentSelectedColor, _this_.currentSelectedItem, _this_.openedMod);
		}
		
		
		_this_.afterWindowOpen = function() {
			if(  _this_.$modalWindowCaller.hasClass('edit-attachment') ) {
				_this_.openedMod = 'edit';
			} else if ( _this_.$modalWindowCaller.hasClass('duplicate-attachment') ) {
				_this_.openedMod = 'duplicate';
			}
			
			var _currentSelectedColorPointer = {};
			frslib.callbacks.doCallback( frslib.modal.colorLibrary.events.getCurrentSelectedColor, _currentSelectedColorPointer );
			
			_this_.currentSelectedItem = _currentSelectedColorPointer[0];
			
			_this_.changeValues( _this_.currentSelectedItem.colors.hex, _this_.currentSelectedItem.colors.opacity );
			
			_this_.jquerySelectors.$colorEditorMinicolors.minicolors('value', _this_.currentSelectedItem.colors.hex );
			_this_.jquerySelectors.$colorEditorMinicolors.minicolors('opacity', _this_.currentSelectedItem.colors.opacity );
			
			_this_.jquerySelectors.$previewBefore.css('background-color', 'rgba('+_this_.currentSelectedItem.colors.rgb.r+','+_this_.currentSelectedItem.colors.rgb.g+','+_this_.currentSelectedItem.colors.rgb.b+','+_this_.currentSelectedItem.colors.opacity+')');
 
			_this_.jquerySelectors.$title.val(_this_.currentSelectedItem.description.name);
			_this_.jquerySelectors.$tags.val(_this_.currentSelectedItem.description.tags);
		}
		
//##############################################################################
//# CHANGE VALUES
//##############################################################################
		_this_.changeValues = function( hex, opacity ) {
			var hexWithoutSharp = hex.replace('#', '');
			//var rgb = $(this).minicolors('rgbObject');
			var rgb = frslib.colors.convert.toArray( hex );
			
			var hsb = frslib.colors.convert.rgbToHsl( rgb.r, rgb.g, rgb.b );
			
			_this_.jquerySelectors.$hexcode.val( hex.replace('#','') );
			_this_.jquerySelectors.$opacity.val( parseInt( opacity * 100) );
			
			_this_.jquerySelectors.$rgb_r.val( rgb.r );
			_this_.jquerySelectors.$rgb_g.val( rgb.g );
			_this_.jquerySelectors.$rgb_b.val( rgb.b );
			
			_this_.jquerySelectors.$hsb_h.val( hsb.h );
			_this_.jquerySelectors.$hsb_s.val( hsb.s );
			_this_.jquerySelectors.$hsb_b.val( hsb.b );
			
			_this_.jquerySelectors.$previewAfter.css('background-color', 'rgba('+rgb.r+','+rgb.g+','+rgb.b+','+opacity+')');
		}
		
//##############################################################################
//# PREVIEW BEFORE CHANGES
//##############################################################################		
		_this_.changes_preview_Hooks = function() {
			_this_.jquerySelectors.$previewBefore.click(function() {
				
				var color = $(this).css('background-color');
				var colorArray = frslib.colors.convert.toArray( color );
				
				var colorHex = frslib.colors.convert.rgbToHex( colorArray.r, colorArray.g, colorArray.b );
				

				_this_.jquerySelectors.$colorEditorMinicolors.minicolors('value', colorHex);
				_this_.jquerySelectors.$colorEditorMinicolors.minicolors('opacity', colorArray.a );
				return false;
			});
		};
		
		
		
//##############################################################################
//# HEX and OPACITY CHANGES
//##############################################################################		
		_this_.changes_HEX_Hooks = function() {
			_this_.jquerySelectors.$hexcode.change(function() {
				var value = $(this).val();
				// frslib.colors.convert.invalid;
				if( frslib.colors.convert.toArray( value ) != frslib.colors.convert.invalid ) {
					value = '000000';
					$(this).val(value);
				}
				
				_this_.changes_HEX_and_Opacity();
			});
			
			_this_.jquerySelectors.$opacity.change(function() {
				var value = $(this).val();
				// frslib.colors.convert.invalid;
				if( value > 100 || value < 0 ) {
					value = 100;
					$(this).val(value);
				}
				
				_this_.changes_HEX_and_Opacity();
			});
		};
		
		_this_.changes_HEX_and_Opacity = function() {
			var hex = '#'+_this_.jquerySelectors.$hexcode.val();
			var opacity = parseInt(_this_.jquerySelectors.$opacity.val());
			
			var colorValid =  frslib.colors.convert.toArray( hex );
			
			if( colorValid == frslib.colors.convert.invalid ) {
				hex = '#ffffff';
			}
			
			if( opacity > 100 || opacity < 0 ) {
				opacity = 100;
			}
			
			_this_.jquerySelectors.$colorEditorMinicolors.minicolors('value', hex);
			_this_.jquerySelectors.$colorEditorMinicolors.minicolors('opacity', opacity / 100 );
		};
//##############################################################################
//# RGB changes
//##############################################################################
		_this_.changes_RGB_Hooks = function() {
			_this_.jquerySelectors.$rgb_r.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 255 ) {
					value = 0;
					$(this).val(0);
				}
				
				_this_.changes_RGB();
			});
			
			_this_.jquerySelectors.$rgb_g.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 255 ) {
					value = 0;
					$(this).val(0);
				}
				
				_this_.changes_RGB();
			});
			
			_this_.jquerySelectors.$rgb_b.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 255 ) {
					value = 0;
					$(this).val(0);
				}
				
				_this_.changes_RGB();
			});
		}
		
		_this_.changes_RGB = function() {
			var r = _this_.jquerySelectors.$rgb_r.val();
			var g = _this_.jquerySelectors.$rgb_g.val();
			var b = _this_.jquerySelectors.$rgb_b.val();
			
			var hex = frslib.colors.convert.rgbToHex(r, g, b);
			var opacity = _this_.jquerySelectors.$opacity.val();
			
			//_this_.changeValues(hex, opacity);
			_this_.jquerySelectors.$colorEditorMinicolors.minicolors('value', hex);
			_this_.jquerySelectors.$colorEditorMinicolors.minicolors('opacity', opacity / 100 );
			/*
			var h = _this_.jquerySelectors.$hsb_h.val();
			var s = _this_.jquerySelectors.$hsb_s.val();
			var b = _this_.jquerySelectors.$hsb_b.val();
		
			var rgb = frslib.colors.convert.hslToRgb(h, s,b);
			var hex = frslib.colors.convert.rgbToHex(rgb.r, rgb.g, rgb.b);
			var opacity = _this_.jquerySelectors.$opacity.val();
			
			_this_.changeValues(hex, opacity);
			_this_.jquerySelectors.$colorEditorMinicolors.minicolors('value', hex);
			_this_.jquerySelectors.$colorEditorMinicolors.minicolors('opacity', opacity);*/
		}
		
//##############################################################################
//# HSB changes
//##############################################################################
		_this_.changes_HSB_Hooks = function() {
			_this_.jquerySelectors.$hsb_h.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 360 ) {
					value = 0;
					$(this).val(0);
				}
				
				_this_.changes_HSB();
			});
			
			_this_.jquerySelectors.$hsb_s.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 100 ) {
					value = 0;
					$(this).val(0);
				}
				
				_this_.changes_HSB();
			});
			
			_this_.jquerySelectors.$hsb_b.change(function() {
				var value = $(this).val();
				if( !(!isNaN(value) && parseInt(Number(value)) == value ) || value < 0 || value > 100 ) {
					value = 0;
					$(this).val(0);
				}
				
				_this_.changes_HSB();
			});
		}
		
		_this_.changes_HSB = function() {
			var h = _this_.jquerySelectors.$hsb_h.val();
			var s = _this_.jquerySelectors.$hsb_s.val();
			var b = _this_.jquerySelectors.$hsb_b.val();
		
			var rgb = frslib.colors.convert.hslToRgb(h, s,b);
			var hex = frslib.colors.convert.rgbToHex(rgb.r, rgb.g, rgb.b);
			var opacity = _this_.jquerySelectors.$opacity.val();
			
			
		//	_this_.changeValues(hex, opacity);
			_this_.jquerySelectors.$colorEditorMinicolors.minicolors('value', hex);
			_this_.jquerySelectors.$colorEditorMinicolors.minicolors('opacity', opacity / 100 );
		}
		
		

		
		_this_.fillWindowFromColor = function() {
			_this_.jquerySelectors.$hexcode.val(_this_.currentSelectedItem.colors.hex);
			//console.log(_this_.currentSelectedItem.colors.hex);
		}

		

		return _this_;
	};

})(jQuery);







