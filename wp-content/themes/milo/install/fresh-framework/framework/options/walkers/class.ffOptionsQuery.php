<?php
/**
 * Try to get the value from the data array. In case of failure ( for example
 * we added another option and user didn't saved them yet ) it will re-create
 * the whole option structure and try to get the value from here. If this 
 * won't help too, it will report error.
 * 
 * @author FRESHFACE
 * @since 0.1
 *
 */
class ffOptionsQuery extends ffBasicObject implements Iterator {
	
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	private $_iteratorPointer = null;
	
	private $_iteratorValidHolder = null;
	
	private $_data = null;
	
	private $_path = null;
	/**
	 * 
	 * @var ffOptionsArrayConvertor
	 */
	private $_arrayConvertor = null;
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffIOptionsHolder
	 */
	private $_optionsHolder = null;
	
	private $_optionsStructureHasBeenCompared = false;
	
	private $_hasBeenComparedWithStructure = false;
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( $data, ffIOptionsHolder $optionsHolder = null, ffOptionsArrayConvertor $arrayConvertor = null, $path = null, $optionsStructureHasBeenCompared = false ) {
		$this->_setData($data);
		$this->_setArrayConvertor($arrayConvertor);
		if( $optionsHolder != null ) {
			$this->_setOptionsHolder($optionsHolder);
		}
		$this->_setPath($path);
	}
	
	
	public function getOnlyDataPart( $query, $wrappedInSectionName = true ) {
		$exploded = explode(' ', $query);
		$arrayName = end($exploded );
		$toReturn = null;
		if( $wrappedInSectionName ) {
			$toReturn[ $arrayName ] = $this->_get($query);
		} else {
			$toReturn = $this->_get( $query );
		}
		return $toReturn;
		//return $this->_get($query);
	}
	
	public function resetPath() {
		$this->_setPath( null );
	}
	
	public function debug_dump( $short = false )
	{
		if( $short ){
			echo '<pre>';
			print_r($this->_path);
			echo '</pre>';
			echo '<pre>';
			print_r($this->_data);
			echo '</pre>';
		}
		var_dump( $this->_path, $this->_data );
	}

    public function debug_export() {
        var_export( $this->_data );
    }
	
	public function getWithoutComparation( $query ) {
		if( $this->_getPath() !== null ) {
			$query = $this->_getPath() . ' ' . $query;
		}
		$result = $this->_get( $query );
		
		if( is_array( $result ) ) {

			$result = $this->getNew( $query );
		}
		
			return $result;
	}

    public function queryExists( $query ) {
        $result = $this->getWithoutComparation( $query );

        if( $result == null ) {
            return false;
        } else {
            return true;
        }
    }
	
	/**
	 * 
	 * @param unknown $query
	 * @return ffOptionsQuery | string
	 */
	public function get( $query ) {
		if( $this->_getPath() !== null ) { 
			$query = $this->_getPath() . ' ' . $query; 
		}
		$result = $this->_get( $query );
		
		if( $result === null ) {
			$this->_compareDataWithStructure();
			$result = $this->_get($query);

            if( $result === null && $this->_getWPLayer()->get_ff_debug() ) {
                throw new ffException('NON EXISTING QUERY STRING -> "'.$query.'"');
            } else {
                $this->_getWPLayer()->do_action( ffConstActions::ACTION_QUERY_NOT_FOUND_IN_DATA, $query );
            }
		}
		
		
		if( is_array( $result ) ) {
			
		//	if( $this->_getPath() == null ) {
				
				$result = $this->getNew( $query ); 
				//new ffOptionsQuery( $this->_getData(), $this->_getOptionsHolder(), $this->_getArrayConvertor(), $query, $this->_optionsStructureHasBeenCompared );
// 			} else {
// 				$this->_setPath( $query);
// 				$result = $this;
// 			}
		}
		
		
 		
		return $result;
	}
	
	public function getText( $query ) {
		$text = $this->get( $query );
		
		return $this->_getWPLayer()->do_shortcode( $text );
	}
	
	public function printText( $query ) {
		$text = $this->get( $query );
		
		echo $this->_getWPLayer()->do_shortcode($text);
		
	}

	public function getMultipleSelect( $query ) {
		$valueText = $this->get($query);
		$valueArray = explode('--||--', $valueText);

		return $valueArray;
	}

    public function getMultipleSelect2( $query ) {
		$valueText = $this->get($query);
        if( empty( $valueText ) ) {
            return array();
        }
		$valueArray = explode('--||--', $valueText);

		return $valueArray;
	}
	
