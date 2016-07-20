<?php

class ffMetaBoxes extends ffFactoryCenterAbstract {
	
	/**
	 * 
	 * @var ffMetaBoxManager
	 */
	private $_metaBoxManager = null;
	
	public function getMetaBoxManager() {
		if( $this->_metaBoxManager == null ) {
			$this->_getClassloader()->loadClass('ffMetaBoxView');
			$this->_getClassloader()->loadClass('ffMetaBoxManager');
			$this->_getClassloader()->loadClass('ffMetaBoxFactory');
			$this->_getClassloader()->loadClass('ffMetaBoxViewFactory');
			$metaBoxViewFactory = new ffMetaBoxViewFactory( $this->_getClassloader() );
			$metaBoxFactory = new ffMetaBoxFactory($this->_getClassloader(), $metaBoxViewFactory);
			$this->_metaBoxManager = new ffMetaBoxManager( ffContainer::getInstance()->getWPLayer(), $metaBoxFactory );
		}
		
		return $this->_metaBoxManager;
	}
}