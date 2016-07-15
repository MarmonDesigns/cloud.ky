<?php

class ffImageInformator extends ffBasicObject {
	
	private $_imageUrl = null;
	
	private $_imagePath = null;
	
	private $_fileSystem = null;
	
	private $_imageExists = false;
	
	public function __construct( ffFileSystem $fileSystem ) {
		$this->_setFileSystem($fileSystem);
	}
	
	public function getImageInfo() {

	}
	
	public function getImageDimensions() {
		if( !$this->_imageExists ) {
			$imageDimensions = new stdClass();
			
			$imageDimensions->width = 1;
			$imageDimensions->height = 1;
			
			return $imageDimensions;
		}	
 	
		
		$imageDimensionsPHP = getimagesize( $this->_imagePath );

		$imageDimensions = new stdClass();
		$imageDimensions->width = $imageDimensionsPHP[0];
		$imageDimensions->height = $imageDimensionsPHP[1];
		$imageDimensions->type = $imageDimensionsPHP[2];
		
		return $imageDimensions;
	}
	
	public function setImageUrl( $imageUrl ) {
		$this->_imageExists = false;
		$this->_imageUrl = $imageUrl;
		$this->_imagePath = $this->_getFileSystem()->findFileFromUrl( $imageUrl );
		
		if( $this->_getFileSystem()->fileExists( $this->_imagePath ) ) {
			
			$pathInfo = pathinfo($this->_imagePath);
			
			if( isset( $pathInfo['extension'] ) ) {
			
				$this->_imageExists = true;
			}
		}
	}
	
	private function _setFileSystem( ffFileSystem $fileSystem ) {
		$this->_fileSystem = $fileSystem;
	}
	
	private function _getFileSystem() {
		return $this->_fileSystem;
	}
	
}