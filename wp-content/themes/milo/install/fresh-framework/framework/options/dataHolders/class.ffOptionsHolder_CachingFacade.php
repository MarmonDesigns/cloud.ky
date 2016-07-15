<?php

class ffOptionsHolder_CachingFacade extends ffOptionsHolder implements  ffIOptionsHolder {
    const OPTIONS_CACHING_NAMESPACE = 'cached_options';
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffIOptionsHolder
     */
    private $_optionsHolder = null;

    /**
     * @var ffClassLoader
     */
    private $_classLoader = null;

    /**
     * @var ffFileSystem
     */
    private $_fileSystem  = null;

    /**
     * @var ffDataStorage_Cache;
     */
    private $_cache = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffIOptionsHolder $optionsHolder, $classLoader, $fileSystem, $cache ) {
        $this->_setOptionsHolder( $optionsHolder );
        $this->_setClassLoader( $classLoader );
        $this->_setFileSystem( $fileSystem );
        $this->_setCache( $cache );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function getOptions() {
        $optionsFromCache = $this->_getOptionsFromCache();
        if( $optionsFromCache == null ) {
            return $this->_getOptionsHolder()->getOptions();
        } else {
            return $optionsFromCache;
        }
    }

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _getOptionsFromCache() {
        $namespace = ffConstCache::CACHED_OPTIONS_NAMESPACE;
        $fileHash = $this->_getOptionsHolderFileHash();

        if( $this->_getCache()->optionExists( $namespace, $fileHash ) ) {
            $optionsSerialized = $this->_getCache()->getOption( $namespace, $fileHash );
            $optionsUnserialized = unserialize( $optionsSerialized );

            return $optionsUnserialized;
        } else {
            $optionsUnserialized = $this->_getOptionsHolder()->getOptions();
            $optionsSerialized = serialize( $optionsUnserialized );

            $this->_getCache()->setOption( $namespace, $fileHash, $optionsSerialized );

            return $optionsUnserialized;
        }
    }

    private function _getOptionsHolderFileHash() {
        $currentClass = get_class( $this->_getOptionsHolder() );
        $currentClassPath = $this->_getClassLoader()->getClassPath( $currentClass );

        if( $currentClassPath == null ) {
            return null;
        }

        $fileHash = $this->_getFileSystem()->getFileHashBasedOnPathAndTimeChange( $currentClassPath );

        return $fileHash;
    }
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/

    /**
     * @return ffIOptionsHolder
     */
    private function _getOptionsHolder()
    {
        return $this->_optionsHolder;
    }

    /**
     * @param ffIOptionsHolder $optionsHolder
     */
    private function _setOptionsHolder($optionsHolder)
    {
        $this->_optionsHolder = $optionsHolder;
    }

    /**
     * @return ffDataStorage_Cache
     */
    private function _getCache()
    {
        return $this->_cache;
    }

    /**
     * @param ffDataStorage_Cache $cache
     */
    private function _setCache($cache)
    {
        $this->_cache = $cache;
    }

    /**
     * @return ffFileSystem
     */
    private function _getFileSystem()
    {
        return $this->_fileSystem;
    }

    /**
     * @param ffFileSystem $fileSystem
     */
    private function _setFileSystem($fileSystem)
    {
        $this->_fileSystem = $fileSystem;
    }

    /**
     * @return ffClassLoader
     */
    private function _getClassLoader()
    {
        return $this->_classLoader;
    }

    /**
     * @param ffClassLoader $classLoader
     */
    private function _setClassLoader($classLoader)
    {
        $this->_classLoader = $classLoader;
    }
}