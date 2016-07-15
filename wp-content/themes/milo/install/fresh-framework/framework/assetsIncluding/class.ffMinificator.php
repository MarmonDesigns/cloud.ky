<?php

class ffMinificator extends ffBasicObject {
	const BATCH_TYPE_CSS = 'css';
	const BATCH_TYPE_JS = 'js';
	const CACHE_NAMESPACE = 'assetsmin';
	/**
	 * 
	 * @var CSSmin
	 */
	private $_cssMin = null;
	
	/**
	 * 
	 * @var JsMinPlus_Adapteur
	 */
	private $_jsMinPlusAdapteur = null;
	
	/**
	 * 
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;
	
	/**
	 * 
	 * @var ffDataStorage_Cache
	 */
	private $_dataStorageCache = null;
	
	private $_currentBatchName = null;
	
	private $_currentBatchType = null;
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	
	/**
	 * 
	 * @var array[ffStyle]
	 */
	private $_stylesToMinification = null;
	
	/**
	 * 
	 * @var array[ffScript]
	 */
	private $_scriptsToMinification = null;
	
	private $_currentCssMinificationUrl = null;
	
	/**
	 * 
	 * @var ffScript_Factory
	 */
	private $_scriptFactory = null;
	
	/**
	 * 
	 * @var ffStyle_Factory
	 */
	private $_styleFactory = null;
	
	
	public function __construct( ffWPLayer $WPLayer, CSSmin $cssMin, JsMinPlus_Adapteur $jsMinPlusAdapteur, ffDataStorage_Cache $dataStorageCache, ffFileSystem $fileSystem, ffScript_Factory $scriptFactory, ffStyle_Factory $styleFactory, $cacheFilesMaxOld, $cacheCheckInterval ) {
		$this->_setCssMin($cssMin);
		$this->_setJsMinPlusAdapteur($jsMinPlusAdapteur);
		$this->_setDataStorageCache($dataStorageCache);
		$this->_setFileSystem($fileSystem);
		$this->_getDataStorageCache()->deleteOldFilesInNamespace( ffMinificator::CACHE_NAMESPACE, $cacheCheckInterval, $cacheFilesMaxOld);
		$this->_setScriptfactory($scriptFactory);
		$this->_setStylefactory($styleFactory);
		$this->_setWPLayer($WPLayer);
	}
################################################################################
## SCRIPT MINIFICATION
################################################################################
	public function startBatchJs( $batchName ) {
		
		$this->_currentBatchName = $batchName;
		$this->_currentBatchType = ffMinificator::BATCH_TYPE_JS;
	}
	
	public function addScript( ffScript $script ) {
		$this->_scriptsToMinification[] = $script;
	}
	
	public function addScriptArray( $script ) {
		// TODO array_merge
		$this->_scriptsToMinification = $script;
	}
	
	public function addScriptOnlyUrl( $url ) {
		$script = $this->_getScriptfactory()->createScript('temporary-script', $url );
		$this->addScript( $script );
	}
	
	public function proceedBatchJs() {
		if( empty( $this->_scriptsToMinification ) ) {
			return false;
		}
		
		$allJsHashes = array();
		foreach( $this->_scriptsToMinification as $oneScript ) {
			$allJsHashes[] = $this->_minifyFile( $oneScript->source );		
		}
		
		$this->_scriptsToMinification = array();
		
		return $this->_minifyMainFile( $allJsHashes, 'js');
		
		
	}
	
################################################################################
## STYLE MINIFICATION
################################################################################	
	public function startBatchCss( $batchName ) {
		$this->_currentBatchName = $batchName;
		$this->_currentBatchType = ffMinificator::BATCH_TYPE_CSS;
	}
	
	public function addStyle( ffStyle $style ) {
		$this->_stylesToMinification[] = $style;
	}
	
	public function addStyleArray( $style ) {
		// TODO array_merge
		$this->_stylesToMinification = $style;
	}
	
	public function addStyleOnlyUrl( $url ) {
		$style = $this->_getStylefactory()->createStyle('temporary-style', $url);
		$this->addStyle( $style );
	}
	
