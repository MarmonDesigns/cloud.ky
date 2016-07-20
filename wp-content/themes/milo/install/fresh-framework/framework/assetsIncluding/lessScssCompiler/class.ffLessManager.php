<?php

class ffLessManager extends ffBasicObject {

################################################################################
# CONSTANTS
################################################################################
	const CACHE_NAMESPACE = 'less_scss';
################################################################################
# PRIVATE OBJECTS
################################################################################
	/**
	 * 
	 * @var ffOneLessFileFactory
	 */
	private $_oneLessFileFactory = null;
	
	/**
	 * 
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;
	
	/**
	 * 
	 * @var ffDataStorage_Cache
	 */
	private $_cache = null;
	
	/**
	 * 
	 * @var ffLessUserSelectedColorsDataStorage
	 */
	private $_lessUserSelectedColorsDataStorage = null;
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
################################################################################
# PRIVATE VARIABLES
################################################################################
	private $_files = array();
################################################################################
# CONSTRUCTOR
################################################################################
	public function __construct( ffOneLessFileFactory $oneLessFileFactory, ffFileSystem $fileSystem, ffDataStorage_Cache $cache, lessc_freshframework $lessParser, ffLessUserSelectedColorsDataStorage $lessUserSelectedColorsDataStorage, ffWPLayer $WPLayer ) {
		$this->_setOneLessFileFactory($oneLessFileFactory);
		$this->_setFileSystem( $fileSystem );
		$this->_setCache( $cache );
		$this->_setLessparser($lessParser );
		$this->_setLessUserSelectedColorsDataStorage($lessUserSelectedColorsDataStorage);
		$this->_setWPLayer($WPLayer);
	}	
################################################################################
# ACTIONS
################################################################################

################################################################################
# PUBLIC FUNCTIONS
################################################################################
	/**
	 * 
	 * @param unknown $types
	 * @return array[ffOneLessFile]
	 */
	public function getVariableFilesWithContent( $types = array( ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE)  ) {
		$variableFiles = $this->_getFilesArray($types);
		
		foreach( $variableFiles as $oneFile ) {
			if( $oneFile->content == null && $oneFile->path != null ) {
				$oneFile->content = $this->_getFileSystem()->getContents( $oneFile->path );
			}
		} 
		
		return $variableFiles;
	}
	
	public function getVariableFilesString( $types = array( ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE)  ) {
		$toReturn = '';
		
		$variablesWithContent = $this->getVariableFilesWithContent( $types );
		
		foreach( $variablesWithContent as $oneFile ) {
			$toReturn .= "\n";
			$toReturn .= $oneFile->content;
			$toReturn .= "\n";
		}
		
		return $toReturn;
	}
	
	public function getVariableFilesArray( $types = array( ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE)) {
		return $this->_getFilesArray($types);
	}
	
	public function getHash( $types = array( ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE) ) {
		$variableFiles = $this->_getFilesArray($types);
		
		$stringToHash = '';
		foreach( $variableFiles as $oneFile ) {
			$stringToHash .= $oneFile->hash;
		}
		
		return md5( $stringToHash );
	}
	
	public function addOneLessFile( $type, $url, $priority = 10, $colorLibraryGroup = null, $additionalInfo = array() ) {
		$oneLessFile = $this->_getOneLessFileFactory()->createOneLessFile();
		$oneLessFile->url = $url;
		$oneLessFile->type = $type;
		$oneLessFile->path = $this->_getFileSystem()->findFileFromUrl($url);
		$oneLessFile->hash = $this->_getFileSystem()->getFileHashBasedOnPathAndTimeChange( $oneLessFile->path );
		$oneLessFile->priority = $priority;
		$oneLessFile->additionalInfo = $additionalInfo;
		$oneLessFile->setAdditionalInfo( ffOneLessFile::INFO_COLOR_LIBRARY_GROUP, $colorLibraryGroup);
		$this->_files[ $type ][ $priority ][] = $oneLessFile;
	}
	
	public function addOneLessString( $type, $content, $priority = 10, $colorLibraryGroup = null, $additionalInfo = array() ) {
		$oneLessFile = $this->_getOneLessFileFactory()->createOneLessFile();
		
		$oneLessFile->type = $type;
		$oneLessFile->content = $content;
		$oneLessFile->hash = md5( $oneLessFile->content );
		$oneLessFile->priority = $priority;
		$oneLessFile->additionalInfo = $additionalInfo;
		$oneLessFile->setAdditionalInfo( ffOneLessFile::INFO_COLOR_LIBRARY_GROUP, $colorLibraryGroup);
		$this->_files[ $type ][ $priority ][] = $oneLessFile;
	}
	
