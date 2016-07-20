<?php

class ffUserModel extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffUserFactory
     */
    private $_userFactory = null;

    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    /**
     * @var ffCiphers
     */
    private $_Ciphers = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffUserFactory $userFactory, ffCiphers $ciphers ) {
        $this->_setUserFactory( $userFactory );
        $this->_setWPLayer( ffContainer()->getWPLayer() );
        $this->_setCiphers( $ciphers );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    /**
     * @param $id
     * @return ffUser
     */
    function getUserById( $id ) {
        $user = $this->_getWPLayer()->get_user_by('id', $id );

        $ourUser = $this->_getOurUserObject( $user );

        return $ourUser;
    }

    /**
     * @param $email
     * @return ffUser
     */
    function getUserByEmail( $email ) {
        $user = $this->_getWPLayer()->get_user_by( 'email', $email );

        $ourUser = $this->_getOurUserObject( $user );

        return $ourUser;
    }

    /**
     * @param $login
     * @return ffUser
     */
    function getUserByLogin( $login ) {
        $user = $this->_getWPLayer()->get_user_by( 'login', $login );

        $ourUser = $this->_getOurUserObject( $user );

        return $ourUser;
    }

    /**
     * @param $username
     * @param $email
     * @return ffUser
     */
    public function createNewUserWithRandomPassword( $username, $email ) {
        $password = $this->_getCiphers()->generateRandomString(25);//substr(str_shuffle("01sdsdad234567asd89asdfghbsdasdcdefasdshijklmnopqrasdxsadyzfdfdAdsdsLretMNOPhgfdQRSTUxaasdddsgsVWXYsapokijuhytgd"), 0, 25);
        return $this->createNewUser( $username, $password, $email );
    }

    public function createNewUserWithRandomPasswordAndEmail( $username ) {
        $email = $this->_getCiphers()->generateRandomString(10) . '@' . $this->_getCiphers()->generateRandomString(10) . '-generated-email.com';
        return $this->createNewUserWithRandomPassword( $username, $email );
    }

    /**
     * @param $username
     * @param $password
     * @param $email
     * @return ffUser
     */
    function createNewUser( $username, $password, $email ) {
        $userId = $this->_getWPLayer()->wp_create_user($username, $password, $email );

        if( $userId instanceof WP_Error ) {
            if( isset($userId->errors['existing_user_login']) ) {
                $user = $this->getUserByLogin( $username );
            } else {
                $user = $this->getUserByEmail( $email );
            }
        } else {
            $user = $this->getUserById( $userId );
        }

        return $user;
    }

    function updateOrInsertUser() {

    }


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _getOurUserObject( $wordpressUser ) {
        $ourUser = $this->_getUserFactory()->createUser();

        $ourUser->setWPUser( $wordpressUser );

        return $ourUser;
    }
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/

    /**
     * @return ffUserFactory
     */
    private function _getUserFactory()
    {
        return $this->_userFactory;
    }

    /**
     * @param ffUserFactory $userFactory
     */
    private function _setUserFactory($userFactory)
    {
        $this->_userFactory = $userFactory;
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
     * @return ffCiphers
     */
    private function _getCiphers()
    {
        return $this->_Ciphers;
    }

    /**
     * @param ffCiphers $Ciphers
     */
    private function _setCiphers($Ciphers)
    {
        $this->_Ciphers = $Ciphers;
    }




}