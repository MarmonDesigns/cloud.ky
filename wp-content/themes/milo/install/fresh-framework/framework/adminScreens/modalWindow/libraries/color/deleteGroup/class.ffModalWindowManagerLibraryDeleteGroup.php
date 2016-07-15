<?php

class ffModalWindowManagerLibraryDeleteGroup extends ffModalWindowManager {
	protected function _initialize() {
		$this->_setId('ff-modal-library-delete-group');
		$this->_setModalWindowClass('ff-modal-library ff-modal-library-delete-group');
		$this->addCssClass( ffModalWindowManager::CLASS_HIDE_MENU);
		$this->addCssClass( ffModalWindowManager::CLASS_HIDE_ROUTER);
		//$this->addCssClass( ffModalWindowManager::CLASS_HIDE_MODAL_WINDOW );
		//$this->_addDifferentRouterMenu($name, $slug)
		//$this->_addDifferentRouterMenu('View', 'view');
		//$this->_addDifferentRouterMenu('Add Group', 'add-group');
		//$this->_addDifferentRouterMenu('Add Color', 'add-color');
	}
}