	public function proceedBatchCss() {
		if( empty( $this->_stylesToMinification ) ) {
			return false;
		}
		
		// minify all css files to one file
		$allCssHashes = array();
		foreach( $this->_stylesToMinification as $oneStyle ) {
			$allCssHashes[] = $this->_minifyFile( $oneStyle->source );
		}
		
		
		// delete the files in the batch
		$this->_stylesToMinification = array();
		
		// create the main css file from other connected hashes
		$mainFile =$this->_minifyMainFile($allCssHashes, 'css');
		return $mainFile;
	}
	
################################################################################
## COMMON MINIFICATION ( JS + CSS together )
################################################################################	
	private function _getFileExtension( $url ) {
		$pathInfo = pathinfo( $url );
		if( isset( $pathInfo['extension']) ) {
			return $pathInfo['extension'];
		} else {
			return false;
		}
	}
	
	private function _removeQuestionmark( $url ) {
		if( strpos( $url, '?') !== false ) {
			$url = explode( '?', $url);
			$url = $url[0];
		}
		
		return $url;
	}
	
	private function _minifyFile( $url ) {
		
		$url = $this->_removeQuestionmark( $url );
		
		// get file extension
		$extension = $this->_getFileExtension($url);
		
		// find file on disk from url
		$path = $this->_getFileSystem()->findFileFromUrl( $url );
		
		
		// if the file does not exists, go away
		if( $path == false ) {
			return false;
		}
	
		// get last time file has been modified
		$lastModifiedTime = $this->_getFileSystem()->fileModifiedTime($path);
	
		// create hash from disk file path and time modified path
		$hash = md5( $path . $lastModifiedTime );
	
		// check if the file already exists
		$fileExists = $this->_getDataStorageCache()->optionExists(ffMinificator::CACHE_NAMESPACE, $hash, $extension);
		// if not, create new file
		if( false == $fileExists ) {
			// get content of the file
			$fileContent = $this->_getFileSystem()->getContents( $path );
			$fileContentMinified = '';
			// minify the content
			if( 'css' == $extension ) {
				$this->_currentCssMinificationUrl = $url;
				
				if( strpos($this->_currentCssMinificationUrl,$this->_getWPLayer()->get_site_url() ) === false  ) {
					$this->_currentCssMinificationUrl = $this->_getWPLayer()->get_site_url() . $this->_currentCssMinificationUrl;
				}
				
				$fileContent = preg_replace_callback('|url\(\'?"?([^\"\')]*)\'?"?\)|', array( $this, '_cssRelativeUrlToAbsolute' ), $fileContent);
				$this->_currentCssMinificationUrl = null;
				$fileContentMinified = $this->_getCssMin()->run( $fileContent );
				
			} else if ( 'js' == $extension ) {
				
				try {
					$fileContentMinified = $this->_getJsMinPlusAdapteur()->minify( $fileContent ).';';
				} catch ( Exception $e ) {
					$fileContentMinified = $fileContent.';';
				}
				
				$fileContentMinified = str_ireplace(array('"use strict";', '"use strict"', "'use strict';", "'use strict';"), '', $fileContentMinified);
				
			}
			

			
			$this->_getDataStorageCache()->setOption(ffMinificator::CACHE_NAMESPACE, $hash, $fileContentMinified, $extension);
			
	
		} else {
			// touch the file, so it's not deleted after some time automatically
			$this->_getDataStorageCache()->touch(ffMinificator::CACHE_NAMESPACE, $hash, $extension);
			//$this->_getFileSystem()->touch( $this->_getDataStorageCache()->getOptionPath( ffMinificator::CACHE_NAMESPACE, $hash, $extension));
		}
		
		return $hash;
	}
	
	private function _cssRelativeUrlToAbsolute($matches) {
		// ../image.jpg
		$dirtyRelativeUrl = $matches[1];
		
		
		// url('../image.jpg')
		$dirtyWholeString = $matches[0];
		

		if( strpos($dirtyRelativeUrl, 'data:') < 3 && strpos( $dirtyRelativeUrl, 'data:' ) !== false ) {
			return $dirtyWholeString;
		}
		
		if( strpos($dirtyRelativeUrl,'http://') !== false ) {
			return $dirtyWholeString;
		}
		
		$positionOfData = strpos( $dirtyRelativeUrl, 'data:' );
		
		if( $positionOfData < 3 && $positionOfData !== false ) {
			return $dirtyWholeString;
		}
		
		// server.com/aaa/../image.jpg
		$dirtyAbsoluteUrl = dirname( $this->_currentCssMinificationUrl ) . '/' . $dirtyRelativeUrl;
		// server.com/image.jpg
		$cleanAbsoluteUrl = $this->_canonicalize( $dirtyAbsoluteUrl );
		
		// url('server.com/image.jpg');
		$cleanWholeString = str_replace( $dirtyRelativeUrl, $cleanAbsoluteUrl, $dirtyWholeString );

		return $cleanWholeString;
	}
	
