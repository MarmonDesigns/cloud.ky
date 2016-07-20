<?php

class ffMenuJavascriptSaver extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

    /**
     * @var ffScriptEnqueuer
     */
    private $_scriptEnqueuer = null;

    /**
     * @var ffRequest
     */
    private $_request = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

    private $_menuHasBeenEnabled = false;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffScriptEnqueuer $scriptEnqueuer, ffRequest $request) {
        $this->_setScriptEnqueuer( $scriptEnqueuer );
        $this->_setRequest( $request );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

    public function enableMenuJavascriptSave() {
        if( $this->_menuHasBeenEnabled == true ) {
            return;
        }

        $this->_menuHasBeenEnabled = true;
        $this->_getScriptEnqueuer()->addScriptFramework('ff-menu-javascript-save', '/framework/themes/menuOptions/assets/menuJavascriptSave.js');

        $this->_unserializeOurPostVariable();
    }


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _unserializeOurPostVariable() {
        if( $this->_getRequest()->post('ff-navigation-menu-serialized') ) {
            $ourPostSerialized = $this->_getRequest()->post('ff-navigation-menu-serialized');
            $postUnserialized = array();

            $this->_customParseString($ourPostSerialized, $postUnserialized);

            $this->_getRequest()->setPost( $postUnserialized );
        }

    }

    private function _customParseString($string, &$result) {
        if($string==='') return false;
        $result = array();
        // find the pairs "name=value"
        $pairs = explode('&', urldecode($string));
        foreach ($pairs as $pair) {
            // use the original parse_str() on each element
            parse_str($pair, $params);
            $k=key($params);
            if(!isset($result[$k])) $result+=$params;
            else $result[$k]+=$params[$k];
        }
        return true;
    }

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return ffScriptEnqueuer
     */
    private function _getScriptEnqueuer()
    {
        return $this->_scriptEnqueuer;
    }

    /**
     * @param ffScriptEnqueuer $scriptEnqueuer
     */
    private function _setScriptEnqueuer($scriptEnqueuer)
    {
        $this->_scriptEnqueuer = $scriptEnqueuer;
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


}