	public function compileFileWithUrl( $url, $types ) {
		$this->_prepareUserVariables();
		
		$allVariableFiles = $this->_getFilesArray( $types );
		$currentFilePath = $this->_getFileSystem()->findFileFromUrl( $url );
		$currentFileHash = $this->_getFileSystem()->getFileHashBasedOnPathAndTimeChange( $currentFilePath );
		
		$finalHashString = '';
		
		foreach( $allVariableFiles as $oneFile ) {
			$finalHashString .= $oneFile->hash;
		}
		
		$finalHashString .= $currentFileHash;
		$finalHash = md5( $finalHashString );
		
		$pathInfo = pathinfo( $currentFilePath );

		$finalFileName = $pathInfo['filename'] . '-' .$finalHash;
		
		
		if( !$this->_getCache()->optionExists( ffLessManager::CACHE_NAMESPACE, $finalFileName, 'css') ) {
			

			
			$variablesContent = '';
			
			foreach( $allVariableFiles as $oneFile ) {
				
				if( empty( $oneFile->content ) ) {
					$oneFile->content = $this->_getFileSystem()->getContents( $oneFile->path );
				}
				
				$variablesContent .= "\n" . $oneFile->content;
				
				
			}
			
			$mainFilecontent = $this->_getFileSystem()->getContents($currentFilePath);
			
			$fullContent = $variablesContent . $mainFilecontent;
			
			$parser = $this->_getLessparser();
			$parser->setImportDir( dirname( $currentFilePath ));
			$fullContentCompiled = $parser->compile($fullContent);
			
			$this->_getCache()->setOption( ffLessManager::CACHE_NAMESPACE, $finalFileName, $fullContentCompiled, 'css');
		}
		
		$url = $this->_getCache()->getOptionUrl( ffLessManager::CACHE_NAMESPACE, $finalFileName, 'css');
		
		return $url;
	}
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	private function _prepareUserVariables() {
		if( !isset( $this->_files[ ffOneLessFile::TYPE_USER ] ) || $this->_getWPLayer()->is_admin() ) {
			$this->_files[ ffOneLessFile::TYPE_USER ] = array();
			$userVariables = $this->_getOneLessFileFactory()->createOneLessFile();
			
			$userVariables->type = ffOneLessFile::TYPE_USER;
			$userVariables->content = $this->_getLessUserSelectedColorsDataStorage()->getColorsAsString();
			$userVariables->hash = md5( $userVariables->content );
			$userVariables->setAdditionalInfo( ffOneLessFile::INFO_COLOR_LIBRARY_GROUP, ffOneLessFile::COLOR_LIBRARY_GROUP_USER );
			
			$this->_files[ ffOneLessFile::TYPE_USER ][10][] = $userVariables;
		} 
	}
	/**
	 * 
	 * @param unknown $types
	 * @return array[ffOneLessFile]:
	 */
	private function _getFilesArray( $types ) {
		
		if( empty( $types ) ) {
			return array();
		}
		
		if( in_array( ffOneLessFile::TYPE_USER,  $types ) ) {
			$this->_prepareUserVariables();
		}
		
		$toReturn = array();
		foreach( $types as $oneType ) {
			
			$newFiles = $this->_getDataForType( $oneType );
			$toReturn = array_merge( $toReturn, $newFiles);
		}
		
		return $toReturn;
		
	}
	
	private function _getDataForType( $type ) {
		$toReturn = array();
		
		if( !empty($this->_files[ $type ] ) ) {
			
			foreach( $this->_files[ $type ] as $files ) {
				$toReturn = array_merge( $toReturn, $files );
			}
		}
		
		return $toReturn;
	}
################################################################################
# GETTERS AND SETTERS
################################################################################

	/**
	 *
	 * @return ffOneLessFileFactory
	 */
	protected function _getOneLessFileFactory() {
		return $this->_oneLessFileFactory;
	}
	
	/**
	 *
	 * @param ffOneLessFileFactory $oneLessFileFactory
	 */
	protected function _setOneLessFileFactory($oneLessFileFactory) {
		$this->_oneLessFileFactory = $oneLessFileFactory;
		return $this;
	}
	
