<?php
/**
 * Loads only one framework even when other versions are active -> preventing
 * to load multiple versions and fail
 */
if( !class_exists('ffFrameworkVersionManager') ) {
	class ffFrameworkVersionManager {
		private static $_instance = null;
		
		public static function getInstance() {
			if( self::$_instance == null ) {
				self::$_instance = new ffFrameworkVersionManager();
			}
			
			return self::$_instance;
		}
		
		private $_registeredVersions = array();
		private $_installedVersions = array();
		private $_duplicateVersions = array();
		
		private $_latestRegistered = null;
		private $_latestInstalled = null;
		
		private $_hasBeenInit =false;
	
	
		
		private function _isInstalledTest( $bootstrapPath ) {
			if( basename(dirname(dirname(dirname( $bootstrapPath )) )) !== basename(WP_PLUGIN_DIR) ) {
				return false;
			} else {
				return true;
			}
		}
		
		public function addVersion( $version, $bootstrapPath, $frameworkDir, $frameworkUrl ) {
			$isInstalled = $this->_isInstalledTest( $bootstrapPath );
			$fwVersion = array();
			$fwVersion['version'] = $version;
			$fwVersion['bootstrapPath'] = $bootstrapPath;
			$fwVersion['frameworkDir'] = $frameworkDir;
			$fwVersion['frameworkUrl'] = $frameworkUrl;
			$fwVersion['isInstalled'] = $isInstalled;
			
			if( isset( $this->_registeredVersions[ $version ] ) ) {
				$this->_duplicateVersions[] = $fwVersion;
			} else {
				$this->_registeredVersions[ $version ] = $fwVersion;
				
				if( $isInstalled ) {
					$this->_installedVersions[ $version ] = $fwVersion;
				}
			}
		}
		
		public function initFrameworkFromTemplate() {
			$this->initFramework();
		}

        public function initFrameworkFromPlugin() {
            $this->initFramework();
        }
		
		public function initFramework() {

			if( $this->_hasBeenInit == true ) {
				return;
			}

			$this->_hasBeenInit = true;

			krsort( $this->_registeredVersions );

			$this->_latestRegistered =  end($this->_registeredVersions);


			DEFINE('FF_FRAMEWORK_DIR', $this->_latestRegistered ['frameworkDir']);
			DEFINE('FF_FRAMEWORK_URL', $this->_latestRegistered ['frameworkUrl']);

			if( !empty( $this->_installedVersions ) ) {
				krsort( $this->_installedVersions );
				$this->_latestInstalled = end( $this->_installedVersions );
			}

			DEFINE( 'FF_FRAMEWORK_IS_INSTALLED', $this->_latestRegistered['isInstalled'] );

			require_once $this->_latestRegistered['bootstrapPath'];
		}

		public function getLatestRegisteredVersion() {
			return $this->_latestRegistered['version'];
		}

		public function getLatestInstalledVersion() {
			if( !empty( $this->_latestInstalled ) ) {
				return $this->_latestInstalled['version'];
			} else {
				return null;
			}
		}

		public function getDuplicatedVersions() {
			return $this->_duplicateVersions;
		}
	}
	
	add_action('plugins_loaded', array( ffFrameworkVersionManager::getInstance(), 'initFramework'));
}