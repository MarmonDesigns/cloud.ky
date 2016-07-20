<?php

interface ffIAdminScreen {
	/**
	 * @return ffMenu
	 */
	public function getMenu();
	
	/**
	 * @return ffIAdminScreenView
	 */
	public function getCurrentView();
}