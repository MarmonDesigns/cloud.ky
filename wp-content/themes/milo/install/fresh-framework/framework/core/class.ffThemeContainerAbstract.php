<?php

abstract class ffThemeContainerAbstract extends ffBasicObject {
	
	private $_themeDir = null;
	
	
	/**
	 * 
	 * @var ffContainer
	 */
	private $_frameworkContainer = null;
	
	public function __construct( ffContainer $container, $themeDir ) {
		$this->_setFrameworkContainer( $container );
		//$this->_setPluginDir( $themeDir );
		$this->_setThemeDir($themeDir);
		$this->_registerFiles();
	}
	
	protected function _registerThemeFile( $className, $relativePath ) {
		$absolutePath = $this->_themeDir . $relativePath;
		$this->getFrameworkContainer()->getClassLoader()->addClassTheme($className, $relativePath);
	}
	
	
	protected abstract function _registerFiles();
	
	/**
	 * @return ffContainer
	*/
	public function getFrameworkContainer() {
		return $this->_frameworkContainer;
	}
	
	protected function _setThemeDir( $themeDir ) {
		$this->_themeDir = $themeDir;
	}
	
	protected function _getThemeDir() {
		return $this->_themeDir;
	}
	
	public function getThemeDir() {
		return $this->_getThemeDir();
	}
	
	protected function _setFrameworkContainer( ffContainer $container ) {
		$this->_frameworkContainer = $container;
	}
	
}