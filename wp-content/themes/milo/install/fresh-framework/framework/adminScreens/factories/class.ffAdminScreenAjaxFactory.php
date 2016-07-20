<?php

class ffAdminScreenAjax_Factory extends ffFactoryAbstract {
	/**
	 * 
	 * @var ffRequest
	 */
	private $_request = null;
	public function __construct( ffClassLoader $classLoader, ffRequest $request ) {
		$this->_setRequest( $request );
		
		parent::__construct($classLoader);
			
	}
	
	public function getAdminScreenAjax() {
		$this->_getClassloader()->loadClass('ffAdminScreenAjax');
		$ajax = new ffAdminScreenAjax();
		
		$ajax->adminScreenName = $this->_getRequest()->post('adminScreenName');
		$ajax->adminViewName = $this->_getRequest()->post('adminViewName');
		$ajax->specification = $this->_getRequest()->post('specification');
		$ajax->data = $this->_getRequest()->post('data');
		
		return $ajax;
	}

	/**
	 * @return ffRequest
	 */
	protected function _getRequest() {
		return $this->_request;
	}
	
	/**
	 * @param ffRequest $request
	 */
	protected function _setRequest(ffRequest $request) {
		$this->_request = $request;
		return $this;
	}
	
	
	
	
}