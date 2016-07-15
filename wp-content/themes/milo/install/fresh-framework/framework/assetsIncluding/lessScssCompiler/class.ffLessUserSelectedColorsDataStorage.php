<?php

class ffLessUserSelectedColorsDataStorage extends ffBasicObject {

################################################################################
# CONSTANTS
################################################################################
	const OPTIONS_NAMESPACE = 'colors_user_selected';
################################################################################
# PRIVATE OBJECTS
################################################################################
	/**
	 * 
	 * @var ffDataStorage_OptionsPostType_NamespaceFacade
	 */
	private $_dataStorage = null;
	
	/**
	 * 
	 * @var ffUserColorLibrary
	 */
 	private $_userColorLibrary = null;
################################################################################
# PRIVATE VARIABLES	
################################################################################	

################################################################################
# CONSTRUCTOR
################################################################################	
	public function __construct( ffDataStorage_OptionsPostType_NamespaceFacade $dataStorage, ffUserColorLibrary $colorLibrary ) {
		$this->_setDatastorage($dataStorage);
		$this->_getDatastorage()->setNamespace( ffLessUserSelectedColorsDataStorage::OPTIONS_NAMESPACE );
		$this->_setUserColorLibrary( $colorLibrary );
	}

################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	

	public function getColorsAsArray() {
		$colors = $this->_getDatastorage()->getAllOptionsForNamespaceWithValues();
		
		return $colors;
	}
	
	public function getColor( $colorName ) {
		return $this->_getDatastorage()->getOption( $colorName );
	}
	
	
	public function getColorsAsString() {
		$colors = $this->_getDatastorage()->getAllOptionsForNamespaceWithValues();
		
		if( empty( $colors ) ) {
			return '';
		}
		
		$colorString = '';
		foreach( $colors as $oneColorName => $oneColorValue ) {
			if( strpos( $oneColorValue, ffUserColorLibrary::LESS_COLOR_PREFIX ) === 0 ) {
				//$id = str_replace('@ff-color-lib-', '', $oneColorValue);
				$id = $oneColorValue;
				$color = $this->_getUserColorLibrary()->getColor( $id );
				
				if( $color !== null ) {
					$hex = $color->getColor()->getHex();
					
					$colorString .= $oneColorName . ': '.$hex.';' . "\n";
				}
			} else {
				$colorString .= $oneColorName .': ' . $oneColorValue .';' . "\n";
			}
		}
		
		return $colorString;
	}
	
	public function setUserColor( $name, $value ) {		
		$this->_getDatastorage()->setOption($name, $value);
	}
	
	public function deleteUserColor( $name ) {
		$this->_getDatastorage()->deleteOption( $name );
	}
	
	public function removeVariablesWithValue( $value ) {
		$value = $this->_forceArray( $value );
	
		$foundNames = $this->findVariablesWithValue( $value );
	
		foreach( $foundNames as $oneName ){
			$this->_getDatastorage()->deleteOption( $oneName );
		}
	}
	
	public function findVariablesWithValue( $value ) {
		$namespace = $this->_getNamespaceWithoutPrivateVariable();
		
		$foundNames = array();
		
		foreach( $namespace as $oneName => $oneValue ) {
			if( $oneValue == $value ) {
				$foundNames[] = $oneName;
			}
		}
		
		return $foundNames;
	}
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	private function _getNamespaceWithoutPrivateVariable() {
		$namespaceWithPrivate = $this->_getDatastorage()->getAllOptionsForNamespaceWithValues();
		unset( $namespaceWithPrivate['private_values'] );
		
		return $namespaceWithPrivate;
	}
	
	private function _forceArray( $value ) {
		if( !is_array( $value ) ) {
			$value = array( $value );
		}
	 	
		return $value;
	}
################################################################################
# GETTERS AND SETTERS
################################################################################	

	/**
	 *
	 * @return ffDataStorage_OptionsPostType_NamespaceFacade
	 */
	protected function _getDatastorage() {
		return $this->_dataStorage;
	}
	
	/**
	 *
	 * @param ffDataStorage_OptionsPostType_NamespaceFacade $dataStorage
	 */
	protected function _setDatastorage(ffDataStorage_OptionsPostType_NamespaceFacade $dataStorage) {
		$this->_dataStorage = $dataStorage;
		return $this;
	}
	
	/**
	 *
	 * @return ffUserColorLibrary
	 */
	protected function _getUserColorLibrary() {
		return $this->_userColorLibrary;
	}
	
