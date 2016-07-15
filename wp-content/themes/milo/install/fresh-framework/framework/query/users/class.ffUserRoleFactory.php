<?php

class ffUserRoleFactory extends ffFactoryAbstract {
    public function createUserRole() {
        $this->_getClassloader()->loadClass('ffUserRole');

        $userRole = new ffUserRole();

        return $userRole;
    }
}