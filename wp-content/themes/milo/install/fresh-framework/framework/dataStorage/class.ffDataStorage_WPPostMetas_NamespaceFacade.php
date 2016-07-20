<?php

class ffDataStorage_WPPostMetas_NamespaceFacade extends ffBasicObject {

	 /**
	 * @var ffDataStorage_WPPostMetas
	 */
	private $_WPPostMetas = null;

	private $_namespace = null;

	public function __construct( ffDataStorage_WPPostMetas $WPPostMetas, $namespace = null) {
		$this->_WPPostMetas = $WPPostMetas;
		$this->_namespace = $namespace;
	}

	public function setNamespace( $namespace ) {
		$this->_namespace = $namespace;
	}

    public function getOptionCoded( $name, $default = null ) {
        return $this->_WPPostMetas->getOptionCoded( $this->_namespace, $name, $default);
    }

    public function setOptionCoded( $name, $value ) {
        return $this->_WPPostMetas->setOptionCoded( $this->_namespace, $name, $value );
    }

	public function getOption( $name, $default = null ) {
		return $this->_WPPostMetas->getOption( $this->_namespace, $name, $default);
	}

	public function setOption( $name, $value ) {
		return $this->_WPPostMetas->setOption( $this->_namespace, $name, $value);
	}

	public function deleteOption( $name ) {
		return $this->_WPPostMetas->deleteOption( $this->_namespace, $name);
	}

	public function deleteNamespace() {
		// TODO
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
}