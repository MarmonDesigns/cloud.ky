<?php

class ffModalWindowManagerConditions extends ffModalWindowManager {
	protected function _initialize() {
		$this->_setId('ff-modal-conditions');
		$this->_setModalWindowClass('ff-modal-conditions');
		$this->addCssClass( ffModalWindowManager::CLASS_HIDE_MENU);
		$this->addCssClass( ffModalWindowManager::CLASS_HIDE_ROUTER);
		$this->addCssClass( ffModalWindowManager::CLASS_HIDE_MODAL_WINDOW );
	}
}