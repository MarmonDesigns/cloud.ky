(function($){

	frslib.provide('frslib.modal');

	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	// CONDITIONAL LOGIC - MODAL WINDOW
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################

	frslib.provide('frslib.modal.conditional_logic');

	frslib.modal.conditional_logic.current_input = null;

	frslib.modal.conditional_logic.show = function() {
		$('.ff-modal-conditions').css('display','block');
	};

	frslib.modal.conditional_logic.hide = function() {
		$('.ff-modal-conditions').css('display','none');
	};



	frslib.modal.conditional_logic.set_content = function( content ) {
		//var val = content
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
                    $('.ff-repeatable').css('display', 'block');
		 	});
		 }
	};

	$(document).on('click', '.ff-conditional-submit', function(){
		frslib.modal.conditional_logic.hide();
		var $form = frslib.options.template.functions.normalize( $(this).parents('.ff-modal-conditions').find('form'));
		frslib.modal.conditional_logic.current_input.val( $form.serialize() );
		frslib.callbacks.doCallback('ff-logic-form-submitted', frslib.modal.conditional_logic.current_input);
		return false;
	});

	$(document).on('click', '.media-modal-close, .media-modal-backdrop', function(){
		frslib.modal.conditional_logic.hide();
		return false;
	});

 
 
	
	
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	// COLOR LIBRARY - MODAL WINDOW
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################

	(function(){

		var deleteGroup = frslib._classes.modalWindowColorDeleteGroup();
		deleteGroup.init();
		
		var addGroup = frslib._classes.modalWindowColorAddGroup();
		addGroup.init();
		
		var colorEditor = frslib._classes.modalWindowColorEditor();
		colorEditor.init();
		
		
		var colorPicker = frslib._classes.modalWindowColorPicker();
		
		colorPicker.variables.addGroupWindow = addGroup;
		colorPicker.variables.deleteGroupWindow = deleteGroup;
		colorPicker.variables.colorEditorWindow = colorEditor;
		
		
		colorPicker.init();
	
		
		
		/*test.init();

		var addGroup = frslib._classes.modalWindowColorAddGroup();
		addGroup.init();

		var deleteGroup = frslib._classes.modalWindowColorDeleteGroup();
		deleteGroup.init();*/

		//modalWindowColorAddGroup

		var iconPicker = frslib._classes.modalWindowIconPicker();
		iconPicker.init();


		frslib.provide('frslib.modal.colorLibrary.events');


		frslib.modal.colorLibrary.events.getCurrentSelectedColor = 'colorlib_event_get_currentSelectedColor';
		frslib.modal.colorLibrary.events.setCurrentSelectedColor = 'colorlib_event_set_currentSelectedColor';

		var colorPicker = frslib._classes.modalWindowColorPicker();
		colorPicker.init();

		var colorEditor = frslib._classes.modalWindowColorEditor();
		colorEditor.init();



	})();

})(jQuery);