	/**
	 *
	 * @return ffFileSystem
	 */
	protected function _getFileSystem() {
		return $this->_fileSystem;
	}
	
	/**
	 *
	 * @param ffFileSystem $fileSystem        	
	 */
	protected function _setFileSystem(ffFileSystem $fileSystem) {
		$this->_fileSystem = $fileSystem;
		return $this;
	}
	
	
	/**
	 *
	 * @return ffDataStorage_Cache
	 */
	protected function _getCache() {
		return $this->_cache;
	}

	/**
	 *
	 * @param ffDataStorage_Cache $_cache
	 */
	protected function _setCache(ffDataStorage_Cache $cache) {
		$this->_cache = $cache;
		return $this;
	}
	
	
	protected function _getLessparser() {
		return $this->_lessParser;
	}

	/**
	 *
	 * @param lessc_freshframework $lessParser
	 * @return ffLessManager
	 */
	protected function _setLessparser(lessc_freshframework $lessParser) {
		$this->_lessParser = $lessParser;
		return $this;
	}
	
	/**
	 *
	 * @return ffLessUserSelectedColorsDataStorage
	 */
	protected function _getLessUserSelectedColorsDataStorage() {
		return $this->_lessUserSelectedColorsDataStorage;
	}
	
	/**
	 *
	 * @param ffLessUserSelectedColorsDataStorage $lessUserSelectedColorsDataStorage        	
	 */
	protected function _setLessUserSelectedColorsDataStorage(ffLessUserSelectedColorsDataStorage $lessUserSelectedColorsDataStorage) {
		$this->_lessUserSelectedColorsDataStorage = $lessUserSelectedColorsDataStorage;
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
	
	
	
	
// ################################################################################
// # CONSTANTS
// ################################################################################
// 	const TYPE_BOOTSTRAP = 'bootstrap';
// 	const TYPE_PLUGIN = 'plugin';
// 	const TYPE_TEMPLATE = 'template';
// 	const TYPE_USER = 'user';
	
// 	const CACHE_NAMESPACE = 'less_scss';
// ################################################################################
// # PRIVATE OBJECTS
// ################################################################################
// 	/**
// 	 * 
// 	 * @var ffFileSystem
// 	 */
// 	private $_fileSystem = null;
	
// 	/**
// 	 * 
// 	 * @var ffDataStorage_Cache
// 	 */
// 	private $_cache = null;
	
// 	/**
// 	 * 
// 	 * @var lessc_freshframework
// 	 */
// 	private $_lessParser = null;
	
// 	/**
// 	 * 
// 	 * @var ffLessColorVariableDataStorage
// 	 */
// 	private $_userVariables = null;
// ################################################################################
// # PRIVATE VARIABLES	
// ################################################################################	
// 	private $_variableInfoArray = array();
// ################################################################################
// # CONSTRUCTOR
// ################################################################################	
// 	public function __construct() {
// 		$this->_setFileSystem( ffContainer::getInstance()->getFileSystem()  );
// 		$this->_setCache( ffContainer::getInstance()->getDataStorageCache() );
// 		$this->_setLessparser( ffContainer::getInstance()->getLessParser() );
// 		$this->_setUserVariables( ffContainer::getInstance()->getLessColorVariableDataStorage() );
		
// 		//ffContainer::getInstance()->getLess
// 	}
// ################################################################################
// # ACTIONS
// ################################################################################
	
// ################################################################################
// # PUBLIC FUNCTIONS
// ################################################################################
// 	public function getVariableArray( $types ) {
// 		return $this->_getVariableArray($types);
// 	}
	
// 	public function getVariableContent( $types ) {
// 		return $this->_getVariableContent($types);
// 	}
	
	
// 	public function addVariableUrl( $type, $url, $priority = 10 ) {
// 	 	$path = $this->_getFileSystem()->findFileFromUrl( $url );
// 	 	if( $path == false ) {
// 	 		throw new Exception('Wasnt able to find file from URL');
// 	 	}
	 	
// 	 	return $this->addVariablePath($type, $path, $priority );
// 	}
	
// 	public function addVariableString( $type, $content, $priority = 10 ) {
// 		$variableInfo = array();
// 		$variableInfo['type'] = $type;
// 		$variableInfo['content'] = $content;
// 		$variableInfo['priority'] = $priority;
// 		$variableInfo['hash'] = md5( $content );
		
// 		$this->_variableInfoArray[ $type ][ $priority ][] = $variableInfo;
// 	}
	 
// 	public function addVariablePath( $type, $path, $priority = 10 ) {
// 	 	$variableFileInfo = array();
// 	 	$variableFileInfo['type'] = $type;
// 	 	$variableFileInfo['path'] = $path;
// 	 	$variableFileInfo['priority'] = $priority;
// 	 	$variableFileInfo['hash'] = $this->_getFileSystem()->getFileHashBasedOnPathAndTimeChange( $path );
	 	
// 	 	$this->_variableInfoArray[ $type ][ $priority ][][ $path ] = $variableFileInfo;
// 	}
	 
// 	public function compileWithFileUrl( $url, $types ) {
// 	 	$path = $this->_getFileSystem()->findFileFromUrl( $url );
	 	
// 	 	$fileInfoFromCache = $this->_loadFileFromCache( $path, $types );
	 	
// 	 	if( $fileInfoFromCache['type'] == 'cached_file_url' ) {
// 	 		return $fileInfoFromCache['value'];
// 	 	} 
	 	
// 	 	$compiledCachedFileUrl = $this->_compileAndCacheFile( $path, $types, $fileInfoFromCache['value'] );
	 	
// 	 	var_dump( $compiledCachedFileUrl );
// 	 	return $compiledCachedFileUrl;
// 	}
// ################################################################################
// # PRIVATE FUNCTIONS
// ################################################################################
// 	private function _compileAndCacheFile( $path, $types, $filename ) {
// 		$variableContent = $this->_getVariableContent( $types );
// 		$fileContent = $this->_getFileSystem()->getContents( $path );
		
// 		$fileForCompilation = '';
// 		$fileForCompilation .= $variableContent;
// 		$fileForCompilation .= $fileContent;
		
// 		$importDir = dirname( $path );
		
// 		$compiler = $this->_getLessparser();
		
// 		$compiler->setImportDir( $importDir );
// 		$compiledFile = $compiler->compile( $fileForCompilation );
		
// 		$this->_getCache()->setOption( ffLessManager::CACHE_NAMESPACE, $filename, $compiledFile, 'css');
		
// 		return $this->_getCache()->getOptionUrl(ffLessManager::CACHE_NAMESPACE, $filename, 'css' );
// 	}
	
// 	private function _getVariableContent( $types ) {
// 		$variableArray = $this->_getVariableArray( $types );
		
// 		$cumulatedContent = '';
		
// 		foreach( $variableArray as $path => $info ) {
// 			$cumulatedContent .= $this->_getFileSystem()->getContents( $path );
// 		}
		
// 		return $cumulatedContent;
// 	} 
	 
// 	private function _loadFileFromCache( $path, $types ) {
// 		$hash = $this->_getFileSystem()->getFileHashBasedOnPathAndTimeChange( $path );
		 
// 		// get all variables in array
// 		$lessVariables = $this->_getVariableArray($types);
		 
// 		// create hash string
// 		$newHashString = $hash;
// 		foreach( $lessVariables as $oneVariable ) {
// 			$newHashString .= $oneVariable[ 'hash'];
// 		}
		 
// 		$newHash = md5( $newHashString );
		
// 		$pathInfo = pathinfo( $path );
// 		$newName = $pathInfo['filename'] .'-'. $newHash;
		
// 		$toReturn = array();
// 		if( $this->_getCache()->optionExists( ffLessManager::CACHE_NAMESPACE, $newName, 'css' ) ) {
// 			$toReturn['type'] = 'cached_file_url';
// 			$toReturn['value'] = $this->_getCache()->getOptionUrl( ffLessManager::CACHE_NAMESPACE, $newName, 'css' );
// 		} else {
// 			$toReturn['type'] = 'file_hash_name';
// 			$toReturn['value'] = $newName;
// 		}
		
// 		return $toReturn;
// 	}
	 
	 
//  	private function _getVariablesHash() {
 		
//  	}
 	
//  	private function _getVariableArray( $types ) {
//  		if( empty( $types ) ) {
//  			return $types;
//  		}
//  		$fullArray = array();
 	
//  		foreach( $types as $oneType ) {
//  			$typeArray = $this->_getVariableTypeArray( $oneType );
 			
//  			$fullArray = array_merge( $fullArray, $typeArray );
 		
//  		}
 		
//  		return $fullArray;
//  	}
 	
//  	private function _getVariableTypeArray( $type ) {
//  		if( !isset( $this->_variableInfoArray[ $type ] ) ) {
//  			return array();
//  		}
//  		$fullArray = array();
 		
//  		foreach( $this->_variableInfoArray[ $type ] as $onePriority ) {
//  			foreach( $onePriority as $oneVariableInfo ) {
//  				$fullArray = array_merge( $fullArray, $oneVariableInfo );
//  			}
//  		} 
 		
//  		return $fullArray;
//  	}
	
// 	/*private function _getVariableStringFinalised() {
// 		$typesArray = func_get_args();
		
// 		$variablesArray = call_user_func_array( array( $this, '_getVariableListFinalised'), $typesArray );
// 		$stringToReturn = '';
// 		//var_dump( $variablesArray );
// 		foreach ( $variablesArray as $oneArray ) {
// 			$stringToReturn .= '@'.$oneArray['name'].': '.$oneArray['value'].';'."\n";
// 			//echo $oneArray['value'];
// 		}
// 		echo $stringToReturn;
// 		return $stringToReturn;
// 	}
	
// 	private function _getVariableListFinalised() {
// 		$typesArray = func_get_args();
	
// 		if( empty( $typesArray ) ) {
// 			return array();
// 		}
		
// 		$finalisedArray = array();
		
// 		foreach( $typesArray as $oneType ) {

// 			$variableArrayFinalised = $this->_getVariableArrayFinalised( $oneType );
// 			$finalisedArray = array_merge( $finalisedArray, $variableArrayFinalised);
// 		}
		
// 		return $finalisedArray;
// 	}
	
	
// 	private function _getVariableArrayFinalised($type){
// 		$finalisedArray = array();
		
// 		$variableArray = $this->_getVariableArray($type);
 		
// 		foreach( $variableArray as $variables ) {
// 			foreach( $variables as $oneVariable ) {
// 				$finalisedArray = array_merge( $finalisedArray, $oneVariable );
// 			}
// 		}
		
// 		return $finalisedArray;
// 	}
	
	
// 	private function _getVariableArray( $type ) {
// 		if( !isset( $this->_variableArrays[ $type ] ) ) {
// 			$this->_loadVariableArray( $type );
// 	 	}
	 	
// 	 	return $this->_variableArrays[ $type ];
// 	}
	 
// 	private function _loadVariableArray( $type ) {
// 		if( !isset( $this->_variableFiles[ $type ] ) ) {
// 			$this->_variableArrays[ $type ] = array(); 
// 		}
// 	}*/
// ################################################################################
// # GETTERS AND SETTERS
// ################################################################################	
// 	/**
// 	 *
// 	 * @return ffFileSystem
// 	 */
// 	protected function _getFileSystem() {
// 		return $this->_fileSystem;
// 	}
	
// 	/**
// 	 *
// 	 * @param ffFileSystem $fileSystem
// 	 */
// 	protected function _setFileSystem(ffFileSystem $fileSystem) {
// 		$this->_fileSystem = $fileSystem;
// 		return $this;
// 	}
	
// 	/**
// 	 *
// 	 * @return ffDataStorage_Cache
// 	 */
// 	protected function _getCache() {
// 		return $this->_cache;
// 	}
	
// 	/**
// 	 *
// 	 * @param ffDataStorage_Cache $_cache        	
// 	 */
// 	protected function _setCache(ffDataStorage_Cache $cache) {
// 		$this->_cache = $cache;
// 		return $this;
// 	}
// 	/**
// 	 * 
// 	 * @return lessc_freshframework
// 	 */
	
// 	protected function _getLessparser() {
// 		return $this->_lessParser;
// 	}
	
// 	/**
// 	 * 
// 	 * @param lessc_freshframework $lessParser
// 	 * @return ffLessManager
// 	 */
// 	protected function _setLessparser(lessc_freshframework $lessParser) {
// 		$this->_lessParser = $lessParser;
// 		return $this;
// 	}
	
// 	/**
// 	 *
// 	 * @return ffLessColorVariableDataStorage
// 	 */
// 	protected function _getUserVariables() {
// 		return $this->_userVariables;
// 	}
	
// 	/**
// 	 *
// 	 * @param ffLessColorVariableDataStorage $_userVariables        	
// 	 */
// 	protected function _setUserVariables(ffLessColorVariableDataStorage $userVariables) {
// 		$this->_userVariables = $userVariables;
// 		return $this;
// 	}
	
	
	
}