<?php

class ffMetaBoxLayoutConditions extends ffMetaBox {
	protected function _initMetaBox() {
        $themeLayoutManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getThemeLayoutManager();

		$this->_addPostType( $themeLayoutManager->getLayoutPostTypeName() );
		$this->_setTitle('Layout Conditions');
		$this->_setContext( ffMetaBox::CONTEXT_NORMAL);
		
		$this->_setParam( ffMetaBox::PARAM_NORMALIZE_OPTIONS, true);
		//$this->_addVisibility( ffMetaBox::VISIBILITY_PAGE_TEMPLATE, 'page-onepage.php');
	}
}