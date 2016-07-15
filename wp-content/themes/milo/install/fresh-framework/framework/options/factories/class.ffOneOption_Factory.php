<?php

class ffOneOption_Factory extends ffFactoryAbstract {
	public function createOneOption( $type = null, $id = null, $title = null, $defaultValue = null, $description = null ) {
		$this->_getClassloader()->loadClass('ffIOneDataNode');
		$this->_getClassloader()->loadClass('ffOneOption');
		
		$option = new ffOneOption( $type, $id, $title, $defaultValue, $description );
		return $option;
	}	
	
	
	public function createOneElement($type, $id, $title = '', $description = '' ) {
		$this->_getClassloader()->loadClass('ffIOneDataNode');
		$this->_getClassloader()->loadClass('ffOneElement');
		
		$element = new ffOneElement( $type, $id, $title, $description );
		return $element;
	}
}