	/**
	 *
	 * @param ffUserColorLibrary $userColorLibrary        	
	 */
	protected function _setUserColorLibrary(ffUserColorLibrary $userColorLibrary) {
		$this->_userColorLibrary = $userColorLibrary;
		return $this;
	}
	
	
}

// class ffLessColorVariableDataStorage extends ffBasicObject {
// ################################################################################
// # CONSTANTS
// ################################################################################
// 	const OPTIONS_NAMESPACE = 'colors_user_selected';
// ################################################################################
// # PRIVATE OBJECTS
// ################################################################################
// 	/**
// 	 * 
// 	 * @var ffDataStorage_OptionsPostType_NamespaceFacade
// 	 */
// 	private $_options = null;
	
// 	/**
// 	 * 
// 	 * @var ffColorLibrary
// 	 */
// 	private $_colorLibrary = null;
// ################################################################################
// # PRIVATE VARIABLES	
// ################################################################################	

// ################################################################################
// # CONSTRUCTOR
// ################################################################################	
// 	public function __construct() {
// 		$this->_setOptions( ffContainer::getInstance()->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade() );
// 		$this->_getOptions( ffLessColorVariableDataStorage::OPTIONS_NAMESPACE);
// 		$this->_setColorLibrary( ffContainer::getInstance()->getLibManager()->createColorLibrary() );
// 	}
// ################################################################################
// # ACTIONS
// ################################################################################
	
// ################################################################################
// # PUBLIC FUNCTIONS
// ################################################################################
// 	public function getColorsLessString() {
// 		$colors = $this->getColors();
		
// 		$colorString = '';
		
// 		foreach( $colors as $name => $value  ) {
// 			// REPLACE COLORS FROM OUR LIBRARY
// 			if( strpos( $value, '@ff-color-lib-') === 0 ) {
// 				$id = str_replace('@ff-color-lib-', '', $value);
				
// 				$color = $this->_getColorLibrary()->getColor( $id );
				
// 				if( $color !== null ) {
// 					$hex = $color->getColor()->getHex();
					
// 					$colorString .= $name . ' : '.$hex.';' . "\n";
// 				}
// 			} else {
// 				$colorString .= $name .' : ' . $value .';' . "\n";
// 			}
// 		}
		
// 		return $colorString;
// 	}
	
// 	public function getColors() {
// 		return $this->_getAllColors();
// 	}
	
// 	public function getColorsAsString() {
// 		$colors = $this->getColors();
// 		$toReturn = '';
// 		foreach( $colors as $name => $value ) {
// 			$toReturn .=  $name .' : ' .$value .';'."\n";
// 		}
		
// 		return $toReturn;
// 	}
	
// 	public function setColor( $name, $value ) {
// 		$this->_options->setOption( $name, $value);
// 	}
	
// 	public function getColorsWithValue( $value ) {
// 		if( !is_array( $value ) ) {
// 			$value = array( $value );
// 		} 
		
// 		$colors = $this->getColors();
		
// 		$colorNames = array();
		
// 		foreach( $value as $oneValue ) {
// 			$search = array_search( $oneValue, $colors );
// 			if( $search !== false ) {
// 				$colorNames[] = $search;
// 			}
// 		}
		
// 		return $colorNames;
// 	}
	
// ################################################################################
// # PRIVATE FUNCTIONS
// ################################################################################
// 	 private function _getAllColors() {
// 	 	return $this->_options->getAllOptionsForNamespaceWithValues();
// 	 }
// ################################################################################
// # GETTERS AND SETTERS
// ################################################################################	
// 	/**
// 	 *
// 	 * @return ffDataStorage_OptionsPostType_NamespaceFacade
// 	 */
// 	protected function _getOptions() {
// 		return $this->_options;
// 	}
	
// 	/**
// 	 *
// 	 * @param ffDataStorage_OptionsPostType_NamespaceFacade $_options
// 	 */
// 	protected function _setOptions(ffDataStorage_OptionsPostType_NamespaceFacade $options) {
// 		$this->_options = $options;
// 		return $this;
// 	}
	
// 	/**
// 	 *
// 	 * @return ffColorLibrary
// 	 */
// 	protected function _getColorLibrary() {
// 		return $this->_colorLibrary;
// 	}
	
// 	/**
// 	 *
// 	 * @param ffColorLibrary $colorLibrary        	
// 	 */
// 	protected function _setColorLibrary(ffColorLibrary $colorLibrary) {
// 		$this->_colorLibrary = $colorLibrary;
// 		return $this;
// 	}
	
// }