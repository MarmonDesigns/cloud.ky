<?php

class ffMenuManager {
	const MENU_TYPE_UNIVERSAL = 'type_universal';
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * 
	 * @var ffMenuFactory
	 */
	private $_menuFactory = null;
	
	/**
	 * 
	 * @var array[ffMenu]
	 */
	private $_menus = array();
	
	/**
	 * 
	 * @var array[strings]
	 */
	private $_slugList = array();
	
	private $_hiddenSlugs = array();
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/ 
	public function __construct( ffWPLayer $WPLayer, ffMenuFactory $menuFactory ) {
		$this->_setWPLayer($WPLayer);
		$this->_setMenuFactory($menuFactory);
	}
	
	public function actionAdminMenu() {
		if( empty( $this->_menus ) ) {
			return false;
		}
		
		foreach( $this->_menus as $menu ) {
			switch( $menu->type ) {
				case ffMenu::TYPE_UNI_LEVEL :
					$this->_registerUniversalMenu( $menu );
					break;
					
				case ffMenu::TYPE_SUB_LEVEL :
					$this->_registerSubMenu( $menu );
					break;
					
				case ffMenu::TYPE_HID_LEVEL :
					$this->_addHiddenSlug( $menu->menuSlug ); 
					$this->_registerUniversalMenu( $menu );
					break;
			}
		}
		
		$this->_removeHiddenMenus();
	}
	

	
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	private function _removeHiddenMenus() {
		if( empty($this->_hiddenSlugs) ) {
			return false;
		}
	
		foreach( $this->_hiddenSlugs as $oneHiddenSlug ) {
			$this->_getWPLayer()->remove_menu_page( $oneHiddenSlug );
		}
	}
	
	private function _addHiddenSlug( $slug ) {
		$this->_hiddenSlugs[] = $slug;
	}
	
	private function _registerSubMenu( ffMenu $menu ) {
		$this->_getWPLayer()->add_submenu_page(
													$menu->parentSlug,
												 	$menu->pageTitle,
												 	$menu->menuTitle,
												 	$menu->capability,
												 	$menu->menuSlug,
												 	$menu->callback
											  );
	}
	
	private function _registerUniversalMenu( ffMenu $menu ) {
		
		$this->_getWPLayer()->add_menu_page(
												$menu->pageTitle,
												$menu->menuTitle,
												$menu->capability,
												$menu->menuSlug,
												$menu->callback,
												$menu->iconUrl,
												$menu->position
											);
	}
	
	public function addUniversalMenu( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null ) {
		$menu = $this->_getMenuFactory()->createMenu();
		$menu->parentSlug = $parent_slug;
		$menu->pageTitle = $page_title;
		$menu->menuTitle = $menu_title;
		$menu->capability = $capability;
		$menu->menuSlug = $menu_slug;
		$menu->callback = $function;
		$menu->iconUrl = $icon_url;
		$menu->position = $position;
		$menu->type = ffMenu::TYPE_UNI_LEVEL;
		$this->_addMenu( $menu );
	}
	
	public function addMenuObject( ffMenu $menu ) {
		$this->_addMenu( $menu );
	}
	
	private function _addMenu( ffMenu $menu ) {
		$this->_menus[ $menu->menuSlug ] = $menu;
		$this->_slugList[] = $menu->menuSlug;
	}
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	
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
	
		
}