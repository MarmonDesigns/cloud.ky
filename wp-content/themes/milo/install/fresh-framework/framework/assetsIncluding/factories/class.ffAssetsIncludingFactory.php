<?php

class ffAssetsIncludingFactory extends ffFactoryAbstract {
	
/******************************************************************************/
/* LESS OBJECTS
/******************************************************************************/
	
	/**
	 * 
	 * @var ffLessUserSelectedColorsDataStorage
	 */
	private $_lessUserSelectedColorsDataStorage = null;
	
	public function getLessUserSelectedColorsDataStorage() {
		if( $this->_lessUserSelectedColorsDataStorage == null ) {
			$this->_getClassloader()->loadClass('ffLessUserSelectedColorsDataStorage');
			
			$this->_lessUserSelectedColorsDataStorage = new ffLessUserSelectedColorsDataStorage(
				ffContainer::getInstance()->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade(),
				ffContainer::getInstance()->getLibManager()->createUserColorLibrary()
			);
		}
		
		return $this->_lessUserSelectedColorsDataStorage;
	}
	
	
	/**
	 * 
	 * @var ffLessManager
	 */
	private $_lessManager = null;
	
	public function getLessManager() {

		if( $this->_lessManager == null ) {
			$this->_getClassloader()->loadClass('ffLessManager');
			$this->_getClassloader()->loadClass('ffOneLessFileFactory');
			$this->_getClassloader()->loadClass('ffOneLessFile');
			
			$oneLessFileFactory = new ffOneLessFileFactory( $this->_getClassloader() );
			
			$this->_lessManager = new ffLessManager(	
					$oneLessFileFactory,
					ffContainer::getInstance()->getFileSystem(),
					ffContainer::getInstance()->getDataStorageCache(),
					ffContainer::getInstance()->getLessParser(),
					$this->getLessUserSelectedColorsDataStorage(),
					ffContainer::getInstance()->getWPLayer()
			);
		}
		
		
		return $this->_lessManager;
	}
	
	private $_colorLibrary = null;
	
	public function getColorLibrary() {
		if( $this->_colorLibrary == null ) {
			$this->_getClassloader()->loadClass('ffLessColorLibrary');
			
			$this->_colorLibrary = new ffLessColorLibrary(
					ffContainer::getInstance()->getLibManager()->createUserColorLibrary(),
					$this->getLessSystemColorLibrary(),
					$this->getLessUserSelectedColorsDataStorage()
			);
		}
		
		return $this->_colorLibrary;
	}
	
	
	private $_optionsColorHashes = null;
	
	public function getOptionsColorHashes() {
		if( $this->_optionsColorHashes == null ) {
			$this->_optionsColorHashes = ffContainer::getInstance()->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade();
			$this->_optionsColorHashes->setNamespace('colors_hashes');
		}
		
		return $this->_optionsColorHashes;
	}
	
	private $_systemColorLibrary = null;
	
	public function getLessSystemColorLibrary() {
		if( $this->_systemColorLibrary == null ) {
			$this->_getClassloader()->loadClass('ffLessSystemColorLibrary');
			
			$this->_systemColorLibrary = new ffLessSystemColorLibrary( ffContainer::getInstance()->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade(), $this->getOptionsColorHashes() );
		}

		return $this->_systemColorLibrary;
	}
	
	
	private $_systemColorLibraryDefault = null;
	
	public function getLessSystemColorLibraryDefault() {
		if( $this->_systemColorLibraryDefault == null ) {
			$this->_getClassloader()->loadClass('ffLessSystemColorLibraryDefault');
				
			$this->_systemColorLibraryDefault = new ffLessSystemColorLibraryDefault( ffContainer::getInstance()->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade(),$this->getOptionsColorHashes() );
		}
	
		return $this->_systemColorLibraryDefault;
	}
	
	
	private $_systemColorLibraryBackend = null;
	
	public function getLessSystemColorLibraryBackend() {
		if( $this->_systemColorLibraryBackend == null ) {
			$this->_getClassloader()->loadClass('ffLessSystemColorLibraryBackend');
				
			$this->_systemColorLibraryBackend = new ffLessSystemColorLibraryBackend( ffContainer::getInstance()->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade(),$this->getOptionsColorHashes() );
		}
	
		return $this->_systemColorLibraryBackend;
	}
	
	private $_systemColorLibraryManager = null;
	
	public function getLessSystemColorLibraryManager() {
		if( $this->_systemColorLibraryManager == null ) {
			$this->_getClassloader()->loadClass('ffLessSystemColorLibraryManager');
			
			$this->_systemColorLibraryManager = new ffLessSystemColorLibraryManager(
				$this->getLessManager(),
				$this->getLessSystemColorLibrary(),
				$this->getLessSystemColorLibraryBackend(),
				$this->getLessVariableParser(),
				$this->getLessUserSelectedColorsDataStorage(),
				$this->getLessSystemColorLibraryDefault()
			);
			
		}
		
		return $this->_systemColorLibraryManager;
	}
	
	public function getLessVariableParser() {
		$this->_getClassloader()->loadClass('ffLessVariableParser');
		
		return new ffLessVariableParser( ffContainer::getInstance()->getLessParser() );
	}
}