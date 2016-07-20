<?php

class ffPostCollection_Factory extends ffFactoryAbstract {

	public function __construct( ffClassLoader $classLoader, ffWPLayer $WPLayer) {
		parent::__construct($classLoader);
		$this->_setWPLayer( $WPLayer );
	}
	/**
	 * 
	 * @param unknown $_posts
	 * @return ffPostCollection
	 */
	
	public function createPostCollection( $_posts ) {
		$this->_getClassloader()->loadClass('ffPostCollection');
		$this->_getClassloader()->loadClass('ffPostCollectionItem');

		// TODO: ... = new ffPostCollection( $_posts, ffPostCollectionItem_Factory )

		$collection = new ffPostCollection();
		foreach ($_posts as $_onePost) {
			$collection->add( $this->createPostCollectionItem( $_onePost ) );
		}
		return $collection;
	}

	public function createPostCollectionItem( $res_arr ) {
		$this->_getClassloader()->loadClass('ffPostCollectionItem');
		return new ffPostCollectionItem( $res_arr, $this->_getWPLayer() );
	}

	public function createEmptyPostCollectionItem(){
		$this->_getClassloader()->loadClass('ffPostCollectionItem');
		return new ffPostCollectionItem( new WP_Post( array() ) );
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