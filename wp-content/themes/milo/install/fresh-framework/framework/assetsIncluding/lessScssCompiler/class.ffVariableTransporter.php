<?php

class ffVariableTransporter extends ffBasicObject {
	private $_variables = array();
	private $_codes = array();
	
	private $_codesImploded = null;
	
	public function addCode( $handle, $name, $value ) {
		$this->_codes[ $handle ][ $name ] = $value;
	}
	
	public function getImplodedCodeForHandle( $handle ) {

		if( isset( $this->_codes[ $handle ] ) ) {
			if ( !isset($this->_codesImploded[ $handle ] ) ) {
				$this->_codesImploded[ $handle ] = implode("\n",  $this->_codes[ $handle ] );
			}
			
			
			
			return $this->_codesImploded[ $handle ];
		} else {
			return null;
		}
	}
	
	public function addVariable( $handle, $name, $value ) {
		$this->_variables[ $handle ][ $name ] = $value;
	}
	
	
	public function getVariables() {
		return $this->_variables;
	}
	
	public function getVariableForHandle( $handle ) {
		
		if( isset( $this->_variables[ $handle ] ) ) {
			return $this->_variables[ $handle ];
		} else {
			return null;
		}
	}
}