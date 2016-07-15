<?php

class ffModalWindowManagerLibraryColorPicker extends ffModalWindowManager {
	protected function _initialize() {
		$this->_setId('ff-modal-library-color-picker');
		$this->_setModalWindowClass('ff-modal-library ff-modal-library-color-picker');
		$this->addCssClass( ffModalWindowManager::CLASS_HIDE_MENU);
		//$this->addCssClass( ffModalWindowManager::CLASS_HIDE_ROUTER);
		//$this->addCssClass( ffModalWindowManager::CLASS_HIDE_MODAL_WINDOW );
		//$this->_addDifferentRouterMenu($name, $slug)
		$this->_addDifferentRouterMenu('Color Library', 'view');
		$this->_addDifferentRouterMenu('Add Color', 'add-color');
		$this->_addDifferentRouterMenu('Add Group', 'add-group');
	}
}