	public function getUnserialize( $query ) {
		return unserialize( $this->get($query) );
	}
	
	public function getJsonDecode( $query ) {
		return json_decode( $this->get( $query ) );
	}
	
	public function getImage( $query ) {
		$image = $this->getJsonDecode( $query );
		
	
		
		if( !is_object( $image ) ) {
			$image = new stdClass();
			$image->url = '';
		} else {
			
			if( strpos( $image->url, $this->_getWPLayer()->get_freshface_demo_url() )!== false && strpos( $this->_getWPLayer()->get_home_url(), $this->_getWPLayer()->get_freshface_demo_url() ) === false) {
				$image->url = $this->_getWPLayer()->wp_get_attachment_url( $image->id );//wp_get_attachment_url( $image->id );
			}
			//if( strpos($this->_getWPLayer()->get_home_url())
			
			//var_dump( get_home_url() );
			//$image->url = wp_get_attachment_url( $image->id );
		}
		
		
		
		return $image;
	}
	
	public function getIcon( $query ) {
		$icon = $this->get( $query );
		
		$iconFiltered = $this->_getWPLayer()->apply_filters( ffConstActions::FILTER_QUERY_GET_ICON, $icon);
		
		return $iconFiltered;
	}
	
	public function getNew( $query ) {
		$query =  new ffOptionsQuery( $this->_data, $this->_getOptionsHolder(), $this->_getArrayConvertor(), $query, $this->_optionsStructureHasBeenCompared );
		$query->setWPLayer( $this->_getWPLayer() );
		return $query;
	}
	
	
	public function getIndex( $query, $index ) {
		$currentQuery = $this->get( $query );
		$toReturn = null;
		
		foreach( $currentQuery as $key => $oneSubItem ) {
			if( $key == $index ) {
				 $toReturn = $oneSubItem;
				 break;
			}
		}
		
		return $toReturn;
	}
	
