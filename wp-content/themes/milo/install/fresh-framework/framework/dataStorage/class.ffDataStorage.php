<?php
abstract class ffDataStorage extends ffBasicObject implements ffIDataStorage {
	/******************************************************************************/
	/* VARIABLES AND CONSTANTS
	 /******************************************************************************/
	const FF_PREFIX = 'ffpf_';					// FreshFramework PreFix

	/**
	 *
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	/******************************************************************************/
	/* CONSTRUCT AND PUBLIC FUNCTIONS
	 /******************************************************************************/
	public function __construct( ffWPLayer $WPLayer ) {
		$this->_setWPLayer($WPLayer);
	}

	public function setOption($namespace, $name, $value ) {
		$fullName = $this->_getFullName($namespace, $name);
		$checkedOption = $this->_checkOptionName( $fullName );
		return $this->_setOption($namespace, $name, $value);
	}

	public function getOption( $namespace, $name, $default = null ) {
		$fullName = $this->_getFullName($namespace, $name, $default);
		return $this->_getOption($namespace, $name );
	}

	public function deleteOption( $namespace, $name ) {
		$fullName = $this->_getFullName($namespace, $name);
		return $this->_deleteOption($namespace, $name);
	}
	
	public function getOptionCoded( $namespace, $name, $default = null ) {
		$value = $this->getOption($namespace, $name, $default );
		$value = base64_decode( $value );
		$value = unserialize( $value );
	
		return $value;
	}
	
	public function setOptionCoded( $namespace, $name, $value ) {
		$value = serialize( $value );
		$value = base64_encode( $value );
		return $this->setOption($namespace, $name, $value);
	}

	/******************************************************************************/
	/* PRIVATE FUNCTIONS
	 /******************************************************************************/
	protected function _getFullName( $namespace, $name ) {
		$fullName = ffDataStorage::FF_PREFIX . $namespace . '_' . $name;
		return $fullName;
	}

	protected abstract function _maxOptionNameLength();

	protected abstract function _setOption( $namespace, $name, $value );
	protected abstract function _getOption( $namespace, $name );
	protected abstract function _deleteOption( $namespace, $name );

	protected function _checkOptionName( $optionName ) {
		if( strlen( $optionName ) > $this->_maxOptionNameLength() ) {
			throw new Exception('MAXIMUM LENGTH FOR OPTION NAME EXCEEDED ->>' . $optionName );
		}

		return $optionName;
	}
	/******************************************************************************/
	/* SETTERS AND GETTERS
	 /******************************************************************************/
	private function _setWPLayer( ffWPLayer $WPLayer ) {
		$this->_WPLayer = $WPLayer;
	}
	/**
	 *
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
}