<?php

class ffLessSystemColorLibraryManager extends ffBasicObject {
################################################################################
# CONSTANTS
################################################################################

################################################################################
# PRIVATE OBJECTS
################################################################################
	/**
	 * 
	 * @var ffLessManager
	 */
	private $_lessManager = null;
	
	/**
	 * 
	 * @var ffLessSystemColorLibrary
	 */
	private $_lessSystemColorLibrary = null;
	
	/**
	 * 
	 * @var ffLessSystemColorLibraryDefault
	 */
	private $_lessSystemColorLibraryDefault = null;
	
	/**
	 * 
	 * @var ffLessSystemColorLibraryBackend
	 */
	private $_lessSystemColorLibraryBackend = null;
	
	/**
	 * 
	 * @var ffLessVariableParser
	 */
	private $_lessVariableParser = null;
	
	
	/**
	 * 
	 * @var ffLessUserSelectedColorsDataStorage
	 */
	private $_lessUserSelectedColors = null;
	
	private $_colorLibraryHasBeenPreparedThisRun = false;
################################################################################
# PRIVATE VARIABLES	
################################################################################	

################################################################################
# CONSTRUCTOR
################################################################################	

################################################################################
# ACTIONS 
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	
	public function __construct( ffLessManager $lessManager, ffLessSystemColorLibrary $lessSystemColorLibrary, ffLessSystemColorLibraryBackend $lessSystemColorLibraryBackend, ffLessVariableParser $lessVariableParser, ffLessUserSelectedColorsDataStorage $lessUserSelectedColors, ffLessSystemColorLibraryDefault $lessSystemColorLibraryDefault ) {
		$this->_setLessManager($lessManager);
		$this->_setLessSystemColorLibrary($lessSystemColorLibrary);
		$this->_setLessSystemColorLibraryBackend($lessSystemColorLibraryBackend);
		$this->_setLessVariableParser($lessVariableParser);
		$this->_setLessUserSelectedColors( $lessUserSelectedColors );
		$this->_setLessSystemColorLibraryDefault($lessSystemColorLibraryDefault);	
	}
	
	public function prepareColorLibrariesFromOptions() {
		
	}
	
