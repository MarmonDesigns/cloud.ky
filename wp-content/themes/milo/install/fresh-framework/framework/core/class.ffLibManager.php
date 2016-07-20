<?php

class ffLibManager extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffContainer
	 */
	private $_container = null;
	
	/**
	 * 
	 * @var ffClassLoader;
	 */
	private $_classLoader = null;
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffClassLoader $classLoader, ffContainer $container ) {
		$this->_setContainer( $container );
		$this->_setClassloader($classLoader);
	}
	
	public function createTwitterFeeder() {
		$this->_getClassloader()->loadClass('ffLib_TwitterFeeder_OAuthFactory');
		$this->_getClassloader()->loadClass('ffLib_TwitterFeeder_OneTweet_Factory');
		$this->_getClassloader()->loadClass('ffLib_TwitterFeeder_TweetsCollection_Factory');
		$this->_getClassloader()->loadClass('ffLib_TwitterFeeder');
		
		$OAuthFactory = new ffLib_TwitterFeeder_OAuthFactory( $this->_getContainer()->getClassLoader() );
		$oneTweetFactory = new ffLib_TwitterFeeder_OneTweet_Factory( $this->_getContainer()->getClassLoader() );
		$tweetsCollectionFactory = new ffLib_TwitterFeeder_TweetsCollection_Factory( $this->_getContainer()->getClassLoader(), $oneTweetFactory );
		$feeder = new ffLib_TwitterFeeder( $this->_getContainer()->getDataStorageFactory()->createDataStorageWPOptions(), $OAuthFactory, $tweetsCollectionFactory);
		
		return $feeder;
	}
	
	public function createConditionalLogicEvaluator() {
		$this->_getClassloader()->loadClass('ffConditionalLogicEvaluator');
		$this->_getClassloader()->loadClass('ffConditionalLogicConstants');
		return new ffConditionalLogicEvaluator( $this->_getContainer()->getWPLayer() );
	}
	
	public function createUserColorLibrary() {
		$this->_getClassloader()->loadClass('ffUserColorLibrary');
		$this->_getClassloader()->loadClass('ffUserColorLibraryItemFactory');
		$this->_getClassloader()->loadClass('ffUserColorLibraryItem');
		$this->_getClassloader()->loadClass('ffColor');
		
		$factory = new ffUserColorLibraryItemFactory( $this->_getClassloader() );
		$library = new ffUserColorLibrary( 
				$factory,
				ffContainer::getInstance()->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade( ffUserColorLibrary::LIBRARY_NAMESPACE )
		);
		
		return $library;
	}

    public function createBreadcrumbs() {

        $this->_getClassloader()->loadClass('ffBreadcrumbsCollectionFactory');
        $this->_getClassloader()->loadClass('ffOneBreadcrumbFactory');

        $breadcrumbsFactory = new ffBreadcrumbsCollectionFactory( $this->_getClassloader() );
        $oneBreadcrumbFactory = new ffOneBreadcrumbFactory( $this->_getClassloader() );

        $this->_getClassloader()->loadClass('ffBreadcrumbs');

        $breadcrumbs = new ffBreadcrumbs( $breadcrumbsFactory->createBreadcrumbsCollection(), $oneBreadcrumbFactory, ffContainer()->getWPLayer(), ffContainer()->getFrontendQueryIdentificator(), ffContainer()->getCustomTaxonomyIdentificator() );

        return $breadcrumbs;
    }
	
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	/**
	 * @return ffContainer
	 */
	protected function _getContainer() {
		return $this->_container;
	}
	
	/**
	 * @param ffContainer $container
	 */
	protected function _setContainer( $container) {
		$this->_container = $container;
		return $this;
	}

	/**
	 * @return ffClassLoader;
	 */
	protected function _getClassloader() {
		return $this->_classLoader;
	}
	
	/**
	 * @param  $classLoader
	 */
	protected function _setClassloader( $classLoader) {
		$this->_classLoader = $classLoader;
		return $this;
	}
		
}