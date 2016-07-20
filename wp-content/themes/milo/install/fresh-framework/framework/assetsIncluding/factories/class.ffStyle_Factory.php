<?php

class ffStyle_Factory extends ffFactoryAbstract {
	
	/**
	 * 
	 * @param string $handle
	 * @param string $source
	 * @param string $dependencies
	 * @param string $inFooter
	 * @param string $type
	 * @return ffScript
	 */
	public function createStyle( $handle = null, $source = null, $dependencies = null, $version = null, $media = null, $type = null, $additionalInfo = null ) {
		$this->_getClassloader()->loadClass('ffStyle');
		$style = new ffStyle( $handle, $source, $dependencies, $version, $media, $type, $additionalInfo );
		
		return $style;
	}
}