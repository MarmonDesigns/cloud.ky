<?php

class ffAttachmentLayer extends ffBasicObject {
	
	public function __construct( ffWPLayer $WPLayer, ffAttachmentLayer_Factory $AttachmentLayer_Factory  ) {
		$this->_setWPLayer($WPLayer);
		$this->_setAttachmentLayerFactory($AttachmentLayer_Factory);
	}

	/**
	 * 
	 * @var ffAttachmentItemsGetter
	 */
	private $_attachmentGetter = null;

	/**
	 * @return ffAttachmentGetter
	 */
	public function getAttachmentGetter() {
		if( empty( $this->_attachmentGetter ) ){
			$this->_attachmentGetter = $this->_getAttachmentLayerFactory()->createAttachmentGetter();
		}
		return $this->_attachmentGetter;
	}

	/**
	 * 
	 * @var ffAttachmentItemsUpdater
	 */
	private $_attachmentUpdater = null;

	/**
	 * @return ffAttachmentUpdater
	 */
	public function getAttachmentUpdater() {
		if( empty( $this->_attachmentUpdater ) ){
			$this->_attachmentUpdater = $this->_getAttachmentLayerFactory()->createAttachmentUpdater();
		}
		return $this->_attachmentUpdater;
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
	 * @var ffAttachmentLayer_Factory
	 */
	private $_attachmentLayer_Factory = null;

	/**
	 * @return ffAttachmentLayer_Factory
	 */
	protected function _getAttachmentLayerFactory() {
		return $this->_attachmentLayer_Factory;
	}
	
	/**
	 * @param ffAttachmentLayer_Factory $AttachmentLayer_Factory
	 */
	protected function _setAttachmentLayerFactory(ffAttachmentLayer_Factory $AttachmentLayer_Factory) {
		$this->_attachmentLayer_Factory = $AttachmentLayer_Factory;
		return $this;
	}
	


}








