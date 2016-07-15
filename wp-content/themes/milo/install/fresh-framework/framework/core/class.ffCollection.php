<?php

/**
 * Robust collection class which allows you to manipulate with objects / data really easy
 */

class ffCollection extends ffBasicObject implements Iterator, ArrayAccess, Countable {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * Here are stored all objects added to the collection
     * @var array
     */
    private $_collectionItems = array();
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

    /**
     * List of validator callbacks, which decide if we want to add item into collection
     * @var array
     */
    private $_validators = array();

    /**
     * When we apply filters, here are stored the ID's which should be displayed
     * @var
     */
    private $_filteredIdToItemsMap = null;

    /**
     * @var null
     */
    private $_currentKey = null;

    /**
     * Which classes could be added in collection, format StdClass -> className, ->couldBeParent
     * @var array
     */
    private $_supportedClassNames = array();
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct() {
        $this->addValidator( array( $this, '_classNameValidationCallback') );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function addItemAtStart( $item ) {
        array_unshift( $this->_collectionItems, $item );
    }

    public function getLastItem() {
        if( $this->_isFiltered() ) {

        } else {
            $lastItemKey = $this->_getKeyOfLastItem();
            return $this->_collectionItems[ $lastItemKey ];
        }
     }

    public function setItem( $key, $item ) {
        if( $this->_validate( $item ) ) {
            $this->_collectionItems[$key] = $item;
            return true;
        }
    }

    public function addItem( $item ) {
        if( $this->_validate( $item ) ) {
            $this->_collectionItems[] = $item;
            return true;
        } else {
            return false;
        }
    }

    public function getLastItemInsertedId() {
        end( $this->_collectionItems );
        $key = key( $this->_collectionItems);

        return $key;
    }

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS - VALIDATING
/**********************************************************************************************************************/
    public function addValidator( $callback ) {
        $this->_validators[] = $callback;
    }

    public function addSupportedClass( $className, $couldBeParent = true) {
        $supportedClass = new stdClass();
        $supportedClass->className = $className;
        $supportedClass->couldBeParent = $couldBeParent;

        $this->_supportedClassNames[] = $supportedClass;
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS - FILTERING
/**********************************************************************************************************************/
    public function filter( $callback ) {
        $newFilteredIdToItemsMap = array();
        foreach( $this as $id => $item ) {
            $result = call_user_func( $callback, $item, $id);

            if( $result ) {
                $newFilteredIdToItemsMap[] = $id;
            }
        }

        $this->_setFilteredIdToItemsMap( $newFilteredIdToItemsMap );
    }

    public function removeFilter() {
        $this->_filteredIdToItemsMap = null;
        $this->rewind();
    }

    public function each( $callback ) {

    }

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS - REMOVING
/**********************************************************************************************************************/
    public function remove( $callback ) {
        $newFilteredIdToItemsMap = $this->_filteredIdToItemsMap;
        foreach( $this as $id => $item ) {
            $result = call_user_func( $callback, $item, $id );

            if( $result ) {
                unset( $this->_collectionItems[ $id ] );

                if( $this->_isFiltered() ) {
                    $filteredId = array_search( $id, $newFilteredIdToItemsMap );
                    unset( $newFilteredIdToItemsMap[ $filteredId ] );
                }
            }
        }

        $this->_setFilteredIdToItemsMap( $newFilteredIdToItemsMap );
    }

########################################################################################################################
/**********************************************************************************************************************/
/* INTERFACE - COUNTABLE
/**********************************************************************************************************************/
########################################################################################################################
    public function count() {
        if( $this->_isFiltered() ) {
            return count( $this->_filteredIdToItemsMap );
        } else {
            return count( $this->_collectionItems );
        }
    }
########################################################################################################################
/**********************************************************************************************************************/
/* INTERFACE - ITERATOR
/**********************************************************************************************************************/
########################################################################################################################
    /**
     * return current object
     */
    public function current() {
        $key = $this->_getCurrentKey();
        if( $this->_isFiltered() ) {
            return $this->_getItemFromFilteredKey( $key );
        } else {
            return $this->_getItemFromKey( $key );
        }
    }

    public function next() {
        if( $this->_isFiltered() ) {
            next( $this->_filteredIdToItemsMap );
            $key = key( $this->_filteredIdToItemsMap );
        } else {
            next( $this->_collectionItems );
            $key = key( $this->_collectionItems );
        }

        $this->_setCurrentKey( $key );
    }

    public function rewind() {
        if( $this->_isFiltered() ) {
            reset( $this->_filteredIdToItemsMap );
            $key = key( $this->_filteredIdToItemsMap );
        } else {
            reset( $this->_collectionItems );
            $key = key( $this->_collectionItems );
        }

        $this->_setCurrentKey( $key );

        return $key;
    }

    public function valid() {
        if( $this->_isFiltered() ) {
            return ( $this->_getItemFromFilteredKey( $this->_getCurrentKey() ) !== null );
        } else {
            return ( $this->_getItemFromKey( $this->_getCurrentKey() ) !== null );
        }
    }

    public function key() {
        $key = $this->_getCurrentKey();

        if( $this->_isFiltered() ) {
            return $this->_filteredIdToItemsMap[ $key ];
        } else {
            return $key;
        }
    }

########################################################################################################################
/**********************************************************************************************************************/
/* INTERFACE - ARRAY ACCESS
/**********************************************************************************************************************/
########################################################################################################################
    public function offsetExists ( $offset ) {
        return isset( $this->_collectionItems[ $offset ] );
    }
    public function offsetGet ( $offset ) {
        if( $this->offsetExists( $offset ) ) {
            return $this->_collectionItems[ $offset ];
        } else {
            return null;
        }
    }
    public function offsetSet ( $offset , $value ) {
        if( $offset == null ) {
            $this->addItem( $value );
        } else {
            if( $this->_validate( $value ) ) {
                $this->_collectionItems[ $offset ] = $value;
            }
        }
    }
    public function offsetUnset ( $offset ) {

    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _getKeyOfLastItem() {
        $keys = array_keys( $this->_collectionItems );
        $last = end($keys);

        return $last;
    }

    private function _classNameValidationCallback( $item ) {
        if( empty( $this->_supportedClassNames ) || !is_object( $item ) ) {
            return true;
        }

        $itemClass = get_class( $item );

        foreach( $this->_supportedClassNames as $oneSupportedClassName ) {
            $className = $oneSupportedClassName->className;
            $couldBeParent = $oneSupportedClassName->couldBeParent;

            if( $className == $itemClass ) {
                return true;
            }

            if( $couldBeParent && is_subclass_of( $item, $className ) ) {
                return true;
            }
        }

        return false;

////        $isOk = true;
//        $itemClass = get_class( $item );
//
//        if( !in_array( $itemClass, $this->_supportedClassNames ) ) {
//            foreach( $this->_supportedClassNames as $oneClassName ) {
//
//                if( $oneClassName->couldBeParent ) {
//                    if( is_subclass_of( $item, $oneClassName->className ) ) {
//                        return true;
//                    }
//                } else {
//                    if
//                }
//
//
//            }
//
//            return false;
//        }
//
//
//
//        return true;
    }

    private function _validate( $item ) {
        $validators = $this->_getValidators();

        if( empty( $validators ) ) {
            return true;
        }

        $isValid = true;

        foreach( $validators as $oneValidator ) {
            $result = call_user_func( $oneValidator, $item );

            if( !$result ) {
                $isValid = false;
            }
        }

        return $isValid;
    }

    private function _getItemFromKey( $key ) {
        if( isset( $this->_collectionItems[ $key ] ) ) {
            return $this->_collectionItems[ $key ];
        } else {
            return null;
        }
    }

    private function _getItemFromFilteredKey( $key ) {
        if( isset( $this->_filteredIdToItemsMap[ $key ] ) ) {
            $collectionItemKey = $this->_filteredIdToItemsMap[ $key ];
            return $this->_getItemFromKey( $collectionItemKey );
        } else {
            return null;
        }
    }

    private function _isFiltered() {
        return $this->_filteredIdToItemsMap !== null;
    }




/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/

    /**
     * @return array
     */
    private function _getValidators()
    {
        return $this->_validators;
    }

    /**
     * @param array $validators
     */
    private function _setValidators($validators)
    {
        $this->_validators = $validators;
    }

    /**
     * @return mixed
     */
    private function _getFilteredIdToItemsMap()
    {
        return $this->_filteredIdToItemsMap;
    }

    /**
     * @param mixed $filteredIdToItemsMap
     */
    private function _setFilteredIdToItemsMap($filteredIdToItemsMap)
    {
        $this->_filteredIdToItemsMap = $filteredIdToItemsMap;
    }
    /**
     * @return null
     */
    private function _getCurrentKey()
    {
        return $this->_currentKey;
    }

    /**
     * @param null $currentKey
     */
    private function _setCurrentKey($currentKey)
    {
        $this->_currentKey = $currentKey;
    }
}
