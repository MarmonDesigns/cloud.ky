<?php

class fImg_facade extends ffBasicObject {

    private $_fImg = null;

    /**
     * @var ffFileSystem
     */
    private $_fileSystem = null;

    /**
     * @var ffImageHttpManager
     */
    private $_imageHttpManager = null;

    public function __construct() {
        $this->_fImg = new fImg();

        $this->_setFileSystem( ffContainer()->getFileSystem() );

        $this->_setImageHttpManager( ffContainer()->getGraphicFactory()->getImageHttpManager() );

    }
/**********************************************************************************************************************/
/* WRAPPERS
/**********************************************************************************************************************/
    public function _resize($url, $width, $height = false, $crop = false, $returnImgSize = false, $resizeMultiThread = false) {
        if( $resizeMultiThread && $returnImgSize == false ) {
            $imageData = $this->_getImageData($url, $width, $height, $crop , true);
            if( $this->_getFileSystem()->fileExists( $imageData->new->path ) ) {
                $image = $this->_getfImg()->_resize($url, $width, $height, $crop, $returnImgSize);
                return $image;
            } else {
                return $this->_getImageHttpManager()->getImageLinkForResize( $url, $width, $height, $crop );
            }

        }

        $image = $this->_getfImg()->_resize($url, $width, $height, $crop, $returnImgSize);
        return $image;
    }


    public function _getImageData($url, $width, $height = false, $crop = false, $delivery = false) {
        return $this->_getfImg()->_getImageData( $url, $width, $height, $crop, $delivery );
    }

    public function _getImgSize($url) {
        return $this->_getfImg()->_getImgSize($url);
    }


    protected function _getfImg() {
        return $this->_fImg;
    }

    /**
     * @return ffFileSystem
     */
    private function _getFileSystem()
    {
        return $this->_fileSystem;
    }

    /**
     * @param ffFileSystem $fileSystem
     */
    private function _setFileSystem($fileSystem)
    {
        $this->_fileSystem = $fileSystem;
    }

    /**
     * @return ffImageHttpManager
     */
    private function _getImageHttpManager()
    {
        return $this->_imageHttpManager;
    }

    /**
     * @param ffImageHttpManager $imageHttpManager
     */
    private function _setImageHttpManager($imageHttpManager)
    {
        $this->_imageHttpManager = $imageHttpManager;
    }

}