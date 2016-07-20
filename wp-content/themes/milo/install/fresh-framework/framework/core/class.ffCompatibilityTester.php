<?php

/**
 * Class ffCompatibilityTester
 *
 * Run series of tests which determine if there could be any incompatibilities from our framework
 *
 *
 * @since 1.8.20
 * @author thomas
 */
class ffCompatibilityTester extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_warnings = array();
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    /**
     *
     */
    public function __construct( ffWPLayer $WPLayer ) {
        $this->_setWPLayer( $WPLayer );

        $WPLayer->add_action( ffConstActions::ACTION_LOAD_OUR_THEME, array($this, 'runTests') );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function runTests() {
        $this->_testMemory();
        $this->_hookNotices();
    }

    /**
     *
     */
    public function actAdminNotices() {
        echo '<div class="error">';

            foreach( $this->_warnings as $oneWarning ) {
                echo '<p>'.$oneWarning . '</p>';
            }
        echo '</div>';
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    /*----------------------------------------------------------*/
    /* TESTS
    /*----------------------------------------------------------*/

    private function _testMemory() {
        $memoryNeeded = 128;
        $memory_limit = $this->_returnMegaBytes(ini_get('memory_limit'));
        if ($memory_limit < ($memoryNeeded )) {
            $this->_addWarning('You will need at least '.$memoryNeeded.'MB of php memory. Your current memory limit is ' .$memory_limit .'MB');
        }
    }


    private function _returnMegaBytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val /1024 / 1024;
    }

    private function _addWarning( $text ) {
        $this->_warnings[] = $text;
    }

    private function _hookNotices() {
        if( empty( $this->_warnings ) ) {
            return false;
        }

        $this->_getWPLayer()->add_action('admin_notices', array( $this, 'actAdminNotices') );
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

}