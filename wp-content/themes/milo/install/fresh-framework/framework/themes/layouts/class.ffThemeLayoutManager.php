<?php

/**
 * Class ffThemeLayoutManager
 * Handles the whole layout business. Only thing required is a Options Holder class name, and theme name
 */
class ffThemeLayoutManager extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffLayoutPostType
     */
    private $_layoutPostType = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_themeName = null;

    private $_optionsHolderName = null;

    private $_defaultOptionsCallbacks = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( $layoutPostType ) {
        $this->_setLayoutPostType( $layoutPostType );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function addLayoutSupport() {
        $this->_getLayoutPostType()->setThemeName( $this->_getThemeName() );
        $this->_getLayoutPostType()->registerPostType();

        // vytvorit custom post type
//     s   die();
    }

    public function printLayout() {
        // mit nejaky printer, ten
    }


    public function getLayoutPostTypeName() {
        return $this->_getLayoutPostType()->getPostTypeName();
    }



/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
    public function setThemeName( $themeName ) {
        $this->_themeName = $themeName;
    }

    public function setLayoutsOptionsHolderClassName( $className ) {
        $this->_optionsHolderName = $className;
    }

    public function getLayoutsOptionsHolderClassName() {
        return $this->_optionsHolderName;
    }

    public function getThemeName() {
        return $this->_getThemeName();
    }
/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return null
     */
    private function _getThemeName()
    {
        return $this->_themeName;
    }

    /**
     * @return ffLayoutPostType
     */
    private function _getLayoutPostType()
    {
        return $this->_layoutPostType;
    }

    /**
     * @param ffLayoutPostType $layoutPostType
     */
    private function _setLayoutPostType($layoutPostType)
    {
        $this->_layoutPostType = $layoutPostType;
    }

}