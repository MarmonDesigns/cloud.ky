<?php

class ffModalWindowBasicObject extends ffBasicObject {
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer=  null;
	
	/**
	 * 
	 * @var ffScriptEnqueuer
	 */
	private $_scriptEnqueuer = null;
	
	/**
	 * 
	 * @var ffStyleEnqueuer
	 */
	private $_styleEnqueuer = null;
	
	public function __construct( ffWPLayer $WPLayer, ffScriptEnqueuer $scriptEnqueuer, ffStyleEnqueuer $styleEnqueuer ) {
		$this->_setWPLayer($WPLayer);
		$this->_setScriptEnqueuer($scriptEnqueuer);
		$this->_setStyleEnqueuer($styleEnqueuer);
		
		$this->_initialize();
	}
	
	protected function _initialize() {
		
	}
	
	
	
	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $_WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
	/**
	 * @return ffScriptEnqueuer
	 */
	protected function _getScriptEnqueuer() {
		return $this->_scriptEnqueuer;
	}
	
	/**
	 * @param ffScriptEnqueuer $_scriptEnqueuer
	 */
	protected function _setScriptEnqueuer(ffScriptEnqueuer $scriptEnqueuer) {
		$this->_scriptEnqueuer = $scriptEnqueuer;
		return $this;
	}
	
	/**
	 * @return ffStyleEnqueuer
	 */
	protected function _getStyleEnqueuer() {
		return $this->_styleEnqueuer;
	}
	
	/**
	 * @param ffStyleEnqueuer $_styleEnqueuer
	 */
	protected function _setStyleEnqueuer(ffStyleEnqueuer $styleEnqueuer) {
		$this->_styleEnqueuer = $styleEnqueuer;
		return $this;
	}
}