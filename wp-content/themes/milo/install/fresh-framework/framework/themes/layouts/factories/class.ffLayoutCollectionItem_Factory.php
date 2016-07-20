<?php

class ffLayoutCollectionItem_Factory extends ffFactoryAbstract {
    public function createLayoutCollectionItem() {
        $this->_getClassloader()->loadClass('ffLayoutCollectionItem');

        $layoutCollectionItem = new ffLayoutCollectionItem();

        return $layoutCollectionItem;
    }
}