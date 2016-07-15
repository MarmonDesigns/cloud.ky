<?php

class ffAdminScreenThemeOptions extends ffAdminScreen implements ffIAdminScreen {
	public function getMenu() {
		$menu = $this->_getMenuObject();
		$menu->pageTitle = 'Theme Options';
		$menu->menuTitle = 'Theme Options';
		$menu->type = ffMenu::TYPE_SUB_LEVEL;
		$menu->capability = 'manage_options';
		$menu->parentSlug='themes.php';
		return $menu;
	}
}
