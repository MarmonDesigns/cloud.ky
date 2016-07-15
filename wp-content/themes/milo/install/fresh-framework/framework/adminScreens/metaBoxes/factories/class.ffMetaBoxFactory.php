<?php

class ffMetaBoxFactory extends ffFactoryAbstract {
	
	/**
	 * 
	 * @var ffMetaBoxViewFactory
	 */
	private $_metaBoxViewFactory = null;
	
	public function __construct( ffClassLoader $classLoader, ffMetaBoxViewFactory $metaBoxViewFactory ) {
		parent::__construct($classLoader);
		$this->_setMetaBoxViewFactory($metaBoxViewFactory);
	}
	
	/**
	 * 
	 * @return ffMetaBox
	 */
	public function createMetaBox( $className ) {
		$this->_getClassloader()->loadClass('ffMetaBox');
		$this->_getClassloader()->loadClass( $className );
		$newMetaBox = new $className( $this->_getMetaBoxViewFactory() );
		return $newMetaBox;
	}
	
	/**
	 *
	 * @return the ffMetaBoxViewFactory
	 */
	protected function _getMetaBoxViewFactory() {
		return $this->_metaBoxViewFactory;
	}
	
	/**
	 *
	 * @param ffMetaBoxViewFactory $metaBoxViewFactory        	
	 */
	protected function _setMetaBoxViewFactory(ffMetaBoxViewFactory $metaBoxViewFactory) {
		$this->_metaBoxViewFactory = $metaBoxViewFactory;
		return $this;
	}
	
}