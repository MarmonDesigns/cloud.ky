<?php

class ffScriptEnqueuer_Factory extends ffFactoryAbstract {
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffScript_Factory
	 */
	private $_scriptFactory = null;
	
	public function __construct( ffClassLoader $classLoader, ffWPLayer $WPLayer, ffScript_Factory $scriptFactory ) {
		
		$this->_setWplayer($WPLayer);
		$this->_setScriptfactory($scriptFactory);
		parent::__construct($classLoader);
	}
	
	public function createScriptEnqueuer() {
		$this->_getClassloader()->loadClass('ffScriptEnqueuer');
		$scriptEnqueuer = new ffScriptEnqueuer($this->_getWplayer(), $this->_getScriptfactory() );
		return $scriptEnqueuer;
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
	 * @return the ffScript_Factory
	 */
	protected function _getScriptfactory() {
		return $this->_scriptFactory;
	}
	
	/**
	 * @param ffScript_Factory $_scriptFactory
	 */
	protected function _setScriptfactory(ffScript_Factory $scriptFactory) {
		$this->_scriptFactory = $scriptFactory;
		return $this;
	}
	
}