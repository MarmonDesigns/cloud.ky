<?php

abstract class ffPluginAbstract {
	
	protected $_pluginDirClean = null;
	
	/**
	 * 
	 * @var ffPluginContainerAbstract
	 */
	protected $_container = null;
	
	public function __construct( ffPluginContainerAbstract $pluginContainer, $pluginDirClean ) {
		$this->_setPluginDirClean($pluginDirClean);
		$this->_setContainer( $pluginContainer );
		$this->_setDependencies();
		
		if( $pluginContainer->getFrameworkContainer()->getWPLayer()->is_ajax() ) {
			$this->_ajax();
		}
		
		$this->_registerAssets();
		$this->_run();	
	}	
	
	public function pluginActivation() {
		
	}
	
	public function pluginDeactivation() {
		
	}
	
	/**
	* @return unknown_type
	*/
	protected function _getPluginDirClean() {
		return $this->_pluginDirClean;
	}
	
	/**
	* @param unknown_type $pluginDirClean
	*/
	protected function _setPluginDirClean($pluginDirClean) {
		$this->_pluginDirClean = $pluginDirClean;
		return $this;
	}

	protected function _getContainer() {
		return $this->_container;
	}
	
	protected function _setContainer(ffPluginContainerAbstract $container) {
		$this->_container = $container;
		return $this;
	}
	
	
	protected abstract function _setDependencies();
	protected abstract function _registerAssets();
	protected abstract function _run();
	
	// added since 1.1.2
	protected function _ajax() {}
}