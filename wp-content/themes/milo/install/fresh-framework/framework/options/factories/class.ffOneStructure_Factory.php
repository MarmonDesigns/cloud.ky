<?php

class ffOneStructure_Factory extends ffFactoryAbstract {
	/**
	 * 
	 * @var ffOneOption_Factory
	 */
	private $_oneOptionFactory = null;
	
	/**
	 * 
	 * @var ffOneSection_Factory
	 */
	private $_oneSectionFactory = null;
	
	public function __construct(ffClassLoader $classLoader, ffOneOption_Factory $oneOptionFactory, ffOneSection_Factory $oneSectionFactory) {
		$this->_setOneoptionfactory($oneOptionFactory);
		$this->_setOnesectionfactory($oneSectionFactory);
		parent::__construct( $classLoader);
	}
	
	public function createOneStructure( $name = 'default' ) {
		$this->_getClassloader()->loadClass('ffIOneDataNode');
		$this->_getClassloader()->loadClass('ffOneSection');
		$this->_getClassloader()->loadClass('ffOneOption');
		$this->_getClassloader()->loadClass('ffOneStructure');
		$structure = new ffOneStructure($name, $this->_getOneoptionfactory(), $this->_getOnesectionfactory());
		return $structure;
	}

	/**
	 * @return ffOneOption_Factory
	 */
	protected function _getOneoptionfactory() {
		return $this->_oneOptionFactory;
	}
	
	/**
	 * @param ffOneOption_Factory $_oneOptionFactory
	 */
	protected function _setOneoptionfactory(ffOneOption_Factory $oneOptionFactory) {
		$this->_oneOptionFactory = $oneOptionFactory;
		return $this;
	}
	
	/**
	 * @return ffOneSection_Factory
	 */
	protected function _getOnesectionfactory() {
		return $this->_oneSectionFactory;
	}
	
	/**
	 * @param ffOneSection_Factory $_oneSectionFactory
	 */
	protected function _setOnesectionfactory(ffOneSection_Factory $oneSectionFactory) {
		$this->_oneSectionFactory = $oneSectionFactory;
		return $this;
	}
	

	
	
}