	public function prepareColorLibraries() {
 
		
	/*	if( $this->_colorLibraryHasBeenPreparedThisRun ) {
			return;
		} else {
			$this->_colorLibraryHasBeenPreparedThisRun = true;
		}*/
		
		$currentRegisteredFilesHash = $this->_getLessManager()->getHash( array( ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE, ffOneLessFile::TYPE_USER) );
		$filesStoredInDatabaseHash = $this->_getLessSystemColorLibrary()->getColorHash();
 
		// TODO ODSTRANIT JINAK SE BUDE VZDY KOMPILIT
		if( $currentRegisteredFilesHash !== $filesStoredInDatabaseHash ) {
			//$this->_getLessUserSelectedColors()->deleteUserColor('@brand-secondary');
			
			$this->_generateColorLibraries( $currentRegisteredFilesHash );
			
		}
		
			//$this->_getLessUserSelectedColors()->setUserColor('@brand-primary', 'blue');
		//$this->_getLessUserSelectedColors()->setUserColor('@brand-secondary', '@ff-color-lib-1');
 
	}
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	 private function _generateColorLibraries( $newHash ) {
	 	/*
	 	 * 
	 	 * Kdyz se prepisou zavislosti zmeni se i defaultni hodnota, oddelat zmenu defaultni hodnoty
	 	 * 
	 	 */
	 	

	 	
	 	$allVariableFilesWithContent = $this->_getLessManager()->getVariableFilesWithContent(  array( ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE, ffOneLessFile::TYPE_USER) );
	 	
	 	//var_dump( $allVariableFilesWithContent );
	
	 	
	 	$contentTogether = '';
	 	$contentByTypes = array();
	 	
	 	// PART FRONT END COLOR LIBRARY
	 	foreach( $allVariableFilesWithContent as $oneVariable ) {
	 		//$colorLibraryGroup = $oneVariable->getAdditionalInfo( ffOneLessFile::INFO_COLOR_LIBRARY_GROUP );
	 		//$contentByTypes[ $oneVariable->getAdditionalInfo( ffOneLessFile::INFO_COLOR_LIBRARY_GROUP ) ] = $this->_getLessVariableParser()->getLessVariablesFromString( $oneVariable->content );
	 		$contentTogether .=  "\n".$oneVariable->content ."\n";
	 	}
	 	//var_dump( $contentTogether );
	 	$allVariables = $this->_getLessVariableParser()->getLessVariablesFromString( $contentTogether );
	 
	 	$variablesWithoutUser = $this->_getLessManager()->getVariableFilesString();
	 	$variablesParsedWithoutUser = $this->_getLessVariableParser()->getLessVariablesFromString($variablesWithoutUser);
	 	$variablesWithoutUserHash = $this->_getLessManager()->getHash();
	 	
	 	$this->_getLessSystemColorLibraryDefault()->setNewColors($variablesWithoutUserHash, $variablesParsedWithoutUser);
	 	
	 	// TODO MISSING COLORS - TEST
	 	$missingColors = $this->_getLessSystemColorLibrary()->setNewColors( $newHash, $allVariables);
	 	$this->_getLessUserSelectedColors()->removeVariablesWithValue($missingColors);
	 	
	 	// PART BACK-END COLOR LIBRARY
	 	foreach( $allVariableFilesWithContent as $oneVariable ) {
	 		$colorLibraryGroup = $oneVariable->getAdditionalInfo( ffOneLessFile::INFO_COLOR_LIBRARY_GROUP );
	 		
	 		
	 		
	 		if( !isset( $contentByTypes[ $colorLibraryGroup ] ) ) {
	 			$contentByTypes[ $colorLibraryGroup ] = array();
	 		}
	 		
	 		$newGroupVariables =  $this->_getLessVariableParser()->getLessVariablesFromString( $oneVariable->content );


            if( !empty( $newGroupVariables ) && is_array( $newGroupVariables) ) {
                foreach( $newGroupVariables as $variable => $value ) {
                    $newValue = $this->_getLessSystemColorLibrary()->getColor( $variable );
                    $newGroupVariables[ $variable ] = $newValue;
                }

	 		
                $contentByTypes[ $colorLibraryGroup ] = array_merge( $contentByTypes[ $colorLibraryGroup ], $newGroupVariables );
            }
	 	}
	 	
	
	 	
	 	$this->_getLessSystemColorLibraryBackend()->setNewColorList( $contentByTypes );
	 	$this->_getLessSystemColorLibraryBackend()->setColorHash( $newHash );

	
	 	
	 	$contentTogetherWithUserSelected = $contentTogether;// . "\n" . $this->_getLessUserSelectedColors()->getColorsAsString();
	 	$generatedReferences = $this->_getLessVariableParser()->getReferenceChainFromString($contentTogetherWithUserSelected);
	 	
	 	$this->_getLessSystemColorLibraryBackend()->setNewBannedVariables($generatedReferences);
	 	$this->_getLessSystemColorLibraryBackend()->setNewReferenceVariables( $this->_getLessVariableParser()->getDirectReferencesFromString($variablesWithoutUser));

	 	//getLessVariablesFromStringWithReferences
	 	
	 }
################################################################################
# GETTERS AND SETTERS
################################################################################	
	/**
	 *
	 * @return ffLessManager
	 */
	protected function _getLessManager() {
		return $this->_lessManager;
	}
	
	/**
	 *
	 * @param ffLessManager $lessManager
	 */
	protected function _setLessManager(ffLessManager $lessManager) {
		$this->_lessManager = $lessManager;
		return $this;
	}
	
	/**
	 *
	 * @return ffLessSystemColorLibrary
	 */
	protected function _getLessSystemColorLibrary() {
		return $this->_lessSystemColorLibrary;
	}
	
	/**
	 *
	 * @param ffLessSystemColorLibrary $lessSystemColorLibrary        	
	 */
	protected function _setLessSystemColorLibrary(ffLessSystemColorLibrary $lessSystemColorLibrary) {
		$this->_lessSystemColorLibrary = $lessSystemColorLibrary;
		return $this;
	}
	
	/**
	 *
	 * @return ffLessSystemColorLibraryBackend
	 */
	protected function _getLessSystemColorLibraryBackend() {
		return $this->_lessSystemColorLibraryBackend;
	}
	
	/**
	 *
	 * @param ffLessSystemColorLibraryBackend $lessSystemColorLibraryBackend        	
	 */
	protected function _setLessSystemColorLibraryBackend(ffLessSystemColorLibraryBackend $lessSystemColorLibraryBackend) {
		$this->_lessSystemColorLibraryBackend = $lessSystemColorLibraryBackend;
		return $this;
	}
	
	/**
	 *
	 * @return ffLessVariableParser
	 */
	protected function _getLessVariableParser() {
		return $this->_lessVariableParser;
	}
	
