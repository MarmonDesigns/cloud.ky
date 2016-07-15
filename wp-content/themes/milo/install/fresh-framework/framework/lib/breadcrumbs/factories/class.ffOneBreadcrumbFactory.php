<?php

class ffOneBreadcrumbFactory extends ffFactoryAbstract {

    public function createOneBreadcrumb() {
        $this->_getClassloader()->loadClass('ffOneBreadcrumb');

        $oneBreadcrumb = new ffOneBreadcrumb();

        return $oneBreadcrumb;
    }

}