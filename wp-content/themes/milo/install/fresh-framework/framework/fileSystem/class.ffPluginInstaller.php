<?php
/**
 * Install our plugins ( must have freshplugin.php and info.php files ). It
 * could be installed from ZIP file or Unpacked folder. Automatically detects
 * if there is lower version and if yes, the version is deleted and replaced
 * with the plugin.
 * 
 * @author boobs.lover
 */
class ffPluginInstaller extends ffBasicObject {
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
	private $_fileSystem = null;
	
	/**
	 * 
	 * @var ffPluginIdentificator
	 */
	private $_pluginIdentificator = null;
	
	private $_installedPlugins = array();

/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct(ffWPLayer $WPLayer, ffFileSystem $fileSystem, ffPluginIdentificator $pluginIdentificator) {
		$this->_setWPLayer($WPLayer);
		$this->_setFileSystem($fileSystem);
		$this->_setPluginIdentificator($pluginIdentificator);
	}	
	
	public function installPluginFromZipFile( $path, $deleteFileAfterSuccessfullInstall = true, $activatePluginAfterInstall = true ) {

        // check if plugin exists
        if( !$this->_getFileSystem()->fileExists( $path ) ) {
            throw new ffException('ffPluginInstaller - trying to install plugin, but it does not exists - ' . $path );
        }

        // check if upgrade dir is ok
        $fileSystem = $this->_getFileSystem();
        $upgradeDir = $fileSystem->getDirUpgrade();
        if( !$fileSystem->isDirWritable( $upgradeDir, true, true ) ) {
            return false;
        }

        // unzip plugin
        $upgradeDirIsolated = $this->_getWPLayer()->trailingslashit( $upgradeDir ) . 'ff-isolated';
        $fileSystem->delete( $upgradeDirIsolated, true );
        $fileSystem->makeDir( $upgradeDirIsolated );
        $hasBeenUnzipped = $fileSystem->unzipFile( $path, $upgradeDirIsolated);

        if( !$hasBeenUnzipped ) {
            return false;
        }

        // install plugin
        $contentOfIsolatedFolder = $fileSystem->dirlist( $upgradeDirIsolated );

        if( count( $contentOfIsolatedFolder  ) == 1 ) {
            $folderName = ( key( $contentOfIsolatedFolder ));
            $pluginFolderDir = $this->_getWPLayer()->trailingslashit( $upgradeDirIsolated ) . $folderName;
        } else {
            $pluginFolderDir = $upgradeDirIsolated;
        }

        $pluginHasBeenInstalled = $this->installPluginFromFolder( $pluginFolderDir );

        $fileSystem->delete( $upgradeDirIsolated, true );

        // activate and delete the plugin zip file
        if( $pluginHasBeenInstalled ) {
            if( $deleteFileAfterSuccessfullInstall ) {
                $fileSystem->delete( $path );
            }

            if( $activatePluginAfterInstall ) {
                $this->activateInstalledPlugins();
            }
            return true;
        } else {
            return false;
        }

	}
	
	public function installPluginFromFolder( $dir ) {
		
		// set time limit to 1k, just to have time :)
		@set_time_limit(999);
		
		$pluginInfo = $this->_getPluginInfo($dir);
	
		if( !$this->_canWeInstallNewPlugin( $pluginInfo ) ) {
			return false;
		}
		
		
		$oldPlugins = $this->_getPluginIdentificator()->findPluginByName( $pluginInfo['Name'] );
		// 0.) fire action "PRE UPDATE PLUGIN"
		$this->_getWPLayer()->getHookManager()->doActionPreUpdatePlugin( $pluginInfo['Name']);
		// 1.) deactivate the old plugin
		$this->_deactivateOldPlugins( $pluginInfo, $oldPlugins );
		// 2.) delete the old plugin
		$this->_deleteOldPlugins( $pluginInfo, $oldPlugins );
		// 3.) replace with the new plugin
		$this->_copyNewPlugin( $pluginInfo, $dir );
		// 4.) store information about the plugin for further activation
		$this->_addActiovationInformations($dir);
		
		//$this->_activateNewPlugin( $pluginInfo, $dir );
		// 5.) fire action "AFTER UPDATE PLUGIN"
		//TODO solve this, because plugins cannot yet register this action
		
		return true;
	}
	/**
	 * Activate all newly installed plugins in bulk. Because function
	 * activate plugin is cached, so if we activate the plugins by one, only
	 * the first one is activated.
	 * @return boolean
	 */
	public function activateInstalledPlugins() {
		if( empty( $this->_installedPlugins ) ) {
			return false;
		}
		
		foreach( $this->_installedPlugins as $onePlugin ) {
			$this->_getWPLayer()->activate_plugin( $onePlugin );
		}
	}
	
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	private function _addActiovationInformations( $dir ) {
		$pluginFolderName = basename( $dir );
		$pluginDir = $pluginFolderName . '/' . 'freshplugin.php';
		$this->_installedPlugins[] = $pluginDir;
	}
	
