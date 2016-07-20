<?php

class ffHelpersFactory extends ffFactoryAbstract {

    public function getStringHelper() {
        $this->_getClassloader()->loadClass('ffStringHelper');
        $stringHelper = new ffStringHelper();

        return $stringHelper;
    }

}