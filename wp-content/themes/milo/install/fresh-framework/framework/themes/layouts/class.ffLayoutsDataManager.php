<?php

class ffLayoutsDataManager extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    private $_themeName = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    /**
     * @var ffLayoutsCollectionFactory
     */
    private $_layoutsCollectionFactory = null;

    /**
     * @var ffDataStorage_OptionsPostType_NamespaceFacade
     */
    private $_dataStorageOptionsPostType = null;

    /**
     * @var ffLayoutsCollection
     */
    private $_layoutsCollection = null;

    /**
     * @var ffDataStorage_Factory
     */
    private $_dataStorageFactory = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( $layoutsCollectionFactory, $themeName, ffDataStorage_OptionsPostType_NamespaceFacade $dataStorage, $dataStorageFactory ) {
        $dataStorage->setNamespace( $themeName . '-layouts');

        $this->_setLayoutsCollectionFactory( $layoutsCollectionFactory );
        $this->_setThemeName( $themeName );
        $this->_setDataStorageOptionsPostType( $dataStorage );
        $this->_setDataStorageFactory( $dataStorageFactory );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function doesLayoutCollectionExists() {
        $collection = $this->_getDataStorageOptionsPostType()->getOption('layouts-collection');
        if( $collection == null ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return ffLayoutsCollection
     */
    public function getLayoutCollection() {
        /** @var ffLayoutsCollection $layoutsCollection */
        if( $this->_getLayoutsCollection() == null || $this->_getLayoutsCollection()->getLayoutCollectionItemFactory() == null ) {

            $layoutsCollection = $this->_getDataStorageOptionsPostType()->getOptionCoded('layouts-collection');


            if( $layoutsCollection == null ) {
                $layoutsCollection = $this->_getLayoutsCollectionFactory()->createLayoutsCollection();

            } else {
                foreach( $layoutsCollection as $oneItem ) {
                    $oneItem->setDataStoragePostMeta( $this->_getDataStorageFactory()->createDataStorageWPPostMetas() );
                }

                $layoutsCollectionItemFactory = $this->_getLayoutsCollectionFactory()->createLayoutsCollectionItemFactory();
                $layoutsCollection->setLayoutCollectionItemFactory( $layoutsCollectionItemFactory );

            }

            $this->_setLayoutsCollection( $layoutsCollection );
        }

        $this->_getLayoutsCollection()->setDataStoragePostMeta( $this->_dataStorageFactory->createDataStorageWPPostMetas() );

        return $this->_getLayoutsCollection();
    }

    public function saveLayoutCollection() {
        $dataStoragePostMeta = $this->_getDataStorageFactory()->createDataStorageWPPostMetas();
        /** @var ffLayoutCollectionItem $oneItem */
        foreach( $this->_getLayoutsCollection() as $oneItem ) {
            $oneItem->unsetDataStoragePostMeta();

            if( $oneItem->changedData() ) {
                $dataStoragePostMeta->setOptionCoded( $oneItem->getId(), 'onepage', $oneItem->getData() );
            }
        }



        $this->_getLayoutsCollection()->unsetLayoutCollectionItemFactory();
        $this->_getLayoutsCollection()->unsetDataStoragePostMeta();

        $lc = $this->_getLayoutsCollection();

        $this->_getDataStorageOptionsPostType()->setOptionCoded('layouts-collection', $lc );

    }


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return ffLayoutsCollectionFactory
     */
    private function _getLayoutsCollectionFactory()
    {
        return $this->_layoutsCollectionFactory;
    }

    /**
     * @param ffLayoutsCollectionFactory $layoutsCollectionFactory
     */
    private function _setLayoutsCollectionFactory($layoutsCollectionFactory)
    {
        $this->_layoutsCollectionFactory = $layoutsCollectionFactory;
    }

    /**
     * @return null
     */
    private function _getThemeName()
    {
        return $this->_themeName;
    }

    /**
     * @param null $themeName
     */
    private function _setThemeName($themeName)
    {
        $this->_themeName = $themeName;
    }

    /**
     * @return ffDataStorage_OptionsPostType_NamespaceFacade
     */
    private function _getDataStorageOptionsPostType()
    {
        return $this->_dataStorageOptionsPostType;
    }

    /**
     * @param ffDataStorage_OptionsPostType_NamespaceFacade $dataStorageOptionsPostType
     */
    private function _setDataStorageOptionsPostType($dataStorageOptionsPostType)
    {
        $this->_dataStorageOptionsPostType = $dataStorageOptionsPostType;
    }

    /**
     * @return ffLayoutsCollection
     */
    private function _getLayoutsCollection()
    {
        return $this->_layoutsCollection;
    }

    /**
     * @param ffLayoutsCollection $layoutsCollection
     */
    private function _setLayoutsCollection($layoutsCollection)
    {
        $this->_layoutsCollection = $layoutsCollection;
    }

    /**
     * @return ffDataStorage_Factory
     */
    private function _getDataStorageFactory()
    {
        return $this->_dataStorageFactory;
    }

    /**
     * @param ffDataStorage_Factory $dataStorageFactory
     */
    private function _setDataStorageFactory($dataStorageFactory)
    {
        $this->_dataStorageFactory = $dataStorageFactory;
    }


}