<?php

class ffUser extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var WP_User
     */
    private $_WPUser = null;

    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( $WPUser = null) {
        if( $WPUser != null ) {
            $this->setWPUser( $WPUser );
        }
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function hasBeenRecognized() {
        return $this->_WPUser != null;
    }

    public function changeUserRole( $role ) {
        if( $this->getWPUser() != null ) {
            $this->getWPUser()->set_role( $role );

        }
    }

    public function changeUserEmail( $email ) {
        if( $this->getWPUser() != null ) {
            $userId = $this->getWPUser()->ID;
            $this->_getWPLayer()->wp_update_user( array('ID'=> $userId, 'user_email'=>$email) );
        }
    }

    public function hasUserRole( $role ) {
        $wpUser = $this->getWPUser();

        $isBuyer = false;
        if( isset( $wpUser->roles ) && is_array( $wpUser->roles ) ) {
            $isBuyer =  in_array( $role,$wpUser->roles);
        }

        if( $isBuyer ) {
            return true;
        }

        if( isset( $wpUser->caps ) && is_array( $wpUser->caps ) ) {
            $isBuyer =  array_key_exists( $role,$wpUser->caps);
        }

        return $isBuyer;


        return false;
    }


    public function setMeta( $name, $value ) {
        if( $this->getWPUser() == null ) {
            return false;
        }
        $userId = $this->getWPUser()->ID;

        $this->_getWPLayer()->update_user_meta( $userId, $name, $value );
    }

    public function getMeta( $name ) {
        $userId = $this->getWPUser()->ID;
        return $this->_getWPLayer()->get_user_meta($userId, $name, true );
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
    public function setWPUser( $WPUser ) {
        $this->_WPUser = $WPUser;
    }

    /**
     * @return WP_User
     */
    public function getWPUser() {
        return $this->_WPUser;
    }

    public function setWPLayer( $WPLayer ) {
        $this->_setWPLayer( $WPLayer );
    }



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
}