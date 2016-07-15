<?php

class ffUserColorLibrary extends ffBasicObject {

################################################################################
# CONSTANTS
################################################################################
	const LIBRARY_NAMESPACE = 'color';
	
	const ID_AUTOINCREMENT_VALUE = 'id_autoincrement';
	
	const PRIVATE_OPTIONS = 'private_options';
	
	const USER_COLOR_GROUPS = 'user_color_groups';
	
	const LESS_COLOR_PREFIX = '@ff-color-lib-';
################################################################################
# PRIVATE OBJECTS
################################################################################
	
################################################################################
# PRIVATE VARIABLES	
################################################################################
	/**
	 * 
	 * @var ffColorLibraryItemFactory
	 */
	private $_colorLibraryItemFactory = null;
	
	/**
	 * 
	 * @var ffDataStorage_OptionsPostType_NamespaceFacade
	 */
	private $_dataStorage = null;
	
	private $_currentIdMax = null;
################################################################################
# CONSTRUCTOR
################################################################################	
	public function __construct( ffUserColorLibraryItemFactory $colorLibraryItemFactory, ffDataStorage_OptionsPostType_NamespaceFacade $dataStorage ) {
		$this->_setColorLibraryItemFactory($colorLibraryItemFactory);
		$this->_setDataStorage( $dataStorage );
	}
################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################
	/**
	 * 
	 * @return array[ffUserColorLibraryItem]
	 */	
	public function getColors() {
		$wholeNamespace = $this->_getDataStorage()->getAllOptionsForNamespaceWithValues();
		unset( $wholeNamespace[ ffUserColorLibrary::ID_AUTOINCREMENT_VALUE ] );
		unset( $wholeNamespace[ ffUserColorLibrary::PRIVATE_OPTIONS] );
		return $wholeNamespace;
	}
	
	/**
	 * 
	 * @return ffUserColorLibraryItem
	 */
	public function getNewColor() {
		$newColorItem =  $this->_colorLibraryItemFactory->createUserColorLibraryItem();
		$newColorItem->setId( $this->_getNewIdMax() );
		return $newColorItem;
	}
	
	/**
	 * 
	 * @param unknown $colorId
	 * @return ffUserColorLibraryItem
	 */
	public function getColor( $colorId ) {
		$colorId = $this->_normalizeId( $colorId );
		$color = $this->_getDataStorage()->getOption( $colorId );
		return $color;
	}
	
	public function setColor( ffUserColorLibraryItem $color ) {
		
		$this->_getDataStorage()->setOption( $color->getId( false ), $color);
	}
	
	public function deleteColor( ffUserColorLibraryItem $color ) {
		$this->deleteColorById( $color->getId( false ) );
	}
	
	public function deleteColorById( $id ) {
		$id = $this->_normalizeId($id);
		$this->_getDataStorage()->deleteOption( $id );
	}
	
	public function getNewId() {
		return $this->_getNewIdMax();
	}
	
	public function getPrivateOption( $name ) {
		$options = $this->_getPrivateOptions();
		
		if( isset( $options[ $name ] ) ) {
			return $options[ $name ];
		} else {
			return null;
		}
	}
	
	public function setPrivateOptions( $name, $value ) {
		$options = $this->_getPrivateOptions();
		
		$options[ $name ] = $value;
		$this->_setPrivateOptions( $options );
	}
	
	
	public function getUserColorGroups() {
		return $this->getPrivateOption( ffUserColorLibrary::USER_COLOR_GROUPS );
	}
	
	public function setUserColorGroups( $value ) {
		return $this->setPrivateOptions( ffUserColorLibrary::USER_COLOR_GROUPS, $value );
	}
	
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	private function _normalizeId( $id ) {
		$idNormalized = str_replace( ffUserColorLibrary::LESS_COLOR_PREFIX, '', $id);
		
		return $idNormalized;
	}
	
	private function _getPrivateOptions() {
		return $this->_getDataStorage()->getOption( ffUserColorLibrary::PRIVATE_OPTIONS );
	}
	
	private function _setPrivateOptions( $privateOptions ) {
		return $this->_getDataStorage()->setOption( ffUserColorLibrary::PRIVATE_OPTIONS, $privateOptions );
	}
	
	
	 private function _getNewIdMax() {
	 	if( $this->_currentIdMax == null ) {
	 		$this->_currentIdMax = $this->_getDataStorage()->getOption( ffUserColorLibrary::ID_AUTOINCREMENT_VALUE, 0);
	 	}
	 	
	 	$this->_currentIdMax++;
	 	
	 	$this->_getDataStorage()->setOption( ffUserColorLibrary::ID_AUTOINCREMENT_VALUE, $this->_currentIdMax );
	 	
	 	return $this->_currentIdMax;
	 	
	 }
################################################################################
# GETTERS AND SETTERS
################################################################################	
	/**
	 *
	 * @return ffColorLibraryItem
	 */
	protected function _getColorLibraryItemFactory() {
		return $this->_colorLibraryItemFactory;
	}
	
	/**
	 *
	 * @param ffColorLibraryItemFactory $colorLibraryItemFactory
	 */
	protected function _setColorLibraryItemFactory(ffUserColorLibraryItemFactory $colorLibraryItemFactory) {
		$this->_colorLibraryItemFactory = $colorLibraryItemFactory;
		return $this;
	}
	
	/**
	 *
	 * @return ffDataStorage_OptionsPostType_NamespaceFacade
	 */
	protected function _getDataStorage() {
		return $this->_dataStorage;
	}
	
	/**
	 *
	 * @param ffDataStorage_OptionsPostType_NamespaceFacade $dataStorage        	
	 */
	protected function _setDataStorage(ffDataStorage_OptionsPostType_NamespaceFacade $dataStorage) {
		$this->_dataStorage = $dataStorage;
		return $this;
	}
	
}