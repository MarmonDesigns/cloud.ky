<?php

class ffLayoutsCollectionFactory extends ffFactoryAbstract {
    public function createLayoutsCollectionItemFactory() {
        $this->_getClassloader()->loadClass('ffLayoutCollectionItem_Factory');

        $layoutsCollectionItemFactory = new ffLayoutCollectionItem_Factory( $this->_getClassloader() );

        return $layoutsCollectionItemFactory;
    }

    public function createLayoutsCollection() {
        $this->_getClassloader()->loadClass('ffCollection');
        $this->_getClassloader()->loadClass('ffLayoutsCollection');

        $layoutsCollection = new ffLayoutsCollection( $this->createLayoutsCollectionItemFactory() );

        return $layoutsCollection;
    }
}