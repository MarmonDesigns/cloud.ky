<?php

class ffModalWindowManagerSectionPicker extends ffModalWindowManager {
	protected function _initialize() {
		$this->_setId('ff-modal-section-picker');
		$this->_setModalWindowClass('ff-modal-library ff-modal-library-icon-picker');
		$this->addCssClass( ffModalWindowManager::CLASS_HIDE_MENU);
		//$this->addCssClass( ffModalWindowManager::CLASS_HIDE_ROUTER);
		//$this->addCssClass( ffModalWindowManager::CLASS_HIDE_MODAL_WINDOW );
		$this->_addDifferentRouterMenu('Section Library', 'view');
		// $this->_addDifferentRouterMenu('Add Icons', 'add-color');
	}
}