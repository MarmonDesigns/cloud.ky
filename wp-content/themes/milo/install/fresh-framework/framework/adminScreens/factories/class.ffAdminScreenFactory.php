<?php

class ffAdminScreenFactory extends ffFactoryAbstract {
	/**
	 * 
	 * @var ffMenuFactory
	 */
	private $_menuFactory = null;
	
	/**
	 * 
	 * @var ffAdminScreenViewFactory
	 */
	private $_adminScreenViewFactory = null;
	
	public function __construct( ffClassLoader $classLoader, ffMenuFactory $menuFactory, ffAdminScreenViewFactory $adminScreenViewFactory ) {
		parent::__construct($classLoader);
		$this->_setMenuFactory( $menuFactory );
		$this->_setAdminScreenViewFactory($adminScreenViewFactory);
	}
	
	/**
	 * 
	 * @param unknown $adminScreenClassName
	 * @return ffIAdminScreen
	 */
	public function createAdminScreen( $adminScreenClassName ) {
		$this->_getClassloader()->loadClass('ffIAdminScreen');
		if ( $this->_getClassloader()->classRegistered( $adminScreenClassName ) ) {
		
			$this->_getClassloader()->loadClass( $adminScreenClassName );
            $request = ffContainer()->getRequest();
			$adminScreenClassInstance = new $adminScreenClassName( $this->_getMenuFactory(), $this->_getAdminScreenViewFactory(), $request );
			
			return $adminScreenClassInstance;
		} else {
			throw new Exception('AdminScreenFactory -> Trying to create class '.$adminScreenClassName.', but it does not exists!');
		}
		return false;
	}

	/**
	 * @return ffMenuFactory
	 */
	protected function _getMenuFactory() {
		return $this->_menuFactory;
	}
	
	/**
	 * @param ffMenuFactory $menuFactory
	 */
	protected function _setMenuFactory(ffMenuFactory $menuFactory) {
		$this->_menuFactory = $menuFactory;
		return $this;
	}

	protected function _getAdminScreenViewFactory() {
		return $this->_adminScreenViewFactory;
	}
	
	protected function _setAdminScreenViewFactory(ffAdminScreenViewFactory $adminScreenViewFactory) {
		$this->_adminScreenViewFactory = $adminScreenViewFactory;
		return $this;
	}
	
	
}