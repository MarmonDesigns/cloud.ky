<?php

class ffCustomPostTypeCollection extends ffBasicObject implements Iterator, ArrayAccess {
	/**
	 * 
	 * @var 
	 */
	private $_postTypesFromWp = null;
	private $_valid = true;
	
	/**
	 * 
	 * @var ffCustomPostTypeCollectionItem_Factory
	 */
	private $_customPostTypeCollectionItemFactory;
	
	
	public function __construct( $postTypesFromWp, ffCustomPostTypeCollectionItem_Factory $customPostTypeCollectionItemFactory ) {
		$this->_setPostTypesFromWp($postTypesFromWp);
		$this->_setCustomPostTypeCollectionItemFactory($customPostTypeCollectionItemFactory);
	}
	
	private function _wpItemToOurItem( $wpItem ) {
		$ourItem = $this->_getCustomPostTypeCollectionItemFactory()->createCustomPostTypeCollectionItem();
		if( isset( $wpItem->labels) && isset( $wpItem->labels->name ) ) {
			$ourItem->label = $wpItem->labels->name;
		}
		 
		if( isset( $wpItem->labels ) && isset( $wpItem->labels->singular_name ) ) {
			$ourItem->labelSingular = $wpItem->labels->singular_name;
		}
		 
		$ourItem->id = key( $this->_postTypesFromWp );
		return $ourItem;
	}

	
	/* Methods */
	 public function current () {
	 	$currentItem = current( $this->_postTypesFromWp );
	 	$item = $this->_wpItemToOurItem( $currentItem );
	 	
	 	return $item;
	 }
	 public function key () {
	 	return key( $this->_postTypesFromWp );
	 }
	 public function next () {
	 	$isValid =  next( $this->_postTypesFromWp );
	 	if( false == $isValid ) {
	 		$this->_valid = false;
	 	}
	 }
	 public function rewind () {
	 	$this->_valid = true;
	 	return reset( $this->_postTypesFromWp );
	 }
	 public function valid () {
	 	return $this->_valid;
	 }

/**********************************************************************************************************************/
/* ARRAY ACCESS
/**********************************************************************************************************************/
    /* Methods */
    public function offsetExists ( $offset ) {
        return isset( $this->_postTypesFromWp[ $offset ] );
    }
    public function offsetGet ( $offset ) {
        return $this->_postTypesFromWp[ $offset ];
    }
    public function offsetSet ( $offset , $value ) {
        $this->_postTypesFromWp[ $offset ] = $value;
    }
    public function offsetUnset ( $offset ) {
        unset( $this->_postTypesFromWp[ $offset ] );
    }



	/**
	 * @return unknown_type
	 */
	protected function _getPostTypesFromWp() {
		return $this->_postTypesFromWp;
	}
	
	/**
	 * @param unknown_type $postTypesFromWp
	 */
	protected function _setPostTypesFromWp($postTypesFromWp) {
		$this->_postTypesFromWp = $postTypesFromWp;
		return $this;
	}

	/**
	 * @return ffCustomPostTypeCollectionItem_Factory
	 */
	protected function _getCustomPostTypeCollectionItemFactory() {
		return $this->_customPostTypeCollectionItemFactory;
	}
	
	/**
	 * @param ffCustomPostTypeCollectionItem_Factory $customPostTypeCollectionItemFactory
	 */
	protected function _setCustomPostTypeCollectionItemFactory(ffCustomPostTypeCollectionItem_Factory $customPostTypeCollectionItemFactory) {
		$this->_customPostTypeCollectionItemFactory = $customPostTypeCollectionItemFactory;
		return $this;
	}
	
	
}