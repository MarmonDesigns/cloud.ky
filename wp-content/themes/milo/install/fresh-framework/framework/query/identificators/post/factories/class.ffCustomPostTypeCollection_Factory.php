<?php

class ffCustomPostTypeCollection_Factory extends ffFactoryAbstract {
	/**
	 * 
	 * @var ffCustomPostTypeCollectionItem_Factory
	 */
	private $_collectionItemFactory = null;
	public function __construct( ffClassLoader $classLoader, ffCustomPostTypeCollectionItem_Factory $collectionItemFactory ) {
		parent::__construct($classLoader);
		$this->_setCollectionItemFactory($collectionItemFactory);
	}
	
	public function createCustomPostTypeCollection( $postTypesFromWp  ) {
		$this->_getClassloader()->loadClass('ffCustomPostTypeCollection');
		return new ffCustomPostTypeCollection($postTypesFromWp, $this->_getCollectionItemFactory());
	}

	/**
	 * @return ffCustomPostTypeCollectionItem_Factory
	 */
	protected function _getCollectionItemFactory() {
		return $this->_collectionItemFactory;
	}
	
	/**
	 * @param ffCustomPostTypeCollectionItem_Factory $collectionItemFactory
	 */
	protected function _setCollectionItemFactory(ffCustomPostTypeCollectionItem_Factory $collectionItemFactory) {
		$this->_collectionItemFactory = $collectionItemFactory;
		return $this;
	}
	
}