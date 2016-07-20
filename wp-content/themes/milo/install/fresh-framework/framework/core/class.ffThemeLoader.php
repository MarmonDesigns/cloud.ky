<?php

class ffThemeLoader extends ffBasicObject {

################################################################################
# CONSTANTS
################################################################################

################################################################################
# PRIVATE OBJECTS
################################################################################
	
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;

    /**
     * @var ffClassLoader
     */
    private $_classLoader = null;
	
	
	private $_ourThemeRootPath = null;
	
	
################################################################################
# PRIVATE VARIABLES	
################################################################################	

################################################################################
# CONSTRUCTOR
################################################################################	

	
	public function __construct( ffWPLayer $WPLayer, ffFileSystem $fileSystem, ffClassLoader $classLoader ) {
		$this->_setWPLayer($WPLayer);
		$this->_setFileSystem($fileSystem);
        $this->_setClassLoader( $classLoader );
	}
	
	
################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	

	
	public function loadOurTheme() {
        $this->_loadImportantThemeClasses();
		$templateInfo = $this->_getTemplateInfo();
		$this->_createTemplateClass( $templateInfo );
        $this->_getWPLayer()->do_action( ffConstActions::ACTION_LOAD_OUR_THEME );
	}
	
	
################################################################################
# PRIVATE FUNCTIONS
################################################################################
    private function _loadImportantThemeClasses() {
        $this->_getClassLoader()->loadClass('ffNavMenuWalker');
        $this->_getClassLoader()->loadClass('ffCommentWalker');
    }

	
	private function _createTemplateClass( $templateInfo ) {
		$mainClass = $templateInfo['mainClassName'];
		$containerClass = $mainClass . 'Container';
		
		require $this->_getOurThemeRootPath() . '/framework/bootstrap/themeClass.php';
		require $this->_getOurThemeRootPath() . '/framework/bootstrap/container.php';
		
		$themeContainerInstance = call_user_func( $containerClass.'::getInstance', ffContainer::getInstance(), $this->_getOurThemeRootPath());
		
	
		
		$themeClassInstance = new $mainClass( $themeContainerInstance, $this->_getOurThemeRootPath() );
		
		return $themeClassInstance;
		
		
// 		if( !isset( $pluginInfo['mainClassName'] ) ) {
// 			throw new Exception('Trying to load PLUGIN which does not have defined plugininfo -> mainClassName' );
// 		}
		
// 		require $pluginDirClean .'/bootstrap/pluginClass.php';
		
// 		$pluginClassName = $pluginInfo['mainClassName'];
		
// 		$containerClassName = $pluginClassName . 'Container';
// 		require $pluginDirClean . '/bootstrap/container.php';
		
		
// 		$pluginContainerInstance =  call_user_func($containerClassName.'::getInstance', $this->_getContainer(), $pluginDirClean );
		
		
// 		$pluginClassInstance = new $pluginClassName( $pluginContainerInstance, $pluginDirClean );
		
// 		return $pluginClassInstance;
	}
	
	
	private function _getTemplateInfo() {
		$templateInfoFilePath = $this->_getOurThemeRootPath() . '/framework/bootstrap/infoFile.php';
		
		require_once $templateInfoFilePath;
		
		return $themeInfo;
	}
	
	 
################################################################################
# GETTERS AND SETTERS
################################################################################	
	
	
	protected function _getOurThemeRootPath() {
		if( $this->_ourThemeRootPath == null ) {
			$this->_ourThemeRootPath = $this->_getWPLayer()->get_template_directory();
		}
		
		return $this->_ourThemeRootPath;
	}
	
	
	/**
	 *
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 *
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
	/**
	 *
	 * @return ffFileSystem
	 */
	protected function _getFileSystem() {
		return $this->_fileSystem;
	}
	
	/**
	 *
	 * @param ffFileSystem $fileSystem
	 */
	protected function _setFileSystem(ffFileSystem $fileSystem) {
		$this->_fileSystem = $fileSystem;
		return $this;
	}

    /**
     * @return ffClassLoader
     */
    private function _getClassLoader()
    {
        return $this->_classLoader;
    }

    /**
     * @param ffClassLoader $classLoader
     */
    private function _setClassLoader($classLoader)
    {
        $this->_classLoader = $classLoader;
    }


	
}