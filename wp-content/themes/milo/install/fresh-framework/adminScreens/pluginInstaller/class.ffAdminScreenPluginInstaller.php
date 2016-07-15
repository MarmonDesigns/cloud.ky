<?php

class ffAdminScreenPluginInstaller extends ffAdminScreen implements ffIAdminScreen {
	public function getMenu() {
		$menu = $this->_getMenuObject();
		//add_menu_page($page_title, $menu_title, $capability, $menu_slug)
		$menu->pageTitle = 'Plugin Installer Variables';
		$menu->menuTitle = 'Plugin Installer Variables';
		$menu->type = ffMenu::TYPE_SUB_LEVEL;
		$menu->capability = 'manage_options';
		$menu->parentSlug='themes.php';
		return $menu;
	}
}