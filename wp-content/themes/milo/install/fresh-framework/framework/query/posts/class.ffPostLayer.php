<?php

class ffPostLayer extends ffBasicObject {

	public function __construct( ffWPLayer $WPLayer, ffPostLayer_Factory $postLayer_Factory  ) {
		$this->_setWPLayer($WPLayer);
		$this->_setPostLayerFactory($postLayer_Factory);
	}

	/**
	 * 
	 * @var ffPostItemsGetter
	 */
	private $_postGetter = null;

	/**
	 * @return ffPostGetter
	 */
	public function getPostGetter() {
		if( empty( $this->_postGetter ) ){
			$this->_postGetter = $this->_getPostLayerFactory()->createPostGetter();
		}
		return $this->_postGetter;
	}


	/**
	 * 
	 * @var ffPostItemsUpdater
	 */
	private $_postUpdater = null;

	/**
	 * @return ffPostUpdater
	 */
	public function getPostUpdater() {
		if( empty( $this->_postUpdater ) ){
			$this->_postUpdater = $this->_getPostLayerFactory()->createPostUpdater();
		}
		return $this->_postUpdater;
	}


	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}


	/**
	 * 
	 * @var ffPostLayer_Factory
	 */
	private $_PostLayer_Factory = null;

	/**
	 * @return ffPostLayer_Factory
	 */
	protected function _getPostLayerFactory() {
		return $this->_PostLayer_Factory;
	}
	
	/**
	 * @param ffPostLayer_Factory $PostLayer_Factory
	 */
	protected function _setPostLayerFactory(ffPostLayer_Factory $PostLayer_Factory) {
		$this->_PostLayer_Factory = $PostLayer_Factory;
		return $this;
	}
	
}