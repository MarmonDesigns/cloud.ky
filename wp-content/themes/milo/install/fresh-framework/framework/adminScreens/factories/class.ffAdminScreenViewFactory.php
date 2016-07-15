<?php

class ffAdminScreenViewFactory extends ffFactoryAbstract {
	
	/**
	 * 
	 * @var ffRequest
	 */
	private $_request = null;
	
	
	/**
	 * 
	 * @var ffStyleEnqueuer
	 */
	private $styleEnqueuer = null;
	
	
	/**
	 * 
	 * @var ffScriptEnqueuer
	 */
	private $scriptEnqueuer = null;
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	public function __construct( ffClassLoader $classLoader, ffRequest $request, ffScriptEnqueuer $scriptEnqueuer, ffStyleEnqueuer $styleEnqueuer, ffWPLayer $WPLayer ) {
		parent::__construct($classLoader);
		$this->_setRequest( $request );
		$this->_setScriptEnqueuer($scriptEnqueuer);
		$this->_setStyleEnqueuer($styleEnqueuer);
		$this->_setWPLayer($WPLayer);
	}
	
	public function createAdminScreenView( $currentSlug, $viewName = null ) {
		// for example Default
		
		if( $viewName == null ) {
			$viewName = $this->_getCurrentViewName();
		}
		
		$fullClassName = 'ffAdminScreen'. $currentSlug . 'View' . $viewName;
		
		$classInstance = $this->_getClassInstance($fullClassName, $currentSlug, $viewName );
		
		return $classInstance;
	}
	
	private function _getClassInstance( $className, $currentSlug, $viewName ) {
		
		if( $this->_getClassloader()->classRegistered( $className ) ) {
			$this->_getClassloader()->loadClass('ffIAdminScreenView');
			$this->_getClassloader()->loadClass('ffAdminScreenView');
			
			$this->_getClassloader()->loadClass( $className );
			
			$viewClassInstance = new $className( $currentSlug, $viewName, $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer(), $this->_getWPLayer() );
			
			return $viewClassInstance;
		} else {
			return null;
		}
	}
	
	private function _getCurrentViewName() {
		if( $this->_getRequest()->post( ffRequest::ADMIN_SCREEN_VIEW_SLUG ) !== null ) {
			return $this->_getRequest()->post( ffRequest::ADMIN_SCREEN_VIEW_SLUG );
		} else {
			return 'Default';
		}
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

	/**
	 * @return ffStyleEnqueuer
	 */
	protected function _getStyleEnqueuer() {
		return $this->_styleEnqueuer;
	}
	
	/**
	 * @param ffStyleEnqueuer $styleEnqueuer
	 */
	protected function _setStyleEnqueuer(ffStyleEnqueuer $styleEnqueuer) {
		$this->_styleEnqueuer = $styleEnqueuer;
		return $this;
	}
	
	/**
	 * @return ffScriptEnqueuer
	 */
	protected function _getScriptEnqueuer() {
		return $this->_scriptEnqueuer;
	}
	
	/**
	 * @param ffScriptEnqueuer $scriptEnqueuer
	 */
	protected function _setScriptEnqueuer(ffScriptEnqueuer $scriptEnqueuer) {
		$this->_scriptEnqueuer = $scriptEnqueuer;
		return $this;
	}

	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
	
	
}