	/**
	 *
	 * @param ffLessVariableParser $_lessVariableParser        	
	 */
	protected function _setLessVariableParser(ffLessVariableParser $lessVariableParser) {
		$this->_lessVariableParser = $lessVariableParser;
		return $this;
	}
	
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
	 * @return ffLessSystemColorLibraryDefault
	 */
	protected function _getLessSystemColorLibraryDefault() {
		return $this->_lessSystemColorLibraryDefault;
	}
	
	/**
	 *
	 * @param ffLessSystemColorLibraryDefault $lessSystemColorLibraryDefault        	
	 */
	protected function _setLessSystemColorLibraryDefault(ffLessSystemColorLibraryDefault $lessSystemColorLibraryDefault) {
		$this->_lessSystemColorLibraryDefault = $lessSystemColorLibraryDefault;
		return $this;
	}
	
	
	
	
		
}

 
// class ffLessColorLibraryManager extends ffBasicObject {

// ################################################################################
// # CONSTANTS
// ################################################################################

// ################################################################################
// # PRIVATE OBJECTS
// ################################################################################
// 	/**
// 	 * 
// 	 * @var ffLessManager
// 	 */
// 	private $_lessManager = null;
	
// 	/**
// 	 * 
// 	 * @var ffLessVariableParser
// 	 */
// 	private $_lessVariableParser = null;
	
// 	/**
// 	 * 
// 	 * @var ffDataStorage_OptionsPostType_NamespaceFacade
// 	 */
// 	private $_options = null;
	
// 	/**
// 	 * 
// 	 * @var ffLessSystemColorLibrary
// 	 */
// 	private $_colorLibrary = null;
// ################################################################################
// # PRIVATE VARIABLES	
// ################################################################################	
// 	private $_currentVariables = array();
// ################################################################################
// # CONSTRUCTOR
// ################################################################################	
// 	public function __construct() {
// 		$this->_setLessManager( ffContainer::getInstance()->getLessManager() );
// 		$this->_setLessVariableParser( ffContainer::getInstance()->getLessVariableParser() );
// 		$this->_setOptions( ffContainer::getInstance()->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade() );
// 		$this->_setColorLibrary( ffContainer::getInstance()->getLessSystemColorLibrary() );
// 	}
// ################################################################################
// # ACTIONS
// ################################################################################
	
// ################################################################################
// # PUBLIC FUNCTION'
// ################################################################################	
// 	public function test() {
// 	//	$a = array('a','b','c');
// 	//	$b = array('a','b');
		
// 	//	var_dump( array_diff( $a, $b ) );
		
// 		$colorStorage = ffContainer::getInstance()->getLessColorVariableDataStorage();
// 		//$colorStorage->getColorsLessString();
// 		//$colorStorage->setColor('@brand-secondary', '@ff-color-lib-5');

		
// 		//var_dump( $colorStorage->getColorsWithValue('#ffffff') );
// 		return;
// 		$typesArray =  array( ffLessManager::TYPE_BOOTSTRAP, ffLessManager::TYPE_PLUGIN, ffLessManager::TYPE_TEMPLATE );
// 		$fileList = $this->_getLessManager()->getVariableArray( $typesArray );
		
// 		$hash = $this->_getHashFromFileList( $fileList );
// 		$libraryHash = $this->_getColorLibrary()->getColorHash();
		
// 		if( $hash !== $libraryHash ) {
// 			$variableString = $this->_getLessManager()->getVariableContent( $typesArray );
// 			$variablesArray = $this->getVariablesFromLessString( $variableString );
			
// 			$missingColors = $this->_getColorLibrary()->setNewColors( $hash, $variablesArray);			
// 		}
		
		
		
// 		//var_dump( $a );
// 		//$allVariables = $this->_getLessManager()->getVariableContent( array( ffLessManager::TYPE_BOOTSTRAP, ffLessManager::TYPE_PLUGIN, ffLessManager::TYPE_TEMPLATE ) );
// 		//$parsedVariables = array();	
// 	 //	preg_match_all("/(\@[^\:\;\s]*)\:\s*([^\s]*)\s*;/mU", $allVariables, $parsedVariables);
	 	
// 	 	//echo '<pre>';
// 		//var_dump( $parsedVariables );
// 	//	echo '</pre>';

// 		//$this->getVariablesFromLessString( $allVariables );
// 	 	//var_dump( $out );
// 	 	//var_dump(Debugger::timer('aa'));
// 	 	//echo '</pre>';
// 	}
	
// 	private function _getHashFromFileList( $fileList ) {
// 		$stringToHash = '';
		
// 		foreach( $fileList as $oneFile ) {
// 			$stringToHash .= $oneFile['hash'];
// 		}
// 		$hashedString = md5( $stringToHash );
// 		return $hashedString;
// 	}
	
// 	public function getVariablesFromLessString( $text ) {
// 		$parsedVariables = array();
		 
