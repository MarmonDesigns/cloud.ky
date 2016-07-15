<?php
class ffOneSection extends ffBasicObject implements ffIOneDataNode {
	
	const TYPE_REPEATABLE = 'variable';
	const TYPE_REPEATABLE_VARIABLE = 'repeatable_variable';
	const TYPE_REPEATABLE_VARIATION = 'repeatable_variation';
	const TYPE_NORMAL = 'normal';
	
	/*
	const TYPE_REPEATABLE = 'repeatable';
	const TYPE_REPEATABLE_VARIABLE = 'repeatable_variable';
	const TYPE_REPEATABLE_VARIATION = 'repeatable_variation';
	const TYPE_NORMAL = 'normal';
	*/

	private $_id = null;
	private $_data = array();
	private $_params = null;

	private $_type = null;

	/******************************************************************************/
	/* CUSTOM FUNCTIONS
	 /******************************************************************************/
	public function __construct( $id = null, $type = null ) {
		$this->_id = $id;
		$this->_type = $type;
	}

	public function addOption( ffOneOption $option ) {
		$this->_data[] = $option;
	}
	
	public function addElement( ffOneElement $element ) {
		$this->_data[] = $element;
	}

	public function addSection( ffOneSection $section ) {
		$this->_data[] = $section;
	}

	public function addParam( $name, $value, $onlyOnce = false ) {
		if( $onlyOnce ) {
			$this->_params[ $name ] = array( $value );
		} else {
			$this->_params[ $name ][] = $value;
		}
		return $this;
	}
	
	public function getParam( $name, $defaultValue = null ) {
		if( isset( $this->_params[$name ] ) ) {
			if( count( $this->_params[ $name ]) == 1 ) {
				return reset( $this->_params[ $name ] );
			} else {
				return $this->_params[ $name ];
			}
		}
	
		return $defaultValue;
	}

	public function getData() {
		return $this->_data;
	}

	public function getType() {
		return $this->_type;
	}

    public function getParams() {
        return $this->_params;
    }
	/******************************************************************************/
	/* IOneDataNode IMPLEMENTATION
	 /******************************************************************************/

	public function getId() {
		return $this->_id;
	}
	
	public function isContainer() {
		return true;
	}
}