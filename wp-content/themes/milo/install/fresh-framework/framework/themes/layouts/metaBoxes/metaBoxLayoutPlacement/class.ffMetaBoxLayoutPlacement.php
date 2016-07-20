<?php

class ffMetaBoxLayoutPlacement extends ffMetaBox {
	protected function _initMetaBox() {
        $themeLayoutManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getThemeLayoutManager();

		$this->_addPostType( $themeLayoutManager->getLayoutPostTypeName() );
		$this->_setTitle('Layout Placement');
		$this->_setContext( ffMetaBox::CONTEXT_SIDE  );

		$this->_setParam( ffMetaBox::PARAM_NORMALIZE_OPTIONS, true);
	}
}