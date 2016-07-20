<?php

class ffTaxLayer extends ffBasicObject {

	protected $_selectArgs = array();

	public function __construct( ffWPLayer $WPLayer, ffTaxLayer_Factory $TaxLayer_Factory  ) {
		$this->_setWPLayer($WPLayer);
		$this->_setTaxLayer_Factory($TaxLayer_Factory);
	}

	/**
	 * 
	 * @var ffPostItemsGetter
	 */
	private $_taxGetter = null;

	/**
	 * @return ffTaxGetter
	 */
	public function getTaxGetter() {
		if( empty( $this->_taxGetter ) ){
			$this->_taxGetter = $this->_getTaxLayer_Factory()->createTaxGetter();
		}
		return $this->_taxGetter;
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
	 * @var ffTaxLayer_Factory
	 */
	private $_TaxLayer_Factory = null;

	/**
	 * @return ffTaxLayer_Factory
	 */
	protected function _getTaxLayer_Factory() {
		return $this->_TaxLayer_Factory;
	}
	
	/**
	 * @param ffTaxLayer_Factory $TaxLayer_Factory
	 */
	protected function _setTaxLayer_Factory(ffTaxLayer_Factory $TaxLayer_Factory) {
		$this->_TaxLayer_Factory = $TaxLayer_Factory;
		return $this;
	}
	
}