// 		preg_match_all("/(\@[^\:\;\s]*)\:\s*([^\s]*)\s*;/mU", $text, $parsedVariables);
		
// 		$combined = array_combine( $parsedVariables[1], $parsedVariables[2]);
		
// 		$this->_currentVariables = $combined;
// 		$this->_removeReferencesFromVariables();
// 		$this->_removeOtherVariablesThanColors();
		
// 		$currentVariables = $this->_currentVariables;
// 		$this->_currentVariables = null;
		
// 		return $currentVariables;
		
		
// 	//	var_dump( $this->_currentVariables );
		
// 		//echo '<pre>';
// 		//var_dump( Debugger::timer('aa') );
// 		//echo '</pre>';
		
// 		/*
// 		$this->_currentVariableNames = $parsedVariables[1];
// 		$this->_currentVariableValues = $parsedVariables[2];
		
// 		/*foreach( $parsedVariables[1] as $id => $variableName ) {
// 			$variableValue = $parsedVariables[2][$id ];
			
// 			if( $variableValue[0] == '@' ) {
// 				echo $variableValue;
// 			}
// 		}
		
// 		echo '<pre>';
// 		var_dump(Debugger::timer('aa'));
// 		echo '</pre>'; */
		
// 	}
	
// 	private function _removeReferencesFromVariables() {
// 		foreach( $this->_currentVariables as $name => $value ) {
// 			if( $value[0] == '@' ) {
// 				$originalVariableValue = $this->_getVariableValue( $value );
// 				if( $originalVariableValue == null ) {
// 					unset( $this->_currentVariables[ $name ] );
// 				} else {
// 					$this->_currentVariables[ $name ] = $originalVariableValue;
// 				}
				
// 			}
// 		}
// 	}
	
// 	private function _removeOtherVariablesThanColors() {
// 		// TODO
// 		foreach( $this->_currentVariables as $name => $value ) {
// 			if( !preg_match('/[#][a-h0-9]{6}/', $value) ) {
// 				unset( $this->_currentVariables[ $name ] );
// 			}
// 		}
// 	}
	
// 	private function _getVariableValue( $variableName ) {
// 		if( !isset( $this->_currentVariables[ $variableName ] ) ) {
// 			return null;
// 		}
		
// 		$value = $this->_currentVariables[ $variableName ];
		
// 		if( $value[0] == '@' ) {
// 			$value = $this->_getVariableValue( $value );
// 		}
		
// 		return $value;
// 	}
	
	
// ################################################################################
// # PRIVATE FUNCTIONS
// ################################################################################
	 
// ################################################################################
// # GETTERS AND SETTERS
// ################################################################################	
// 	/**
// 	 *
// 	 * @return ffLessManager
// 	 */
// 	protected function _getLessManager() {
// 		return $this->_lessManager;
// 	}
	
// 	/**
// 	 *
// 	 * @param ffLessManager $lessManager
// 	 */
// 	protected function _setLessManager(ffLessManager $lessManager) {
// 		$this->_lessManager = $lessManager;
// 		return $this;
// 	}
	
// 	/**
// 	 *
// 	 * @return ffLessVariableParser
// 	 */
// 	protected function _getLessVariableParser() {
// 		return $this->_lessVariableParser;
// 	}
	
// 	/**
// 	 *
// 	 * @param ffLessVariableParser $lessVariableParser
// 	 */
// 	protected function _setLessVariableParser(ffLessVariableParser $lessVariableParser) {
// 		$this->_lessVariableParser = $lessVariableParser;
// 		return $this;
// 	}
	
// 	/**
// 	 *
// 	 * @return ffDataStorage_OptionsPostType_NamespaceFacade
// 	 */
// 	protected function _getOptions() {
// 		return $this->_options;
// 	}
	
// 	/**
// 	 *
// 	 * @param ffDataStorage_OptionsPostType_NamespaceFacade $options
// 	 */
// 	protected function _setOptions(ffDataStorage_OptionsPostType_NamespaceFacade $options) {
// 		$this->_options = $options;
// 		return $this;
// 	}
	
// 	/**
// 	 *
// 	 * @return ffLessSystemColorLibrary
// 	 */
// 	protected function _getColorLibrary() {
// 		return $this->_colorLibrary;
// 	}
	
// 	/**
// 	 *
// 	 * @param ffLessSystemColorLibrary $_colorLibrary        	
// 	 */
// 	protected function _setColorLibrary(ffLessSystemColorLibrary $colorLibrary) {
// 		$this->_colorLibrary = $colorLibrary;
// 		return $this;
// 	}
		
// }