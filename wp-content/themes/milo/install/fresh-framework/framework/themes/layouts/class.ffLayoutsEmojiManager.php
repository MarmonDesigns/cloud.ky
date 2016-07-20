<?php

class ffLayoutsEmojiManager extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    /**
     * @var ffScriptEnqueuer
     */
    private $_scriptEnqueuer = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_disablePreviewButtonInPages = false;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffWPLayer $WPLayer, ffScriptEnqueuer $scriptEnqueuer ) {
        $this->_setWPLayer( $WPLayer );
        $this->_setScriptEnqueuer( $scriptEnqueuer );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function unregisterEmojiAtLayoutAdminScreen() {
        if( $this->_getWPLayer()->is_admin() && !$this->_getWPLayer()->is_ajax() ) {
            $this->_getWPLayer()->add_action('admin_print_scripts', array( $this, 'actAdminPrintScripts' ), 1);
            $this->_getWPLayer()->add_action('current_screen', array( $this, 'actCurrentScreen' ) );
        }
    }
    public function actAdminPrintScripts() {
        $currentScreen = $this->_getWPLayer()->get_current_screen();
        $currentScreenId = $currentScreen->id;

        if( strpos( $currentScreenId, 'ff-layout') !== false || strpos( get_page_template(), 'page-onepage') !== false || $currentScreenId == 'page' ) {
            $this->_unregisterEmoji();
        }

    }

    public function actCurrentScreen() {
        $currentScreen = $this->_getWPLayer()->get_current_screen();
        $currentScreenId = $currentScreen->id;

        $this->_disablePreviewButtonInPages = true;
        if( $this->_disablePreviewButtonInPages && $currentScreenId == 'page' ) {
            $this->_getScriptEnqueuer()->getFrameworkScriptLoader()->requireFrsLib();
            $this->_getScriptEnqueuer()->addScriptFramework('ff-previewButtonDisabler', 'framework/themes/layouts/assets/previewButtonDisabler.js');
        }
    }

    public function disablePreviewButtonInPages() {
        $this->_disablePreviewButtonInPages = true;
    }

//    public function disab
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _unregisterEmoji() {
         remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
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


}