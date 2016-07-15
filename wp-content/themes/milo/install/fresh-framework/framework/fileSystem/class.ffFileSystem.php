<?php

class ffFileSystem extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	const FILE_SYSTEM_METHOD_DIRECT = 'direct';
	/**
	 *
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	private $_WPFileSystem = null;
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffWPLayer $WPLayer, $WPFileSystem ) {
		$this->_setWPLayer($WPLayer);
		$this->_setWPFileSystem($WPFileSystem);
	}
	
	public function fileModifiedTime( $path ) {
		return $this->_getWPFileSystem()->mtime( $path );
	}
	
	public function locateFileInChildTheme( $relativePath, $returnUrlInsteadOfDir = false ) {
		
		if( !$this->_getWPLayer()->is_child_theme() ) {
			if( $returnUrlInsteadOfDir ) {
				return $this->_getWPLayer()->get_template_directory_uri().$relativePath;
			} else {
				return $this->_getWPLayer()->get_template_directory().$relativePath;
			}
		}
		
		$childThemePath = $this->_getWPLayer()->get_stylesheet_directory().$relativePath;

		if( $this->fileExists( $childThemePath ) ) {
			if( $returnUrlInsteadOfDir ) {
				return $this->_getWPLayer()->get_stylesheet_directory_uri().$relativePath;
			} else {
				return $this->_getWPLayer()->get_stylesheet_directory().$relativePath;
			}
		} else {
			if( $returnUrlInsteadOfDir ) {
				return $this->_getWPLayer()->get_template_directory_uri().$relativePath;
			} else {
				return $this->_getWPLayer()->get_template_directory().$relativePath;
			}
		}
		
	}

    public function fileExistsInChildTheme( $relativePath ) {
        $childThemePath = $this->_getWPLayer()->get_stylesheet_directory().$relativePath;
        return $this->fileExists( $childThemePath );
    }

    /**
     * @param $ffRelativePath
     * @param array $ffArgumentsArray
     *
     * requires file in child theme. If the file has suffix "before" or "after, it requires these files as well.
     * This way you can avoid overloading the files and you can just attach your code at the end of the file,
     * like a boss :-)
     */
    public function requireFileInChildTheme( $ffRelativePath, $ffArgumentsArray = null ) {
        if( is_array( $ffArgumentsArray ) ) {
            extract( $ffArgumentsArray );
        }

        $ffFilePathInfo = pathinfo( $ffRelativePath );

        if( isset( $ffFilePathInfo['extension'] ) && $ffFilePathInfo['extension'] == 'php' ) {
            $ffFilePathInfoBefore = str_replace('.php', '-before.php', $ffRelativePath);

            if( $this->fileExistsInChildTheme( $ffFilePathInfoBefore ) ) {
                $ffAbsolutePathBefore = $this->locateFileInChildTheme( $ffFilePathInfoBefore );
                require $ffAbsolutePathBefore;
            }

        }

        $ffAbsolutePath = $this->locateFileInChildTheme( $ffRelativePath );

        require $ffAbsolutePath;

        if( isset( $ffFilePathInfo['extension'] ) && $ffFilePathInfo['extension'] == 'php' ) {
            $ffFilePathInfoAfter = str_replace('.php', '-after.php', $ffRelativePath);

            if( $this->fileExistsInChildTheme( $ffFilePathInfoAfter ) ) {
                $ffAbsolutePathAfter = $this->locateFileInChildTheme( $ffFilePathInfoAfter );
                require $ffAbsolutePathAfter;
            }

        }
    }

	
	
	
	public function getAbsPath() {
		return $this->_getWPLayer()->get_absolute_path();
	}
	
	public function fileExists( $path ) {
		return file_exists( $path );
	}
	
	public function makeDir($path, $chmod = false, $chown = false, $chgrp = false) {
		return $this->_getWPFileSystem()->mkdir($path, $chmod, $chown, $chgrp );
	}
	
	public function makeDirRecursive( $path ) {
		$this->_getWPLayer()->wp_mkdir_p($path);
	}
	
	public function putContents( $file, $contents, $mode = false ) {
		return $this->_getWPFileSystem()->put_contents( $file, $contents, $mode );
	}
	
	public function getFileHashBasedOnPathAndTimeChange( $path ) {
		if( !$this->fileExists( $path ) ) {
			return false;
		}
		
		$timeLastChanged = $this->fileModifiedTime( $path );

		$stringToHash = $path . $timeLastChanged;
		
		$hashedString = md5( $stringToHash );
		
		return $hashedString;
	}
	
	public function putContentsGzip( $file, $contents ) {
		$gz = @gzopen( $file, "w9");
		if( $gz ){
			gzwrite($gz, $contents);
			gzclose($gz);
		}
	}
	
	public function canonicalizePath($address)
	{
		$address = explode('/', $address);
		$keys = array_keys($address, '..');
	
		foreach($keys AS $keypos => $key)
			array_splice($address, $key - ($keypos * 2 + 1), 2);
	
		$address = implode('/', $address);
		$address = str_replace('./', '', $address);

		// 8 == strlen('https://')
		$address_1 = substr($address, 0,8);
		$address_2 = substr($address, 8);
		$address_2 = str_replace('//', '/', $address_2);
		return $address_1.$address_2;
	}

	public function getRelativePath( $from, $to ){
		$from = $this->canonicalizePath( trim( $from ) );
		$to   = $this->canonicalizePath( trim( $to ) );

		if( substr($from, 0,8) != substr($to, 0,8) ){
			throw new Exception("getRelativePath: Cannot get relative path:<br/>FROM: $from<br/>TO: $to", 1);
			exit;
		}

		$from = substr($from, 8);
		$to = substr($to, 8);

		// var_dump($from);
		// var_dump($to);

		$base = $from . ' ';

		for( $i=0; $i<100; $i++ ){
			if( 0 === strpos($from, $base) ){
				if( 0 === strpos($to, $base) ){
					break;
				}
			}
			$base = dirname($base);
		}

		$base_len = strlen( $base );

		if( $base == dirname($to) ){
			$to = str_replace( dirname($to), '', $to);
			return '.'.$to;
		}

		$from = substr($from, $base_len);
		$to   = substr($to,   $base_len);

		$from_dir = dirname($from . ' ' );
		$to_dir   = dirname($to   . ' ' );

		$from_dir = str_replace('//', '/', $from_dir);
		$to_dir   = str_replace('//', '/', $to_dir);

		$dot_dot_count = substr_count( $from_dir, '/');

		// $ret = str_repeat('../', $dot_dot_count) . substr($to, 1);
		// var_dump($ret);
		// exit;
		return str_repeat('../', $dot_dot_count) . substr($to, 1);
	}

	public function isDir( $path ) {
		
		return $this->_getWPFileSystem()->is_dir( $path );
	}

    public function chmod( $file, $mode = false, $recursive = false ) {
        return $this->_getWPFileSystem()->chmod( $file, $mode, $recursive );
    }

    public function is_writable( $file ) {
        return $this->_getWPFileSystem()->is_writable( $file );
    }

	public function putContentsAtEndOfFile( $file, $contents, $mode = false ) {
		if( $this->_getWPFileSystem()->method == ffFileSystem::FILE_SYSTEM_METHOD_DIRECT ) {
			if ( ! ($fp = @fopen($file, 'a')) )
				return false;
			@fwrite($fp, $contents);
			@fclose($fp);
			$this->_getWPFileSystem()->chmod($file, $mode);
			return true;
		} else {
			//TODO made for other types
		}
	}
	
	public function getFileSystemMethod() {
		return $this->_getWPFileSystem()->method;
	}
	
	public function copy($source, $destination, $overwrite = false, $mode = false) {
		
		//function copy_dir($from, $to, $skip_list = array() ) {
		
		return $this->_getWPFileSystem()->copy( $source, $destination, $overwrite, $mode );
	}
	
	
	public function copyDir($from, $to, $skip_list = array() ) {
		return $this->_getWPLayer()->copy_dir( $from, $to, $skip_list );	
	}

	public function move($source, $destination, $overwrite = false) {		
		return $this->_getWPFileSystem()->move( $source, $destination, $overwrite );
	}
	
	public function getContents( $path ) {
		return $this->_getWPFileSystem()->get_contents( $path );
	}
	
	public function file( $path ) {
		return explode("\n", $this->getContents( $path ) );
	}
	
	public function delete( $path, $recursive = false, $type = false ) {
		$this->_getWPFileSystem()->delete( $path, $recursive, $type );
	}


	public function findFileFromUrl( $url ) {
		// TODO FOR WORDPRESS MU
		$homeUrl = $this->_getWPLayer()->get_home_url();
		$homePath = $this->_getWPLayer()->get_home_path();

		// replace "http://" and "https://" to "//"
		$homeUrl = ( 0 === strpos($homeUrl, 'https:') )
					? substr($homeUrl, strlen('https:') )
					: $homeUrl;

		$homeUrl = ( 0 === strpos($homeUrl, 'http:') )
					? substr($homeUrl, strlen('http:') )
					: $homeUrl;

		$url = ( 0 === strpos($url, 'https:') )
					? substr($url, strlen('https:') )
					: $url;

		$url = ( 0 === strpos($url, 'http:') )
					? substr($url, strlen('http:') )
					: $url;

		if( strpos($url, '//') !== 0 ) {
			$url = $homeUrl . $url;
		}

		// http://localhost/wp/wp-content/uploads/something.jpg -> /wp-content/uploads/something.jpg
		$withoutBase = str_replace( $homeUrl,'', $url );

		$absolutePath = untrailingslashit( $homePath ) . $withoutBase;

		if( file_exists( $absolutePath ) ) {
			return $absolutePath;
		} else {
			return false;
		}
	}

	public function zipDir( $dir, $to, $basename = null) {
		$zipArchive = new ZipArchive();
		$zipArchive->open( $to, ZipArchive::CREATE );
		
		if( empty( $basename ) ){
			$dirItems = $this->dirlist( $dir );
			if( !empty($dirItems) ){
				foreach ( $dirItems as $oneItem ) {
					if( $oneItem['type'] == 'd' ){
						$this->_addFolderToZip( $dir. '/'.$oneItem['name'], $zipArchive, $oneItem['name'] );
					} else {
						$zipArchive->addFile( $dir . '/'. $oneItem['name'], $oneItem['name']);
					}
				} 
			}
		}else{
			$this->_addFolderToZip($dir, $zipArchive, $basename);
		}
		
		$zipArchive->close();
	}
	
	private function _getRelativeDirPath( $dirPath, $fileName ) {
		if( $dirPath == null ) return $fileName;
		else return $dirPath .'/'.$fileName;
	}
	private function _addFolderToZip($baseDir, $zipArchive, $otherDirs = null){
		$baseDirList = $this->dirlist( $baseDir );
		if( empty( $baseDirList ) ) {
			return null;
		}
		foreach ($baseDirList as $oneItem ) {
			//if( $oneItem['name'] == '.git' || $oneItem['name'] == '.settings') continue;
			if( $oneItem['type'] == 'd' ){
				
				$this->_addFolderToZip( $baseDir. '/'.$oneItem['name'], $zipArchive, $otherDirs.'/'.$oneItem['name'] );
			} else {
				
				$zipArchive->addFile( $baseDir . '/'. $oneItem['name'], $this->_getRelativeDirPath($otherDirs, $oneItem['name']));
			}
		} 
	}
	
	
	public function unzipFile( $file, $to ) {
		return unzip_file($file, $to);
	}
	
	public function touch( $path ) {
		return touch( $path );
	}
	
	public function dirlist($path, $includeHidden = true, $recursive = false) {
		return $this->_getWPFileSystem()->dirlist( $path, $includeHidden, $recursive);
	}

	public function getDirPlugins() {
		return WP_PLUGIN_DIR;
	}

	public function getDirThemes() {
		return WP_CONTENT_DIR .'/themes';
	}

	public function getDirUpgrade( $additionalDir = '') {
        if( $additionalDir != '' ) {
            $additionalDir = '/'.$additionalDir;
        }
		return WP_CONTENT_DIR .'/upgrade' . $additionalDir;
	}

    public function isDirWritable( $path, $makeDirIfNotExists = true, $createTestFile = false ) {
        if( !$this->fileExists( $path ) ) {
            if( $makeDirIfNotExists ) {
                $this->makeDirRecursive( $path );

                if( !$this->fileExists( $path ) ) {
                    return false;
                }
            } else {
                return false;
            }
        }

        if( $createTestFile ) {
            $testFilePath = $this->_getWPLayer()->trailingslashit( $path ) . 'ff-fw-testing-file.txt';

            $this->putContents( $testFilePath, 'testing content');

            if( $this->fileExists( $testFilePath ) ) {
                $this->delete( $testFilePath );
                return true;
            } else {
                return false;
            }
        } else {
            return $this->is_writable( $path );
        }
    }
	
	public function getDirUploads() {
		return WP_CONTENT_DIR .'/uploads';
	}
	
	public function getDirUploadsFramework() {
		return WP_CONTENT_DIR .'/uploads/framework';
	}
	
	public function getDirUpgradePluginsInfoDir() {
		return WP_CONTENT_DIR .'/upgrade-plugins-info/';
	}
	
	public function requireOnce( $path ) {
		require_once( $path );
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	
	
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
	 * @return WP_Filesystem_Direct
	 */
	protected function _getWPFileSystem() {
		return $this->_WPFileSystem;
	}
	
	/**
	 * @param unknown_type $_WPFileSystem
	 */
	protected function _setWPFileSystem($WPFileSystem) {
		$this->_WPFileSystem = $WPFileSystem;
		return $this;
	}
	
	
}