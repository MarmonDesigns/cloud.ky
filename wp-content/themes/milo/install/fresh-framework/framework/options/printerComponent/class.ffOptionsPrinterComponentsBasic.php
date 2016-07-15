<?php

class ffOptionsPrinterComponentsBasic extends ffOptionsPrinterElementsAndComponentsBasic {
	


	protected function _isValueSelected( $optionValue, $selectValue ) {
		if( is_array( $selectValue ) ) {
			return in_array( $optionValue, $selectValue);
		} else {
			return $optionValue == $selectValue;
		}
	}

	protected function _getLabelAfter( ffOneOption $oneOption ){
		return $labelAfter = trim( $oneOption->getParam( ffOneOption::PARAM_TITLE_AFTER ) );
	}

	protected function _placeholder( ffOneOption $oneOption ){
		$placeholder = trim( $oneOption->getParam('placeholder') );

		return empty($placeholder)
				? ''
				:' placeholder="'.$placeholder.'" '
				;
	}

	protected function _class( ffOneOption $oneOption, $additionalClasses = ' ' ){
		$class = $oneOption->getParam('class');
		if( is_array($class) ) {
			$class = implode( ' ', $class );
		}
		$class = trim( $class );

		return empty($class) && $additionalClasses == ' '
				? ''
				: ' class="'.$class.$additionalClasses.'" '
				;
	}

	protected function _rows( ffOneOption $oneOption ){
		$rows = trim( $oneOption->getParam('rows') );
		return empty($rows)
				? ' rows="5" '
				: ' rows="'.$rows.'" '
				;
	}

	protected function _cols( ffOneOption $oneOption ){
		$cols = trim( $oneOption->getParam('cols') );
		return empty($cols)
				? ' cols="30" '
				: ' cols="'.$cols.'" '
				;
	}

	protected function _checkedCheckBox( ffOneOption $oneOption ){
		return ( 1 == $oneOption->getValue() )
				? ' checked="checked" '
				: ''
				;
	}

}







