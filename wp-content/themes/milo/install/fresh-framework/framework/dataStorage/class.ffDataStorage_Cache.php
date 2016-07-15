<?php

class ffDataStorage_Cache extends ffBasicObject implements ffIDataStorage {
	const CACHING_DIR_NAME = 'freshframework';
	const CACHING_DATASTORAGE_NAMESPACE = 'cache_dir';
	const CACHING_LAST_DELETION_FILE_NAME = 'last_deletion';
	const CACHING_INFO_FILE_NAME = 'caching_info';
	const CACHING_LAST_DELETION_FILE_CONTENT = 'nothing';
	const FILE_AGE_SEC = 1;
	const FILE_AGE_MIN = 60;		// 60 * 1
	const FILE_AGE_HOUR = 3600; 	// 60 * 60
	const FILE_AGE_DAY = 86400;		// 60 * 60 * 24
	const FILE_AGE_MONTH = 2592000; // 60 * 60 * 24 * 30
	
	
	/**
	 * 
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;
	
	/**
	 * 
	 * @var ffDataStorage_WPOptions_NamespaceFacede
	 */
	private $_dataStorage = null;
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	private $_cacheDir = null;
	
	private $_cacheUrl = null;
	
	public function __construct( ffFileSystem $fileSystem, ffWPLayer $WPLayer, ffDataStorage_WPOptions_NamespaceFacede $dataStorage ) {
		$this->_setFileSystem($fileSystem);	
		$this->_setWPLayer($WPLayer);
		$this->_initializeCachingDir();
		$this->_setDataStorage( $dataStorage );
		$this->_getDataStorage()->setNamespace( ffDataStorage_Cache::CACHING_DATASTORAGE_NAMESPACE );
	}
	
	private function _initializeCachingDir() {
		if( !$this->_getFileSystem()->fileExists( $this->_getCacheDir() ) ) {
			$this->_getFileSystem()->makeDir( $this->_getCacheDir() );
		}
	}	
	
	private function _initializeNamespaceDir( $namespaceDirPath ) {
		
		if( !$this->_getFileSystem()->fileExists( $namespaceDirPath ) ) {
			$this->_getFileSystem()->makeDir( $namespaceDirPath );
		}
	}
	
	private function _touchLastDeletion( $namespace ) {
		$checkFilePath = $this->getOptionPath($namespace, ffDataStorage_Cache::CACHING_LAST_DELETION_FILE_NAME);
		$this->_getFileSystem()->putContents( $checkFilePath, ffDataStorage_Cache::CACHING_LAST_DELETION_FILE_CONTENT );
	}
	
	private function _getLastDeletion( $namespace ) {
		$checkFilePath = $this->getOptionPath($namespace, ffDataStorage_Cache::CACHING_LAST_DELETION_FILE_NAME);
		$fileLastChanged = time();
		if( $this->_getFileSystem()->fileExists( $checkFilePath ) ) {
			$fileLastChanged = $this->_getFileSystem()->fileModifiedTime( $checkFilePath );
		} else {
			$this->_getFileSystem()->putContents( $checkFilePath, ffDataStorage_Cache::CACHING_LAST_DELETION_FILE_CONTENT );
		}
		return $fileLastChanged;
	}
	
	public function getNumberOfOptionsInNamespace( $namespace ) {
		$namespaceDir = $this->getNamespacePath( $namespace );
		
		if( !$this->_getFileSystem()->fileExists( $namespaceDir) ) {
			return 0;
		}
		
		return count( $this->_getFileSystem()->dirlist( $namespaceDir ) );
	}

