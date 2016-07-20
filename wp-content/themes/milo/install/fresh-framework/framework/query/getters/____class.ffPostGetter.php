<?php

class ffPostGetterxxxx extends ffBasicObject {
	const ARG_POSTS_PER_PAGE = 'posts_per_page';
	
	private $_postTypes = array();
	
	private $_categories = array();
	
	private $_customTaxonomies = array();
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	private $_currentArgs = array();
	
	
	public function __construct( ffWPLayer $WPLayer ) {
		$this->_setWPLayer($WPLayer);
	}
	
	
	public function addCategory( $categoryId ) {
		if( is_array( $categoryId ) ) {
			$this->_categories = array_merge( $this->_categories, $categoryId );
		} else {
			$this->_categories[] = $categoryId;
		}
		
		return $this;
	}
	
	public function getPosts() {
		$arguments = $this->_createArguments();
		$posts = $this->_getWPLayer()->get_posts( $arguments );
		$this->_reset();
		
		return $posts;
	}
	
	private function _reset() {
		$this->_postTypes = array();
		$this->_categories = array();
		$this->_customTaxonomies = array();
		$this->_currentArgs = array();
	}
	
	public function setArgument( $name, $value ) {
		$this->_currentArgs[ $name ] = $value;
		
		return $this;
	}
	
	private function _createArguments() {
		$args = $this->_currentArgs;
		if( !empty( $this->_categories ) ) {
			$args['category'] = implode(',',$this->_categories);
		} 
		
		if( !empty( $this->_customTaxonomies ) ) {
			$args['tax_query'] = $this->_customTaxonomies;
		}
		
		if( !empty( $this->_postTypes ) ) {
			$args['post_type'] = $this->_postTypes;
		}
		
		return $args;
	}
	
	public function addPostType( $postTypeName ) {
		$this->_postTypes[] = $postTypeName;
		return $this;
	}

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