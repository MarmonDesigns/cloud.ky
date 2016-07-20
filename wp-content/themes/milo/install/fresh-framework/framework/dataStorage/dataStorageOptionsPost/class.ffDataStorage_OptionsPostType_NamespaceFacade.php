<?php

class ffDataStorage_OptionsPostType_NamespaceFacade extends ffBasicObject {

	
	
################################################################################
# CONSTANTS
################################################################################

################################################################################
# PRIVATE OBJECTS
################################################################################
	/**
	 * @var ffDataStorage_OptionsPostType
	 */
	private $_OptionsPostType = null;
	
################################################################################
# PRIVATE VARIABLES	
################################################################################	

	private $_namespace = null;
	
################################################################################
# CONSTRUCTOR
################################################################################	

################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	
	public function __construct( ffDataStorage_OptionsPostType $OptionsPostType, $namespace = null) {
		$this->_OptionsPostType = $OptionsPostType;
		$this->_namespace = $namespace;
	}
	
	public function setNamespace( $namespace ) {
		$this->_namespace = $namespace;
	}
	
	public function getOptionCoded( $name, $default = null ) {
		$value = $this->getOption( $name, $default );
		
		if( $value !== $default ) {
			$value = base64_decode( $value );
			$value = unserialize( $value );
		}
		
		return $value;
	}
	
	public function setOptionCoded( $name, $value ) {
		$value = serialize( $value );
		$value = base64_encode( $value );
		$this->setOption( $name, $value);
	}
	
	public function getOption( $name, $default = null ) {
		return $this->_OptionsPostType->getOption( $this->_namespace, $name, $default);
	}
	
	public function setOption( $name, $value ) {
		return $this->_OptionsPostType->setOption( $this->_namespace, $name, $value);
	}
	
	public function deleteOption( $name ) {
		
		return $this->_OptionsPostType->deleteOption( $this->_namespace, $name);
	}
	
	public function deleteNamespace() {
		return $this->_OptionsPostType->deleteNamespace( $this->_namespace );
		
		// TODO
	}
	
	public function getAllOptionsForNamespace() {
		return $this->_OptionsPostType->getAllOptionsForNamespace( $this->_namespace );
	}
	
	public function getAllOptionsForNamespaceWithValues() {
		return $this->_OptionsPostType->getAllOptionsForNamespaceWithValues( $this->_namespace );
	}
	
	
	public function addToOption( $name, $value ) {
		$optionCurrentValue = $this->getOption( $name );
		if( empty( $optionCurrentValue ) ) {
			$optionCurrentValue = array();
		}
	
		if( !is_array( $optionCurrentValue ) ) {
			return false;
		}
	
		if( !is_array($value ) ) {
			$value = array($value);
		}
	
		$optionCurrentValue = array_merge( $optionCurrentValue, $value);
	
		$this->setOption( $name, $optionCurrentValue);
	}
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	 
################################################################################
# GETTERS AND SETTERS
################################################################################	
	
}