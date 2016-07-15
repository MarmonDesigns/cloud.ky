<?php

class ffOptions_Factory extends ffFactoryAbstract {
	
	private $_optionsPrinterDataBoxGenerator = null;
	
	/**
	 * 
	 * @var ffOneStructure_Factory
	 */
	private $_oneStructureFactory = null;
	
	/**
	 * 
	 * @var ffOptionsQuery_Factory
	 */
	private $_optionsQueryFactory = null;
	
	/**
	 * 
	 * @var ffOptionsHolder_Factory
	 */
	private $_optionsHolderFactory = null;
	
	/**
	 * 
	 * @var ffOptionsPrinterComponent_Factory
	 */
	private $_printerComponentFactory = null;
	
	public function __construct( ffOneStructure_Factory $oneStructureFactory, ffOptionsQuery_Factory $optionsQueryFactory, ffOptionsHolder_Factory $optionsHolderFactory, ffClassLoader $classLoader ) {

		$classLoader->loadClass('ffConditionalLogicConstants');

		$this->_setOnestructurefactory($oneStructureFactory);
		$this->_setOptionsqueryfactory($optionsQueryFactory);
		$this->_setOptionsholderfactory($optionsHolderFactory);
		
		parent::__construct($classLoader);
	}
	
	public function createOptionsArrayConvertor( $data = null, $structures = null) {
		$this->_getClassloader()->loadClass('ffOptionsArrayConvertor_Factory');
		$factory = new ffOptionsArrayConvertor_Factory( $this->_getClassloader() );
		return $factory->createArrayConvertor($data, $structures);
	}
	
	public function createOptionsPostReader( $optionsStructure = null ) {
		$this->_getClassloader()->loadClass('ffOptionsWalker');
		$this->_getClassloader()->loadClass('ffOptionsPostReader');
		
		
		
		$optionsPostReader = new ffOptionsPostReader( ffContainer::getInstance()->getRequest() );
		if( $optionsStructure !== null ) {
			$optionsPostReader->setOptionsStructure( $optionsStructure );
		}
		
		return $optionsPostReader;
	}

	public function createOptionsPrinterDataboxGenerator() {
		if( $this->_optionsPrinterDataBoxGenerator == null ) {

            $this->_getClassloader()->loadClass('ffIOptionsHolder');
            $this->_getClassloader()->loadClass('ffOptionsHolder');
            $this->_getClassloader()->loadClass('ffOptionsHolder_CachingFacade');
            $this->_getClassloader()->loadClass('ffIOneDataNode');
            $this->_getClassloader()->loadClass('ffOneSection');
            $this->_getClassloader()->loadClass('ffOneOption');
            $this->_getClassloader()->loadClass('ffOneStructure');
            $this->_getClassloader()->loadClass('ffOneElement');

			$WPLayer = ffContainer::getInstance()->getWPLayer();
			$this->_getClassloader()->loadClass('ffOptionsPrinterDataBoxGenerator');
			$this->_optionsPrinterDataBoxGenerator = new ffOptionsPrinterDataBoxGenerator( $WPLayer );
		}
		
		return $this->_optionsPrinterDataBoxGenerator;
		
	}
	
	public function createOptionsPrinter(  $optionsArrayData = null, $optionsStructure = null ) {
		$this->_getClassloader()->loadClass('ffOptionsPrinterComponent_Factory');
		$this->_getClassloader()->loadClass('ffOptionsWalker');
		$this->_getClassloader()->loadClass('ffOptionsPrinter');
		
		
		
		
		if( $this->_getPrintercomponentfactory() == null ) {
			$this->_setPrintercomponentfactory( new ffOptionsPrinterComponent_Factory( $this->_getClassloader()) );
		}

		
		$optionsPrinter = new ffOptionsPrinter( $optionsArrayData, $optionsStructure, $this->_getPrintercomponentfactory(), $this->createOptionsPrinterDataboxGenerator() );
		
		return $optionsPrinter;
		
	}

