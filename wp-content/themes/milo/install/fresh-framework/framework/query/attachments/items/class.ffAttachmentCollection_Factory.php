<?php

class ffAttachmentCollection_Factory extends ffFactoryAbstract {

	public function __construct( ffClassLoader $classLoader, ffWPLayer $WPLayer) {
		parent::__construct($classLoader);
		$this->_setWPLayer( $WPLayer );
	}
	
	public function createAttachmentCollection( $_posts ) {
		$this->_getClassloader()->loadClass('ffAttachmentCollection');
		$this->_getClassloader()->loadClass('ffAttachmentCollectionItem');

		// TODO: ... = new ffAttachmentCollection( $_posts, ffAttachmentCollectionItem_Factory )

		$collection = new ffAttachmentCollection();
		foreach ($_posts as $_onePost) {
			$collection->add( $this->createAttachmentCollectionItem( $_onePost ) );
		}
		return $collection;
	}	

	public function createAttachmentCollectionItem( $res_arr ) {
		$this->_getClassloader()->loadClass('ffAttachmentCollectionItem');
		return new ffAttachmentCollectionItem( $res_arr, $this->_getWPLayer() );
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