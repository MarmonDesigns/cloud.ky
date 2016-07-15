<?php

class ffTaxGetter extends ffBasicObject{

	protected $_selectArgs = array( 'hide_empty' => 0 );
	protected $_taxonomy   = 'category';

	public function __construct( ffWPLayer $WPLayer  ) {
		$this->_setWPLayer($WPLayer);
	}

	public function getList(){
		return $this->_getWPLayer()->get_terms( $this->_taxonomy, $this->_selectArgs );
	}
	

	public function filterByTaxonomy( $taxonomy ){
		$this->_taxonomy = $taxonomy;
		return $this;
	}

    public function getTermsForPost( $postId, $taxonomy ) {
        return $this->_getWPLayer()->wp_get_post_terms($postId, $taxonomy);
    }

	////////////////////////////////////////////////////////////////////////
	//
	//   ffWPLayer
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
		return $this;
	}
}