    public function createOptionsPrinterJavascriptConvertor( $optionsArrayData = null, $optionsStructure = null ) {
        		$this->_getClassloader()->loadClass('ffOptionsPrinterComponent_Factory');
		$this->_getClassloader()->loadClass('ffOptionsWalker');
		$this->_getClassloader()->loadClass('ffOptionsPrinter');
		$this->_getClassloader()->loadClass('ffOptionsPrinterJavaScriptConvertor');

		if( $this->_getPrintercomponentfactory() == null ) {
			$this->_setPrintercomponentfactory( new ffOptionsPrinterComponent_Factory( $this->_getClassloader()) );
		}

		$optionsPrinter = new ffOptionsPrinterJavaScriptConvertor( $optionsArrayData, $optionsStructure, $this->_getPrintercomponentfactory(), $this->createOptionsPrinterDataboxGenerator() );
		return $optionsPrinter;
    }
	

	
	public function createOptionsPrinterBoxed(  $optionsArrayData = null, $optionsStructure = null ) {
		$this->_getClassloader()->loadClass('ffOptionsPrinterComponent_Factory');
		$this->_getClassloader()->loadClass('ffOptionsWalker');
		$this->_getClassloader()->loadClass('ffOptionsPrinter');
		$this->_getClassloader()->loadClass('ffOptionsPrinterBoxed');
		
		if( $this->_getPrintercomponentfactory() == null ) {
			$this->_setPrintercomponentfactory( new ffOptionsPrinterComponent_Factory( $this->_getClassloader()) );
		}

		$optionsPrinter = new ffOptionsPrinterBoxed( $optionsArrayData, $optionsStructure, $this->_getPrintercomponentfactory(), $this->createOptionsPrinterDataboxGenerator() );
		return $optionsPrinter;		
	}
	
	
	public function createOptionsPrinterLogic(  $optionsArrayData = null, $optionsStructure = null ) {
		$this->_getClassloader()->loadClass('ffOptionsPrinterComponent_Factory');
		$this->_getClassloader()->loadClass('ffOptionsWalker');
		$this->_getClassloader()->loadClass('ffOptionsPrinter');
		$this->_getClassloader()->loadClass('ffOptionsPrinterLogic');
	
		if( $optionsArrayData == null ) {
			$optionsArrayData = array();
		}
	
	
	
		if( $this->_getPrintercomponentfactory() == null ) {
			$this->_setPrintercomponentfactory( new ffOptionsPrinterComponent_Factory( $this->_getClassloader()) );
		}
	
	
		$optionsPrinter = new ffOptionsPrinterLogic( $optionsArrayData, $optionsStructure, $this->_getPrintercomponentfactory(), $this->createOptionsPrinterDataboxGenerator() );
	
		return $optionsPrinter;
	
	}
	
	/**
	 * 
	 * @return ffIOptionsHolder
	 */
	public function createOptionsHolder( $optionsHolderName ){
		return $this->_getOptionsholderfactory()->createOptionsHolder( $optionsHolderName );
	}

	/**
	 * Creates structure
	 * @param  string $name Name of structure
	 * @return ffOneStructure       Structure Class
	 */
	public function createStructure( $name ) {
		$this->_getClassloader()->loadClass('ffIOneDataNode');
		$this->_getClassloader()->loadClass('ffOneSection');
		$structure = $this->_getOnestructurefactory()->createOneStructure($name);
		return $structure;
	}
	
	public function createQuery( $data, $structures = null ) {
		$query = $this->_getOptionsqueryfactory()->createOptionsQuery($data, $structures);
		return $query;
	}

	/**
	 * @return ffOneStructure_Factory
	 */
	protected function _getOnestructurefactory() {
		return $this->_oneStructureFactory;
	}
	
	/**
	 * @param ffOneStructure_Factory $_oneStructureFactory
	 */
	protected function _setOnestructurefactory(ffOneStructure_Factory $oneStructureFactory) {
		$this->_oneStructureFactory = $oneStructureFactory;
		return $this;
	}

	protected function _getOptionsqueryfactory() {
		return $this->_optionsQueryFactory;
	}
	
	protected function _setOptionsqueryfactory(ffOptionsQuery_Factory $optionsQueryFactory) {
		$this->_optionsQueryFactory = $optionsQueryFactory;
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

	/**
	 * @return ffOptionsPrinterComponent_Factory
	 */
	protected function _getPrintercomponentfactory() {
		return $this->_printerComponentFactory;
	}
	
	/**
	 * @param ffOptionsPrinterComponent_Factory $_printerComponentFactory
	 */
	protected function _setPrintercomponentfactory(ffOptionsPrinterComponent_Factory $printerComponentFactory) {
		$this->_printerComponentFactory = $printerComponentFactory;
		return $this;
	}
	
	
	
	
}