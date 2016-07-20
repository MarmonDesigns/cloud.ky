<?php

class ffAttrHelper extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_values = array();
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct() {

    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    /*----------------------------------------------------------*/
    /* ADDING VALUES
    /*----------------------------------------------------------*/
    public function addValue( $attributeValue ) {
        $this->_values[] = $attributeValue;
    }

    public function addValuesArray( $attributeValueArray ) {
        if( !is_array( $attributeValueArray ) ) {
            throw new ffException('ffAttrHelper - addValueArray - param should be array!');
        }

        $this->_values = array_merge( $this->_values, $attributeValueArray );
    }

    /*----------------------------------------------------------*/
    /* GETTING VALUES
    /*----------------------------------------------------------*/
    public function getValues( $implodingGlue = ' ') {
        $valuesImploded = implode(' ', $this->_values );
        return $valuesImploded;
    }

    public function getValuesArray() {
        return $this->_values;
    }

    public function getValuesAndMergeWithString( $string, $implodingGlue = ' ') {
        $values = $this->getValues( $implodingGlue );
        $valuesMerged = $string . $implodingGlue . $values;

        return $valuesMerged;
    }

    public function getValuesWrappedByAttr( $attrName, $implodingGlue = ' ') {
        $values = $this->getValues( $implodingGlue );

        $toReturn = $attrName.'="'.$values.'"';

        return $toReturn;
    }

    public function getValuesWrappedByAttrWithString( $attrName, $string, $implodingGlue = ' ' ) {
        $values = $this->getValues( $implodingGlue );

        $toReturn = $attrName.'="'. $string . $implodingGlue .$values.'"';

        return $toReturn;
    }

    public function reset() {
        $this->_values = array();
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
}