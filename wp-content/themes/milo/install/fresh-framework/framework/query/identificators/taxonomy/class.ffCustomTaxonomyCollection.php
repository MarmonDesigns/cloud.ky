<?php
class ffCustomTaxonomyCollection extends ffBasicObject implements Iterator {
	
	private $_taxonomiesFromWp = null;
	
	/**
	 * 
	 * @var ffCustomTaxonomyCollectionItem_Factory
	 */
	private $_customTaxonomyCollectionItemFactory = null;
	
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	
	private $_hasNext = null;
	
	public function __construct( $taxonomiesFromWp, ffCustomTaxonomyCollectionItem_Factory $customTaxonomyCollectionItemFactory, ffWPLayer $WPLayer ) {
		$this->_setTaxonomiesFromWp($taxonomiesFromWp);
		$this->_setCustomTaxonomyCollectionItemFactory($customTaxonomyCollectionItemFactory);
		$this->_setWPLayer($WPLayer);
		$this->_hasNext = true;
	}
	
	
/******************************************************************************/
/* ITERATOR INTERFACE 
/******************************************************************************/
    /**
     * @return ffCustomTaxonomyCollectionItem
     */
	public function current() {
		$currentTaxonomyName = current( $this->_taxonomiesFromWp );
		$taxonomyOur = $this->_wpTaxonomyToOurTaxonomy( $currentTaxonomyName );
		
		return $taxonomyOur;
	}
	
	private function _wpTaxonomyToOurTaxonomy( $currentTaxonomyName ) {
		$taxonomyWp = $this->_getWPLayer()->get_taxonomy( $currentTaxonomyName );
		$taxonomyOur = $this->_getCustomTaxonomyCollectionItemFactory()->createCustomTaxonomyCollectionItem();

        if( isset( $taxonomyWp->hierarchical ) ) {
            $taxonomyOur->hierarchical = $taxonomyWp->hierarchical;
        }

		if( isset( $taxonomyWp->labels ) && isset( $taxonomyWp->labels->name) ) {
			$taxonomyOur->label = $taxonomyWp->labels->name;
		}

        if( isset( $taxonomyWp->object_type ) ) {
           $taxonomyOur->appliedToObjects = $taxonomyWp->object_type;
        }
		
		if( isset( $taxonomyWp->labels ) && isset( $taxonomyWp->labels->singular_name) ) {
			$taxonomyOur->labelSingular = $taxonomyWp->labels->singular_name;
		}
		
		$taxonomyOur->id = key( $this->_taxonomiesFromWp );
		
		return $taxonomyOur;
	}
	
	public function key() {
		return key( $this->_taxonomiesFromWp );
	}
	public function next() {
		$hasNext = next( $this->_taxonomiesFromWp );
		if( false == $hasNext ) {
			$this->_hasNext = false;
		}
	}
	public function rewind() {
		$this->_hasNext = true;
		return reset( $this->_taxonomiesFromWp );
	}
	public function valid() {
		return $this->_hasNext;
	}
	
	

	/**
	 * @return ffCustomTaxonomyCollectionItem_Factory
	 */
	protected function _getCustomTaxonomyCollectionItemFactory() {
		return $this->_customTaxonomyCollectionItemFactory;
	}
	
	/**
	 * @param ffCustomTaxonomyCollectionItem_Factory $customTaxonomyCollectionItemFactory
	 */
	protected function _setCustomTaxonomyCollectionItemFactory(ffCustomTaxonomyCollectionItem_Factory $customTaxonomyCollectionItemFactory) {
		$this->_customTaxonomyCollectionItemFactory = $customTaxonomyCollectionItemFactory;
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

	/**
	 * @return unknown_type
	 */
	protected function _getTaxonomiesFromWp() {
		return $this->_taxonomiesFromWp;
	}
	
	/**
	 * @param unknown_type $taxonomiesFromWp
	 */
	protected function _setTaxonomiesFromWp($taxonomiesFromWp) {
		$this->_taxonomiesFromWp = $taxonomiesFromWp;
		return $this;
	}
	


	
	
}