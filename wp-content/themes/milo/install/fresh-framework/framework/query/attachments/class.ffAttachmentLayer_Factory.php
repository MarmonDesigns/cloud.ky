<?php

class ffAttachmentLayer_Factory extends ffFactoryAbstract {

	public function __construct( ffClassLoader $classLoader, ffWPLayer $WPLayer, ffAttachmentCollection_Factory $_attachmentCollection_Factory) {
		parent::__construct($classLoader);
		$this->_setWPLayer( $WPLayer );
		$this->_setAttachmentCollectionFactory( $_attachmentCollection_Factory );		
	}

	public function createAttachmentGetter(){
		$this->_getClassLoader()->loadClass( 'ffAttachmentGetter' );
		return new ffAttachmentGetter( $this->_getWPLayer(), $this->_getAttachmentCollectionFactory() );
	}

	public function createAttachmentUpdater(){
		$this->_getClassLoader()->loadClass( 'ffAttachmentUpdater' );
		return new ffAttachmentUpdater( $this->_getWPLayer(), $this->_getAttachmentCollectionFactory() );
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
	 * @var ffAttachmentCollection_Factory
	 */
	private $_attachmentCollection_Factory = null;

	/**
	 * @return ffAttachmentCollection_Factory
	 */
	protected function _getAttachmentCollectionFactory() {
		return $this->_attachmentCollection_Factory;
	}
	
	/**
	 * @param ffAttachmentCollection_Factory $AttachmentCollection_Factory
	 */
	protected function _setAttachmentCollectionFactory(ffAttachmentCollection_Factory $AttachmentCollection_Factory) {
		$this->_attachmentCollection_Factory = $AttachmentCollection_Factory;
		return $this;
	}

}


