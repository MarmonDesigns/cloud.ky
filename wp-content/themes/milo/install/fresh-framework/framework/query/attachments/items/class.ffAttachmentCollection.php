<?php

class ffAttachmentCollection extends ffBasicObject implements Iterator {
	

	protected $_collectionItems = array();

	protected $_valid = false;

	public function __construct(){
		
	}

	public function add( ffAttachmentCollectionItem $item ){
		$this->_collectionItems[] = $item;
	}

	/* Methods */
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

}



