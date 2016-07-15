<?php

class ffAttachmentGetter extends ffBasicObject{

	protected $_selectArgs = array();

	public function __construct( ffWPLayer $WPLayer, ffAttachmentCollection_Factory $ffAttachmentCollection_Factory ) {
		$this->_setWPLayer($WPLayer);
		$this->_setAttachmentCollectionFactory( $ffAttachmentCollection_Factory );
	}

	////////////////////////////////////////////////////////////////////////
	//
	//   Post types / $args[tax_query]
	//
	////////////////////////////////////////////////////////////////////////

	// More than one

	public function getPostsByType(){
		$this->_selectArgs['post_type'] = 'attachment';

		$_attachments = $this->_getWPLayer()->get_posts( $this->_selectArgs );

		$this->_selectArgs = array();

		return $this->_getAttachmentCollectionFactory()->createAttachmentCollection( $_attachments );
	}

	public function getAll(){
		return $this->getPostsByType();		
	}

	// Single

	public function getAttachmentByID( int $ID ){
		$this->_selectArgs = array();
		return $this->_getWPLayer()->get_posts( $ID );
	}

	public function getSingle(){
		$ret = $this->getPostsByType( $post_type );
		if( defined('WP_DEBUG') and WP_DEBUG ){
			if( 1 < count($ret) ){
				echo 'Warning: '.__FILE__.' - line '.__LINE__.' returned more than 1 post type ['.$post_type.']<br />'."\n";
			}
		}

		if( 0 < count($ret) ){
			return $this->_getPostCollectionFactory()->createPostCollectionItem( $ret[0] );
		}else{
			return FALSE;
		}
	}

	////////////////////////////////////////////////////////////////////////
	//
	//   Post parent filter
	//
	////////////////////////////////////////////////////////////////////////

	public function filterByPostParent( $post_ID ){

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












