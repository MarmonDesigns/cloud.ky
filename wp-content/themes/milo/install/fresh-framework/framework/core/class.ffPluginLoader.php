<?php
//TODO REFACTOR WITH PLUGIN IDENTIFICATOR
class ffPluginLoader extends ffBasicObject {
	const FF_PLUGIN_NAME = 'freshplugin.php';
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffFileSystem
	 */
	private $_fileSystem  = null;
	
	/**
	 * 
	 * @var ffContainer
	 */
	private $_container = null;
	
	/**
	 * 
	 * @var ffPluginIdentificator
	 */
	private $_pluginIdentificator = null;
	
	private $_allOurActivePlugins = array();
	
	private $_nonDuplicateActivePlugins = array();
	
	private $_activatedPlugins = array();
	
	private $_activePluginClasses = array();
	
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffWPLayer $WPLayer, ffFileSystem $fileSystem, ffContainer $container, ffPluginIdentificator $pluginIdentificator ) {
		$this->_setWplayer($WPLayer);
		$this->_setFileSystem( $fileSystem );
		$this->_setContainer( $container );
		$this->_setPluginIdentificator($pluginIdentificator);
		
		// hook action for plugin activation and de-activation
		$this->_getWplayer()->add_action('activated_plugin', array( $this, 'catchActivatedPlugin'));
	}
	
	// catch activated plugin and if it's our, create it;
	public function catchActivatedPlugin( $activatedPluginName ) {
		if( strpos( $activatedPluginName, 'freshplugin.php') !== false ) {
			$pluginNameClean = str_replace( '/freshplugin.php', '', $activatedPluginName);
			$pluginInfo = $this->_loadOneOurActivePlugin( $pluginNameClean );
			$pluginClass = $this->_instantiateOnePluginClass( $pluginInfo );
			
			$pluginClass->pluginActivation();
			
			$this->_activePluginClasses[  $pluginInfo['plugin-name']  ] = $pluginClass;
		}
	}
	
	public function createPluginClasses() {
		$this->_identifyNonDuplicatePlugins();
		return $this->_loadPlugins();
	}
	
	public function getActivePluginClasses() {
		return $this->_activePluginClasses;
	}
	
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/	
	private function _setNonDuplicatePlugin( $folder, $name, $version ) {
		$this->_nonDuplicateActivePlugins[ $name ]['plugin-version'] = $version;
		$this->_nonDuplicateActivePlugins[ $name ]['plugin-name'] = $folder;
		return $this->_nonDuplicateActivePlugins[ $name ];
	}	
	
	private function _identifyNonDuplicatePlugins()  {
		// get all active plugins ( even duplicate -> multiple instances of one plugin )
		$this->_allOurActivePlugins = $this->_getPluginIdentificator()->getOurActivePlugins();
		
		foreach( $this->_allOurActivePlugins as $oneActivePlugin ) {
			$this->_loadOneOurActivePlugin($oneActivePlugin);
		}
	}
	
	private function _loadOneOurActivePlugin( $oneActivePlugin ) {
		// php info file about our plugin
		$ourPluginInfo = $this->_getPluginIdentificator()->getOurPluginInfoFile( $oneActivePlugin );
		// when its framework, continue
		if( $ourPluginInfo['plugin-name'] == 'fresh-framework') return;
		
		$pluginName = $ourPluginInfo['plugin-name'];
		$pluginVersion = $ourPluginInfo['plugin-version'];
		
		// if we already registered this plugin
		if( isset($this->_nonDuplicateActivePlugins[ $pluginName ] ) ) {
			// check if the new instance has bigger version
			if( $this->_nonDuplicateActivePlugins[ $pluginName ]['plugin-version'] < $pluginVersion ) {
				return $this->_setNonDuplicatePlugin( $oneActivePlugin, $pluginName, $pluginVersion);
			}
		} else {
			return $this->_setNonDuplicatePlugin( $oneActivePlugin, $pluginName, $pluginVersion);
		}
	}
	
	private function _getPluginDirAbsolute( $pluginFolderName ) {
		return $this->_getWplayer()->get_wp_plugin_dir() . '/' . $pluginFolderName;
	}
	
	private function _loadPlugins() {
		if( empty( $this->_nonDuplicateActivePlugins ) ) return false;
		
		
		foreach( $this->_nonDuplicateActivePlugins as $onePlugin ) {
			
			$pluginClass = $this->_instantiateOnePluginClass( $onePlugin );
			
			if( $pluginClass !== false ) {
				$this->_activePluginClasses[ $onePlugin['plugin-name'] ] = $pluginClass;
			}

		}		
	}
	
	private function _instantiateOnePluginClass( $onePlugin ) {
		$pluginDirAbsolute = $this->_getPluginDirAbsolute($onePlugin['plugin-name']);
		$pluginInfo = $this->_getPluginInfo( $pluginDirAbsolute );
		if( $pluginInfo == false ) return false;
		
		$pluginClass = $this->_createPluginClass( $pluginDirAbsolute, $pluginInfo);
		
		return $pluginClass;
	}
	
	/**
	 * Open our PHP file with function containing array with informations about
	 * the plugin. This array contains mainly a classname which we will be
	 * including and other stuff
	 * @param string $pluginDirClean
	 * @return string
	 */
	private function _getPluginInfo( $pluginDirClean ) {
		$pluginInfoFilePath = $pluginDirClean .'/bootstrap/infoFile.php';
		if( $this->_getFileSystem()->fileExists( $pluginInfoFilePath ) ) {
			require $pluginInfoFilePath;
			return $pluginInfo;
		} else {
			return false;
		}	
	}
	
	private function _createPluginClass( $pluginDirClean, $pluginInfo ) {
		if( !isset( $pluginInfo['mainClassName'] ) ) {
			throw new Exception('Trying to load PLUGIN which does not have defined plugininfo -> mainClassName' );
		}

		require $pluginDirClean .'/bootstrap/pluginClass.php';
	
		$pluginClassName = $pluginInfo['mainClassName'];
	
		$containerClassName = $pluginClassName . 'Container';
		require $pluginDirClean . '/bootstrap/container.php';
	
		
		$pluginContainerInstance =  call_user_func($containerClassName.'::getInstance', $this->_getContainer(), $pluginDirClean );
		
		
		$pluginClassInstance = new $pluginClassName( $pluginContainerInstance, $pluginDirClean );
	
		return $pluginClassInstance;
	}
		
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/

	/**
	 * @return ffWPLayer
	 */
	protected function _getWplayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $_WPLayer
	 */
	protected function _setWplayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	

	/**
	 * @return the ffContainer
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
	 * @return ffFileSystem
	 */
	protected function _getFileSystem() {
		return $this->_fileSystem;
	}
	
	/**
	 * @param ffFileSystem $fileSystem
	 */
	protected function _setFileSystem(ffFileSystem $fileSystem) {
		$this->_fileSystem = $fileSystem;
		return $this;
	}

	/**
	 * @return ffPluginIdentificator
	 */
	protected function _getPluginIdentificator() {
		return $this->_pluginIdentificator;
	}
	
	/**
	 * @param ffPluginIdentificator $pluginIdentificator
	 */
	protected function _setPluginIdentificator(ffPluginIdentificator $pluginIdentificator) {
		$this->_pluginIdentificator = $pluginIdentificator;
		return $this;
	}
			
}