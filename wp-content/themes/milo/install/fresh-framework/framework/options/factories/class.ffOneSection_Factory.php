<?php

class ffOneSection_Factory extends ffFactoryAbstract {
	public function createOneSection( $id = null, $type = null ) {
		$this->_getClassloader()->loadClass('ffIOneDataNode');
		$this->_getClassloader()->loadClass('ffOneSection');
		$this->_getClassloader()->loadClass('ffOneOption');
		$this->_getClassloader()->loadClass('ffOneElement');
		$oneSection = new ffOneSection( $id, $type );
		return $oneSection;
	}
}