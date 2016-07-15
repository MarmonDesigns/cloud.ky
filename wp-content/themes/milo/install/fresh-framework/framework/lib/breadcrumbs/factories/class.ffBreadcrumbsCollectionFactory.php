<?php

class ffBreadcrumbsCollectionFactory extends ffFactoryAbstract {

        public function createBreadcrumbsCollection() {
            $this->_getClassloader()->loadClass('ffCollection');
            $this->_getClassloader()->loadClass('ffBreadcrumbsCollection');
            $this->_getClassloader()->loadClass('ffOneBreadcrumb');

            $breadcrumbsCollection = new ffBreadcrumbsCollection();

            return $breadcrumbsCollection;
        }


}