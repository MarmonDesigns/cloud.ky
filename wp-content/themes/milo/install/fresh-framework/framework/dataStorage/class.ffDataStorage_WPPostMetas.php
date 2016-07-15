<?php

class ffDataStorage_WPPostMetas extends ffDataStorage {
	protected function _maxOptionNameLength() { return 255; }
	
	protected function _setOption( $namespace /* = Post ID */, $name, $value ) {
		return $this->_getWPLayer()->update_post_meta($namespace, $name, $value);
	}
	protected function _getOption( $namespace /* = Post ID */, $name, $default=null ) {
		return $this->_getWPLayer()->get_post_meta( $namespace, $name, true );
	}
	protected function _deleteOption( $namespace /* = Post ID */, $name ) {
		return $this->_getWPLayer()->delete_post_meta($namespace, $name);
	}

	public function setOption($namespace, $name, $value ) {
		return $this->_setOption($namespace, $name, $value);
	}

    public function setOptionCoded( $namespace, $name, $value ) {
        $valueSerialized = serialize( $value );
        $valueBase64 = base64_encode( $valueSerialized );

        return $this->_setOption( $namespace, $name, $valueBase64 );
    }

	public function getOption( $namespace, $name, $default = null ) {
		return $this->_getOption($namespace, $name, $default );
	}

    private function _isBase64( $string ) {
        if (!preg_match('~[^0-9a-zA-Z+/=]~', $string)) {
        $check = str_split(base64_decode($string));
        $x = 0;
            foreach ($check as $char) if (ord($char) > 126) {
                $x++;
            }
            if ($x/count($check)*100 < 30) {
                return  true;
            }
        }
        return false;
    }
	
	public function getOptionCoded( $namespace, $name, $default = null ) {
		$value = $this->getOption($namespace, $name, $default );
		
		if( $value !== $default ) {
			$value = base64_decode( $value );
			$value = unserialize( $value );
		}
		
		return $value;
	}

	public function deleteOption( $namespace, $name ) {
		return $this->_deleteOption($namespace, $name);
	}

}