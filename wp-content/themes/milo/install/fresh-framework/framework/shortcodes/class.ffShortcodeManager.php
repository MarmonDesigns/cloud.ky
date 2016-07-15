<?php

class ffShortcodeManager extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    /**
     * @var ffShortcodeFactory
     */
    private $_shortcodeFactory = null;

    /**
     * @var ffShortcodeContentParser
     */
    private $_shortcodeContentParser = null;

    /**
     * @var ffCollection
     */
    private $_shortcodeCollection = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    /**
     * Array of recursive shortcodes, which have to be fixed for recursiveness
     * @var array
     */
    private $_recursiveShortcodes = array();

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffWPLayer $WPLayer, ffShortcodeFactory $shortcodeFactory, ffShortcodeContentParser $shortcodeContentParser, ffCollection $collection ) {
        $this->_setWPLayer( $WPLayer );
        $this->_setShortcodeFactory( $shortcodeFactory );
        $this->_setShortcodeContentParser( $shortcodeContentParser );
        $this->_setShortcodeCollection( $collection );

        $this->_getWPLayer()->add_filter('the_content', array( $this, 'actTheContent' ), 1);
        $this->_getWPLayer()->add_filter('the_content', array( $this, 'actHookOurShortcodes' ), 1);
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function actTheContent__hook( $item, $id ){
        if( $item->getIsRecursive() ) {
            return true;
        } else {
            return false;
        }
    }

    public function actTheContent( $content ) {

        $shortcodesCollection = $this->_getShortcodeCollection();
        $contentParser = $this->_getShortcodeContentParser();

        $shortcodesCollection->filter( array($this, 'actTheContent__hook') );

        $contentParser->setRecursiveShortcodesCollection( $shortcodesCollection );
        $contentParser->setContent( $content );

        $content = $contentParser->filterShortcodes();

        $shortcodesCollection->removeFilter();

        return $content;
    }

    public function actHookOurShortcodes( $content ) {
        foreach( $this->_getShortcodeCollection() as $oneItem ) {
            /** @var $oneItem ffShortcodeObjectBasic */

            foreach( $oneItem->getShortcodeNames() as $oneName ) {

                add_shortcode( $oneName, array( $oneItem, 'printShortcode') );
            }
        }

        return $content;
    }


    public function addShortcodeClassName( $className ) {
        $newShortcode = $this->_getShortcodeFactory()->createShortcode( $className );
        $this->_getShortcodeCollection()->addItem( $newShortcode );
    }

    public function  kok($content ) {
        add_shortcode('ffrow', array( $this, 'row'));

        return $content;

    }

    public function row() {
        return 'pica';
    }


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _addRecursiveShortcode( $recursiveShortcode ) {
        if( is_array( $recursiveShortcode ) ) {

            $this->_recursiveShortcodes = array_merge( $this->_recursiveShortcodes, $recursiveShortcode );
        } else {
            $this->_recursiveShortcodes[] = $recursiveShortcode;
        }
    }
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/

    /**
     * @return ffWPLayer
     */
    private function _getWPLayer()
    {
        return $this->_WPLayer;
    }

    /**
     * @param ffWPLayer $WPLayer
     */
    private function _setWPLayer($WPLayer)
    {
        $this->_WPLayer = $WPLayer;
    }

    /**
     * @return ffShortcodeFactory
     */
    private function _getShortcodeFactory()
    {
        return $this->_shortcodeFactory;
    }

    /**
     * @param ffShortcodeFactory $shortcodeFactory
     */
    private function _setShortcodeFactory($shortcodeFactory)
    {
        $this->_shortcodeFactory = $shortcodeFactory;
    }

    /**
     * @return ffShortcodeContentParser
     */
    private function _getShortcodeContentParser()
    {
        return $this->_shortcodeContentParser;
    }

    /**
     * @param ffShortcodeContentParser $shortcodeContentParser
     */
    private function _setShortcodeContentParser($shortcodeContentParser)
    {
        $this->_shortcodeContentParser = $shortcodeContentParser;
    }

    /**
     * @return ffCollection
     */
    private function _getShortcodeCollection()
    {
        return $this->_shortcodeCollection;
    }

    /**
     * @param ffCollection $shortcodeCollection
     */
    private function _setShortcodeCollection($shortcodeCollection)
    {
        $this->_shortcodeCollection = $shortcodeCollection;
    }
}