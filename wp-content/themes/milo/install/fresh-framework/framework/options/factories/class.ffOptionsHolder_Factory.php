<?php

class ffOptionsHolder_Factory extends ffFactoryAbstract {
	
	/**
	 * 
	 * @var ffOneStructure_Factory
	 */
	private $_oneStructureFactory = null;
	
	public function __construct( ffClassLoader $classLoader, ffOneStructure_Factory $oneStructureFactory ) {
		$this->_setOnestructurefactory($oneStructureFactory);
		parent::__construct( $classLoader );
	}

    /**
     * @param $className
     * @return ffOptionsHolder
     * @throws Exception
     */
	public function createOptionsHolder( $className ) {

        $this->_getClassloader()->loadClass('ffIOptionsHolder');
		$this->_getClassloader()->loadClass('ffOptionsHolder');
        $this->_getClassloader()->loadClass('ffOptionsHolder_CachingFacade');
		$this->_getClassloader()->loadClass( $className );
        $this->_getClassloader()->loadClass('ffIOneDataNode');
        $this->_getClassloader()->loadClass('ffOneSection');
        $this->_getClassloader()->loadClass('ffOneOption');
        $this->_getClassloader()->loadClass('ffOneStructure');
        $this->_getClassloader()->loadClass('ffOneElement');


		$optionsHolder = new $className( $this->_getOnestructurefactory(), $this );
        $container = ffContainer();

        if( $container->getWPLayer()->get_ff_debug() ) {
            return $optionsHolder;
        }


        $classLoader = $container->getClassLoader();
        $fileSystem = $container->getFileSystem();
        $cache = $container->getDataStorageCache();
        $optionsHolderCachingFacade = new ffOptionsHolder_CachingFacade( $optionsHolder, $classLoader, $fileSystem, $cache );

		    return $optionsHolderCachingFacade;

	}

	/**
	 * @return ffOneStructure_Factory
	 */
	protected function _getOnestructurefactory() {
		return $this->_oneStructureFactory;
	}
	
	/**
	 * @param ffOneStructure_Factory $oneStructureFactory
	 */
	protected function _setOnestructurefactory(ffOneStructure_Factory $oneStructureFactory) {
		$this->_oneStructureFactory = $oneStructureFactory;
		return $this;
	}
	
}