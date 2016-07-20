<?php

class ffModalWindowLibraryColorPickerColorPreparator extends ffBasicObject {

################################################################################
# CONSTANTS
################################################################################

################################################################################
# PRIVATE OBJECTS
################################################################################
	/**
	 * 
	 * @var ffLessUserSelectedColorsDataStorage
	 */
	private $_lessUserSelectedColors = null;
	
	/**
	 * 
	 * @var ffUserColorLibrary
	 */
	private $_userColorLibrary = null;
	
	/**
	 * 
	 * @var ffLessSystemColorLibrary
	 */
	private $_systemColorLibrary = null;
	
	/**
	 * 
	 * @var ffLessSystemColorLibraryBackend
	 */
	private $_systemColorLibraryBackend = null;
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
################################################################################
# PRIVATE VARIABLES	
################################################################################	

################################################################################
# CONSTRUCTOR
################################################################################	
	public function __construct( ffLessUserSelectedColorsDataStorage $lessUserSelectedColors, ffUserColorLibrary $userColorLibrary, ffLessSystemColorLibrary $systemColorLibrary, ffLessSystemColorLibraryBackend $systemColorLibraryBackend, ffWPLayer $WPLayer ) {
		$this->_setLessUserSelectedColors($lessUserSelectedColors);
		$this->_setUserColorLibrary($userColorLibrary);
		$this->_setSystemColorLibrary($systemColorLibrary);
		$this->_setSystemColorLibraryBackend($systemColorLibraryBackend);
		$this->_setWPLayer($WPLayer);
	}
################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	
	public function getPreparedUserColors( $selectedColorName = null ) {
		$userColors = $this->_getUserColorLibrary()->getColors();
		
		if( empty( $userColors ) ) {
			return array();
		}
	
		$colorsSortedByGroup = array();
		
		foreach( $userColors as $oneColor ) {
			$groupSanitized = $oneColor->getGroup();//strtolower($this->_getWPLayer()->sanitize_only_letters_and_numbers( $oneColor->getGroup() ));
		
			$colorsSortedByGroup[ $groupSanitized ][] = $oneColor;
		}		
	
		
		return $colorsSortedByGroup;
	}
	
	public function deleteUserColorGroup( $groupName ) {
		$colors = $this->_getUserColorLibrary()->getColors();
	
		foreach( $colors as $oneColor ) {
			$groupSanitized = strtolower($this->_getWPLayer()->sanitize_only_letters_and_numbers( $oneColor->getGroup() ));
		
			if( $groupSanitized == $groupName ) {
				$this->_getUserColorLibrary()->deleteColor( $oneColor);
			}
		}
		
		$groups = $this->getUserColorsGroups();
		
		if( isset( $groups[$groupName ] ) ) {
			unset( $groups[ $groupName ] );
			
			$this->setUserColorGroups( $groups );
		}
		
		
	}
	
	public function getUserColorsGroups() {
		return $this->_getUserColorLibrary()->getUserColorGroups();
	}
	
	public function setUserColorGroups( $value ) {
		return $this->_getUserColorLibrary()->setUserColorGroups( $value );
	}
	
	public function getPreparedSystemColors( $selectedColorName = null ) {
		$systemColors = $this->_getSystemColorLibrary()->getColors();
		$systemColorsInGroups = $this->_getSystemColorLibraryBackend()->getColorList();
		$bannedColors = $this->_getSystemColorLibraryBackend()->getBannedVariable( $selectedColorName  );
		
		$newColorsInGroup = array();
		
		unset($systemColorsInGroups['user_group']);
		//var_dump( $systemColorsInGroups );
		
		if( empty( $systemColorsInGroups ) ) {
			return false;
		}
		
	 	foreach( $systemColorsInGroups as $groupName=> $oneGroup ) {

	 		foreach( $oneGroup as $colorName => $colorValue ) {
	 			
	 			if( !in_array( $colorName, $bannedColors ) ) {
	 				$colorValueFinal = $systemColors[ $colorName ];
	 				$newColorsInGroup[ $groupName ][ $colorName ] = $colorValueFinal;
	 			}
	 			
	 		}
	 		
	 	}
	 	
	 	return( $newColorsInGroup );
	}
	
	public function getBannedColors( $colorName = null) {
		return $this->_getSystemColorLibraryBackend()->getBannedVariable( $colorName);
	}
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	private function _decideWhichColorsToIgnore( $selectedColorsName ) {
	 	
	}
################################################################################
# GETTERS AND SETTERS
################################################################################	
	/**
	 *
	 * @return ffLessUserSelectedColorsDataStorage
	 */
	protected function _getLessUserSelectedColors() {
		return $this->_lessUserSelectedColors;
	}
	
	/**
	 *
	 * @param ffLessUserSelectedColorsDataStorage $lessUserSelectedColors
	 */
	protected function _setLessUserSelectedColors(ffLessUserSelectedColorsDataStorage $lessUserSelectedColors) {
		$this->_lessUserSelectedColors = $lessUserSelectedColors;
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
	
	/**
	 *
	 * @return ffLessSystemColorLibrary
	 */
	protected function _getSystemColorLibrary() {
		return $this->_systemColorLibrary;
	}
	
	/**
	 *
	 * @param ffLessSystemColorLibrary $systemColorLibrary
	 */
	protected function _setSystemColorLibrary(ffLessSystemColorLibrary $systemColorLibrary) {
		$this->_systemColorLibrary = $systemColorLibrary;
		return $this;
	}
	
	/**
	 *
	 * @return ffLessSystemColorLibraryBackend
	 */
	protected function _getSystemColorLibraryBackend() {
		return $this->_systemColorLibraryBackend;
	}
	
	/**
	 *
	 * @param ffLessSystemColorLibraryBackend $systemColorLibraryBackend
	 */
	protected function _setSystemColorLibraryBackend(ffLessSystemColorLibraryBackend $systemColorLibraryBackend) {
		$this->_systemColorLibraryBackend = $systemColorLibraryBackend;
		return $this;
	}
	
	/**
	 *
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 *
	 * @param ffWPLayer $WPLayer        	
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
}