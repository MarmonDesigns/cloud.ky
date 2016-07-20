<?php

class ffShortcodeFactory extends ffFactoryAbstract {
    /**
     * @param $className
     * @return ffShortcodeObjectBasic
     * @throws Exception
     */
    private $_WPLayer = null;

	public function createShortcode( $className ) {
        $this->_getClassloader()->loadClass( $className );
		$shortcode = new $className( $this->_getWPLayer() );

		return $shortcode;
	}

    public function setWPLayer( $WPLayer ) {
        $this->_WPLayer = $WPLayer;
    }

    private function _getWPLayer() {
        return $this->_WPLayer;
    }
}