<?php

class ffFileManager extends ffBasicObject {

	public function unzipFile( $zipFilePath, $unzipFilePath ) {
		if( !file_exists( $unzipFilePath) ) {
			mkdir( $unzipFilePath, '0755', true);
			chmod( $unzipFilePath, 0755);
		} 
		
		if( class_exists('ZipArchive') ) {
			$zip = new ZipArchive();
			$res = $zip->open( $zipFilePath );
			if( true === $res ) {
				$zip->extractTo( $unzipFilePath );
				$zip->close();
			}
		}		
	}
	
	
	public function readFolderRecursive( $path, $loadedFiles = array() ) {
		if( substr( $path, -1) != '/' ) {
			$path = $path . '/';
		}
	
		$elementsInCurrentFolder = $this->readFolder($path);
	
		foreach( $elementsInCurrentFolder as $oneElement ) {
			if( $oneElement['type'] == 'file' ) {
				$loadedFiles[] = $oneElement;
	
			} else if( strpos($oneElement['path'], '.git' ) === false ) {
				$loadedFiles = array_merge( $loadedFiles, $this->readFolderRecursive($oneElement['path']  ) );
			}
		}
	
		return $loadedFiles;
	}
	
	public function readFolder( $path ) {
		$listOfElements = array();
		if( substr( $path, -1) !== '/' ) {
			$path = $path . '/';
		}
	
		if( is_dir( $path ) ) {
			if( $dirHandle = opendir( $path ) ) {
				while( ( $file = readdir( $dirHandle ) ) !== false ) {
					$fileType = filetype( $path . $file );
						
					if( ( $fileType == 'file' || $fileType == 'dir' ) && $file != '.' && $file != '..' ) {
						$oneElement = array( 'path' => $path.$file, 'type' => $fileType );
						$listOfElements[] = $oneElement;
					}
				}
	
				closedir($dirHandle);
			}
		}
	
		sort($listOfElements);
		// return sorted array
		return $listOfElements;
	}
	
	public function getFile( $path ) {
		return file_get_contents( $path );
	}
	
	public function setFile( $path, $data ) {
		return file_put_contents( $path , $data );
	}
}