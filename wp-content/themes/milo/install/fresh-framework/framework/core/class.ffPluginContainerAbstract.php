<?php

abstract class ffPluginContainerAbstract extends ffBasicObject {
	protected $_pluginDir = null;	
	
	protected $_pluginUrl = null;
	/**
	 * 
	 * @var ffContainer
	 */
	private $frameworkContainer = null;
	
	public function __construct( ffContainer $container, $pluginDir ) {
		$this->_setFrameworkContainer( $container );
		$this->_setPluginDir( $pluginDir );
		
		
		$wpLayer = $container->getWPLayer();
		$pluginUrl = $wpLayer->plugins_url() . '/' . $wpLayer->plugin_basename( $pluginDir );
		
		$this->_setPluginUrl( $pluginUrl );
		
		$this->_registerFiles();
	}
	
	protected abstract function _registerFiles();

	/**
	 * @return ffContainer
	 */
	public function getFrameworkContainer() {
		return $this->frameworkContainer;
	}
	
	/**
	 * @param ffContainer $frameworkContainer
	 */
	protected function _setFrameworkContainer(ffContainer $frameworkContainer) {
		$this->frameworkContainer = $frameworkContainer;
		return $this;
	}

	public function getPluginDir() {
		return $this->_getPluginDir();
	}
	
	/**
	 * @return unknown_type
	 */
	protected function _getPluginDir() {
		return $this->_pluginDir;
	}
	
	/**
	 * @param unknown_type $pluginDir
	 */
	protected function _setPluginDir($pluginDir) {
		$this->_pluginDir = $pluginDir;
		return $this;
	}
	
	/**
	 * 
	 * @return ffClassLoader
	 */
	protected function _getClassLoader() {
		return $this->getFrameworkContainer()->getClassLoader();
	}

	/**
	 * @return unknown_type
	 */
	protected function _getPluginUrl() {
		return $this->_pluginUrl;
	}
	
	/**
	 * @param unknown_type $_pluginUrl
	 */
	protected function _setPluginUrl($_pluginUrl) {
		$this->_pluginUrl = $_pluginUrl;
		return $this;
	}
	
	public function getPluginUrl() {
		return $this->_getPluginUrl(); 
	}
	
	
}