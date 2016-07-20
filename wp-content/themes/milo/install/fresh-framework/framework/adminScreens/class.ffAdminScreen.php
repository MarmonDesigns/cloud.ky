<?php

abstract class ffAdminScreen extends ffBasicObject {
	
	/**
	 * 
	 * @var ffMenuFactory
	 */
	private $_menuFactory = null;
	
	private $_menuSlug = null;

    /**
     * @var ffRequest
     */
    private $_request = null;
	
	/**
	 * 
	 * @var ffAdminScreenViewFactory
	 */
	private $_adminScreenViewFactory = null;
	
	private $_currentAdminScreenView = null;
	
	public function __construct( ffMenuFactory $menuFactory, ffAdminScreenViewFactory $adminScreenViewFactory, ffRequest $request ) {
		$this->_setMenuFactory($menuFactory);
		$this->_setAdminScreenViewFactory($adminScreenViewFactory);
        $this->_setRequest( $request );
	}
	
	public function render() {
		$this->getCurrentView()->render();
	}
	
	/**
	 * 
	 * @return ffIAdminScreenView
	 */
	public function getCurrentView( $viewName = null ) {
        if( $this->_getRequest()->get('adminScreenView') != null ) {
            $viewName = $this->_getRequest()->get('adminScreenView');
        }

		if( $this->_currentAdminScreenView == null ) {
			$this->_currentAdminScreenView = $this->_getAdminScreenViewFactory()->createAdminScreenView( $this->_menuSlug, $viewName );
		}
		
		return $this->_currentAdminScreenView;
	}
	
	public function proceedAjax( ffAdminScreenAjax $ajax ) {
	
		$this->getCurrentView( $ajax->adminViewName )->ajaxRequest( $ajax );
	}

	
	
	/**
	 * @return ffMenu
	 */
	protected function _getMenuObject() {
		$menu = $this->_getMenuFactory()->createMenu();
		
		$menu->menuSlug = $this->_getMenuSlug();
		$menu->callback = array( $this, 'render');
		
		return $menu;
	}
	
	private function _getMenuSlug() {
		if( $this->_menuSlug == null ) {
			$inheritedClassName = get_class( $this );  // eg ffAdminScreenSidebarManager
			$baseClassName = get_parent_class( $this ); // ffAdminScreen
			
			// ffAdminScreenSidebarManager -> SidebarManager
			$this->_menuSlug= str_replace( $baseClassName, '', $inheritedClassName);
		}
		return $this->_menuSlug;
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

	/**
	 * @return ffAdminScreenViewFactory
	 */
	protected function _getAdminScreenViewFactory() {
		return $this->_adminScreenViewFactory;
	}
	
	/**
	 * @param ffAdminScreenViewFactory $adminScreenViewFactory
	 */
	protected function _setAdminScreenViewFactory(ffAdminScreenViewFactory $adminScreenViewFactory) {
		$this->_adminScreenViewFactory = $adminScreenViewFactory;
		return $this;
	}

    /**
     * @return ffRequest
     */
    private function _getRequest()
    {
        return $this->_request;
    }

    /**
     * @param ffRequest $request
     */
    private function _setRequest($request)
    {
        $this->_request = $request;
    }


	
}