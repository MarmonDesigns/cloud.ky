<?php

class ffAttachmentUpdater extends ffBasicObject{
	public function __construct( ffWPLayer $WPLayer, ffAttachmentCollection_Factory $ffAttachmentCollection_Factory ) {
		$this->_setWPLayer($WPLayer);
		$this->_setAttachmentCollectionFactory( $ffAttachmentCollection_Factory );
	}

	public function createEmptyAttachmentCollectionItem(){
		return $this->_getAttachmentCollectionFactory()->createEmptyAttachmentCollectionItem();
	}

	public function attachFileToPost($file, $post_id, $desc = null) {
		if ( empty($file) ) {
			return null;
		}

		// Set variables for storage
		// fix file filename for query strings
		$file_array['name'] = basename($file);
		$file_array['tmp_name'] = $file;

		// do the validation and storage stuff
		$id = media_handle_sideload( $file_array, $post_id, $desc );

		// If error storing permanently, show
		if ( is_wp_error($id) ) {
			echo '<hr /><hr /><hr /><hr /><pre>';
			var_dump($id);
			exit;
		}

		return $id;
	}	

	public function deleteAttachment( $post_ID ){
		$this->_getWPLayer()->wp_delete_post( $post_ID, true );
	}


	////////////////////////////////////////////////////////////////////////
	//
	//   getters / setters
	//
	////////////////////////////////////////////////////////////////////////


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
	}


	/**
	 * 
	 * @var ffAttachmentCollection_Factory
	 */
	private $_AttachmentCollection_Factory = null;

	/**
	 * @return ffAttachmentCollection_Factory
	 */
	protected function _getAttachmentCollectionFactory() {
		return $this->_AttachmentCollection_Factory;
	}
	
	/**
	 * @param ffAttachmentCollection_Factory $AttachmentCollection_Factory
	 */
	protected function _setAttachmentCollectionFactory(ffAttachmentCollection_Factory $AttachmentCollection_Factory) {
		$this->_AttachmentCollection_Factory = $AttachmentCollection_Factory;
		return $this;
	}


}