	private function _canonicalize($address)
	{
		$address = explode('/', $address);
		$keys = array_keys($address, '..');
	
		foreach($keys AS $keypos => $key)
			array_splice($address, $key - ($keypos * 2 + 1), 2);
	
		$address = implode('/', $address);
		$address = str_replace('./', '', $address);
	
		return $address;
	}
	

	
	private function _minifyMainFile( $allHashes, $extension ) {
		// convert array of hashes to one big string
		$allFileHashesConnected = implode('', $allHashes );
		
		// create hash of the main file from this string
		$mainFileHash = md5( $allFileHashesConnected );
	
		// get path of the main file on the disk
		$mainFilePath = $this->_getDataStorageCache()->getOptionPath( ffMinificator::CACHE_NAMESPACE, $mainFileHash, $extension );
	
		// if the main file does not exists, create it!
		if( false == $this->_getDataStorageCache()->optionExists( ffMinificator::CACHE_NAMESPACE, $mainFileHash, $extension) ) {
			
			foreach( $allHashes as $oneHash ) {
				$subFileContent = $this->_getDataStorageCache()->getOption( ffMinificator::CACHE_NAMESPACE, $oneHash, $extension );
				$this->_getFileSystem()->putContentsAtEndOfFile( $mainFilePath, $subFileContent);
			}
			
			if( function_exists('gzcompress') ) {
				$content = $this->_getFileSystem()->getContents( $mainFilePath );

				$this->_getFileSystem()->putContentsGzip( $mainFilePath.'.gz', $content);
				$this->_getDataStorageCache()->touch(ffMinificator::CACHE_NAMESPACE, $mainFileHash, $extension.'.gz');
				//
			}
			
		} else {
			// touch the file so it wont be deleted after X days automatically
			if( function_exists('gzcompress') ) {
				$this->_getDataStorageCache()->touch(ffMinificator::CACHE_NAMESPACE, $mainFileHash, $extension.'.gz');
			}
			$this->_getDataStorageCache()->touch(ffMinificator::CACHE_NAMESPACE, $mainFileHash, $extension);
			//$this->_getFileSystem()->touch( $mainFilePath );
		}
	
		return $this->_getDataStorageCache()->getOptionUrl( ffMinificator::CACHE_NAMESPACE, $mainFileHash, $extension );
	}

	/**
	 * @return CSSmin
	 */
	protected function _getCssMin() {
		return $this->_cssMin;
	}
	
	/**
	 * @param CSSmin $cssMin
	 */
	protected function _setCssMin(CSSmin $cssMin) {
		$this->_cssMin = $cssMin;
		return $this;
	}
	
	/**
	 * @return JsMinPlus_Adapteur
	 */
	protected function _getJsMinPlusAdapteur() {
		return $this->_jsMinPlusAdapteur;
	}
	
	/**
	 * @param JsMinPlus_Adapteur $JsMinPlusAdapteur
	 */
	protected function _setJsMinPlusAdapteur(JsMinPlus_Adapteur $jsMinPlus) {
		$this->_jsMinPlusAdapteur = $jsMinPlus;
		return $this;
	}

	protected function _getFileSystem() {
		return $this->_fileSystem;
	}
	
	protected function _setFileSystem(ffFileSystem $fileSystem) {
		$this->_fileSystem = $fileSystem;
		return $this;
	}
	
	protected function _getDataStorageCache() {
		return $this->_dataStorageCache;
	}
	
	protected function _setDataStorageCache(ffDataStorage_Cache $dataStorageCache) {
		$this->_dataStorageCache = $dataStorageCache;
		return $this;
	}

	protected function _getScriptfactory() {
		return $this->_scriptFactory;
	}
	
	protected function _setScriptfactory(ffScript_Factory $scriptFactory) {
		$this->_scriptFactory = $scriptFactory;
		return $this;
	}
	
	protected function _getStylefactory() {
		return $this->_styleFactory;
	}
	
	protected function _setStylefactory(ffStyle_Factory $styleFactory) {
		$this->_styleFactory = $styleFactory;
		return $this;
	}

	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
	
	
	
}