<?php

class ffMenuFactory extends ffFactoryAbstract {
	public function createMenu() {
		$this->_getClassloader()->loadClass('ffMenu');
		$menu = new ffMenu();
		
		return $menu;
	}
}