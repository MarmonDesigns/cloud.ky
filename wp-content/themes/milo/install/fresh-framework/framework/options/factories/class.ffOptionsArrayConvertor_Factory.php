<?php

class ffOptionsArrayConvertor_Factory extends ffFactoryAbstract {
	public function createArrayConvertor( $data = null, $structures = null) {
		$this->_getClassloader()->loadClass( 'ffOptionsWalker');
		$this->_getClassloader()->loadClass( 'ffOptionsArrayConvertor');
		
		$convertor = new ffOptionsArrayConvertor( $data, $structures );
		return $convertor;
	}
}