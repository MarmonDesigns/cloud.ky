(function($){

frslib._classes.modalWindowColorAddGroup = function(){


//##############################################################################
//# INHERITANCE
//##############################################################################


		var _ = frslib._classes.modalWindow_aBasic();
		_._className = 'modalWindowColorAddGroup';


//##############################################################################
//# PARAMS
//##############################################################################


			_.selectors.modalWindowOpener = 'nothing';
			_.selectors.modalWindow = '#ff-modal-library-add-group';
			_.selectors.sidebar = '.media-sidebar';
			_.selectors.groupTitle = '.ff-group-title-input';


//##############################################################################
//# INITIALIZATION
//##############################################################################



//##############################################################################
//# HOOKS: EXECUTIVE FUNCTIONS ( OPEN, CLOSE, ETC )
//##############################################################################


		_.hooks.afterOpenWindow.focus = function() {
			_.jquery.$modalWindow.find( _.selectors.groupTitle ).focus();
		}


		_.bindAction.SizeSliderInit_PlusButton = function() {
			_.jquery.$modalWindow.find( _.selectors.groupTitle ).keyup(function(e) {
				if (e.keyCode == 13) {
					_.jquery.$modalWindow.find( _.selectors.mediaButtonSubmit ).click();
				}
			});
		};


//##############################################################################
//# FUNCTIONS
//##############################################################################


			_.getGroupTitle = function() {
				return _.jquery.$modalWindow.find( _.selectors.groupTitle ).val();
			}

			_.setGroupTitle = function( value ) {
				return _.jquery.$modalWindow.find( _.selectors.groupTitle ).val( value );
			}


//##############################################################################
//# RETURN ITSELF
//##############################################################################


			return _;


		}

})(jQuery);







//ff-modal-library-add-group