	public function getOnlyData() {
		return $this->_data;
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	private function _compareDataWithStructure() {
		if ($this->_getOptionsstructureHasBeenCompared() == false && $this->_optionsHolder != null ) {
			$this->_setOptionsstructureHasBeenCompared(true);
			$options = $this->_getOptionsHolder()->getOptions();
			$this->_getArrayConvertor()->setOptionsArrayData( $this->_data );
			$this->_getArrayConvertor()->setOptionsStructure( $options );
			$this->_data = $this->_getArrayConvertor()->walk();
			$this->_setOptionsstructureHasBeenCompared(true);
		} else if( $this->_getOptionsstructureHasBeenCompared() == false && $this->_optionsHolder == null ) {
			$this->_setOptionsstructureHasBeenCompared(true);
		}
	}
	
	private function _get( $query ) {
		$queryArray = $this->_convertQueryToArray( $query );
		$result = $this->_getFromData($queryArray);
		return $result;
	}
	
	private function _convertQueryToArray( $query ) {
		$queryArray = explode(' ', $query);
		return $queryArray;
	}	

	private function _getFromData( $queryArray ){
		$dataPointer = &$this->_data;
		
		if( empty( $dataPointer ) ) {
			return null;
		}
		
		foreach( $queryArray as $oneArraySection ) {
			if( isset( $dataPointer[ $oneArraySection ] ) ) {
				$dataPointer = &$dataPointer[ $oneArraySection ];
			} else {
				return null;
			}
		}
		
		return ( $dataPointer );
	}
	
	
/******************************************************************************/
/* ITERATOR INTERFACE
/******************************************************************************/
	private $_currentKeys = array();
	private $_currentKeysCount = 0;
	
	private $_currentVariationType = null;
	
	public function getVariationType() {
		return $this->_currentVariationType;
	}
	
	public function getNumberOfElements() { 
		$this->_recalculateKeys();
		return count( $this->_currentKeys );
	}
	
	public function setVariationType( $variationType ) {
		$this->_currentVariationType = $variationType;
	}
	
	private function _recalculateKeys() {
		$dataPart = $this->getOnlyDataPart( $this->_getPath(), false );
		$this->_currentKeys = array_keys( $dataPart );
		$this->_currentKeysCount = count( $this->_currentKeys );
		$this->_currentVariationType = null;
	}
	
	public function current () {
		$this->_currentVariationType = null;
		
		$currentKey = $this->_currentKeys[ $this->_iteratorPointer ];
		
		if( is_numeric($currentKey) ) {
			return $this->getNew( $this->_getPath() .' '.$this->_iteratorPointer);
		}
		
		$potentialSplit = explode('-|-', $currentKey);
		
		// 0-|-one-text-item
		$queryAddition = $this->_iteratorPointer;
		if( count( $potentialSplit )  == 2 ) {
			$index = $potentialSplit[0];
			$type = $potentialSplit[1];
			
			$queryAddition = $currentKey . ' ' . $type;
			$this->_currentVariationType = $type;
		}
		
		$newQuery = $this->getNew( $this->_getPath() .' '.$queryAddition);
		$newQuery->setVariationType( $this->_currentVariationType );
		return $newQuery;
		
		
		//var_dump( is_numeric('0-|-one-text-item'));
		
		//if( is_numeric($var))
		
		//var_dump( $currentKey );
		
		//die();
		
		//return $this->getNew( $this->_getPath() .' '.$this->_iteratorPointer);
	}
	public function key () {
		return $this->_iteratorPointer;
	}
	public function next () {
		$this->_iteratorPointer++;
	}
	public function rewind () {
		$this->_iteratorPointer = 0;
		$this->_recalculateKeys();
	}
	public function valid () {
		if( $this->_iteratorPointer == 0) {
			return $this->_validFirst();
		} else {
			return $this->_validNotFirst();
		}
		
		
		/*$this->_iteratorValidHolder = $this->get( $this->_getPath() . ' ' . $this->_iteratorPointer);
		if( $this->_iteratorValidHolder !== null ) {
			return true;
		} else {
			return false;
		}*/
		//if( $this->_iteratorPointer <= 2) return true;
		//return false;
	}
	
	private function _validFirst() {
		if( $this->_currentKeysCount == 0 ) {
			$this->_compareDataWithStructure();
			$this->_recalculateKeys();
			
			return $this->_validNotFirst();
		}
		return true;
		
		
		/*
		$dataPart = $this->getOnlyDataPart( $this->_getPath(), false );
		var_dump( count($dataPart) );
		$a = microtime(true);
		var_dump( array_keys( $dataPart ));
		//var_dump( ( microtime(true) - $a) * 10);
		die();
		echo $this->_getPath() . ' ' . $this->_iteratorPointer;
		die();
		
		if( !($this->getOnlyDataPart( $this->_getPath() .' ' . $this->_iteratorPointer, false )) ) {
			$this->_compareDataWithStructure();
			return $this->_validNotFirst();
		} else {
			return true;
		}*/
	} 
	
	private function _validNotFirst() {
		if( $this->_iteratorPointer == $this->_currentKeysCount || $this->_currentKeysCount == 0 ) {
			return false;
		}
		
		return true;
		
		/////]
		
		return;
		if( ($this->getOnlyDataPart( $this->_getPath() .' ' . $this->_iteratorPointer, false )) ) {
			return true;
		} else {
			return false;
		}
	}
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	public function setWPLayer( ffWPLayer $WPLayer ) {
		$this->_WPLayer = $WPLayer;
	}
	
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	/********** DATA **********/
	private function _setData( $data ) {
		$this->_data = $data;
	}
	
	/**
	 * 
	 */
	private function _getData() {
		return $this->_data;
	}
	
	/********** ARRAY CONVERTOR **********/
	private function _setArrayConvertor(ffOptionsArrayConvertor $arrayConvertor ){
		$this->_arrayConvertor = $arrayConvertor;
	}
	
	/**
	 * 
	 * @return ffOptionsArrayConvertor
	 */
	private function _getArrayConvertor() {
		return $this->_arrayConvertor;
	}
	
	/********** OPTIONS HOLDER **********/
	private function _setOptionsHolder(ffIOptionsHolder $optionsHolder ) {
		$this->_optionsHolder = $optionsHolder;
	}
	/**
	 * 
	 * @return ffIOptionsHolder
	 */
	private function _getOptionsHolder() {
		return $this->_optionsHolder;
	}

	/**
	 * @return unknown_type
	 */
	protected function _getPath() {
		return $this->_path;
	}
	
	/**
	 * @param unknown_type $path
	 */
	protected function _setPath($path) {
		$this->_path = $path;
		return $this;
	}

	/**
	 * @return unknown_type
	 */
	protected function _getOptionsstructureHasBeenCompared() {
		return $this->_optionsStructureHasBeenCompared;
	}
	
	/**
	 * @param unknown_type $optionsStructureHasBeenCompared
	 */
	protected function _setOptionsstructureHasBeenCompared($optionsStructureHasBeenCompared) {
		$this->_optionsStructureHasBeenCompared = $optionsStructureHasBeenCompared;
		return $this;
	}
	
	
}