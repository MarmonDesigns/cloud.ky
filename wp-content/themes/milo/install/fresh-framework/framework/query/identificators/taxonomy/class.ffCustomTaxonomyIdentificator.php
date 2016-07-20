<?php
class ffCustomTaxonomyIdentificator extends ffBasicObject {
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffCustomTaxonomyCollection_Factory
	 */
	private $_customTaxonomyCollectionFactory = null;
	
	private $_taxonomyBlacklist = array();
	
	public function __construct( ffWPLayer $WPLayer, ffCustomTaxonomyCollection_Factory $customTaxonomyCollectionFactory ) {
		$this->_setWPLayer($WPLayer);
		$this->_setCustomTaxonomyCollectionFactory($customTaxonomyCollectionFactory);
		
		$this->addWordpressDefaultBlacklist();
	}

    public function getActiveTaxonomyCollectionForPostType( $postType ){
        $currentCollection = $this->getActiveTaxonomyCollection();

        $collectionToReturn = array();
        foreach( $currentCollection as $oneTaxonomy ) {
            if($oneTaxonomy->isAppliedToPostType( $postType ) ) {
                $collectionToReturn[] = $oneTaxonomy;
            }
        }

        return $collectionToReturn;

    }
	public function getActiveTaxonomyCollection() {
		$taxonomiesFromWp = $this->_getWPLayer()->get_taxonomies();
		$taxonomiesFromWpAfterBlacklist = $this->_filterBlacklistedTaxonomies( $taxonomiesFromWp );
		return $this->_getCustomTaxonomyCollectionFactory()->createTaxonomyCollection($taxonomiesFromWpAfterBlacklist);
	}
	
	public function addWordpressDefaultBlacklist() {
		$this->addBlacklistedTaxonomy('nav_menu');
		$this->addBlacklistedTaxonomy('link_category');
		$this->addBlacklistedTaxonomy('post_format');
	}
	
	public function resetBlacklist() {
		$this->_taxonomyBlacklist = array();
        return $this;
	}
	
	private function _filterBlacklistedTaxonomies( $taxonomies ) {
		if( empty($this->_taxonomyBlacklist) ) return $taxonomies;
		
		foreach( $this->_taxonomyBlacklist as $oneTaxonomy ) {
			if( isset( $taxonomies[ $oneTaxonomy ] ) ) {
				unset( $taxonomies[ $oneTaxonomy ]);
			}
		}
		return $taxonomies;
	}
	
	public function addBlacklistedTaxonomy( $taxonomyName ) {
		$this->_taxonomyBlacklist[] = $taxonomyName;
	}

	/**
	 * @return ffWPLayer
	 */
	private function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $_WPLayer
	 */
	private function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	/**
	 * @return ffCustomTaxonomyCollection_Factory
	 */
	protected function _getCustomTaxonomyCollectionFactory() {
		return $this->customTaxonomyCollectionFactory;
	}
	
	/**
	 * @param ffCustomTaxonomyCollection_Factory $customTaxonomyCollectionFactory
	 */
	protected function _setCustomTaxonomyCollectionFactory(ffCustomTaxonomyCollection_Factory $customTaxonomyCollectionFactory) {
		$this->customTaxonomyCollectionFactory = $customTaxonomyCollectionFactory;
		return $this;
	}
	
	
	//get_taxonomies
}