<?php

/**
 * Combine data array and structures together and walk through the options.
 * Automatically calls these abstract functions:
 * 
 * _beforeContainer
 * _afterContainer
 * _oneOption
 * 
 * You can inherit them, it's useful for printing, querying options and other
 * stuff.
 * 
 * @author FRESHFACE
 * @since 0.1
 * 
 */

abstract class ffOptionsWalker extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	protected $_optionsArrayData = null;
	protected $_optionsStructure = null;
	
	private $_currentRoute = array();
	private $_currentRouteCount = 0;
	
	private $_currentRouteForPrint = array();
	private $_currentRouteForPrintCount = 0;
	
	protected $_walkElements = true;

    protected $_walkTemplates = true;
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( $optionsArrayData = null, $optionsStructure = null ) {
		$this->_setOptionsArrayData( $optionsArrayData );
		$this->_setOptionsStructure($optionsStructure);
	}
	
	public function setOptionsArrayData( $optionsArrayData ) {
		$this->_setOptionsArrayData($optionsArrayData);
	}
	
	public function setOptionsStructure( $optionsStructure ) {
		$this->_setOptionsStructure($optionsStructure);
	}
	
/******************************************************************************/
/* ABSTRACT FUNCTION
/******************************************************************************/	
	protected abstract function _beforeContainer( $item );
	protected abstract function _afterContainer( $item );
	protected abstract function _oneOption( $item );
	
	protected function _oneElement( ffOneElement $item ) {}
	protected function _beforeRepeatableTemplate( $item, $currentLevel ) {}
	protected function _afterRepeatableTemplate( $item, $currentLevel ) {}
	protected function _beforeRepeatableNode( $item, $index ) {}
	protected function _afterRepeatableNode( $item, $index ) {}
	
	protected function _beforeRepeatableVariableTemplate( $item, $currentLevel ) {}
	protected function _afterRepeatableVariableTemplate( $item, $currentLevel ) {}
	protected function _beforeRepeatableVariableNode( $item, $index ) {}
	protected function _afterRepeatableVariableNode( $item, $index ) {}
	
	protected function _beforeAllItems() {}
	protected function _afterAllItems() {}
	
