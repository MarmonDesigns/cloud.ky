<?php
/**
 * Here we are creating proper components ( printers and options holders).
 * These components could be overloaded in theme files. So firstly we
 * have to check if there exists an overloading class. If yes, we will
 * create the overloading, if no, then we create the original.
 * 
 * @author FRESHFACE
 * @since 0.1
 *
 */

class ffComponent_Factory extends ffFactoryAbstract {
	const BASE_NAME_OPTIONS_HOLDER = 'ffComponent_%s_OptionsHolder';
	const BASE_NAME_PRINTER = 'ffComponent_%s_Printer';
	const SUFFIX_THEME = '_Theme';
	/**
	 * 
	 * @var ffOptionsHolder_Factory
	 */
	private $_optionsHolderFactory = null;
	
	public function __construct( ffClassLoader $classLoader, ffOptionsHolder_Factory $optionsHolderFactory ) {
		$this->_setOptionsholderfactory($optionsHolderFactory);
		parent::__construct($classLoader);
	}
	
	public function createOptionsHolder( $componentName ) {
		$className = $this->_getOptionsHolderName($componentName);//'ffComponent_'.$componentName.'_OptionsHolder';
		$optionsHolder = $this->_getOptionsholderfactory()->createOptionsHolder( $className );
		
		return $optionsHolder;
	}
	
	public function createComponentPrinter( $componentName ) {
		$this->_getClassloader()->loadClass('ffIOptionsHolder');
		$this->_getClassloader()->loadClass('ffOptionsHolder');
		$className = $this->_getPrinterName($componentName);
		 
		$this->_getClassloader()->loadClass( $className );
		$componentPrinter = new $className();
		
		return $componentPrinter;
	}
	
/******************************************************************************/
/* WHICH CLASS WE SHOULD CREATE
/******************************************************************************/
	private function _decideWhichClass( $classNames ) {
		foreach( $classNames as $oneClassName ) {
			if( $this->_getClassloader()->classExists( $oneClassName ) || $this->_getClassloader()->classRegistered( $oneClassName ) ) {
				return $oneClassName;
			}
		}

        throw new ffException('WIDGET ADMIN - corresponding options holder is not registered - ' . $classNames );

		return false;
	}
	
	private function _getPossibleClassNames( $componentName, $className ) {
		$classNames = array();
		
		$baseClassName = sprintf( $className, $componentName );
		$themeClassName = $baseClassName . ffComponent_Factory::SUFFIX_THEME;
		
		$classNames[] = $themeClassName;
		$classNames[] = $baseClassName;
		
		return $classNames;
	}
	
	private function _getPrinterName( $componentName ) {
		$classNames = $this->_getPossibleClassNames($componentName, ffComponent_Factory::BASE_NAME_PRINTER);
		return $this->_decideWhichClass($classNames);}
	
	private function _getOptionsHolderName( $componentName ) {
		//TODO create options holder DECORATOR so we can overload option holders in theme without need of ffOptionsHolder class!!!
		$classNames = $this->_getPossibleClassNames($componentName, ffComponent_Factory::BASE_NAME_OPTIONS_HOLDER);
		return $this->_decideWhichClass($classNames);
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
	
	
}