<?php

abstract class ffModalWindow extends ffModalWindowBasicObject {
	private $_menuName = null;
	
	private $_menuSlug = null;

	private $_views = null;
	
	 
	protected function _initialize() {} 
	
	
	
	/**
	 * 
	 * @return array[ffModalWindowView]
	 */
	public function getViews() {
		return $this->_views;
	}
	
	public function getSlug() {
		return $this->_menuSlug;
	}
	
	public function getName() {
		return $this->_menuName;
	}
	
	public function addViewObject( ffModalWindowView $view ) {
		$this->_views[ $view->getSlug() ] = $view;
	}
	
	/**
	 * @return unknown_type
	 */
	protected function _getMenuName() {
		return $this->_menuName;
	}
	
	/**
	 * @param unknown_type $_menuName
	 */
	protected function _setMenuName($menuName) {
		$this->_setMenuSlug($menuName );
		$this->_menuName = $menuName;
		return $this;
	}
	
	/**
	 * @return unknown_type
	 */
	protected function _getMenuSlug() {
		return $this->_menuSlug;
	}
	
	/**
	 * @param unknown_type $_menuSlug
	 */
	protected function _setMenuSlug($menuSlug) {
		$this->_menuSlug = $this->_getWPLayer()->sanitize_title($menuSlug);
		return $this;
	}	
}




