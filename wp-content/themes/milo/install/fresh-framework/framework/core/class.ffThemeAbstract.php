<?php

abstract class ffThemeAbstract {
	
	/**
	 * 
	 * @var ffThemeContainerAbstract
	 */
	protected  $_container = null;
	
	public function __construct( ffThemeContainerAbstract $themeContainer ) {
		$this->_setContainer($themeContainer);
		$this->_setDependencies();
		
		if( $themeContainer->getFrameworkContainer()->getWPLayer()->is_ajax() ) {
			$this->_ajax();
		}
		
		$this->_registerAssets();
		$this->_beforeRun();
		$this->_run();
	}
	
	
	private function _beforeRun() {
		$fwc = $this->_getContainer()->getFrameworkContainer();
		
		// it will hook actions after initialisation
		$fwc->getThemeFrameworkFactory()->getThemeAssetsManager();
		//ffContainer::getInstance()->getThemeFrameworkFactory()->getThemeAssetsManager();
	}
	
	
	protected abstract function _setDependencies();
	protected abstract function _registerAssets();
	protected abstract function _run();
	protected abstract function _ajax();
	
	/**
	 *
	 * @return ffThemeContainerAbstract
	 */
	protected function _getContainer() {
		return $this->_container;
	}
	
	/**
	 *
	 * @param ffThemeContainerAbstract $_container        	
	 */
	protected function _setContainer(ffThemeContainerAbstract $container) {
		$this->_container = $container;
		return $this;
	}
	
	
	
	
	
	
// 	/*
// 	protected $_pluginDirClean = null;
	
// 	/**
// 	 * 
// 	 * @var ffPluginContainerAbstract
// 	 */
// 	protected $_container = null;
	
// 	public function __construct( ffPluginContainerAbstract $pluginContainer, $pluginDirClean ) {
// 		$this->_setPluginDirClean($pluginDirClean);
// 		$this->_setContainer( $pluginContainer );
// 		$this->_setDependencies();
		
// 		if( $pluginContainer->getFrameworkContainer()->getWPLayer()->is_ajax() ) {
// 			$this->_ajax();
// 		}
		
// 		$this->_registerAssets();
// 		$this->_run();	
// 	}	
	
// 	public function pluginActivation() {
		
// 	}
	
// 	public function pluginDeactivation() {
		
// 	}
	
// 	/**
// 	* @return unknown_type
// 	*/
// 	protected function _getPluginDirClean() {
// 		return $this->_pluginDirClean;
// 	}
	
// 	/**
// 	* @param unknown_type $pluginDirClean
// 	*/
// 	protected function _setPluginDirClean($pluginDirClean) {
// 		$this->_pluginDirClean = $pluginDirClean;
// 		return $this;
// 	}

// 	protected function _getContainer() {
// 		return $this->_container;
// 	}
	
// 	protected function _setContainer(ffPluginContainerAbstract $container) {
// 		$this->_container = $container;
// 		return $this;
// 	}
	
	
// 	protected abstract function _setDependencies();
// 	protected abstract function _registerAssets();
// 	protected abstract function _run();
	
// 	// added since 1.1.2
// 	protected function _ajax() {}
}