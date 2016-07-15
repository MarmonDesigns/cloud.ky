<?php

abstract class ffShortcodeObjectBasic extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_shortcodeNames = null;

    private $_isRecursive = false;

    private $_printedShortcodeName = null;

    private $_printedShortcodeDepth = null;

    private $_defaultArguments = array();

    private $_currentArguments = array();
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( $WPLayer ) {
        $this->_setWPLayer( $WPLayer );
        $this->_setRecursive();
        $this->_addNames();
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function getShortcodeNames() {
        return $this->_shortcodeNames;
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
    public function getIsRecursive() {
        return $this->_isRecursive;
    }

    public function addName( $name ) {
        $this->_addShortcodeName( $name );
    }

    public function printShortcode( $atts = array(), $content = '', $shortcodeName ) {
        $contentShortcoded = $this->_getWPLayer()->do_shortcode( $content );

        $this->_processShortcodeName( $shortcodeName );
        $this->_processCurrentArguments( $atts );
        ob_start();
            $this->_printShortcode( $atts, $contentShortcoded, $shortcodeName );
            $currentShortcode = ob_get_contents();
        ob_end_clean();

        return $currentShortcode;
    }
/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    protected function _addDefaultArgument( $name, $value ) {
        $this->_defaultArguments[ $name ] = $value;
    }

    protected function _getArgument( $name ) {
        if( isset( $this->_currentArguments[ $name ] ) ) {
            return $this->_currentArguments[ $name ];
        } else {
            return null;
        }
    }

    private function _processCurrentArguments( $arguments ) {
        $mergedArguments = $this->_getWPLayer()->wp_parse_args( $arguments, $this->_defaultArguments );
        $this->_currentArguments = $mergedArguments;
    }

    private function _processShortcodeName( $shortcodeName ) {

        if( $this->getIsRecursive() ) {
            $depthExploded = explode(ffShortcodeContentParser::SUFFIX, $shortcodeName );
            if( isset( $depthExploded[1] ) ) {
                $this->_printedShortcodeDepth = $depthExploded[1];
            } else {
                $this->_printedShortcodeDepth = 0;
            }

            $this->_printedShortcodeName = $depthExploded[0];
        }
    }

    protected function _getShortcodeDepth() {
        return $this->_printedShortcodeDepth;
    }

    protected function _getShortcodeBaseName() {
        return $this->_printedShortcodeName;
    }

    abstract protected function _addNames();
    abstract protected function _setRecursive();
    abstract protected function _printShortcode( $atts = array(), $content = '', $currentShortcodeName ='');
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    protected  function  _addShortcodeName( $name ) {
        if( $this->_shortcodeNames == null ) {
            $this->_shortcodeNames = array();
        }

        $this->_shortcodeNames[] = $name;
    }

    protected function _setIsRecursive( $value ) {
        $this->_isRecursive = $value;
    }

    /**
     * @return null
     */
    protected function _getWPLayer()
    {
        return $this->_WPLayer;
    }

    /**
     * @param ffWPLayer $WPLayer
     */
    protected function _setWPLayer($WPLayer)
    {
        $this->_WPLayer = $WPLayer;
    }


}