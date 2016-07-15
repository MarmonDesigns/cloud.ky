<?php

abstract class ffOptionsHolder extends ffBasicObject implements ffIOptionsHolder {

	/**
	 * 
	 * @var ffOneStructure_Factory
	 */
	private $_oneStructureFactory = null;
	
	/**
	 * 
	 * @var ffOptionsHolder_Factory
	 */
	private $_optionsHolderFactory = null;
	
	public function __construct( ffOneStructure_Factory $oneStructureFactory, ffOptionsHolder_Factory $optionsHolderFactory ) {
		$this->_setOnestructurefactory($oneStructureFactory);
		$this->_setOptionsholderfactory($optionsHolderFactory);
	}
	
	abstract public function getOptions();

	/**
	 * @return ffOneStructure_Factory
	 */
	protected function _getOnestructurefactory() {
		return $this->_oneStructureFactory;
	}
	
	/**
	 * @param ffOneStructure_Factory $oneStructureFactory
	 */
	protected function _setOnestructurefactory(ffOneStructure_Factory $oneStructureFactory) {
		$this->_oneStructureFactory = $oneStructureFactory;
		return $this;
	}

	/**
	 * @return ffOptionsHolder_Factory
	 */
	protected function _getOptionsholderfactory() {
		return $this->_optionsHolderFactory;
	}
	
	/**
	 * @param ffOptionsHolder_Factory $optionsHolderFactory
	 */
	protected function _setOptionsholderfactory(ffOptionsHolder_Factory $optionsHolderFactory) {
		$this->_optionsHolderFactory = $optionsHolderFactory;
		return $this;
	}
	
    protected function _insertOptionsHolder( ffOneStructure $s, $optionsHolderClassName ) {
        $optionsHolder = $this->_getOptionsholderfactory()->createOptionsHolder( $optionsHolderClassName );
        $s->insertStructure( $optionsHolder->getOptions() );
    }
	

	
	
}