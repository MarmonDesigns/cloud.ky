<?php

class ffMetaBoxPortfolioTitle extends ffMetaBox {
	protected function _initMetaBox() {
		$this->_addPostType( 'portfolio' );
		$this->_setTitle('Portfolio Title View Settings');
		$this->_setContext( ffMetaBox::CONTEXT_NORMAL);

		$this->_setParam( ffMetaBox::PARAM_NORMALIZE_OPTIONS, true);
	}
}