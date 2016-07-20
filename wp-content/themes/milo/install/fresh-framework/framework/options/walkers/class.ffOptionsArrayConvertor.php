<?php
class ffOptionsArrayConvertor extends ffOptionsWalker {
	private $_optionValues = null;
	
	public function walk() {
		$this->_walk();
		
		return $this->_optionValues;
	}
	
	protected function _getNamePlaceholder( $index ) {
		//TODO
		return 0;
	}
	
	protected function _beforeContainer( $item ) {
		
	}
	protected function _afterContainer( $item ) {
		
	}
	protected function _oneOption( $item ) {
		$this->_addOptionValue( $item->getValue() );
	}
	
	private function _addOptionValue( $value ) {
		$current = &$this->_optionValues;
		
		$completeRoute = $this->_getRoute();
		$routeEnd = end( $completeRoute );
		foreach( $completeRoute as $route ) {
			$route = (string)$route;
			
			if( !isset( $current[ $route ] ) ) {
				if( !is_array( $current ) ) {
					$current = array();
				}
				$current[ $route ] = array();
			}
			if( $route == $routeEnd ) {
				$current[ $route ] = $value;
			}
			// TODO TEST FIX
			if( is_array( $current ) ) {
				$current = &$current[$route ];
			}
		}
		
	}
}