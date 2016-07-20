<?php

class ffAdminScreenManager extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffMenuManager
	 */
	private $_menuManager = null;		
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffAdminScreenAjax_Factory
	 */
	private $adminScreenAjaxFactory = null;
	
	
	/**
	 * 
	 * @var ffAdminScreenFactory
	 */
	private $_adminScreenFactory = null;
	
	private $_adminScreensClassNames = array();
	
	private $_adminScreenObjects = array();
	
	/**
	 * 
	 * @var ffRequest
	 */
	private $_request = null;
	
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffWPLayer $WPLayer, ffMenuManager $menuManager, ffAdminScreenFactory $adminScreenFactory, ffRequest $request, ffAdminScreenAjax_Factory $adminScreenAjaxFactory ) {
		$this->_setWPLayer( $WPLayer );
		$this->_setMenuManager($menuManager);
		$this->_setAdminScreenFactory($adminScreenFactory);
		$this->_setRequest($request);
		$this->_setAdminScreenAjaxFactory( $adminScreenAjaxFactory );
		
		$this->_getWPLayer()->getHookManager()->addActionAdminMenu( array( $this, 'actionAdminMenu' ) );//add_action('admin_menu', array($this,'actionAdminMenu') );
		$this->_getWPLayer()->getHookManager()->addActionWPAjax( array( $this, 'actionWPAjax') );
		$this->_getWPLayer()->add_action('admin_init', array( $this, 'actionSaveScreen' ) );
	}
	
	
	public function actionSaveScreen() {
		if( !$this->_request->postEmpty() ) {
			$this->_createAdminMenus();
			
			if( $this->_getCurrentAdminScreen() != null ) {
				$this->_getCurrentAdminScreen()->getCurrentView()->actionSave( $this->_request );
			}
		}
	}
	
	
	/**
	 * @return array[ffStyle]
	 */
	public function enqueueStyles() {
		//$this->_createAdminMenus();
	}
	
	public function actionAdminMenu() {
		$this->_createAdminMenus();
		$this->_getMenuManager()->actionAdminMenu();
	}
	
	public function addAdminScreenClassName( $adminScreenClassName ) {
		
		$this->_adminScreensClassNames[] = $adminScreenClassName;
	}
	//TODO ajax vcetne picovin z javascriptu
	public function actionWPAjax() {
		if( $this->_getWPLayer()->is_admin() ) {		
			$this->_createAdminMenus();
			$ajax = $this->_getAdminScreenAjaxFactory()->getAdminScreenAjax();		
			$this->_getAdminScrenBySlug( $ajax->adminScreenName )->proceedAjax( $ajax );
			$this->_getWPLayer()->getHookManager()->doActionAjaxShutdown();
		}
		die();
	}
	
	
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	private function _createAdminMenus() {
		if( empty( $this->_adminScreensClassNames ) ) {
			return false;
		}
		foreach( $this->_adminScreensClassNames as $oneClassName ) {
			$newClass = $this->_getAdminScreenFactory()->createAdminScreen($oneClassName);
			$menu = $newClass->getMenu();
			$this->_adminScreenObjects[ $menu->menuSlug ] = $newClass;
			$this->_getMenuManager()->addMenuObject( $menu );
				
			//if( $this->_menu)
		}
		
		if( $this->_getCurrentAdminScreen() != null ) {
			$this->_getCurrentAdminScreen()->getCurrentView();
		}
	}
	
	private function _getAdminScrenBySlug( $slug ) {
		if( isset( $this->_adminScreenObjects[ $slug ] ) ) {
			return $this->_adminScreenObjects[ $slug ];
		}
		
		return null;
	}
		
	/**
	 * 
	 * @return ffIAdminScreen
	 */
	private function _getCurrentAdminScreen() {
		$slug = $this->_getRequest()->get('page');
		return $this->_getAdminScrenBySlug($slug);
	}
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	/**
	 * 
	 * @return ffMenuManager
	 */
	protected function _getMenuManager() {
		return $this->_menuManager;
	}
	
	/**
	 * 
	 * @param ffMenuManager $menuManager
	 * @return ffAdminScreenManager
	 */
	protected function _setMenuManager(ffMenuManager $menuManager) {
		$this->_menuManager = $menuManager;
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
	protected function _setWPLayer($WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	/**
	 * @return ffAdminScreenFactory
	 */
	protected function _getAdminScreenFactory() {
		return $this->_adminScreenFactory;
	}
	
	/**
	 * @param ffAdminScreenFactory $adminScreenFactory
	 */
	protected function _setAdminScreenFactory(ffAdminScreenFactory $adminScreenFactory) {
		$this->_adminScreenFactory = $adminScreenFactory;
		return $this;
	}

	/**
	 * @return ffRequest
	 */
	protected function _getRequest() {
		return $this->_request;
	}
	
	/**
	 * @param ffRequest $_request
	 */
	protected function _setRequest(ffRequest $request) {
		$this->_request = $request;
		return $this;
	}

	/**
	 * @return ffAdminScreenAjax_Factory
	 */
	protected function _getAdminScreenAjaxFactory() {
		return $this->_adminScreenAjaxFactory;
	}
	
	/**
	 * @param ffAdminScreenAjax_Factory $adminScreenAjaxFactory
	 */
	protected function _setAdminScreenAjaxFactory(ffAdminScreenAjax_Factory $adminScreenAjaxFactory) {
		$this->_adminScreenAjaxFactory = $adminScreenAjaxFactory;
		return $this;
	}
	
	
	
		
}