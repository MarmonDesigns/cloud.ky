<?php

class ffModalWindowLibraryDeleteGroupViewDefault extends ffModalWindowView {
	
	/**
	 * 
	 * @var ffModalWindowLibraryColorPickerColorPreparator
	 */
	private $colorLibraryPreparator = null;

	// Toolbar
	protected $_toolbarCancelText = "Cancel";
	protected $_toolbarOKText = "Delete Group";
	protected $_toolbarHasSizeSlider = false;

	protected function _initialize() {
		$this->_setViewName('Default');
		$this->_setWrappedInnerContent( false );
	}

	protected  function _requireAssets() {
		$this->_getScriptEnqueuer()->getFrameworkScriptLoader()
										->requireSelect2()
										->requireFrsLib()
										->requireFrsLibOptions()
										->requireFrsLibModal();
		
		//$this->_getScriptEnqueuer()->addScriptFramework('ff-modal-color-picker', '/framework/adminScreens/modalWindow/libraries/color/picker/assets/ModalWindowLibraryColorPicker.js', array('jquery'));
		/*
		$this->_getScriptEnqueuer()->addScriptFramework('ff-nouislider-js', '/framework/extern/nouislider/jquery.nouislider.min.js', array('jquery'));
		$this->_getStyleEnqueuer()->addStyleFramework('ff-nouislider-css', '/framework/extern/nouislider/jquery.nouislider.min.css');*/
	}
	
	

	private function _printUserColors( $data ) {

		 
	}
	
	protected function _render() {
		$container = ffContainer::getInstance();
		
		$s = $container->getOptionsFactory()->createStructure('a');
		
		$s->startSection('start');

			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'How would you like to proceed?');
	
					$s->addOption( ffOneOption::TYPE_RADIO, '', '', 'delete-group', '')
							->addSelectValue('Delete <span class="ff-current-group">&#8220;My colors&#8221;</span> group and its colors forever', 'delete-group')
							->addSelectValue('Delete <span class="ff-current-group">&#8220;My colors&#8221;</span> group but transfer its colors to this group:', 'move-colors-delete-group')
							->addParam('class', 'ff-group-delete-option');

					$s->addOption( ffOneOption::TYPE_SELECT, '', '', 'delete-colors', '')
							->addParam('class', 'ff-group-select');
					
					//$s->addElement( ffOneElement::TYPE_HTML, '', 'html tady prosim');

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );			
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		
		$s->endSection('end');
		
		$printer = $container->getOptionsFactory()->createOptionsPrinter( array(), $s );
		$printer->walk();
		
		
		
	}
	
	
	private function _printSidebar() {
	
	}


	public function proceedAjax( ffAjaxRequest $request ) {
		
	}


	private function _printForm( $data = array() ) {
 
	}
}