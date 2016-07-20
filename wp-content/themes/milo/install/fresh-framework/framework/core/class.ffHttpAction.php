<?php

class ffHttpAction extends  ffBasicObject {
    const PARAM_ACTION_TRIGGER = 'ff_http_action_trigger';
    const PARAM_ACTION_NAME = 'ff_http_action_name';
    const PARAM_ACTION_PARAMS = 'ff_http_action_params';
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffRequest
     */
    private $_request = null;

    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    /**
     * @var ffUrlRewriter
     */
    private $_URLRewriter = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct() {
        $this->_setRequest( ffContainer()->getRequest() );
        $this->_setWPLayer( ffContainer()->getWPLayer() );
        $this->_setURLRewriter( ffContainer()->getUrlRewriter() );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function checkForOurActionFired() {
        if( $this->_getRequest()->get( ffHttpAction::PARAM_ACTION_TRIGGER ) === null ) {
            return false;
        } else {
            $this->_callOurHttpAction();
        }
    }

    public function generateActionUrl( $actionName, $parameters = null) {
        $rewriter = $this->_getURLRewriter();

        $rewriter->reset();
        $rewriter->setSiteUrl();
        $rewriter->addQueryParameter( ffHttpAction::PARAM_ACTION_TRIGGER, 1);
        $rewriter->addQueryParameter( ffHttpAction::PARAM_ACTION_NAME, $actionName);
        $rewriter->addQueryParameter( ffHttpAction::PARAM_ACTION_PARAMS, $parameters);

        return $rewriter->getNewUrl();
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _callOurHttpAction() {
        $request = $this->_getRequest();
        $actionName = $request->get( ffHttpAction::PARAM_ACTION_NAME );
        $actionParams = $request->get( ffHttpAction::PARAM_ACTION_PARAMS );

        $this->_getWPLayer()->do_action( $actionName, $actionParams );
    }
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/

    /**
     * @return ffRequest
     */
    private function _getRequest() {
        return $this->_request;
    }

    /**
     * @param ffRequest $request
     */
    private function _setRequest($request) {
        $this->_request = $request;
    }

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
     * @return ffUrlRewriter
     */
    private function _getURLRewriter()
    {
        return $this->_URLRewriter;
    }

    /**
     * @param ffUrlRewriter $URLRewriter
     */
    private function _setURLRewriter($URLRewriter)
    {
        $this->_URLRewriter = $URLRewriter;
    }



}