<?php

class ffOptionsPostReader extends ffOptionsWalker {
	
	const RETURN_COLORLIB_VALUE = 'return_colorlib_value';
	
	/**
	 * 
	 * @var ffRequest
	 */
	private $_request = null;
	
	private $_settings = null;
	
	public function __construct( ffRequest $request) {
		$this->_request = $request;	
		$this->_settings[ ffOptionsPostReader::RETURN_COLORLIB_VALUE ] = false;
	}
	
	public function setSetting( $name, $value ) {
		$this->_settings[ $name ] = $value;
	}
	
	public function getDataFromArray( $array ) {
		$this->_setOptionsArrayData( $array );
		if( empty( $this->_optionsStructure ) ) {
				
			return $this->_optionsArrayData;
		}
		
		$this->_walk();
		
		//	die();
		
		return $this->_getOptionsArrayData();
	}
	
	public function getData( $prefixName ) {
		$this->_setOptionsArrayData( $this->_getRequest()->post( $prefixName ) );
		if( empty( $this->_optionsStructure ) ) {
			
			return $this->_optionsArrayData;
		}
		
		$this->_walk();
		
	//	die();
		
		return $this->_getOptionsArrayData();
		//die();
		return $this->_getRequest()->post( $prefixName );
	}
	protected function _beforeContainer( $item ) {}
	protected function _afterContainer( $item ) {}
	protected function _oneOption( $item ) {
		
		switch( $item->getType() ) {
			case ffOneOption::TYPE_CONDITIONAL_LOGIC:
				$valueRaw = $item->getValue();
				$valueParsed = array();
				parse_str($valueRaw, $valueParsed);
				
				$value = ( isset( $valueParsed['option-value'])) ? $valueParsed['option-value'] : array();
				
				$this->_setDataValue( $value );
				break;
				
				
			case ffOneOption::TYPE_COLOR_LIBRARY:
				
					$colorLibrary = ffContainer::getInstance()->getAssetsIncludingFactory()->getColorLibrary();
					$variableName = $item->getParam('less-variable-name');
					$variableValue = $item->getValue();
					
					if( strpos($variableValue, '@') !== false ) {
						$colorLibrary->setUserColor( $variableName, $variableValue);
					} else {
						$colorLibrary->deleteUserColor($variableName);
					}
					if( $this->_settings[ ffOptionsPostReader::RETURN_COLORLIB_VALUE ] == true ) {
						
					} else {
						$this->_setDataValue('');
					}
					
					//var_dump( $variableValue );
				break;
				
			case ffOneOption::TYPE_TEXT:
			case ffOneOption::TYPE_TEXTAREA:
				
				$value = $item->getValue();
				$valueStripped = stripslashes( $value );
				$this->_setDataValue($valueStripped);
				break;
		}
		
	}
	
	/**
	 *
	 * @return ffRequest ss
	 */
	protected function _getRequest() {
		return $this->_request;
	}
	/**
	 *
	 * @param ffRequest $_request        	
	 */
	protected function _setRequest(ffRequest $_request) {
		$this->_request = $_request;
		return $this;
	}
	

	private function _setDataValue( $value ) {
		$route = $this->_getRoute();
		$data = &$this->_optionsArrayData;
		
		foreach( $route as $onePath ) {
			if( isset( $data[ $onePath ] ) ) {
				$data = &$data[$onePath];
			} else {
				return;
			}
		}
		
		$data = $value;
	}
	
	
 
	
	/*
	private $_repeatable = false;
	public function __construct( $optionsStructure ) {
		$this->_setOptionsStructure($optionsStructure);
		$request = ffContainer::getInstance()->getRequest();
		$this->_setOptionsArrayData( $request->post('prefix'));
		
		$this->_walk();
	}
	
	protected function _beforeRepeatableTemplate( $item, $currentLevel ) {
		$this->_repeatable = true;
	}
	
	protected function _afterRepeatableTemplate( $item, $currentLevel ) {
		$this->_repeatable = false;
	}
	
	protected function _walkRepeatableContainer( $item ) {
		// TODO there MIGHT be problem when repeatables are 0,1,5,6,9,10
		$this->_addRoute( $item->getId() );
		$this->_beforeContainer($item);
		$currentRepeatableRoute = $this->_getCurrentRouteValue();
		
		if( !empty($currentRepeatableRoute) && count( $currentRepeatableRoute > 0 ) ) {
			$repeatableRouteSorted = array();
			$counter = 0;
			
			foreach( $currentRepeatableRoute as $oneItem ) {
				$repeatableRouteSorted[ $counter ] = $oneItem;
				$counter++;
			}
			
			$currentRepeatableRoute = $repeatableRouteSorted;
		}
		
		$repeatableCount = count( $currentRepeatableRoute );
		if( $repeatableCount == 0) $repeatableCount = 1;
		for( $i = -1; $i < $repeatableCount; $i++ ) {
	
			if( $i == -1 ) {
					
				$this->_addRoute( '!!!'.$this->_getCurrentRouteCount() .'-TEMPLATE'.'!!!' );
					
				$this->_beforeRepeatableTemplate($item, '!!!'.($this->_getCurrentRouteCount()-1) .'-TEMPLATE'.'!!!' );
					
				$this->_beforeRepeatableNode($item, '!!!'.($this->_getCurrentRouteCount()-1) .'-TEMPLATE'.'!!!');
			} else {
					
				$this->_addRoute( $i );
					
				$this->_beforeRepeatableNode($item, $i);
			}
		
			foreach( $item->getData() as $index => $childItem ) {
				$this->_walkItem( $childItem );
			}
	
			if( $i == -1 ) {
				$this->_afterRepeatableNode($item, '!!!'.($this->_getCurrentRouteCount()-1 ).'-TEMPLATE'.'!!!');
					
				$this->_afterRepeatableTemplate($item, '!!!'.($this->_getCurrentRouteCount()-1 ).'-TEMPLATE'.'!!!');
			} else {
				$this->_afterRepeatableNode($item, $i);
			}
				
			$this->_removeRoute();
	
	
		}
		$this->_afterContainer($item);
		$this->_removeRoute();
	}
	
	protected function _beforeContainer( $item ) {
		echo '---START---';
		echo $item->getId();
		echo "<br>";
	}
	protected function _afterContainer( $item ) {
		echo '---END---';
		echo "<br>";
	}
	protected function _oneOption( $item ) {
		if( $this->_repeatable == false )
			var_dump( $item );
	}*/
}