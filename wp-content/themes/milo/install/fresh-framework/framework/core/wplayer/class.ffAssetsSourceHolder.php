<?php

class ffAssetsSourceHolder extends ffBasicObject {
	private $_WPLayer = null;

	public function __construct( ffWPLayer $WPLayer ) {
		$this->_WPLayer = $WPLayer;
	}

	private function _getWPLayer() {
		return $this->_WPLayer;
	}

	public function getGoogleFontsAjax() {
		return $this->_WPLayer->getFrameworkUrl() . 'framework/assets/fonts/google-fonts/google-webfonts-alphabet.json';
	}
}