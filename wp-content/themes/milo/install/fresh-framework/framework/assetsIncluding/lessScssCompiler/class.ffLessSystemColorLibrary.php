<?php

class ffLessSystemColorLibrary extends ffBasicObject {
################################################################################
# CONSTANTS
################################################################################
	const COLOR_NAMESPACE = 'color_namespace';
################################################################################
# PRIVATE OBJECTS
################################################################################
	/**
	 * 
	 * @var ffDataStorage_OptionsPostType_NamespaceFacade
	 */
	private $_options = null;
	
	/**
	 * 
	 * @var ffDataStorage_OptionsPostType_NamespaceFacade
	 */
	private $_optionsHashes = null;
################################################################################
# PRIVATE VARIABLES	
################################################################################	

################################################################################
# CONSTRUCTOR
################################################################################	
	public function __construct( ffDataStorage_OptionsPostType_NamespaceFacade $options,  ffDataStorage_OptionsPostType_NamespaceFacade $optionsHashes) {
		$this->_setOptions( $options );
		$this->_getOptions()->setNamespace( ffLessSystemColorLibrary::COLOR_NAMESPACE );
		$this->_setOptionsHashes($optionsHashes);
	}
################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	
	public function getColors() {
		$colors = $this->_getOptions()->getAllOptionsForNamespaceWithValues();
		unset( $colors['private_data'] );
		
		return $colors;
	}
	
	public function getColor( $name ) {
		$color = $this->_getOptions()->getOption( $name );
		return $color;
	}
	
	public function getColorHash() {
		return $this->_getOptionsHashes()->getOption( ffLessSystemColorLibrary::COLOR_NAMESPACE .'-file-hash' );
		//return $this->_getPrivateOption('color_file_hash');
	}
	
	public function setNewColors( $hash, $colorsArray ) {
		$oldColors = $this->getColors();
		$missingColors = array_diff( $oldColors, $colorsArray );
		
		$privateData = $this->_getOptions()->getOption('private_data');
		
		$this->_getOptions()->deleteNamespace();
		
		$this->_getOptions()->setOption('private_data', $privateData);
		//$this->_setPrivateOption('color_file_hash', $hash);
		$this->_setHash( $hash );
		foreach( $colorsArray as $name => $value ) {
			$this->_getOptions()->setOption($name, $value);
		}
		
		
		return $missingColors;
	}
 
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	private function _setHash( $hash ) {
		$this->_getOptionsHashes()->setOption( ffLessSystemColorLibrary::COLOR_NAMESPACE .'-file-hash', $hash );
	}
	
	 private function _getPrivateOption( $optionName ) {
	 	$privateData = $this->_getOptions()->getOption('private_data');
	 	if( !isset( $privateData[ $optionName ] ) ) {
	 		return null;
	 	} else {
	 		return $privateData[ $optionName ];
	 	}
	 }
	 
	 private function _setPrivateOption( $optionName, $optionValue ) {
	 	$privateData = $this->_getOptions()->getOption('private_data');
	 	$privateData[ $optionName ] = $optionValue;
	 	$this->_getOptions()->setOption('private_data', $privateData);
	 }
################################################################################
# GETTERS AND SETTERS
################################################################################	

	
	/**
	 *
	 * @return ffDataStorage_OptionsPostType_NamespaceFacade
	 */
	protected function _getOptions() {
		return $this->_options;
	}
	
	/**
	 *
	 * @param ffDataStorage_OptionsPostType_NamespaceFacade $_options
	 */
	protected function _setOptions(ffDataStorage_OptionsPostType_NamespaceFacade $options) {
		$this->_options = $options;
		return $this;
	}
	
	/**
	 *
	 * @return ffDataStorage_OptionsPostType_NamespaceFacade
	 */
	protected function _getOptionsHashes() {
		return $this->_optionsHashes;
	}
	
	/**
	 *
	 * @param ffDataStorage_OptionsPostType_NamespaceFacade $optionsHashes        	
	 */
	protected function _setOptionsHashes(ffDataStorage_OptionsPostType_NamespaceFacade $optionsHashes) {
		$this->_optionsHashes = $optionsHashes;
		return $this;
	}
	
}
