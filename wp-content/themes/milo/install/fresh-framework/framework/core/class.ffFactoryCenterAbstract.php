<?php

class ffFactoryCenterAbstract extends ffFactoryAbstract {
	
	/**
	 * 
	 * @var ffContainer
	 */
	private $_container = null;
	
	public function __construct( ffClassLoader $classLoader, ffContainer $container ) {
		parent::__construct($classLoader);
		$this->_setContainer($container);
	}
	
	protected function _getContainer( ffContainer $container ) {
		return $this->_container;
	}
	
	protected function _setContainer(  ffContainer $container ) {
		$this->_container = $container;
	}
}