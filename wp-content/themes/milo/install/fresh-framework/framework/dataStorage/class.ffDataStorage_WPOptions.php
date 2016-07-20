<?php

class ffDataStorage_WPOptions extends ffDataStorage {
	protected function _maxOptionNameLength() { return 64; }
	
	protected function _setOption( $namespace, $name, $value ) {
		$fullName = $this->_getFullName($namespace, $name);
		return $this->_getWPLayer()->update_option($fullName, $value);
	}
	protected function _getOption( $namespace, $name, $default = null ) {
		$fullName = $this->_getFullName($namespace, $name, $default);
		return $this->_getWPLayer()->get_option( $fullName );
	}
	protected function _deleteOption( $namespace, $name ) {
		$fullName = $this->_getFullName($namespace, $name);
		return $this->_getWPLayer()->delete_option( $fullName );
	}

}