jQuery(document).ready(function($){
	(function(){
		
		return;
		
		$('.duplicate-attachment').click(function() {
			$('#ff-modal-library-color-editor').css('display', 'block');
			var colorInfo = frslib.modal.library.color.picker.getCurrentSelectedColorInfo();
			data.currentEditorAction = 'duplicate';
			frslib.modal.library.color.editor.setValue( colorInfo, function(colorInfo) {
				if( data.currentEditorAction == 'duplicate' ) {
					specification = prepareAjaxSpecification('duplicate');
					var datas = {};
					datas.colorInfo = colorInfo;
					
				
					
					frslib.ajax.frameworkRequest( 'ffModalWindow', specification, datas, function( response ) {
						console.log( response );
				 	});
				}
				
				
			});
			return false;
		});
		
		$('#ff-modal-library-color-editor .media-modal-close').click(function(){
			$('#ff-modal-library-color-editor').css('display', 'none');
			return false;
		});
		
		
		frslib.provide('frslib.modal.library.color.picker');
		
		frslib.modal.library.color.picker.getCurrentSelectedColorInfo = function() {
			return data.currentSelectedColorInfo;
		}
//##############################################################################
//# SELECTORS
//##############################################################################
		var selectors = {};
		
		selectors.$modalWindow = $('#ff-modal-library-color-picker');
		selectors.$groupItem =  selectors.$modalWindow.find('.ff-modal-library-items-group-item');
		selectors.$bannedVariables = selectors.$modalWindow.find('.ff-colorlib-banned-variables');
		selectors.$sidebar=  selectors.$modalWindow.find('.media-sidebar');
		
		selectors.itemInfo = '.ff-item-info';
		
		var data = {};
		
		data.bannedVariables = null;
		data.$currentSelectedColor = null;
		data.currentSelectedColorInfo = null
		data.currentEditorAction = null;
		
//##############################################################################
//# AJAX ACTION - DUPLICATE
//##############################################################################			
		
		var duplicateColor = function( colorInfo ) {
			
		}
		
//##############################################################################
//# PREPARE AJAX SPECIFICATION
//##############################################################################		
		var prepareAjaxSpecification = function( action ) {
			var specification = {
					'managerClass' 	: 'ffModalWindowManagerLibraryColorPicker',
					'modalClass' 	: 'ffModalWindowLibraryColorPicker',
					'viewClass'		: 'ffModalWindowLibraryColorPickerViewDefault',
					'action'		: action
			}
			
			return specification;
		}
		
		
//##############################################################################
//#	GET BANNED VARIABLES
//##############################################################################
		var getBannedVariablesForColor = function( colorName ) {
			if( data.bannedVariables == null ) {
				data.bannedVariables = $.parseJSON( selectors.$bannedVariables.html() );
			}
			
			if( data.bannedVariables.hasOwnProperty( colorName ) ) {
				return data.bannedVariables[colorName];
			} else {
				return null;
			}
		}
		
		var hideBannedVariablesForColor = function( colorName ) {
			var bannedVariables = getBannedVariablesForColor( colorName );
			
			if( bannedVariables == null ) {
				return;
			}
			
			for( key in bannedVariables ) {
				var oneVariable = bannedVariables[key];
				
				var oneItem = selectors.$groupItem.find('input[value="'+oneVariable+'"]').parents('.ff-modal-library-items-group-item');
				
				oneItem.css('display', 'none');
				
			}
		}
		
		var showBannedVariables = function() {
			selectors.$groupIte.css('display', 'block');
		};
		
	
//##############################################################################
//#	CURRENTLY SELECTED COLOR
//##############################################################################		
		
		var getCurrentSelectColorSelector = function() {
			
		}
		
		var getColorInfoObjectFromSelector = function( $colorItem ) {
			var $itemInfo = $colorItem.find( selectors.itemInfo );
			
			var colorInfo = {};
			colorInfo.name = $itemInfo.find('.ff-item-name').val();
			colorInfo.type = $itemInfo.find('.ff-item-type').val();
			colorInfo.color = $itemInfo.find('.ff-item-color').val();
			colorInfo.tags = $itemInfo.find('.ff-item-tags').val();
			colorInfo.opacity = 1;
			
			colorInfo.hex = '';
			colorInfo.rgba = '';
			
			if( colorInfo.type == 'system' ) {
				colorInfo.id = colorInfo.name;
			} else {
				colorInfo.id = 'dodelatPICO';
			}
			
			
			
			var colorType = frslib.colors.type.identify( colorInfo.color );
	
			switch( colorType ) {
				case frslib.colors.type.hex :
					//colorInfo.hex = frslib.colors.convert.hexToRgb 
					var rgb = frslib.colors.convert.hexToRgb(  colorInfo.color );
					
					colorInfo.hex = colorInfo.color;
					colorInfo.rgba = 'rgba('+rgb.r+','+rgb.g+','+rgb.b+',1)';
					
					break;
					
				case frslib.colors.type.rgba : 
					var rgbaArray = frslib.colors.convert.toArray( colorInfo.color ); 
					
					colorInfo.hex = frslib.colors.convert.rgbToHex( rgbaArray.r, rgbaArray.g, rgbaArray.b );
					colorInfo.rgba = colorInfo.color;
					
					colorInfo.opacity = rgbaArray.a;
					break;
			}
			
			return colorInfo;
		}
		
//##############################################################################
//#	SIDEBAR CHANGES
//##############################################################################
		var changeSidebarColor = function( colorInfo ) {
			$sidebar = selectors.$sidebar;
			//$sidebar.remove();
			$sidebar.find('.thumbnail').find('.ff-modal-library-item-color').css('background-color', colorInfo.hex).css('opacity', colorInfo.opacity )
			
			$sidebar.find('.filename').html( colorInfo.name );
			
			$sidebar.find('.ff-modal-library-item-tedails-settings-tags').find('p').html( colorInfo.tags);
			$sidebar.find('.ff-modal-library-item-tedails-settings-hex').find('p').html( colorInfo.hex);
			$sidebar.find('.ff-modal-library-item-tedails-settings-rgba').find('p').html( colorInfo.rgba);
			
			// ff-modal-library-item-tedails-settings-tags  / hex / rgba
			if( colorInfo.type == 'system' ) {
				$sidebar.find('.edit-attachment').css('display','none');
			} else {
				$sidebar.find('.edit-attachment').css('display','block');
			}
		}
		
		
		//console.log(hideBannedVariablesForColor('@brand-primary'));

		
		/**getBannedVariables('@brand-primary', function( bannedVariablesArray ){
			console.log( bannedVariablesArray );
			console.log('pica');
		});*/
		
		
//##############################################################################
//# GROUP ITEMS
//##############################################################################		
		selectors.$groupItem.click(function(){
			var colorInfo = getColorInfoObjectFromSelector( $(this) );
			changeSidebarColor( colorInfo );
			data.$currentSelectedColor = $(this);
			data.currentSelectedColorInfo = colorInfo;
		});
		
	})();	
});


/*	//var val = content
		frslib.modal.conditional_logic.show ();
		var specification =  	{
		 							'managerClass' : 'ffModalWindowManagerConditions',
		 							'modalClass' : 'ffModalWindowConditions',
		 							'viewClass' : 'ffModalWindowConditionsViewDefault'
								};
		if( true ) {
			$('.media-frame-content-inner').html('');
			frslib.ajax.frameworkRequest( 'ffModalWindow', specification, content, function( response ) {
				$('.media-frame-content-inner').html( response);
		 			frslib.options.select_content_type.init();
		 			frslib.conditional_logic.disable_options( $('.media-frame-content-inner').find('.ff-conditional-logic-checkbox') );
		 	});
		 } */

//alert('x');