<?php
class ffPluginIdentificator extends ffBasicObject {
	const FF_PLUGIN_NAME = 'freshplugin.php';
	const FF_PLUGIN_INFO_NAME = 'info.php';
	/**
	 * @var ffWPLayer
	 */
	private $WPLayer = null;
	
	/**
	 * 
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;
	
	private $_ourActivePlugins = null;
	
	private $_ourActivePluginsInfo = array();
	
	private $_ourActivePluginsInfoFile = array();
	
	private $_ourAllPlugins = null;
	
	private $_pluginDir = null;
	
	public function __construct( ffWPLayer $WPLayer, ffFileSystem $fileSystem ) {
		$this->_setWPLayer($WPLayer);
		$this->_setFileSystem($fileSystem);
	}
	
	private function _isPluginActive( $folderName ) {
		$activePlugins = $this->getOurActivePlugins();
		if( !is_array( $activePlugins ) ) {
			return false;
		}
		return in_array( $folderName, $activePlugins);
	}
	
	public function getAllPluginInfo() {
		return $this->_getWPLayer()->get_plugins();
	}
	
	public function getAllThemesInfo() {
		return $this->_getWPLayer()->wp_get_themes();
	}
	
	/**
	 * Find if the plugin exists, doesn't matter if its active or not. The
	 * name is from the info file, like "Fresh Minificator" or "Twitter Widget" 
	 * @param string $pluginName
	 */
	public function findPluginByName( $pluginName ) {
		$allOurPlugins = $this->getOurAllPlugins();
		
		if( empty( $allOurPlugins ) ) {
			return false;
		}
		
		$foundPlugins = array();
		
		foreach( $allOurPlugins as $onePlugin ) {
			$onePluginInfo = $this->getOurPluginInfo( $onePlugin );
			if( $onePluginInfo['Name'] == $pluginName ) {
				$onePluginInfo['FolderName'] = $onePlugin;
				$onePluginInfo['IsActive'] = $this->_isPluginActive($onePlugin);
				$foundPlugins[] = $onePluginInfo;
			}
		}
		
		if( empty( $foundPlugins ) ) {
			return false;
		} 
		
		return $foundPlugins;
		/*if( count( $foundPlugins ) == 1 ) {
			return array_pop( $foundPlugins );
		} else {
			return $foundPlugins;
		}*/
	}
	
	
	public function findOurActivePluginBySlug( $slug ) {
		$slug = str_replace('/freshplugin.php','', $slug);
		return $this->getOurPluginInfo( $slug );
	}
	
	public function getOurActivePlugins() {
		if( $this->_ourActivePlugins == null ) {
			$this->_identificateOurActivePlugins();
		}
		if( empty( $this->_ourActivePlugins ) ) {
			$this->_ourActivePlugins = array();
		}
		return $this->_ourActivePlugins;
	}
	
	public function getOurAllPlugins() {
		if( $this->_ourAllPlugins == null ) {
			$this->_identificateOurAllPlugins();
		}
		
		return $this->_ourAllPlugins;
	}
	
	public function getOurPluginVersion( $pluginName ) {
		$this->getOurPluginInfo( $pluginName );
		if( !isset( $this->_ourActivePluginsInfo[ $pluginName]['Version'] ) ) {
			throw new Exception('Plugin :'.$pluginName .' does not have version defined');
		}
		
		return $this->_ourActivePluginsInfo[ $pluginName ]['Version'];
	}
	
	public function getOurPluginInfo( $pluginName ) {
		if( !isset( $this->_ourActivePluginsInfo[ $pluginName ] ) ) {
			$fileDir = $this->_getPluginDir() . '/' . $pluginName . '/' . ffPluginIdentificator::FF_PLUGIN_NAME;
			if( !$this->_getFileSystem()->fileExists( $fileDir) ) {
				return false;
			}
			
		
			$this->_ourActivePluginsInfo[ $pluginName ] = $this->getPluginInfoFromPath( $fileDir );
			
		}
		
		return $this->_ourActivePluginsInfo[ $pluginName ];
	}
	
	public function getPluginInfoFromPath( $path ) {
		$default_headers = array(
				'Name' => 'Plugin Name',
				'PluginURI' => 'Plugin URI',
				'Version' => 'Version',
				'Description' => 'Description',
				'Author' => 'Author',
				'AuthorURI' => 'Author URI',
				'TextDomain' => 'Text Domain',
				'DomainPath' => 'Domain Path',
				'Dependency' => 'Dependency',
		);
		
		return $this->_getWPLayer()->get_file_data( $path, $default_headers );
	}
	
	public function getOurPluginInfoFile( $pluginName ) {
		if( !isset( $this->_ourActivePluginsInfoFile[ $pluginName ] ) ) {
			$fileDir = $this->_getPluginDir() . '/' . $pluginName . '/' . ffPluginIdentificator::FF_PLUGIN_INFO_NAME;
			if( !$this->_getFileSystem()->fileExists( $fileDir ) ) {
				return false;
			}
			require_once $fileDir;
			$this->_ourActivePluginsInfoFile[ $pluginName ] = $info;
		}
		
		return $this->_ourActivePluginsInfoFile[ $pluginName ];
	}
	
	public function identificateOurAllPlugins() {
		$ourPlugins =  $this->_identificateOurAllPlugins();
		if( empty( $ourPlugins ) ) return array();
		return $ourPlugins;
	}
	
	private function _identificateOurAllPlugins() {
		$wpPluginDir = $this->_getFileSystem()->getDirPlugins();
		
		$wpPluginDirList= $this->_getFileSystem()->dirlist( $wpPluginDir );
		
		if( empty( $wpPluginDirList ) ) return false;
		
		foreach( $wpPluginDirList as $oneDir ) {
			if( $oneDir['type'] !== 'd' ) continue;
			
			if( $this->_getFileSystem()->fileExists( $wpPluginDir . '/' . $oneDir['name'] .'/freshplugin.php') ) {
				$this->_ourAllPlugins[] = $oneDir['name'];
			}
		}
		
		return $this->_ourAllPlugins;
	}
	
	private function _identificateOurActivePlugins() {
		$allActivePlugins = $this->_getWPLayer()->get_option('active_plugins');
		
		if( empty( $allActivePlugins ) ) {
			return false;
		}
		
		foreach( $allActivePlugins as $oneActivePlugin ) {
			if( false !== strpos( $oneActivePlugin, ffPluginIdentificator::FF_PLUGIN_NAME ) ) {
				$pluginName = str_replace('/'. ffPluginIdentificator::FF_PLUGIN_NAME, '', $oneActivePlugin );
				$this->_ourActivePlugins[] = $pluginName;
			}	
		}
		
		return true;
	}
	
	
	private function _getPluginDir() {
		if( $this->_pluginDir == null ) {
			$this->_pluginDir = $this->_getWPLayer()->get_plugin_base_dir();
		}
		
		return $this->_pluginDir;
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
	
	
}