	private function _activateNewPlugin( $pluginInfo, $dir ) {
		$pluginFolderName = basename( $dir );
		$pluginDir = $pluginFolderName . '/' . 'freshplugin.php';
	
		$this->_getWPLayer()->activate_plugin( $pluginDir );
	}
	
	/**
	 * Copy the new plugin into the wp-content/plugins directories
	 * @param unknown $pluginInfo
	 * @param unknown $dir
	 */
	private function _copyNewPlugin( $pluginInfo, $dir ) {
		$pluginFolderName = basename( $dir );
		$destinationDirectory = $this->_getWPLayer()->get_plugin_base_dir() . '/' . $pluginFolderName;
		$this->_getFileSystem()->makeDir( $destinationDirectory );
		$this->_getFileSystem()->copyDir( $dir, $destinationDirectory );
	}
	
	private function _deleteOldPlugins( $pluginInfo, $oldPlugins ) {
		if( empty( $oldPlugins) ) {
			return true;
		}
	
		foreach( $oldPlugins as $onePlugin ) {
			$dir = $this->_getWPLayer()->get_plugin_base_dir() . '/' . $onePlugin['FolderName'];
			//$this->_getFileSystem()->delete( $dir, true );
		}
	}
	
	private function _deactivateOldPlugins( $pluginInfo, $oldPlugins ) {
		if( empty( $oldPlugins ) ) {
			return true;
		}
	
		foreach( $oldPlugins as $onePlugin ) {
			$pluginName = $onePlugin['FolderName'] . '/' . 'freshplugin.php';
				
			$this->_getWPLayer()->deactivate_plugins( $pluginName );
		}
	
		return true;
	}	
	/**
	 * Check if the new plugin is already installed. If is not, we can install.
	 * If is, we have to compare versions. If the new plugin has got greater
	 * version, then we install him. If not, we keep the old version
	 * @param unknown $newPluginInfo
	 */
	private function _canWeInstallNewPlugin( $newPluginInfo ) {
		
		$oldPluginName = $newPluginInfo['Name'];
		$oldPluginInfo = $this->_getPluginIdentificator()->findPluginByName($oldPluginName);
		
		// If the plugin does not exists, we definitely can install it
		if( $oldPluginInfo == false ) {
			return true;
		}

		// If the plugin exists, but all the versions are smaller than the our current one
		foreach( $oldPluginInfo as $oneOldPluginInfo ) {
			$versionCompare = version_compare( $newPluginInfo['Version'], $oneOldPluginInfo['Version']); 
				
			if( $versionCompare != 1 ) {
				return false;
			}
		}
			
		return true;
	}
	
	/**
	 * You give the folder as a parameter, it automatically reads the 
	 * freshplugin.php file and find the informations
	 * 
	 * @param string $dir
	 * @return boolean|Ambigous <multitype:, boolean, unknown, string>
	 */	
	private function _getPluginInfo( $dir ) {
		$pluginFile = $dir . '/freshplugin.php';
		
		if( !$this->_getFileSystem()->fileExists( $pluginFile) ) {
			return false;
		}
		
		
		
		$pluginInfo = $this->_getWPLayer()->get_plugin_data($pluginFile);
		
		return $pluginInfo;
	}
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
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