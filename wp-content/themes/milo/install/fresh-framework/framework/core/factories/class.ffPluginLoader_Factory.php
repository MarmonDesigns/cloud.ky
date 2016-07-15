<?php

class ffPluginLoader_Factory extends ffFactoryAbstract {
	/**
	 * 
	 * @var ffWPLayer
	 */ 
	private $_WPLayer = null;

	/**
	 * 
	 * @var ffFileManager
	 */
	private $_fileManager = null;
	
	
	/**
	 * 
	 * @var ffContainer
	 */
	private $_container = null;
	

	public function __construct( ffClassLoader $classLoader, ffWPLayer $WPLayer, ffFileManager $fileManager, ffContainer $container ) {
		$this->_setWplayer( $WPLayer );
		$this->_setFilemanager( $fileManager );
		$this->_setContainer($container);
		parent::__construct($classLoader);
	}
	
	
	public function createPluginLoader() {
		$this->_getClassloader()->loadClass('ffPluginLoader');
		return new ffPluginLoader( $this->_getWplayer(), $this->_getFilemanager(), $this->_getContainer() );
	}
	
	/**
	 * @return the ffWPLayer
	 */
	protected function _getWplayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $_WPLayer
	 */
	protected function _setWplayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
	/**
	 * @return the ffFileManager
	 */
	protected function _getFilemanager() {
		return $this->_fileManager;
	}
	
	/**
	 * @param ffFileManager $_fileManager
	 */
	protected function _setFilemanager(ffFileManager $fileManager) {
		$this->_fileManager = $fileManager;
		return $this;
	}

	/**
	 * @return the ffContainer
	 */
	protected function _getContainer() {
		return $this->_container;
	}
	
	/**
	 * @param ffContainer $_container
	 */
	protected function _setContainer(ffContainer $container) {
		$this->_container = $container;
		return $this;
	}
	
	
}