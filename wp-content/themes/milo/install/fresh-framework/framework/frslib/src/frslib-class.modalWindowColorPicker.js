"use strict";

(function($){


	frslib._classes.modalWindowColorPicker = function(){


//##############################################################################
//# INHERITANCE
//##############################################################################


		// modalWindow_aPicker is parent class
		var _ = frslib._classes.modalWindow_aPicker();
		_._className = 'modalWindowColorPicker';


//##############################################################################
//# PARAMS
//##############################################################################


		_.selectors.modalWindowOpener = '.ff-open-library-color-button';
		_.selectors.modalWindow = '#ff-modal-library-color-picker';
		_.selectors.sidebar = '.media-sidebar';

		_.variables.currentColorObject = {};
		_.variables.addGroupWindow = {};
		_.variables.deleteGroupWindow = {};
		_.variables.colorEditorWindow = {};

		_.jquery.$sidebar = {};

		_.useTitlesHiding = false;

//##############################################################################
//# INITIALIZATION jQuery selectors
//##############################################################################


		_.initJqueryAction.initSidebar = function() {
			_.jquery.$sidebar = _.jquery.$modalWindow.find( _.selectors.sidebar );
		};
		
		
		_.initAction.initAddGroup = function() {
			//_.variables.addGroupWindow.openWindow();
		}


//##############################################################################
//# HOOKS: EXECUTIVE FUNCTIONS ( OPEN, CLOSE, ETC )
//##############################################################################


		// change the sidebar for the actual color
		_.hooks.libraryItemChosen.changeSidebar = function( $selectedItem ) {
			_.jquery.$currentselectedItem_New = $selectedItem;
			_.variables.currentColorObject = frslib._classes.modalWindowColorLibraryColor();
			_.variables.currentColorObject.setCurrentSelector( $selectedItem );
			_.variables.currentColorObject.gatherDataFromSelector();

			_.changeSidebar( $selectedItem );
		}
		

//##############################################################################
//# FUNCTIONS
//##############################################################################

		
		_.ajaxRequest = function( action, data, callback ) {
			var specification = {
					  'managerClass' : 'ffModalWindowManagerLibraryColorPicker'
					, 'modalClass'   : 'ffModalWindowLibraryColorPicker'
					, 'viewClass'    : 'ffModalWindowLibraryColorPickerViewDefault'
					, 'action'       : action
			}


			frslib.ajax.frameworkRequest( 'ffModalWindow', specification, data, callback);
		};
		
		
		_.hideSidebar = function() {
			_.jquery.$sidebar.find('.attachment-details').css('display', 'none');
		};

		// change the sidebar for the latest selected color
		_.changeSidebar = function( $selectedItem ) {

			if( $selectedItem ){} else{ _.hideSidebar(); return; }

			var currentColorObject = _.variables.currentColorObject;
			var $sidebar = _.jquery.$sidebar;

			$sidebar.find('.attachment-details').css('display', 'block');

			$sidebar.find('.ff-modal-library-item-color').css('background', currentColorObject.colors.rgba);

			$sidebar.find('.filename').html( currentColorObject.description.name);
			$sidebar.find('.ff-modal-library-item-tedails-settings-tags').find('p').html( _.getTagsHtmlFromString( currentColorObject.description.tags ) );			$sidebar.find('.ff-modal-library-item-tedails-settings-hex').find('p').html( currentColorObject.colors.hex );

			var rgb =  currentColorObject.colors.rgb;
			$sidebar.find('.ff-modal-library-item-tedails-settings-rgba').find('p').html( 'rgba('+ rgb.r+',' + rgb.g+',' + rgb.b + ',' + currentColorObject.colors.opacity + ')' );


			$sidebar.find('.edit-attachment').show();
			$sidebar.find('.delete-attachment').show();
			if( currentColorObject.description.type == 'system' ){
				$sidebar.find('.edit-attachment').hide();
				$sidebar.find('.delete-attachment').hide();

			}
		}


		// _.templateExists = function( groupName ) {
		// 	var groupSlug = frslib.text.onlyAlphaNumeric( groupName ).toLowerCase().replace(new RegExp(' ', 'g'), '-');
		// 	return _.groups.groupExistBySlug( groupSlug );
		// }

		_.colorGroupWithNiceNameExists = function( groupName ){
			var groupNameExists = false;

			_.jquery.$itemsTitles.each(function( index ){
				var lbl = $(this).find('.ff-group-label').html();
				if( lbl == groupName ){
					groupNameExists = true;
				}
			});

			return groupNameExists;
		}

		_.updateNewColorGroupName = function( groupName ){

			var groupNameExists = _.colorGroupWithNiceNameExists( groupName );

			var i;

			if( groupNameExists ){
				for ( i = 2 ; i < 10000; i++) {
					groupNameExists = _.colorGroupWithNiceNameExists( groupName + ' ' + i );
					if( ! groupNameExists ){
						return  groupName + ' ' + i;
					}
				};

				return _.updateNewColorGroupName( groupName + ' 2' );
			}else{
				return groupName;
			}
		}

		_.createColorGroupSlug = function(){
			// var groupSlug = frslib.text.onlyAlphaNumeric( groupName ).toLowerCase().replace(new RegExp(' ', 'g'), '-');
			var groupSlug = 'user_group_' + _.getNowTimestamp();
			return groupSlug;
		}


		_.printNewTemplate = function( groupName, groupSlug ) {
			var groupTemplate = $.base64.atob(_.jquery.$modalWindow.find('.ff-new-group').html());

			var $itemGroups = _.jquery.$modalWindow.find('.ff-modal-library-items-container .ff-modal-library-items');

			$itemGroups.prepend( groupTemplate );

			var $newGroup = $itemGroups.find('.ff-modal-library-items-group[data-group-name-nice=template]:first');
			var $newGroupTitle = $newGroup.find('.ff-modal-library-items-group-title');
			var $newGroupLabel = $newGroupTitle.find('label span.ff-group-label');

			$newGroupLabel.html( groupName );

			$newGroup.attr('data-group-name-nice', groupName);
			$newGroup.attr('data-group-name', groupSlug);

			$newGroupTitle.attr('data-group-name-nice', groupName);
			$newGroupTitle.attr('data-group-name', groupSlug);
		}


		_.createNewGroupAjax = function( groupName, groupSlug ) {
			var data = {};
			data.groupName = groupName;
			data.groupSlug = groupSlug;
			_.ajaxRequest( 'create-new-group', data, function( response ){

			});
		}
		_.createNewGroup = function( groupName ) {
			var groupSlug = _.createColorGroupSlug();
			groupName = _.updateNewColorGroupName( groupName );
			// if( !_.templateExists( groupName ) ) {
				_.printNewTemplate( groupName, groupSlug );
				_.createNewGroupAjax( groupName, groupSlug );
			// }
		}


		_.bindAction.initModalRemoveGroup = function() {
			$('body').on( 'click', '.ff-modal-library-items-group-delete', function() {
				
				var allGroups = _.groups.getUserGroupsInfo();
				var thisTitleSelector = $(this).parents('.ff-popup-color-settings-container').attr('data-for');
				// var $thisTitle = $(this).parents('.ff-modal-library-items-group-title');
				var $thisTitle = _.jquery.$modalWindow.find('.ff-modal-library-items-groups-titles').find(thisTitleSelector);

			
				
				var currentGroup = {};
				currentGroup.slug = $thisTitle.attr('data-group-name');
				currentGroup.name = $thisTitle.attr('data-group-name-nice');
				
				
				
				var $thisGroup = _.jquery.$modalWindow.find('.ff-modal-library-items-group[data-group-name="'+currentGroup.slug+'"]');
				

				_.variables.deleteGroupWindow.setGroupInfo( allGroups, currentGroup );
				_.variables.deleteGroupWindow.openWindow();
				_.variables.deleteGroupWindow.hooks.afterSubmitWindow.deleteGroup = function() {
					
					
					
					var selectedValues = _.variables.deleteGroupWindow.getSelectedValues();
					selectedValues.groupToDelete = currentGroup;
					
					if( selectedValues.action == 'move-colors-delete-group' ) {
					
					//console.log( selectedValues );
					/*delete-group
					move-colors-delete-group*/
					
						var $items = $thisGroup.find('.ff-modal-library-items-group-item');
						
					
						
						var $newGroup = _.jquery.$modalWindow.find('.ff-modal-library-items-group[data-group-name="'+selectedValues.newGroup+'"]');
						
						$newGroup.find('.ff-modal-library-items-group-items').append( $items );
					
						// CLEAR
						_.reinit();
						// CLEAR
					}
					
					_.ajaxRequest( selectedValues.action , selectedValues, function( response ){

						console.log( selectedValues );
						window.setTimeout(function(){
							// TODO: CIGANSKY FIX
							_.ajaxRequest( 'delete-group' , selectedValues, function( response ){});
							// TODO: CIGANSKY FIX

							// CLEAR
							_.reinit();
							// CLEAR
						},100);

					});
					
					$thisTitle.hide(function(){ $(this).remove()});
					$thisGroup.hide(function(){ $(this).remove()});
					
					_.jquery.$search.click();
				}
			});
		}
		
		
		_.bindAction.initModalAddGroup = function() {
			
			$('body').on( 'click','.add-group', function(){

				_.variables.addGroupWindow.openWindow();
				
				_.variables.addGroupWindow.setModalTitle('Add Group');
				_.variables.addGroupWindow.setGroupTitle('Color Group');
				_.variables.addGroupWindow.hooks.afterSubmitWindow.createNewGroup = function() {
					var newColorGroupName = _.variables.addGroupWindow.getGroupTitle();
					_.createNewGroup( newColorGroupName );
					
					_.variables.addGroupWindow.hooks.afterSubmitWindow.createNewGroup = null;

					// CLEAR
					_.reinit();
					// CLEAR

				}
				return false;
			});
		}
		
		
		_.bindAction.initModalRenameGroup = function() {
			$('body').on('click', '.ff-modal-library-items-color-rename', function() {
				var thisTitleSelector =  $(this).parents('.ff-popup-color-settings-container').attr('data-for');
				var $thisTitle = _.jquery.$modalWindow.find('.ff-modal-library-items-groups-titles').find(thisTitleSelector);
				

				var currentGroup = {};
				currentGroup.slug = $thisTitle.attr('data-group-name');
				currentGroup.name = $thisTitle.attr('data-group-name-nice');
				
				var $thisGroup = _.jquery.$modalWindow.find('.ff-modal-library-items-group[data-group-name="'+currentGroup.slug+'"]');
				
				_.variables.addGroupWindow.setGroupTitle( currentGroup.name );
				
				_.variables.addGroupWindow.setModalTitle('Rename Group');
				_.variables.addGroupWindow.hooks.afterSubmitWindow.editWorkingGroup = function() {
					var newColorGroupName = _.variables.addGroupWindow.getGroupTitle();
					
					var data = {};
					data.newGroupName = _.updateNewColorGroupName(newColorGroupName);
					data.oldGroupSlug = currentGroup.slug;
					
					// console.log( data );
			
					
					$thisTitle.find('.ff-group-label').html( data.newGroupName );
					$thisGroup.find('.ff-group-label').html( data.newGroupName );
					
					_.ajaxRequest('rename-group', data, function( response ) {
						// CLEAR
						_.reinit();
						// CLEAR
					});
					
					//_.createNewGroup( newColorGroupName );
					
					//alert( newColorGroupName );
					
					_.variables.addGroupWindow.hooks.afterSubmitWindow.editWorkingGroup = null;
				}
				
				_.variables.addGroupWindow.openWindow();
			});
			//ff-modal-library-items-color-rename
		}


		_.createNewColor = function( newColorObject ) {
			var newColorHtml = $.base64.atob(_.jquery.$modalWindow.find('.ff-new-color').html());
			var $newColor = $(newColorHtml);

			newColorObject.description.type = 'user';
			newColorObject.selectors.$currentSelectedColor = $newColor;
			newColorObject.writeDataToSelector();

			var $groupToAdd = _.jquery.$modalWindow.find('.ff-modal-library-items-group[data-group-name="'+newColorObject.description.group+'"]' );
			//data-group-name
			//$groupToAdd.removeClass('hidden-force');
			_.jquery.$search.click();
			$groupToAdd.find('.ff-modal-library-items-group-items').append( $newColor );

			// CLEAR
			_.reinit();
			// CLEAR

			//_.ajaxRequest = function( action, data, callback ) {
			_.ajaxRequest( 'create-color', newColorObject.getOnlyData() , function( response ) {
				var newInsertedColorId = response;
				$newColor.find('.ff-item-id').val( newInsertedColorId );
				// CLEAR
				_.reinit();
				// CLEAR
			});
		}

		_.hooks.oneLibraryItemHooverIn.oneLibraryItem_itemMouseEnter = function( $what ) {
			//_.jquery.$currentSelectedItem = $what;
			//console.log( $what );
			//_.changeSidebar();
			_.jquery.$oldItemForHover = _.jquery.$currentSelectedItem; 
			//_.jquery.$oldItemForHover = _.jquery.$currentselectedItem_New; 
			_.hooks.libraryItemChosen.changeSidebar( $what );
		};

		_.hooks.oneLibraryItemHooverOut.oneLibraryItem_itemMouseLeave = function( $what ) {
			_.hooks.libraryItemChosen.changeSidebar( _.jquery.$currentSelectedItem );
		};
		
		_.bindAction.initModalAddColor = function() {
			
			$('body').on( 'click', '.add-color', function() {
				
				var userGroups =  _.groups.getUserGroupsInfo();
				var newColor = new frslib._classes.modalWindowColorLibraryColor();
				newColor.setColor('#000000');
				newColor.setOpacity(1);
				newColor.setName('New Color');
			
				if( userGroups.length == 0 ) {
					alert('You need to create at least one color group first. Start by clicking on the "Add Group" button.');
				} else {
				
					_.variables.colorEditorWindow.setInformations( newColor, userGroups );
					
					_.variables.colorEditorWindow.openWindow();
					
					_.variables.colorEditorWindow.hooks.afterSubmitWindow.createNewColor = function() {						
						_.createNewColor( _.variables.colorEditorWindow.getColorObject() );						

						// CLEAR
						_.reinit();
						// CLEAR
					};
				}
			});
			//ff-modal-library-items-group-settings-color-add
			$('body').on( 'click', '.ff-modal-library-items-color-add', function() {
				
				var thisTitleSelector = $(this).parents('.ff-popup-color-settings-container').attr('data-for');
				var $thisTitle = _.jquery.$modalWindow.find( thisTitleSelector );
				
				var groupName = $thisTitle.attr('data-group-name');
				
			 
				var userGroups =  _.groups.getUserGroupsInfo();
				var newColor = new frslib._classes.modalWindowColorLibraryColor();
				newColor.setColor('#000000');
				newColor.setOpacity(1);
				newColor.setName('New Color');
				newColor.description.group = groupName;

				_.variables.colorEditorWindow.setInformations( newColor, userGroups );

				_.variables.colorEditorWindow.openWindow();

				_.variables.colorEditorWindow.hooks.afterSubmitWindow.createNewColor = function() {
					// CLEAR
					_.reinit();
					// CLEAR
					_.createNewColor( _.variables.colorEditorWindow.getColorObject() );

				};

			});

			$('body').on( 'click', '.ff-modal-library-items-group-settings-color-add', function() {
				//var thisTitleSelector = $(this).parents('.ff-popup-color-settings-container').attr('data-for');
				var $thisTitle = $(this).parents('.ff-modal-library-items-group-title:first');// _.jquery.$modalWindow.find( thisTitleSelector );
				
				var groupName = $thisTitle.attr('data-group-name');
				
			 
				var userGroups =  _.groups.getUserGroupsInfo();
				var newColor = new frslib._classes.modalWindowColorLibraryColor();
				newColor.setColor('#000000');
				newColor.setOpacity(1);
				newColor.setName('New Color');
				newColor.description.group = groupName;
				
				_.variables.colorEditorWindow.setInformations( newColor, userGroups );
				
				_.variables.colorEditorWindow.openWindow();
				
				_.variables.colorEditorWindow.hooks.afterSubmitWindow.createNewColor = function() {

					_.createNewColor( _.variables.colorEditorWindow.getColorObject() );

					// CLEAR
					_.reinit();
					// CLEAR
				};
				
			});
			
			
			
		};
		
	
		
		
		_.saveEditedColor = function() {
			_.ajaxRequest( 'edit-color', _.variables.currentColorObject.getOnlyData() , function( response ) {
				//console.log( response );
			});
		};
		
		_.bindAction.initModalEditColor = function() {
			
			
			$('body').on( 'click', '.edit-attachment, .ff-modal-library-items-group-item-color-controls-edit', function() {
				var userGroups =  _.groups.getUserGroupsInfo();
				_.variables.currentColorObject 
				
				_.variables.colorEditorWindow.setInformations( _.variables.currentColorObject , userGroups );
				
				_.variables.colorEditorWindow.openWindow();
				
				_.variables.colorEditorWindow.hooks.afterSubmitWindow.createNewColor = function() {
					_.variables.currentColorObject = _.variables.colorEditorWindow.getColorObject();
					_.variables.currentColorObject.writeDataToSelector();
					
					
					var $group = _.variables.currentColorObject.selectors.$currentSelectedColor.parents('.ff-modal-library-items-group:first');
					var groupName = $group.attr('data-group-name');
					
					if( groupName != _.variables.currentColorObject.description.group ) {
						_.variables.currentColorObject.selectors.$currentSelectedColor.remove();
						_.jquery.$modalWindow.find('.ff-modal-library-items-group[data-group-name="'+_.variables.currentColorObject.description.group+'"]').find('.ff-modal-library-items-group-items').append(_.variables.currentColorObject.selectors.$currentSelectedColor );
					}
					
					//$group.remove();
					
					_.changeSidebar();
					_.saveEditedColor();
					
					_.jquery.$search.click();

					// CLEAR
					_.reinit();
					// CLEAR
				};
			});
		
		}
		
		_.bindAction.submitWithButtonClick = function() {
			$('body').on('click', '.ff-modal-library-items-group-item-color-controls-select', function() {
				_.submitWindow();
			});
		};
		

		_.bindAction.sidebarTagClick = function(){
			$('body').on( 'click', _.selectors.modalWindow + ' ' + '.ff-modal-library-item-tedails-settings-tags p a', function(){
				_.jquery.$search.val( $(this).html() );
				_.searchFilter();
			});
		};
		
		_.bindAction.duplicateColor = function() {
			$('body').on( 'click', '.duplicate-attachment', function() {
				
				var userGroups =  _.groups.getUserGroupsInfo();
				var newColor =  _.variables.currentColorObject;
				//newColor.setColor('#000000');
				//newColor.setOpacity(1);
				//newColor.setName('New Color');
				newColor.description.id = null;
			
				_.variables.colorEditorWindow.setInformations( newColor, userGroups );
				
				_.variables.colorEditorWindow.openWindow();
				
				_.variables.colorEditorWindow.hooks.afterSubmitWindow.createNewColor = function() {
					//console.log( 'kokotik');
					
					_.createNewColor( _.variables.colorEditorWindow.getColorObject() );
					
					// CLEAR
					_.reinit();
					// CLEAR
				};
			});
		}
		
		_.bindAction.deleteColor = function() {
			$('body').on( 'click', '.delete-attachment', function() {
				
				if( confirm('Do you really want to delete this color?' ) ) {
					var data = {};
					data.idToDelete = _.variables.currentColorObject.description.id;
					_.hideSidebar();
					_.ajaxRequest( 'delete-color', data, function( response ) {
						 
					});
					
					_.variables.currentColorObject.selectors.$currentSelectedColor.hide(500, function(){
						$(this).remove();
						_.variables.currentColorObject = null;
					});
				}
				
				
				
				return;


			});
		}
		
		
		_.selectColorByValue = function( colorValue ) {
			
			_.jquery.$modalWindow.find('.ff-modal-library-items-group-item').css('display', 'block');
			
			var $oneField = _.jquery.$modalWindow.find('.ff-item-id[value="'+colorValue+'"]');
			var $item = $oneField.parents('.ff-modal-library-items-group-item:first');
			
			
			$item.click();
			
			var currentColorName = _.jquery.$openingButton.find('.ff-less-variable-name').html();
			
			
			var $oneFieldBanned = _.jquery.$modalWindow.find('.ff-item-id[value="'+currentColorName+'"]');
			var $itemBanned = $oneFieldBanned.parents('.ff-modal-library-items-group-item:first');
			
			//console.log(currentColorName);
			
			$itemBanned.css('display','none');
			
			
			var ignoredColors = $.parseJSON(_.jquery.$modalWindow.find('.ff-ignored-colors').html());
			
			if( ignoredColors == null ) {
				ignoredColors = {};
			}
			
			//console.log( ignoredColors );
			//console.log( currentColorName + 'xx');
			if( ignoredColors.hasOwnProperty( currentColorName ) ) {
				//console.log( 'yes');
				for( var key in ignoredColors[ currentColorName ] ) {
					var oneColorName = ignoredColors[ currentColorName ][ key ];
				
					
					var $oneFieldBanned = _.jquery.$modalWindow.find('.ff-item-id[value="'+ignoredColors[ currentColorName ][ key ]+'"]');
					var $itemBanned = $oneFieldBanned.parents('.ff-modal-library-items-group-item:first');
					$itemBanned.css('display', 'none');
				}
			}
			
			// TODO SCROLLLLLLLLLL
		};
		
		_.hooks.beforeOpenWindow.selectValue = function() {
			if( _.jquery.$openingButton != null ) {
				var selectedValue = _.jquery.$openingButton.find('.ff-color-input').val();
	
				_.selectColorByValue( selectedValue);
			}
		};
		
		 
		


		// Group Settings popup

		_.popupMenuCreateHtmlFunction_ColorPicker = function(){
			var ret = '';

			ret += '<div class="ff-popup-container ff-popup-color-settings-container" style="z-index: 99999999">';
				ret += '<div class="ff-popup-wrapper">';
					ret += '<div class="ff-popup-backdrop"></div>';
					ret += '<ul class="ff-popup">';
						ret += '<li class="ff-popup-button-wrapper">';
							ret += '<div class="ff-popup-button ff-modal-library-items-color-add">Add Color</div>';
						ret += '</li>';
						ret += '<li class="ff-popup-button-wrapper">';
							ret += '<div class="ff-popup-button ff-modal-library-items-color-rename">Rename Group</div>';
						ret += '</li>';
						ret += '<li class="ff-popup-button-wrapper">';
							ret += '<div class="ff-popup-button ff-modal-library-items-group-delete">Delete Group</div>';
						ret += '</li>';
					ret += '</ul>';
				ret += '</div>';
			ret += '</div>';

			_.jquery.$modalWindow.append( ret );
		}

		_.bindAction.groupSettings_Click = function(){
			$('body').on( 'click', _.selectors.modalWindow + ' ' + _.selectors.modalGroupSettings, function( e ){
				var index = $( this ).parents( _.selectors.itemsTitles ).attr('data-title-index');

				_.openPopupGroup( '.ff-popup-color-settings-container', _.popupMenuCreateHtmlFunction_ColorPicker, _.selectors.itemsTitles + '-' + index );
				var $popupMenu = $('.ff-popup-color-settings-container .ff-popup');

				var _left = e.pageX;
				var _top  = e.pageY - $(window).scrollTop();

				_left = _left + 20;
				_left = _left - parseInt( _.jquery.$modalWindow.find( _.selectors.modalWindowInner ).css('left') );

				$popupMenu.css('position', 'fixed');
				$popupMenu.css('left', _left);
				$popupMenu.css('top', _top);

				return false;
			});
		};
		
		
		
	// Remove Value
		
		
		_.hooks.afterSubmitWindow.saveValueToButton = function() {
			
			if( _.jquery.$openingButton != null ) {
				//console.log( _.variables.currentColorObject);
				
				_.jquery.$openingButton.find('.ff-open-library-button-preview-color').css('background',_.variables.currentColorObject.colors.hex );
				_.jquery.$openingButton.find('.ff-open-library-button-preview-color').css('opacity',_.variables.currentColorObject.colors.opacity );
				
				var objectToSave = {};
				objectToSave.id = _.variables.currentColorObject.description.id;
				objectToSave.type = _.variables.currentColorObject.description.type;
				
				
				
				
				var $input = _.jquery.$openingButton.find('.ff-color-input');
				var lessVariableName = _.jquery.$openingButton.find('.ff-less-variable-name').html();
				
				//console.log( $input );
				$input.val( objectToSave.id );
				
				var ajaxData = {};
				ajaxData.lessVariableName = lessVariableName;
				ajaxData.newValue = objectToSave.id;
				
				
				return;
				_.ajaxRequest('save-color', ajaxData, function( response ) {
					console.log( response );
				});
				
				//_.ajaxRequest = function( action, data, callback ) {
				
			}
		}
		
		_.hooks.afterSubmitWindow.saveValueToOtherButtons = function() {
			//ff-less-variable-name
		}
		
		_.bindAction.HookRemovingButton = function() {
			//ff-open-color-library-button-wrapper
		
			
			$('body').on('click', '.ff-open-color-library-button-wrapper .ff-open-library-remove', function(){
				var $button = $(this).parents('.ff-open-color-library-button-wrapper:first').find('.ff-open-library-color-button');
				var defaultValue = $button.find('.ff-less-variable-value').html();
				
				
				
				$button.find('.ff-color-input').val('');
				$button.find('.ff-open-library-button-preview-color').css('background', defaultValue);
				
				var data = {};
				data.colorName = $button.find('.ff-less-variable-name').html();
				
				return false;
				
				_.ajaxRequest( 'delete-color-value', data, function( response ){
					console.log( response );
				});
				
			});
			/*
			 * $(document).on('click','.ff-open-library-remove',function(e){
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
			 */
		}


//##############################################################################
//# ADD / REMOVE LESS FUNCTIONS REPEATABLE
//##############################################################################

//##############################################################################
//# RETURN ITSELF
//##############################################################################


		return _;


	}
})(jQuery);







