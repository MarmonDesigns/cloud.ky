<?php

/**
 * Class ffImageHttpManager
 *
 * Sometimes we need to resize image in another thread. So we just insert proper url to the <img src=""> like
 * yoursite.com/?ff_trigger_http_action=1&ff_image_hash_to_resize=xxxx. This class actually catch the action and then
 * it resize the image or do whatever we need to do with it
 *
 * @since 1.8.20
 * @author thomas
 */
class ffImageHttpManager extends  ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    /**
     * @var ffHttpAction
     */
    private $_httpAction = null;

    /**
     * @var ffImageServingObject
     */
    private $_imageServingObject = null;

    /**
     * @var ffFileSystem
     */
    private $_fileSystem = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffWPLayer $WPLayer, ffHttpAction $httpAction, ffImageServingObject $imageServingObject, ffFileSystem $fileSystem ) {
        $this->_setWPLayer( $WPLayer );
        $this->_setHttpAction( $httpAction );
        $this->_setImageServingObject( $imageServingObject);
        $this->_setFileSystem( $fileSystem );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function hookActions() {
        $this->_WPLayer->add_action('ff_http_request_resize_and_serve_image', array( $this, 'actResizeAndServeImage') );
    }

    public function actResizeAndServeImage( $parameters ) {

        if( !isset( $parameters['image_name'] ) ) {
            return false;
        }

        $imageOptionName = $parameters['image_name'];

        $imageData = $this->_getWPLayer()->get_option( $imageOptionName );

        if( $imageData == null ) {
            die();
        }

        $this->_getWPLayer()->delete_option( $imageOptionName );

        ffContainer()->getClassLoader()->loadClass('externFreshizer');
        $newUrl = fImg::resize( $imageData['url'], $imageData['width'], $imageData['height'], $imageData['crop'], false, false);

        $path = $this->_getFileSystem()->findFileFromUrl( $newUrl );

        $this->_getImageServingObject()->serveImage( $path );



    }

    public function getImageLinkForResize( $url, $width, $height, $crop  ) {
        $data = array();

        $data['url'] = $url;
        $data['width'] = $width;
        $data['height'] = $height;
        $data['crop'] = $crop;

        $hash = md5( $url . $width . $height . $crop );

        $optionName = 'ff_img_'.$hash;

        $this->_getWPLayer()->update_option( $optionName, $data );

        $url = $this->_getHttpAction()->generateActionUrl('ff_http_request_resize_and_serve_image', array('image_name' => $optionName ) );

        return $url;
    }

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return ffWPLayer
     */
    private function _getWPLayer()
    {
        return $this->_WPLayer;
    }

    /**
     * @param ffWPLayer $WPLayer
     */
    private function _setWPLayer($WPLayer)
    {
        $this->_WPLayer = $WPLayer;
    }

    /**
     * @return ffHttpAction
     */
    private function _getHttpAction()
    {
        return $this->_httpAction;
    }

    /**
     * @param ffHttpAction $httpAction
     */
    private function _setHttpAction($httpAction)
    {
        $this->_httpAction = $httpAction;
    }

    /**
     * @return ffImageServingObject
     */
    private function _getImageServingObject()
    {
        return $this->_imageServingObject;
    }

    /**
     * @param ffImageServingObject $imageServingObject
     */
    private function _setImageServingObject($imageServingObject)
    {
        $this->_imageServingObject = $imageServingObject;
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





}