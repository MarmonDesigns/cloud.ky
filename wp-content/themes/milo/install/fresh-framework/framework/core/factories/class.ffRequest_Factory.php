<?php

class ffRequest_Factory extends ffFactoryAbstract {
	public function createRequest() {
		$this->_getClassloader()->loadClass('ffRequest');
		$request = new ffRequest();
		return $request;
	}
}