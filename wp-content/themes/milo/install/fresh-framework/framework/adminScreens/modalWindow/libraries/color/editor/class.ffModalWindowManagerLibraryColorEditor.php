<?php

class ffModalWindowManagerLibraryColorEditor extends ffModalWindowManager {
	protected function _initialize() {
		$this->_setId('ff-modal-library-color-editor');
		$this->_setModalWindowClass('ff-modal-library-color-editor');
		$this->addCssClass( ffModalWindowManager::CLASS_HIDE_MENU);
		$this->addCssClass( ffModalWindowManager::CLASS_HIDE_ROUTER);

	}
}