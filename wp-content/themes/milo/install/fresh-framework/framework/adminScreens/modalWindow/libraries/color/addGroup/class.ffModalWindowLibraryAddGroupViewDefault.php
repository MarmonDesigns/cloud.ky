<?php

class ffModalWindowLibraryAddGroupViewDefault extends ffModalWindowView {
	
	/**
	 * 
	 * @var ffModalWindowLibraryColorPickerColorPreparator
	 */
	private $colorLibraryPreparator = null;

	// Toolbar
	protected $_toolbarCancelText = "Cancel";
	protected $_toolbarOKText = "Add Group";
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
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Group Title');

					$s->addOption( ffOneOption::TYPE_TEXT, '', '', 'My Colors', 'description')
							->addParam('class', 'ff-group-title-input');

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