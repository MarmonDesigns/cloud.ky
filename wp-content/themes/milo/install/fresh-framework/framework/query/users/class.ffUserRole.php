<?php

class ffUserRole extends ffBasicObject {
    private $_role = null;
    private $_displayName = null;
    private $_capabilities = array();

    public function setRole( $role ) {
        $this->_role = $role;
    }

    public function setDisplayName( $displayName ) {
        $this->_displayName = $displayName;
    }

    public function addCapability( $name ) {
        $this->_capabilities[ $name ] = true;
    }

    public function removeCapability( $name ) {
        unset( $this->_capabilities[ $name ] );
    }
}