<?php

class ffOptionsQuery_Factory extends ffFactoryAbstract {
	/**
	 * 
	 * @var ffOptionsArrayConvertor_Factory
	 */
	private $_optionsArrayConvertorFactory = null;
	
	private $_optionsHolderFactory = null;
	
	public function __construct( ffClassLoader $classLoader, ffOptionsArrayConvertor_Factory $optionsArrayConvertorFactory, ffOptionsHolder_Factory $optionsHolderFactory ) {
		$this->_setOptionsarrayconvertorfactory($optionsArrayConvertorFactory);
		$this->_setOptionsholderfactory($optionsHolderFactory);
		parent::__construct($classLoader);
	}
	
	public function createOptionsQuery( $data, $structures = null ) {
		
		if( is_string($structures )) {
			$structures = $this->_getOptionsholderfactory()->createOptionsHolder($structures);
		}
		
		$this->_getClassloader()->loadClass('ffOptionsQuery');
		$arrayConvertor = $this->_getOptionsarrayconvertorfactory()->createArrayConvertor();
		
		$WPLayer = ffContainer::getInstance()->getWPLayer();
		
		$query = new ffOptionsQuery($data, $structures, $arrayConvertor );
		$query->setWPLayer( $WPLayer );
		return $query;
	}


	/**
	 * @return ffOptionsArrayConvertor_Factory
	 */
	protected function _getOptionsarrayconvertorfactory() {
		return $this->_optionsArrayConvertorFactory;
	}
	
	/**
	 * @param ffOptionsArrayConvertor_Factory $optionsArrayConvertorFactory
	 */
	protected function _setOptionsarrayconvertorfactory(ffOptionsArrayConvertor_Factory $optionsArrayConvertorFactory) {
		$this->_optionsArrayConvertorFactory = $optionsArrayConvertorFactory;
		return $this;
	}
	
	/**
	 *
	 * @return ffOptionsHolder_Factory
	 */
	protected function _getOptionsholderfactory() {
		return $this->_optionsHolderFactory;
	}
	
	/**
	 *
	 * @param unknown_type $_optionsHolderFactory        	
	 */
	protected function _setOptionsholderfactory($_optionsHolderFactory) {
		$this->_optionsHolderFactory = $_optionsHolderFactory;
		return $this;
	}
	
	
}