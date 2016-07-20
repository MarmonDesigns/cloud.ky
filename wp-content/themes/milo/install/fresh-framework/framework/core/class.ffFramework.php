<?php

class ffFramework extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffContainer
	 */
	
	private $_container = null;
	
	
	/**
	 * 
	 * @var ffPluginLoader
	 */
	private $_pluginLoader = null;
	
	/**
	 * 
	 * @var ffThemeLoader
	 */
	private $_themeLoader = null;
	
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffContainer $container, ffPluginLoader $pluginLoader, ffThemeLoader $themeLoader ) {
		$this->_setContainer( $container );
		$this->_setPluginloader( $pluginLoader );
		$this->_setThemeLoader($themeLoader);
	}
	
	public function run() {
		$this->_getPluginloader()->createPluginClasses();
		$this->_getPluginloader()->getActivePluginClasses();
	
		$this->_getContainer()->getWPUpgrader();
		$this->_frameworkRun();
		
		if( $this->_getContainer()->getWPLayer()->is_admin() ) {
			$this->_isAdmin();		
		}
		
		if( $this->_getContainer()->getWPLayer()->is_ajax() ) {
			$this->_isAjaxRequest();
		}
	}
	
	public function loadOurTheme() {
		return $this->_getThemeLoader()->loadOurTheme();
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	private function _frameworkRun() {
        $this->_hookActions();
		$this->_getContainer()->getLessScssCompiler();
		$this->_getContainer()->getDataStorageFactory()->createDataStoragePostTypeRegistrator()->registerOptionsPostType();
		
		$this->_getContainer()->getAssetsIncludingFactory()->getLessManager()->addOneLessFile( ffOneLessFile::TYPE_BOOTSTRAP, FF_FRAMEWORK_URL.'/framework/extern/bootstrap/less/variables.less', 10,'Bootstrap');

        $this->_getContainer()->getHttpAction()->checkForOurActionFired();
	}
	

	
	private function _isAdmin() {
        $this->_getContainer()->getCompatibilityTester();
        $this->_requireClassesInWidgetsAdmin();
        $this->_getContainer()->getDataStorageFactory()->createDataStoragePostTypeRegistrator()->registerOptionsPostType();
        $this->_getContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutsEmojiManager()->unregisterEmojiAtLayoutAdminScreen();

	}

    private function _requireClassesInWidgetsAdmin() {
        $request = $this->_getContainer()->getRequest();

        if( strpos( $request->server('SCRIPT_FILENAME'), 'widgets.php' ) !== false ) {
            $this->_getContainer()->getWPLayer()->add_action('admin_enqueue_scripts', array($this,'actWidgetsEnqueueMedia'));
            $this->_getContainer()->getFrameworkScriptLoader()->requireFfAdmin()->requireFrsLibModal();
        }
    }

    public function actWidgetsEnqueueMedia() {
        $this->_getContainer()->getWPLayer()->wp_enqueue_media();
    }

	private function _isAjaxRequest() {
		$this->_getContainer()->getAjaxDispatcher()->hookActions();
		$this->_getContainer()->getModalWindowAjaxManager()->hookAjax();
		$this->_getContainer()->getOptionsFactory()->createOptionsPrinterDataboxGenerator()->hookAjax();
		$this->_getContainer()->getMetaBoxes()->getMetaBoxManager()->hookAjax();
	}

    private function _hookActions() {
        $this->_getContainer()->getGraphicFactory()->getImageHttpManager()->hookActions();
    }
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/	
	
	/**
	 * @return ffContainer
	 */
	protected function _getContainer() {
		return $this->_container;
	}
	
	/**
	 * @param ffContainer $_container
	 */
	protected function _setContainer(ffContainer $container) {
		$this->_container = $container;
		return $this;
	}

	/**
	 * @return ffPluginLoader
	 */
	protected function _getPluginloader() {
		return $this->_pluginLoader;
	}
	
	/**
	 * @param ffPluginLoader $_pluginLoader
	 */
	protected function _setPluginloader(ffPluginLoader $pluginLoader) {
		$this->_pluginLoader = $pluginLoader;
		return $this;
	}
	
	/**
	 *
	 * @return ffThemeLoader
	 */
	protected function _getThemeLoader() {
		return $this->_themeLoader;
	}
	
	/**
	 *
	 * @param ffThemeLoader $themeLoader        	
	 */
	protected function _setThemeLoader(ffThemeLoader $themeLoader) {
		$this->_themeLoader = $themeLoader;
		return $this;
	}
	
	
	
}