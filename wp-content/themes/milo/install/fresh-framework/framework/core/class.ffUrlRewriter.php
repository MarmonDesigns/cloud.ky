<?php

class ffUrlRewriter extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    /**
     * @var ffRequest
     */
    private $_request = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_siteUrl = null;

    private $_pathUrl = null;

    private $_queryParams = null;

    private $_urlHasBeenDisassembled = false;

    private $_url = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct() {
        $this->_setWPLayer( ffContainer()->getWPLayer() );
        $this->_setRequest( ffContainer()->getRequest() );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function reset() {
        $this->_siteUrl = null;
        $this->_pathUrl = null;
        $this->_queryParams = null;
        $this->_urlHasBeenDisassembled = false;
        $this->_url = null;

        return $this;
    }

    public function setSiteUrl() {
        $this->setUrl( $this->_getWPLayer()->get_site_url() );

        return $this;
    }

    public function setUrl( $url ) {
        $this->_setUrl( $url );

        return $this;
    }

    public function getCurrentUrl() {
        return $this->_currentUrl();
    }

    public function getNewUrl() {
        $this->_disassembleUrl();

        return $this->_assembleUrl();
    }

    public function addQueryParameter( $name, $value ) {
        $this->_disassembleUrl();

        $this->_queryParams[ $name ] = $value;
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/



/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _assembleUrl() {
        $base = $this->_getWPLayer()->trailingslashit($this->_siteUrl);

        $path = implode('/', $this->_pathUrl );

        $query = '';

        if( is_array( $this->_queryParams ) ) {
            $query = http_build_query( $this->_queryParams );
        }

        if( !empty( $query ) ) {
            $query = '?' .$query;
        }

        $fullUrl = $base . $path . $query;

        return $fullUrl;
    }

    private function _disassembleUrl() {
        if( $this->_urlHasBeenDisassembled == true ) {
            return false;
        }

        // site url == localhost/wordpress
        $this->_siteUrl = $this->_getWPLayer()->get_site_url();


        // currentUrl = something like localhost/wordpress/wp-admin/tools.php?page=import&someVariable=xx
        $currentUrl = $this->_currentUrl();
        // currentUrlWithoutsite = wp-admin/tools.php?page=import&someVariable=xx
        $currentUrlWithoutSite = str_replace( $this->_siteUrl, '', $currentUrl );

        $urlParsed = parse_url( $currentUrlWithoutSite);

        // path = wp-admin/tools.php
        if( isset( $urlParsed['path'] ) ) {
            $pathSplitted = explode('/', ltrim($urlParsed['path'],'/') );

            $this->_pathUrl = $pathSplitted;
        }
        // query = page=import&someVariable=xx
        if( isset( $urlParsed['query'] ) ) {
            $query = $urlParsed['query'];

            $queryParsed = array();

            parse_str( $query, $queryParsed );

            $this->_queryParams = $queryParsed;
        }

        $this->_urlHasBeenDisassembled = true;
    }

    private function _currentUrl() {

        if( $this->_getUrl() != null ) {
            return $this->_getUrl();
        }

        $pageURL = 'http';
        $request = $this->_getRequest();

        if ( $request->server('HTTPS') == 'on' ) {
            $pageURL .= "s";
        }
        $pageURL .= "://";

        if ( $request->server('SERVER_POST') != 80 ){
            $pageURL .=
            $request->server('SERVER_NAME') . ':' . $request->server('SERVER_PORT') . $request->server('REQUEST_URI');
        }
        else {
            $pageURL .= $request->server('SERVER_NAME') . $request->server('REQUEST_URI');
        }
        return $pageURL;
    }
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
     * @return ffRequest
     */
    private function _getRequest()
    {
        return $this->_request;
    }

    /**
     * @param ffRequest $request
     */
    private function _setRequest($request)
    {
        $this->_request = $request;
    }

    /**
     * @return null
     */
    private function _getUrl()
    {
        return $this->_url;
    }

    /**
     * @param null $url
     */
    private function _setUrl($url)
    {
        $this->_url = $url;
    }


}