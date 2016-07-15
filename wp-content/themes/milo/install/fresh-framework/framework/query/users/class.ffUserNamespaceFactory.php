<?php

class ffUserNamespaceFactory extends ffFactoryAbstract {
    public function getUserModel() {

        $this->_getClassloader()->loadClass('ffUserModel');

        $userFactory = $this->getUserFactory();

        $userModel = new ffUserModel( $userFactory, ffContainer()->getCiphers() );

        return $userModel;
    }

    public function getUserFactory() {
        $this->_getClassloader()->loadClass('ffUser');
        $this->_getClassloader()->loadClass('ffUserFactory');

        $userFactory = new ffUserFactory( $this->_getClassloader() );

        return $userFactory;
    }


    private $_userRoleManager = null;
    public function getUserRoleManager() {
        if( $this->_userRoleManager == null ) {
            $this->_getClassloader()->loadClass('ffUserRoleManager');

            $this->_userRoleManager = new ffUserRoleManager( $this->getUserRoleFactory() );
        }

        return $this->_userRoleManager;
    }

    public function getUserRoleFactory() {
        $this->_getClassloader()->loadClass('ffUserRoleFactory');
        $this->_getClassloader()->loadClass('ffUserRole');

        $userRoleFactory = new ffUserRoleFactory( $this->_getClassloader() );

        return $userRoleFactory;
    }
}