<?php

class ffHookManager extends ffBasicObject {
	const ACTION_PRE_ENQUEUE_SCRIPTS = 'ff_pre_enqueue_scripts';
	const ACTION_PRE_UPDATE_PLUGIN = 'ff_pre_update_plugin';
	const ACTION_NAME_PREFIX = 'ff_';
	const ACTION_GATHER_LESS_SCSS_VARIABLES = 'ff_gather_less_scss_variables';
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	private $_registeredActions = array();
	
	public function __construct( ffWPLayer $WPLayer ) {
		$this->_setWPLayer($WPLayer);
	}
################################################################################
# ENQUEUE_SCRIPTS
################################################################################
	public function addActionEnqueuScripts( $callback ) {
		if( !isset($this->_registeredActions['wp_enqueue_scripts']) ) {
			$this->_getWPLayer()->add_action_enque_scripts( array( $this, 'actionEnqueueScripts' ) );
		}
		
		$this->_getWPLayer()->add_action('ff_wp_enqueue_scripts', $callback);
	}
	
	public function addActionPreEnqueueScripts( $callback ) {
		$this->_getWPLayer()->add_action( ffHookManager::ACTION_PRE_ENQUEUE_SCRIPTS, $callback);
	}
	
	private $_actionEnqueueScriptsHasBeenFired = false;
	
	public function actionEnqueueScripts() {
		if( $this->_actionEnqueueScriptsHasBeenFired == true ) {
			return;
		} else {
			$this->_actionEnqueueScriptsHasBeenFired = true;
		}
		$this->_getWPLayer()->do_action( ffHookManager::ACTION_PRE_ENQUEUE_SCRIPTS );
		$this->_getWPLayer()->do_action('ff_wp_enqueue_scripts' );
	}
################################################################################
# ADMIN_MENU
################################################################################	
	public function addActionAdminMenu( $callback ) {
		$this->_getWPLayer()->add_action('admin_menu', $callback);
	}
	
################################################################################
# ADMIN_INIT
################################################################################	
	public function addActionAdminInit( $callback ) {
		$this->_getWPLayer()->add_action('admin_init', $callback);
	}
################################################################################
# WIDGETS_INIT
################################################################################	
	public function addActionWidgetsInit( $callback ) {
		$this->_getWPLayer()->add_action('widgets_init', $callback);
	}
	
	public function addActionWPPrintScripts( $callback, $priority = 10 ) {
		$this->_getWPLayer()->add_action('wp_print_scripts', $callback, $priority);
	}
	public function addActionWPPrintStyles( $callback, $priority = 10 ) {
		if( $this->_getWPLayer()->is_admin() )
			$this->_getWPLayer()->add_action('admin_print_styles', $callback, $priority);
		else
			$this->_getWPLayer()->add_action('wp_print_styles', $callback, $priority);
	}
	
################################################################################
# OUR_PLUGIN_ACTIONS
################################################################################	
	public function addActionPreUpdatePlugin( $pluginName, $callback ) {
		$normalizedName = $this->_getPluginNameNormalized( $pluginName );
		
		$this->_getWPLayer()->add_action(ffHookManager::ACTION_PRE_UPDATE_PLUGIN.'-'.$normalizedName, $callback);
	}
	
	public function doActionPreUpdatePlugin( $pluginName ) {
		$normalizedName = $this->_getPluginNameNormalized( $pluginName );
		$this->_getWPLayer()->do_action(ffHookManager::ACTION_PRE_UPDATE_PLUGIN.'-'.$normalizedName);
	}
	
	private function _getPluginNameNormalized( $pluginName ) {
		$nameLower = strtolower( $pluginName );
		$nameWithoutSpace = str_replace(' ', '-', $nameLower);
		return $nameWithoutSpace;
	}
	
################################################################################
# AJAX
################################################################################
	public function addActionWPAjax( $callback ) {
		$this->_getWPLayer()->add_action('wp_ajax_ff_ajax_admin', $callback);
	}
	
	public function addActionAjax( $callback ) {
		$this->_getWPLayer()->add_action('wp_ajax_ff_ajax', $callback);
		$this->_getWPLayer()->add_action('wp_ajax_nopriv_ff_ajax', $callback);
	}
	
	public function addAjaxRequestOwner( $owner, $callback ) {
		$this->_getWPLayer()->add_action('ff_ajax-'.$owner, $callback);
	}

    public function removeAjaxRequestOwner( $owner, $callback ) {
        $this->_getWPLayer()->remove_action('ff_ajax-'.$owner, $callback);
    }
	
	
	public function doAjaxRequest( ffAjaxRequest $request ) {
		$this->_getWPLayer()->do_action('ff_ajax-'.$request->owner, $request );
	}
	
################################################################################
# SHUTDOWN
################################################################################	
	public function addActionShutdown( $callback ) {
		if( $this->_getWPLayer()->is_ajax() ) {
			
			$this->_getWPLayer()->add_action('ff_ajax_shutdown', $callback);
		} else {
			
			$this->_getWPLayer()->add_action('shutdown', $callback);
		}
	}
	
	public function doActionAjaxShutdown() {
		$this->_getWPLayer()->do_action('ff_ajax_shutdown');
	}
################################################################################
# WP_LOADED
################################################################################
	public function addActionWPLoaded( $callback ) {
		$this->_getWPLayer()->add_action('wp_loaded', $callback);
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