    public function getAllOptionNames( $namespace ) {
        $allFilesInNamespace = $this->_getFileSystem()->dirlist( $this->getNamespacePath( $namespace ) );

        $names = array_keys( $allFilesInNamespace );
        $toReturn = array();
        foreach( $names as $oneName ) {
            $pathInfo = pathinfo($oneName);

            if( $pathInfo['filename'] == 'caching_info' ) {
                continue;
            }

            $oneFile = array();
            $oneFile['name'] = $pathInfo['filename'];
            $oneFile['extension'] = $pathInfo['extension'];

            $toReturn[] = $oneFile;
            //var_dump( pathinfo($oneName) );
        }

        return $toReturn;
    }
	
	public function deleteOldFilesInNamespace( $namespace, $intervalCheck, $maximumFileAge ) {

		$listOfDeletedFiles = array();
		
		$fileLastChanged = $this->_getLastDeletion($namespace);
		
		if( ($fileLastChanged + $intervalCheck) < time() ) {

			$allFilesInNamespace = $this->_getFileSystem()->dirlist( $this->getNamespacePath( $namespace ) );
			
			$cacheFileContent = $this->getOption($namespace, ffDataStorage_Cache::CACHING_INFO_FILE_NAME, 'frs');
			$cacheFile = array();
			if( !empty( $cacheFileContent ) ) {
				$cacheFile = unserialize( $cacheFileContent );
			}
			
			if( !empty($allFilesInNamespace) ) {
				foreach( $allFilesInNamespace as $oneFile ) {
					
					if( $oneFile['name'] == ffDataStorage_Cache::CACHING_LAST_DELETION_FILE_NAME .'.frs' || $oneFile['name'] == ffDataStorage_Cache::CACHING_INFO_FILE_NAME .'.frs' ) {
						continue;
					}
					
					$pathInfo = pathinfo( $oneFile['name'] );
					
					// gz hack
					if( $pathInfo['extension'] == 'gz') {
						$cleanName = str_replace( '.gz', '', $oneFile['name']);
						$pathInfo = pathinfo( $cleanName );
						$pathInfo['extension'] = $pathInfo['extension'].'.gz';
					}
					
					
					//$lastMod = $this->getLastModifiedTime($namespace,  $pathInfo['filename'], $pathInfo['extension']);	
					$name = $this->_createNameForDataStorageOptions($namespace, $pathInfo['filename'], $pathInfo['extension']);
					
					
					
					
					$lastMod = 0;
					if( isset( $cacheFile[ $name ] ) ) {
						$lastMod = $cacheFile[ $name ];
					}
				
					
					if( $lastMod + $maximumFileAge < time() ) {	
						$this->_getFileSystem()->delete(  $this->getNamespacePath( $namespace ) .'/' . $oneFile['name']);
						unset( $cacheFile[ $name ] );
						$listOfDeletedFiles[] = $oneFile;
					}
				}
			}
			
			//$this->touch($namespace, ffDataStorage_Cache::CACHING_LAST_DELETION_FILE_NAME);
			$this->_touchLastDeletion($namespace);
			
			$cacheFileContent = serialize( $cacheFile );
			$this->setOption($namespace, ffDataStorage_Cache::CACHING_INFO_FILE_NAME, $cacheFileContent, 'frs');
		}
		
		return $listOfDeletedFiles;
	}
	
	public function deleteNamespace( $namespace ) {
		$this->_getFileSystem()->delete($this->getNamespacePath($namespace), true);
	}
	
	public function touch( $namespace, $name, $extension = 'frs' ) {
		$cacheFileContent = $this->getOption($namespace, ffDataStorage_Cache::CACHING_INFO_FILE_NAME, 'frs');
		
		$cacheFile = array();
		if( !empty( $cacheFileContent ) ) {
			$cacheFile = unserialize( $cacheFileContent );
		}
		$name = $this->_createNameForDataStorageOptions($namespace, $name, $extension);
		$time = time();
		$cacheFile[ $name ] = $time;
		
		$cacheFileContent = serialize( $cacheFile );
		
		$this->setOption($namespace, ffDataStorage_Cache::CACHING_INFO_FILE_NAME, $cacheFileContent, 'frs');
	}
	
