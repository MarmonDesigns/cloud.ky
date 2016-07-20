<?php
/**
 * This class automatically loads all necessary files. It will be also used
* across the whole template, when you need to load something dynamically
* @author freshface
* @since 1.1.2
*/
class ffAjaxRequest extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	public $owner = NULL;
	
	public $specification = NULL;

	public $data = NULL;
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function getData( $name ) {
        if( isset( $this->data[ $name ] ) ) {
            return $this->data[ $name ];
        } else {
            return null;
        }
    }
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/	
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
}