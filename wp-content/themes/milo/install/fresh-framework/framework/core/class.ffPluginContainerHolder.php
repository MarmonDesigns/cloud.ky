<?php
class ffPluginContainerHolder extends ffBasicObject {
	private static $_instance = null;
	
	/**
	 * 
	 * @var f
	 */
	private $_pluginDeployContainer = null;
	
	public static function getInstance() {
		if( is_null( self::$_instance ) ) {
			self::$_instance = new ffPluginContainerHolder();
		}
	}
	
	
}