	public function getLastModifiedTime( $namespace, $name, $extension = 'frs') {
		$name = $this->_createNameForDataStorageOptions($namespace, $name, $extension);
		return $this->_getDataStorage()->getOption($name);
	}
	
	private function _createNameForDataStorageOptions( $namespace, $name, $extension ) {
		$name = $namespace . $name . $extension;
		return $name;
	}
	
	
	public function setOption( $namespace, $name, $value, $extension = 'frs') {
		if( $name !== ffDataStorage_Cache::CACHING_INFO_FILE_NAME ) 
			$this->touch($namespace, $name, $extension);
		
		$namespaceDirPath = $this->_getCacheDir() .'/'. $namespace;
		$this->_initializeNamespaceDir($namespaceDirPath);
		
		$extension = '.'.$extension;
		
		$fullPath = $namespaceDirPath.'/'. $name . $extension;
		
		$this->_getFileSystem()->putContents( $fullPath, $value);
	}
	public function getOption( $namespace, $name, $extension = 'frs' ) {
		$extension = '.' . $extension;
		$fullPath = $this->_getCacheDir() .'/' . $namespace .'/' .$name . $extension;
		
		if( !$this->_getFileSystem()->fileExists( $fullPath ) ) {
			return null;
		}
		
		return $this->_getFileSystem()->getContents( $fullPath );
	}
	public function deleteOption( $namespace, $name, $extension = 'frs' ) {
		$extension = '.'.$extension;
		$fullPath = $this->_getCacheDir() .'/' . $namespace .'/' .$name . $extension;
		$this->_getFileSystem()->delete( $fullPath );
		$this->_getDataStorage()->deleteOption( $this->_createNameForDataStorageOptions($namespace, $name, $extension));
	}
	
	public function optionExists( $namespace, $name, $extension = 'frs') {
		$fullPath = $this->getOptionPath($namespace, $name, $extension);
		return $this->_getFileSystem()->fileExists( $fullPath );
	}
	
	public function getOptionPath( $namespace, $name, $extension = 'frs' ) {
		$extension = '.'.$extension;
		$fullPath = $this->_getCacheDir() .'/' . $namespace .'/'.$name . $extension;
		
		return $fullPath;
	}
	
	public function getNamespacePath( $namespace ) {
		return $this->_getCacheDir() .'/' . $namespace;
	}
	
	public function getOptionUrl( $namespace, $name, $extension = 'frs') {
		$extension = '.'.$extension;
		
		$fullPath = $this->_getCacheUrl() .'/' . $namespace . '/' . $name . $extension;
		
		return $fullPath;
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
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $_WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	private function _getCacheDir() {
		if( $this->_cacheDir == null ) {
			$uploadDir = $this->_getWPLayer()->wp_upload_dir();
			$this->_cacheDir =$uploadDir['basedir'].'/' . ffDataStorage_Cache::CACHING_DIR_NAME; //$this->_getWPLayer()->wp_upload_dir();
		}
		return $this->_cacheDir;
	}
	
	private function _getCacheUrl() {
		if( $this->_cacheUrl == null ) {
			$uploadDir = $this->_getWPLayer()->wp_upload_dir();
			$this->_cacheUrl = $uploadDir['baseurl'].'/'.ffDataStorage_Cache::CACHING_DIR_NAME;
		}
		if( is_ssl() ){
			$this->_cacheUrl = str_replace('http://', 'https://', $this->_cacheUrl);
		}

		return $this->_cacheUrl;
	}

	/**
	 * @return ffDataStorage_WPOptions_NamespaceFacede
	 */
	protected function _getDataStorage() {
		return $this->_dataStorage;
	}
	
	/**
	 * @param ffDataStorage_WPOptions_NamespaceFacede $dataStorage
	 */
	protected function _setDataStorage(ffDataStorage_WPOptions_NamespaceFacede $dataStorage) {
		$this->_dataStorage = $dataStorage;
		return $this;
	}
	

	
	
	
}