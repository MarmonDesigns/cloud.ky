<?php

class ffScript_Factory extends ffFactoryAbstract {
	
	/**
	 * 
	 * @param string $handle
	 * @param string $source
	 * @param string $dependencies
	 * @param string $inFooter
	 * @param string $type
	 * @return ffScript
	 */
	public function createScript( $handle = null, $source = null, $dependencies = null, $version = null, $inFooter = null, $type = null, $canBeMinified = null ) {
		$this->_getClassloader()->loadClass('ffScript');
		$script = new ffScript( $handle, $source, $dependencies, $version, $inFooter, $type, $canBeMinified );
		
		return $script;
	}
}