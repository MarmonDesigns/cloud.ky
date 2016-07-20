<?php

class ffPostCollection extends ffBasicObject implements Iterator, ArrayAccess {
	

	protected $_collectionItems = array();

	protected $_valid = false;

	public function __construct(){

	}
	
	public function getNumberOfItems() {
		return count( $this->_collectionItems );
	}

	public function add( ffPostCollectionItem $item ){
		$this->_collectionItems[] = $item;
	}

	/* Methods */
	/**
	 * (non-PHPdoc)
	 * @see Iterator::current()
	 * @return ffPostCollectionItem
	 */
	public function current () {
		return current( $this->_collectionItems );
	}

	public function key () {
		return key( $this->_collectionItems );
	}

	public function next () {
		$isValid =  next( $this->_collectionItems );
		if( false == $isValid ) {
			$this->_valid = false;
		}
	}

	public function rewind () {
		$this->_valid = true;
		return reset( $this->_collectionItems );
	}

	public function valid () {
		return $this->_valid;
	}
/**********************************************************************************************************************/
/* ARRAY ACCESS
/**********************************************************************************************************************/

    /**********************************************************************************************************************/
/* ARRAY ACCESS
/**********************************************************************************************************************/
    /* Methods */
    public function offsetExists ( $offset ) {
        return isset( $this->_collectionItems[ $offset ] );
    }
    public function offsetGet ( $offset ) {
        return $this->_collectionItems[ $offset ];
    }
    public function offsetSet ( $offset , $value ) {
        $this->_collectionItems[ $offset ] = $value;
    }
    public function offsetUnset ( $offset ) {
        unset( $this->_collectionItems[ $offset ] );
    }

}



