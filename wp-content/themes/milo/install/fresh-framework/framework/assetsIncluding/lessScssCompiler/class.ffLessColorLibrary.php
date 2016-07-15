<?php

class ffLessColorLibrary extends ffBasicObject {

################################################################################
# CONSTANTS
################################################################################
	const TYPE_USER = 'urs';
	const TYPE_SYSTEM = 'sys';
################################################################################
# PRIVATE OBJECTS
################################################################################

	
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
	 * @var ffLessUserSelectedColorsDataStorage
	 */
	private $_userSelectedColors = null;
	
	
################################################################################
# PRIVATE VARIABLES	
################################################################################	

################################################################################
# CONSTRUCTOR
################################################################################	

	
	public function __construct( ffUserColorLibrary $userColorLibrary, ffLessSystemColorLibrary $systemColorLibrary, ffLessUserSelectedColorsDataStorage $userSelectedColors ) {
		$this->_setUserColorLibrary( $userColorLibrary );// ffContainer::getInstance()->getLibManager()->createUserColorLibrary() );
		$this->_setSystemColorLibrary( $systemColorLibrary );//ffContainer::getInstance()->getAssetsIncludingFactory()->getLessSystemColorLibrary() );
		$this->_setUserSelectedColors($userSelectedColors);
	}

	
################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	
	
	
	public function getColorOptionData( $colorName ) {
		//$this->_getUserSelectedColors()->setUserColor( $colorName, '@ff-color-lib-4');
		//die();
		
		
		$dataToReturn = new stdClass();
		
		// NAME OF THE COLOR, IF SELECTED
		$dataToReturn->pickedColorName = $this->_getUserSelectedColors()->getColor($colorName);
		
		// NO COLOR SELECTED, GET DEFAULT VALUE AS DEFINED IN LESS FILE 
		if( null == $dataToReturn->pickedColorName ) {
			$dataToReturn->colorValue = $this->_getSystemColorLibrary()->getColor( $colorName );
			
		// WE ALREADY SELECTED COLOR
		} else {
			// USER OR SYSTEM
			$type = $this->_getColorType( $dataToReturn->pickedColorName );
			
			// USER - ASSIGN THE FINAL COLOR
			if( ffLessColorLibrary::TYPE_USER == $type ) {
			
				$colorItem = $this->_getUserColorLibrary()->getColor($dataToReturn->pickedColorName);
				
				if( $colorItem instanceof  ffUserColorLibraryItem ) {			
				
					$dataToReturn->colorValue = $colorItem->getColor()->getHTMLColor();
				} else {
					$dataToReturn->colorValue = $this->_getSystemColorLibrary()->getColor( $colorName );
				}
				
			// SYSTEM - ASSIGN THE FINAL COLOR
			} else if ( ffLessColorLibrary::TYPE_SYSTEM == $type ) {
				$dataToReturn->colorValue =  $this->_getSystemColorLibrary()->getColor( $dataToReturn->pickedColorName );
				
			}
			
		}
		
		$referenceVariables = ffContainer::getInstance()->getAssetsIncludingFactory()->getLessSystemColorLibraryBackend()->getReferenceVariables();
	/*	echo '<pre>';
		
		var_dump( $bannedVariables );
		echo '</pre>';
		$isBanned = false;
		foreach( $bannedVariables as $parentName => $content ) {
			if( in_array( $colorName, $content ) ) {
				$isBanned = $parentName;
			}
		}
		
		var_dump( $isBanned );*/
		
		if( isset( $referenceVariables[ $colorName ] ) ) {
			$dataToReturn->defaultValue = $this->_getSystemColorLibrary()->getColor( $referenceVariables[ $colorName ] );
		} else {
			$dataToReturn->defaultValue = ffContainer::getInstance()->getAssetsIncludingFactory()->getLessSystemColorLibraryDefault()->getColor( $colorName );
		}
	
		
		//var_dump( $dataToReturn );
		
		//$dataToReturn->defaultValue = ffContainer::getInstance()->getAssetsIncludingFactory()->getLessSystemColorLibraryDefault()->getColor( $colorName );//$this->_getSystemColorLibrary()->getColor( $colorName );
		
		

		//var_dump( ffContainer::getInstance()->getAssetsIncludingFactory()->getLessSystemColorLibraryBackend()->getBannedVariable());
		
		return $dataToReturn;
	}
	
	public function setUserColor( $colorName, $colorValue ) {
		
		return $this->_getUserSelectedColors()->setUserColor( $colorName , $colorValue );
	}
	
	public function deleteUserColor( $colorName ) {
		return $this->_getUserSelectedColors()->deleteUserColor($colorName);
	}
	
	
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	 
	private function _getColorType( $colorName ) {
		if( strpos( $colorName, ffUserColorLibrary::LESS_COLOR_PREFIX ) === 0 ) {
			return ffLessColorLibrary::TYPE_USER;
		} else {
			return ffLessColorLibrary::TYPE_SYSTEM;
		}
	}
	
################################################################################
# GETTERS AND SETTERS
################################################################################	

	
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
	 * @return ffLessUserSelectedColorsDataStorage
	 */
	protected function _getUserSelectedColors() {
		return $this->_userSelectedColors;
	}
	
	/**
	 *
	 * @param ffLessUserSelectedColorsDataStorage $userSelectedColors        	
	 */
	protected function _setUserSelectedColors(ffLessUserSelectedColorsDataStorage $userSelectedColors) {
		$this->_userSelectedColors = $userSelectedColors;
		return $this;
	}
	
	
	
}