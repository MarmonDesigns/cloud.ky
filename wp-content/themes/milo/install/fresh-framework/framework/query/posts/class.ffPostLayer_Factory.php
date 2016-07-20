<?php

class ffPostLayer_Factory extends ffFactoryAbstract {

	public function __construct( ffClassLoader $classLoader, ffWPLayer $WPLayer, ffPostCollection_Factory $ffPostCollection_Factory) {
		parent::__construct($classLoader);
		$this->_setWPLayer( $WPLayer );
		$this->_setPostCollectionFactory( $ffPostCollection_Factory );		
	}

	public function createPostGetter(){
		$this->_getClassLoader()->loadClass( 'ffPostGetter' );
		return new ffPostGetter( $this->_getWPLayer(), $this->_getPostCollectionFactory() );
	}

	public function createPostUpdater(){
		$this->_getClassLoader()->loadClass( 'ffPostUpdater' );
		return new ffPostUpdater( $this->_getWPLayer(), $this->_getPostCollectionFactory() );
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
	 * @var ffPostCollection_Factory
	 */
	private $_postCollection_Factory = null;

	/**
	 * @return ffPostCollection_Factory
	 */
	protected function _getPostCollectionFactory() {
		return $this->_postCollection_Factory;
	}
	
	/**
	 * @param ffPostCollection_Factory $PostCollection_Factory
	 */
	protected function _setPostCollectionFactory(ffPostCollection_Factory $PostCollection_Factory) {
		$this->_postCollection_Factory = $PostCollection_Factory;
		return $this;
	}

}






