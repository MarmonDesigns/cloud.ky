<?php

class ffLayoutsNamespaceFactory extends ffFactoryAbstract {

    private $_layoutManager = null;

    public function getOnePageRevisionManager () {
        $this->_getClassloader()->loadClass('ffOnePageRevisionManager');

        $revisionManager = new ffOnePageRevisionManager();

        return $revisionManager;
    }

    public function getLayoutsEmojiManager() {
        $this->_getClassloader()->loadClass('ffLayoutsEmojiManager');
        $emojiManager = new ffLayoutsEmojiManager( ffContainer()->getWPLayer(), ffContainer()->getScriptEnqueuer() );

        return $emojiManager;
    }

    public function getThemeLayoutManager() {
        if( $this->_layoutManager == null ) {
            $this->_getClassloader()->loadClass('ffThemeLayoutManager');
            $this->_getClassloader()->loadClass('ffLayoutPostType');





            $fwc = ffContainer();



            $lpt = new ffLayoutPostType(
                $fwc->getMetaBoxes()->getMetaBoxManager(),
                $fwc->getPostTypeRegistratorManager(),
                $this->getLayoutsDataManager(),
                $fwc->getpostAdminColumnManager(),
                $fwc->getWPLayer(),
                $fwc->getScriptEnqueuer(),
                $fwc->getRequest()
            );



            $layoutManager = new ffThemeLayoutManager(
                $lpt
            );

            $this->_layoutManager = $layoutManager;
        }
        return $this->_layoutManager;
    }

    private $_layoutPrinter = null;

    public function getLayoutPrinter() {
        if( $this->_layoutPrinter == null ) {
            $this->_getClassloader()->loadClass('ffLayoutPrinter');

            $this->_layoutPrinter = new ffLayoutPrinter(
                $this->getLayoutsDataManager(),
                ffContainer()->getLibManager()->createConditionalLogicEvaluator(),
                ffContainer()->getOptionsFactory()
            );
        }
        return $this->_layoutPrinter;
    }

    public function getLayoutsCollection() {
        $this->_getClassloader()->loadClass('ffCollection');
        $this->_getClassloader()->loadClass('ffLayoutCollectionItem_Factory');

        $this->_getClassloader()->loadClass('ffLayoutsCollection');



        $lci = new ffLayoutCollectionItem_Factory( $this->_getClassloader() );

        $layoutsCollection = new ffLayoutsCollection( $lci );

        return $layoutsCollection;
    }

    public function getLayoutsCollectionFactory() {
        $this->_getClassloader()->loadClass('ffCollection');
        $this->_getClassloader()->loadClass('ffLayoutCollectionItem');
        ffContainer()->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade();
        ffContainer()->getDataStorageFactory()->createDataStorageWPPostMetas();
        $this->_getClassloader()->loadClass('ffDataStorage_WPPostMetas');

        $this->_getClassloader()->loadClass('ffLayoutCollectionItem_Factory');
        $this->_getClassloader()->loadClass('ffLayoutsCollection');
        $this->_getClassloader()->loadClass('ffLayoutsCollectionFactory');

        $lcf = new ffLayoutsCollectionFactory( $this->_getClassloader() );

        return $lcf;
    }

    private $_ldm = null;

    public function getLayoutsDataManager() {
        if( $this->_ldm == null ) {
            $this->_getClassloader()->loadClass('ffLayoutsDataManager');
            if( defined('ffThemeContainer::THEME_NAME_LOW') ) {
                $themeName = ffThemeContainer::THEME_NAME_LOW;
            } else {
                $themeName = 'universal-layout';
            }
            $dataStorage = ffContainer()->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade();

            $this->_ldm = new ffLayoutsDataManager( $this->getLayoutsCollectionFactory(), $themeName, $dataStorage, ffContainer()->getDataStorageFactory() );
        }
        return $this->_ldm;
    }
}