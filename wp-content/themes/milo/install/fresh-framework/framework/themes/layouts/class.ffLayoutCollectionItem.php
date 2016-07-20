<?php

class ffLayoutCollectionItem extends ffBasicObject {
    private $_id = null;

    private $_data = null;
    private $_placement = null;
    private $_conditional = null;

    private $_active = true;

    private $_trashed = false;

    /**
     * @var ffDataStorage_WPPostMetas
     */
    private $_dataStoragePostMeta = null;

    private $_changedData = false;

    private $_changedPlacement = false;

    private $_changedConditional = false;

    private $_dataHasBeenGathered = false;

    public function __construct() {
//        $this->_dataStoragePostMeta = ffContainer()->getDataStorageFactory()->createDataStorageWPPostMetas();
    }

    public function setDataStoragePostMeta( $dataStorage ) {
        $this->_dataStoragePostMeta = $dataStorage;
    }

    public function unsetDataStoragePostMeta() {
        $this->_dataStoragePostMeta = null;
//        unset( $this->_dataStoragePostMeta );
    }

    public function getId() {
        return $this->_id;
    }

    public function getActive() {
        $placement = $this->getPlacement();
        if( isset( $placement['placement'] ) && isset( $placement['placement']['active'] ) ) {
            return $placement['placement']['active'];
        }

        return false;
    }

    public function setActive( $active ) {
        $placement = $this->getPlacement();

        if( isset( $placement['placement'] ) && isset( $placement['placement']['active'] ) ) {
            $placement['placement']['active'] = $active;
        }

        $this->setPlacement( $placement );
    }

    public function getTrashed() {
        return $this->_trashed;
    }

    public function setTrashed( $trashed ) {
        $this->_trashed = $trashed;
    }

    public function getData() {
        if( $this->_dataHasBeenGathered == false ) {
            $this->_data = $this->_dataStoragePostMeta->getOptionCoded( $this->getId(), 'onepage' );
            $this->_dataHasBeenGathered = true;
        }

        return $this->_data;
    }

    public function setId( $id ) {
        $this->_id = $id;
    }

    public function getPlacement() {
        return $this->_placement;
    }

    public function getConditional() {
        return $this->_conditional;
    }

    public function setData( $data ) {
        $this->_changedData = true;
        $this->_dataHasBeenGathered = true;
        $this->_data = $data;
    }

    public function setPlacement( $placement ) {
        $this->_changedPlacement = true;
        $this->_placement = $placement;

    }

    public function setConditional( $conditional ) {
        $this->_changedConditional = true;
        $this->_conditional = $conditional;
    }


    public function changedData() {
        return $this->_changedData;
    }

    public function changedPlacement() {
        return $this->_changedPlacement;
    }

    public function changedConditional() {
        return $this->_changedConditional;
    }
}