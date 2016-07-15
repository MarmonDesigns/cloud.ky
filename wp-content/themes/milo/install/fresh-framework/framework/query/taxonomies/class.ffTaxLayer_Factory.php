<?php

class ffTaxLayer_Factory extends ffFactoryAbstract {

	public function __construct( ffClassLoader $classLoader, ffWPLayer $WPLayer) {
		parent::__construct($classLoader);
		$this->_setWPLayer( $WPLayer );
	}

	public function createTaxGetter(){
		$this->_getClassLoader()->loadClass( 'ffTaxGetter' );
		return new ffTaxGetter( $this->_getWPLayer() );
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

}






