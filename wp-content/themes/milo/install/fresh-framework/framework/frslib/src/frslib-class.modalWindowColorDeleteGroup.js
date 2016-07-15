(function($){
	
frslib._classes.modalWindowColorDeleteGroup = function(){


//##############################################################################
//# INHERITANCE
//##############################################################################


		var _ = frslib._classes.modalWindow_aBasic();
		_._className = 'modalWindowColorDeleteGroup';


//##############################################################################
//# PARAMS
//##############################################################################


			_.selectors.modalWindowOpener = 'nothing';
			_.selectors.modalWindow = '#ff-modal-library-delete-group';
			_.selectors.sidebar = '.media-sidebar';
			_.selectors.groupSelect = '.ff-group-select';
			_.selectors.groupDeleteOptions = '.ff-group-delete-option';
			_.selectors.currentGroup = '.ff-current-group';

			_.variables.allGroups = null;
			_.variables.currentGroupSlug = null;
			_.variables.groupInfo = null;

			_.jquery.$groupSelect = null;
			_.jquery.$groupDeleteOptions = null;
			_.jquery.$currentGroup = null;


//##############################################################################
//# INITIALIZATION
//##############################################################################


			_.initJqueryAction.initSelectors = function() {
				//ff-group-select
				_.jquery.$groupSelect = _.jquery.$modalWindow.find( _.selectors.groupSelect );
				_.jquery.$currentGroup = _.jquery.$modalWindow.find( _.selectors.currentGroup );
				_.jquery.$groupDeleteOptions = _.jquery.$modalWindow.find( _.selectors.groupDeleteOptions );
			}


//##############################################################################
//# HOOKS: EXECUTIVE FUNCTIONS ( OPEN, CLOSE, ETC )
//##############################################################################


//##############################################################################
//# FUNCTIONS
//##############################################################################


			_.setGroupInfo = function( groupInfo, currentGroup) {
				var optionHtml = '';
				_.variables.groupInfo= groupInfo;
				for( key in groupInfo ) {
					var oneGroup = groupInfo[ key ];

					if( oneGroup.slug == currentGroup.slug ) {
						continue;
					}
					optionHtml += '<option value="' + oneGroup.slug + '">' + oneGroup.name + '</option>';

				}

				_.jquery.$currentGroup.html('"' + currentGroup.name + '"' );
				_.jquery.$groupSelect.html( optionHtml );

				_.jquery.$groupDeleteOptions.eq(1).parents('label:first').css('display','block');
				_.jquery.$groupSelect.parents('label:first').css('display','block');

				if( groupInfo.length == 1 ) {
					_.jquery.$groupDeleteOptions.eq(1).parents('label:first').css('display','none');
					_.jquery.$groupSelect.parents('label:first').css('display','none');
				}
			};


			_.getSelectedValues = function() {
				var info = {};

				info.action = _.jquery.$groupDeleteOptions.filter(':checked').val();
				info.newGroup = _.jquery.$groupSelect.val();

				return info;
			};



//##############################################################################
//# RETURN ITSELF
//##############################################################################


			return _;


		}

})(jQuery);







//ff-modal-library-add-group