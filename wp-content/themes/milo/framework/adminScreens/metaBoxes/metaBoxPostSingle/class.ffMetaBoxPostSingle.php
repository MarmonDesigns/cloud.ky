<?php

class ffMetaBoxPostSingle extends ffMetaBox {
	protected function _initMetaBox() {
		$this->_addPostType( 'post' );
		$this->_setTitle('Post Single View Settings');
		$this->_setContext( ffMetaBox::CONTEXT_NORMAL);
		
		$this->_setParam( ffMetaBox::PARAM_NORMALIZE_OPTIONS, true);
	}
}