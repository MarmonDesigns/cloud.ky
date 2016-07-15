<?php

class ffLayoutsCollection extends  ffCollection {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    private $_layoutCollectionItemFactory = null;

    /**
     * @var ffDataStorage_WPPostMetas
     */
    private $_dataStoragePostMeta = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffLayoutCollectionItem_Factory $layoutCollectionItem_Factory ) {
        parent::__construct();

        $this->_setLayoutCollectionItemFactory(  $layoutCollectionItem_Factory );
    }

    public function getLayoutById( $id ) {
        $layout = null;
        foreach( $this as $key => $item ) {
            if( $item->getId() == $id ) {
                $layout = $item;
            }
        }


        if( $layout == null ) {
            $layout = $this->_getLayoutCollectionItemFactory()->createLayoutCollectionItem();
            $layout->setId( $id );
            $this->addItem( $layout );
        }


        $layout->setDataStoragePostMeta( $this->_getDataStoragePostMeta() );

        return $layout;
    }

    public function deleteLayoutById__hook( $item  ){
        if( $item->getId() == $this->_temporaryIdHolder ) {
            return true;
        } else {
            return false;
        }
    }

    private $_temporaryIdHolder = null;

    public function deleteLayoutById( $id ) {
        $layout = null;
        foreach( $this as $key => $item ) {
            if( $item->getId() == $id ) {
                $layout = $item;
            }
        }

        $this->_getDataStoragePostMeta()->deleteOption( $id, 'onepage');

        $this->_temporaryIdHolder = $id;
        $this->remove( array($this, 'deleteLayoutById__hook') );
        $this->_temporaryIdHolder = null;

    }

    public function setLayoutCollectionItemFactory( $layoutCollectionItem_Factory ) {
        $this->_setLayoutCollectionItemFactory( $layoutCollectionItem_Factory );
    }

    public function unsetLayoutCollectionItemFactory() {
        $this->_layoutCollectionItemFactory = null;
//        unset( $this->_layoutCollectionItemFactory );
    }


/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
    public function setDataStoragePostMeta( $dataStoragePostMeta ) {

        $this->_dataStoragePostMeta = $dataStoragePostMeta;
    }

    public function unsetDataStoragePostMeta() {
        $this->_dataStoragePostMeta = null;
//        unset( $this->_dataStoragePostMeta );
    }


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return ffDataStorage_WPPostMetas
     */
    private function _getDataStoragePostMeta()
    {
        return $this->_dataStoragePostMeta;
    }
    /**
     * @return ffLayoutCollectionItem_Factory
     */
    private function _getLayoutCollectionItemFactory()
    {
        return $this->_layoutCollectionItemFactory;
    }

    /**
     * @param null $layoutCollectionItemFactory
     */
    private function _setLayoutCollectionItemFactory($layoutCollectionItemFactory)
    {
        $this->_layoutCollectionItemFactory = $layoutCollectionItemFactory;
    }

    public function getLayoutCollectionItemFactory() {
        return $this->_layoutCollectionItemFactory;
    }
}