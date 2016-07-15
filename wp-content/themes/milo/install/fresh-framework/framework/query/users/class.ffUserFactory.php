<?php

class ffUserFactory extends ffFactoryAbstract {
    public function createUser() {
        $this->_getClassloader()->loadClass('ffUser');

        $user = new ffUser();

        $user->setWPLayer( ffContainer()->getWPLayer() );

        return $user;
    }
}