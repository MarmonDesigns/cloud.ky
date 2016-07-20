<?php

class ffPostUpdater extends ffBasicObject{

	public function __construct( ffWPLayer $WPLayer, ffPostCollection_Factory $ffPostCollection_Factory ) {
		$this->_setWPLayer($WPLayer);
		$this->_setPostCollectionFactory( $ffPostCollection_Factory );
	}

	public function createEmptyPostCollectionItem(){
		return $this->_getPostCollectionFactory()->createEmptyPostCollectionItem();
	}
	
	public function insertPost( $data ){
		return $this->_getWPLayer()->wp_insert_post( $data, TRUE );
	}
	
	public function updatePost( $data ){
		return $this->_getWPLayer()->wp_update_post( $data, TRUE );
	}

	public function deletePost( $post_ID ){
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
	 * @var ffPostCollection_Factory
	 */
	private $_PostCollection_Factory = null;

	/**
	 * @return ffPostCollection_Factory
	 */
	protected function _getPostCollectionFactory() {
		return $this->_PostCollection_Factory;
	}
	
	/**
	 * @param ffPostCollection_Factory $PostCollection_Factory
	 */
	protected function _setPostCollectionFactory(ffPostCollection_Factory $PostCollection_Factory) {
		$this->_PostCollection_Factory = $PostCollection_Factory;
		return $this;
	}


}















