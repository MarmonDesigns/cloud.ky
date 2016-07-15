<?php

abstract class ffDatabaseModelBasic extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    /**
     * @var wpdb
     */
    protected $_WPDB = null;

    private $_fields = array();

    private $_fieldsUpdate = array();

    private $_conditions = array();

    private $_limit = '';

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( $wpdb ) {
        $this->_setWPDB( $wpdb );
    }

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    abstract protected function _initiate();

    abstract public function getTableName();


    protected function _columnExists( $column, $value ) {
        $sql = 'SELECT '.$column.' FROM `'.$this->getTableName().'` WHERE '.$column.'="'.$value.'"';

        $result = $this->_getWPDB()->get_col( $sql );

        return !empty( $result );
    }

    protected function _addField( $field ) {
        $this->_fields[] = $field;
    }

    protected function _addFields( $fields ) {
        if( is_array( $fields ) ) {
            $this->_fields = array_merge( $this->_fields, $fields );
        } else {
            $this->_fields[] = $fields;
        }
    }

    protected function _addFieldUpdate( $name, $value ) {
        $this->_fieldsUpdate[ $name ] = $value;
    }


    protected  function _select() {
        $sql = '';

        // fields
        $fieldsArray = $this->_getFields();
        $fieldsString = ''. implode( ', ', $fieldsArray) . '';

        //conditions
        $conditionsString = '';
        foreach( $this->_getConditions() as $oneCondition ) {
            if( !empty( $conditionsString ) ) {
                $conditionsString .= ' ';
                $conditionsString .= $oneCondition['type'];
            }

            $conditionsString .= ' ';
            $conditionsString .= $oneCondition['name'];
            $conditionsString .= '';
            $conditionsString .= $oneCondition['operator'];
            $conditionsString .= '"';
            $conditionsString .= $oneCondition['value'];
            $conditionsString .= '"';
        }

        $sql .= 'SELECT ' . $fieldsString ;
        $sql .= ' ';
        $sql .= 'FROM `' . $this->getTableName().'`';

        if( !empty( $conditionsString ) ) {
            $sql .= ' ';
            $sql .= 'WHERE ' . $conditionsString;
        }

        if( !empty( $this->_limit ) ) {
            $sql .= ' ';
            $sql .= $this->_limit;
        }

        return $sql;
    }

    protected function _addConditionOR( $name, $operator, $value ) {
        $condition = array();
        $condition[ 'name' ] = $name;
        $condition['operator'] = $operator;
        $condition[ 'value' ] = $value;
        $condition[ 'type' ] = 'OR';

        $this->_conditions[] = $condition;
    }

    protected function _addConditionAND( $name, $operator, $value ) {
        $condition = array();
        $condition[ 'name' ] = $name;
        $condition['operator'] = $operator;
        $condition[ 'value' ] = $value;
        $condition[ 'type' ] = 'AND';

        $this->_conditions[] = $condition;
    }

    protected function _setLimit( $limit ) {
        $this->_limit = $limit;
    }

    protected function _reset() {
        $this->_fields = array();
        $this->_fieldsUpdate = null;
        $this->_conditions = array();
        $this->_limit = '';
    }


    protected function _update() {
        $sql = '';

        $sql.= 'UPDATE `'.$this->getTableName().'`';
        $sql .= ' ';
        $sql .= 'SET';

        $updates = array();
        foreach( $this->_fieldsUpdate as $name => $value ) {
            $fieldString = $name.'="'.$value.'"';
            $updates[] = $fieldString;
        }

        $updatesString = implode(', ', $updates );

        $sql .= ' ' . $updatesString;

        $sql .= ' ' . $this->_getConditionsString();

        return $sql;
    }

    private function _getConditionsString() {
                //conditions
        $conditionsString = '';
        foreach( $this->_getConditions() as $oneCondition ) {
            if( !empty( $conditionsString ) ) {
                $conditionsString .= ' ';
                $conditionsString .= $oneCondition['type'];
            }

            $conditionsString .= ' ';
            $conditionsString .= $oneCondition['name'];
            $conditionsString .= '';
            $conditionsString .= $oneCondition['operator'];
            $conditionsString .= '"';
            $conditionsString .= $oneCondition['value'];
            $conditionsString .= '"';
        }

        if( !empty( $conditionsString ) ) {
            $conditionsString = 'WHERE'.$conditionsString;
        }

        return $conditionsString;
    }


    protected function _insert( $fields, $tableName = null ) {
        if( $tableName == null ) {
            $tableName = $this->getTableName();
        }

        $sql = '';

        $dbRows = array_keys( $fields );

        $dbRowString = '(`'.implode( '`, `', $dbRows ) . '`)';
        $valueRowString = "('" . implode( "', '", $fields) . "')";

        $sql .= 'INSERT INTO `'.$tableName.'`';
        $sql .= ' ';
        $sql .= $dbRowString;
        $sql .= ' ';
        $sql .= 'VALUES';
        $sql .= ' ';
        $sql .= $valueRowString;

        $this->_getWPDB()->query( $sql );

        return $this->_getWPDB()->insert_id;
    }

    protected function _escapeString( $value ) {
        return $value;
    }

    protected function _escapeInt( $value ) {
        return $value;
    }

    protected function _escapeDateTime( $value ) {
        return $value;
    }

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/

    /**
     * @return wpdb
     */
    protected function _getWPDB()
    {
        return $this->_WPDB;
    }

    /**
     * @param wpdb $WPDB
     */
    protected function _setWPDB($WPDB)
    {
        $this->_WPDB = $WPDB;
    }

    /**
     * @return array
     */
    private function _getFields()
    {
        return $this->_fields;
    }

    /**
     * @param array $fields
     */
    private function _setFields($fields)
    {
        $this->_fields = $fields;
    }

    /**
     * @return array
     */
    private function _getConditions()
    {
        return $this->_conditions;
    }

    /**
     * @param array $conditions
     */
    private function _setConditions($conditions)
    {
        $this->_conditions = $conditions;
    }



}