/******************************************************************************/
/* PROTECTED FUNCTIONS
/******************************************************************************/	
	/**
	 * Start walkings
	 */
	protected function _walk() {
		$this->_beforeAllItems();
		if( get_class($this->_getOptionsStructure()) == 'ffOneStructure' ) {
			foreach( $this->_getOptionsStructure()->getData() as $oneItem ) {
				$this->_walkItem( $oneItem );
			}
		}
		else {
			$this->_walkItem( $this->_getOptionsStructure()->getData() );
		}
		$this->_afterAllItems();
	}
	
	protected function _getCurrentForPrint() {
		return $this->_currentRouteForPrint;
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/

	/**
	 * Deciding if its container ( containes other options), or directly
	 * option.
	 * @param ffOneOption|ffOneStructure $item
	 */
	private function _walkItem( $item ) {
		if( $this->_isItemContainer($item) ) {
			$this->_walkContainer( $item );
		} else if( $item instanceof ffOneOption ) {
			$this->_walkOption( $item );
		} else {
			$this->_walkElement( $item );
		}
	}
	
	private function _walkContainer( $item ) {
		if( $this->_isContainerRepeatable($item) ) {
			$this->_walkRepeatableContainer( $item );
		} else if ( $this->_isContainerRepeatableVariable($item) ) {
			$this->_walkRepeatableVariableContainer( $item ) ;
		} else {
			$this->_walkNonRepeatableContainer( $item );
		}
	}
	
	private function _walkNonRepeatableContainer( $item ) {
		$this->_addRoute( $item->getId() );
			$this->_beforeContainer($item);
			foreach( $item->getData() as $childItem ) {
				$this->_walkItem( $childItem );
			}
			$this->_afterContainer($item);
		$this->_removeRoute();
	}
	
	private function _addRouteVariation( $originalRoute, $printingRoute) {
		$this->_currentRouteCount++;
		$this->_currentRoute[] = $originalRoute;
		
		
		$id = $this->_currentRouteForPrintCount;
		$this->_currentRouteForPrintCount++;
		$this->_currentRouteForPrint[] = $printingRoute;
	}
	
	private function _walkRepeatableVariableContainer( $item ) {
		$variations = $item->getData();
		$variationsId = array();
		
		

		foreach( $variations as $oneVar)  {
			$variationsId[ $oneVar->getId() ] = $oneVar;
		}
		
		$this->_addRoute( $item->getId() );
		$this->_beforeContainer($item);

            if( $this->_walkTemplates ) {
                // PRINT JAVASCRIPT TEMPLATES FIRST
                foreach( $variationsId as $id => $oneVar ) {
                        // -_-1-TEMPLATE-_- -|- repeatable-variation-id
                    $this->_addRoute( $this->_getNamePlaceholder( $this->_currentRouteCount ) .'-|-'. $id );

                        $this->_beforeRepeatableVariableTemplate($oneVar, $this->_getNamePlaceholder($this->_getCurrentRouteCount() - 1) ) ;
                        $this->_beforeRepeatableVariableNode($oneVar,$this->_getNamePlaceholder($this->_getCurrentRouteCount()-1));

                        $this->_walkItem($oneVar);

                        $this->_afterRepeatableVariableNode($oneVar, $this->_getNamePlaceholder($this->_getCurrentRouteCount()-1 ) );
                        $this->_afterRepeatableVariableTemplate($oneVar, $this->_getNamePlaceholder($this->_getCurrentRouteCount() -1));

                    $this->_removeRoute();
                }
            }
			
			
			$currentRouteValue = $this->_getCurrentRouteValue();
	
			if( empty ($currentRouteValue ) ) {
				foreach( $variationsId as $id => $oneVar ) {
					// HIDE WISHED VARIATIONS
					if( empty($this->_optionsArrayData) && $oneVar->getParam( 'hide-default') && $this->_walkTemplates == true ) {
						continue;
					}
					
					$this->_addRoute( $this->_getNamePlaceholder( $this->_currentRouteCount ) .'-|-'. $id );
						$this->_beforeRepeatableVariableNode($oneVar,$this->_getNamePlaceholder($this->_getCurrentRouteCount()-1));
							
						$this->_walkItem($oneVar);
					
						$this->_afterRepeatableVariableNode($oneVar, $this->_getNamePlaceholder($this->_getCurrentRouteCount()-1 ) );
					$this->_removeRoute();
					

				}
			} else {
				foreach( $this->_getCurrentRouteValue() as $name => $value ) {
					// get type ID from the 1-|-type_id
					$exploded = ( explode('-|-',$name ));	
					//var_dump( $name, $exploded );
				
					// the second part of the id ( without number )
					$type = $exploded[1];
					// current node item
					
					if( isset( $variationsId[ $type ] ) ) {
					$currentNode =  $variationsId[ $type ];
					
						$this->_addRouteVariation(  $name, $this->_getNamePlaceholder( $this->_currentRouteCount ) .'-|-'. $type );
							$this->_beforeRepeatableVariableNode($currentNode,$this->_getNamePlaceholder($this->_getCurrentRouteCount()-1));
						
								$this->_walkItem( $currentNode );
						
							$this->_afterRepeatableVariableNode($currentNode, $this->_getNamePlaceholder($this->_getCurrentRouteCount()-1 ) );
						$this->_removeRoute();
					}
				}
			}
		
		$this->_afterContainer($item);
		$this->_removeRoute();
	}
	
	
	/**
	 * Repeatable containers has specific data saving structure. It's like this:
	 * 
	 * [repeatableContainer][0][optionName]
	 * [repeatableContainer][1][optionName]
	 * 
	 * See the numbers, they are here to identify the repeatabling.
	 * @param ffOneStructure $item
	 */
	private function _walkRepeatableContainer( $item ) {
		// IMAGE
		// TODO there MIGHT be problem when repeatables are 0,1,5,6,9,10
		
		
		// [!!repeatableContainer!!]  // [0][optionName]
		$this->_addRoute( $item->getId() );
		
		// this handle the printe
		$this->_beforeContainer($item);
		
		// number of items, now we are returned [0][optionName]
		$currentRepeatableRoute = $this->_getCurrentRouteValue();
		$repeatableCount = count( $currentRepeatableRoute );
		// it's empty (mean nothing saved now), we then simply set this to 1 and default value aappears;
		if( $repeatableCount == 0) $repeatableCount = 1;
		
			// GO THROUGH ALL SAVED FILES, AND FIRST is -1 to generate template for javascript shti
			for( $i = -1; $i < $repeatableCount; $i++ ) {
				
				$this->_addRoute( $i,true );
				if( $i == -1 ) {
					//$this->_addRoute( $this->_getNamePlaceholder($this->_getCurrentRouteCount()) );
					$this->_beforeRepeatableTemplate($item, $this->_getNamePlaceholder($this->_getCurrentRouteCount()-1) ) ;
					$this->_beforeRepeatableNode($item,$this->_getNamePlaceholder($this->_getCurrentRouteCount()-1));
				} else {
					
					$this->_beforeRepeatableNode($item, $i);
				}
				
					foreach( $item->getData() as $childItem ) {
						$this->_walkItem( $childItem );
					}

				if( $i == -1 ) {
					$this->_afterRepeatableNode($item, $this->_getNamePlaceholder($this->_getCurrentRouteCount()-1 ) );
					$this->_afterRepeatableTemplate($item, $this->_getNamePlaceholder($this->_getCurrentRouteCount()-1 ));
				} else {
					$this->_afterRepeatableNode($item, $i);
					
				}					
					
				$this->_removeRoute();
			}
			$this->_afterContainer($item);
		$this->_removeRoute();
	}
	
	private function _walkOption( $item ) {
		$this->_addRoute( $item->getId() );
			$item->setValue( $this->_getOptionValue($item) );
			$this->_oneOption($item);
		$this->_removeRoute();
	}
	
	private function _walkElement( $item ) {
		if( !$this->_walkElements || !is_object( $item ) ) {
			return false;
		}
		
		$this->_addRoute( $item->getId() );
			$this->_oneElement($item);
		$this->_removeRoute();
	}
	
	private function _getOptionValue( $item ) {
		$currentValue = ($this->_getCurrentRouteValue());
		//var_dump( $currentValue );
		$itemValue = $item->getDefaultValue();
		
		( $currentValue === null ) ? $toReturn = $itemValue : $toReturn = $currentValue;
		return $toReturn;
	}
	
	private function _getCurrentRouteValue() {
		return $this->_getDataValue( $this->_getRoute() );
	}
	

	
	private function _getDataValue( $route ) {
		$data = &$this->_optionsArrayData;
		foreach( $route as $onePath ) {
			if( isset( $data[ $onePath ] ) ) {
				$data = &$data[$onePath];
			} else {
				return null;
			}
		}
		return $data;
	}
	
	private function _isItemContainer( $item ) {
		//$containerClasses = array('ffOneStructure', 'ffOneSection');
		//$className = get_class( $item );
		if( !is_object( $item ) ) {
			return false;
		}
		return $item->isContainer();//in_array( $className, $containerClasses );
	}
	
	private function _isContainerRepeatableVariable( $item ) {
		
		$type = $item->getType();
		
		if( ffOneSection::TYPE_REPEATABLE_VARIABLE === $type ) {
			return true;
		} else {
			return false;
		}
	}
	
	private function _isContainerRepeatable( $item ) {
		$type = $item->getType();
		if( ffOneSection::TYPE_REPEATABLE === $type ) {
			return true; 
		} else {
			return false;
		}
	}
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	
	protected function _getNamePlaceholder( $index ) {
		return '-_-'.$index.'-TEMPLATE-_-';
	}
	
	
	/********** CURRENT ROUTE **********/
	protected function _addRoute( $routeName, $isRepeatableNode = false ) {
		$this->_currentRouteCount++;
		$this->_currentRoute[] = $routeName;
		
		
		$id = $this->_currentRouteForPrintCount;
		$this->_currentRouteForPrintCount++;
		$this->_currentRouteForPrint[] = ($isRepeatableNode) ? $this->_getNamePlaceholder( $id ): $routeName;
	}
	
	protected function _removeRoute() {
		$this->_currentRouteCount--;
		array_pop( $this->_currentRoute );
		
		$this->_currentRouteForPrintCount--;
		array_pop( $this->_currentRouteForPrint);
	}
	
	protected function _getCurrentRouteCount() {
		return $this->_currentRouteCount;
	}
	
	protected function _getRoute() {
		return $this->_currentRoute;
	}
	
	/********** OPTIONS ARRAY DATA **********/
	protected function _setOptionsArrayData( $optionsArrayData ) {
		$this->_optionsArrayData = $optionsArrayData;
	}
	/**
	 * @return array;
	 */
	protected function _getOptionsArrayData() {
		return $this->_optionsArrayData;
	}
	
	
	/********** OPTIONS STRUCTURE **********/
	/**
	 * 
	 * @param ffOneStructure|ffOneSection $optionsStructure
	 */
	protected function _setOptionsStructure( $optionsStructure ) {
		$this->_optionsStructure = $optionsStructure;
	}
	
	protected function _getOptionsStructure() {
		return $this->_optionsStructure;
	}
}