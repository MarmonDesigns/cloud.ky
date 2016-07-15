<?php

class ffCustomTaxonomyCollection_Factory extends ffFactoryAbstract {
	
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
	
	public function __construct( ffClassLoader $classLoader, ffCustomTaxonomyCollectionItem_Factory $customTaxonomyCollectionItemFactory, ffWPLayer $WPLayer ) {
		parent::__construct($classLoader);
		$this->_setCustomTaxonomyCollectionItemFactory($customTaxonomyCollectionItemFactory);
		$this->_setWPLayer($WPLayer);
	}
	
	public function createTaxonomyCollection( $taxonomiesFromWP ) {
		$this->_getClassloader()->loadClass('ffCollection');
        $this->_getClassloader()->loadClass('ffCustomTaxonomyCollection');

		$taxonomyCollection = new ffCustomTaxonomyCollection($taxonomiesFromWP, $this->_getCustomTaxonomyCollectionItemFactory(), $this->_getWPLayer() );
		
		return $taxonomyCollection;
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
	
	
	
	
}