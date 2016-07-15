<?php

class ffOptionsPrinterElementsAndComponentsBasic extends ffBasicObject {
	private $_cssClasses = array();
	
	private function _prepareClasses( $elementOrOption ) {
		$classes = $elementOrOption->getParam('class');
		
		if( $classes == null ) {
			return false;
		}
		
		if( !is_array( $classes ) ) {
			$classes = array( $classes );
		}
		
		$this->_cssClasses = $classes;
	}
	
	private function _escapeOptionValue( ffOneOption $oneOption) {
		$value = $oneOption->getValue();
		$escapedValue = $this->_escapedValue( $value );
		$oneOption->setValue( $escapedValue );
	}
	
	protected function _escapedValue( $value ){
		$value = str_replace( '&', '&amp;', $value );
		$value = str_replace( array('<','>','"',"'"), array('&lt;','&gt;','&quot;','&apos;'), $value);
		return $value;
	}
	
	protected function _getClassesArray() {
		return $this->_cssClasses;
	}
	
	protected function _getClassesString() {
		return implode(' ',$this->_cssClasses);
	}
	
	public function printOption( ffOneOption $oneOption, $nameRoute, $idRoute) {
		$this->_prepareClasses( $oneOption );
		if( empty( $this->valueEscapingDisabled ) ){
			$this->_escapeOptionValue( $oneOption );
		}
		$this->_printOption( $oneOption, $nameRoute, $idRoute );
	}
	
	public function printElement( ffOneElement $element ) {
		$this->_prepareClasses( $element );
		$this->_printElement( $element );
	}
}