<?php

class ffTaxonomyGetter extends ffBasicObject {
	/*$args = array(
	 		'orderby'       => 'name',
			'order'         => 'ASC',
			'hide_empty'    => true,
			'exclude'       => array(),
			'exclude_tree'  => array(),
			'include'       => array(),
			'number'        => '',
			'fields'        => 'all',
			'slug'          => '',
			'parent'         => '',
			'hierarchical'  => true,
			'child_of'      => 0,
			'get'           => '',
			'name__like'    => '',
			'pad_counts'    => false,
			'offset'        => '',
			'search'        => '',
			'cache_domain'  => 'core'
	); */	
	
	const ARG_ORDER_BY = 'orderby';
	const ARG_ORDER = 'order';
	const ARG_HIDE_EMPTY = 'hide_empty';
	const ARG_EXCLUDE = 'exclude';
	const ARG_EXCLUDE_TREE = 'exclude_tree';
	const ARG_INCLUDE = 'include';
	const ARG_NUMBER = 'number';
	const ARG_FIELDS = 'fields';
	const ARG_SLUG = 'slug';
	const ARG_PARENT = 'parent';
	const ARG_HIERARCHICAL = 'hierarchical';
	const ARG_CHILD_OF = 'child_of';
	const ARG_GET = 'get';
	const ARG_NAME_LIKE = 'name__like';
	const ARG_PAD_COUNTS = 'pad_counts';
	const ARG_OFFSET = 'offset';
	const ARG_SEARCH = 'search';
	const ARG_CACHE_DOMAIN = 'cache_domain';
	
	private $_args = array();
	
	private $_taxonomyName = '';
 	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	public function __construct( ffWPLayer $WPLayer ) {
		$this->_setWPLayer($WPLayer);
	}
	
	public function setTaxonomy( $taxonomyName ) {
		$this->_taxonomyName = $taxonomyName;
		return $this;
	}
	
	public function getTerms() {
		if( empty($this->_taxonomyName) ) {
			throw new Exception('Trying to get Terms, but taxonomy is empty!');
		}
		$terms =$this->_getWPLayer()->get_terms( $this->_taxonomyName, $this->_args );
		
		if( $terms instanceof WP_Error ) {
			throw new Exception('Error in get_terms method -> most probably invalid taxonomy');
		}
		$this->resetArgs(); 
		return $terms;
	}
	
	public function setArg( $name, $value ) {
		$this->_args[ $name ] = $value;
		return $this;
	}
	
	public function resetArgs() {
		$this->_args = array();
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