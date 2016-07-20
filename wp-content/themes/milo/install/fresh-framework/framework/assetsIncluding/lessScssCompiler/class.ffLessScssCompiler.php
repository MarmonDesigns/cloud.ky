<?php

class ffLessScssCompiler extends ffBasicObject {
	const EXTENDED_CACHING_DIR_NAMESPACE = 'caching_dir';
	const OPT_NAMESPACE = 'ff_less_compiler';
	const CACHE_NAMESPACE  = 'less_scss';
	const ACTION_GATHER_LESS_VARIABLES = 'ff_css_variables';
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffDataStorage_Cache
	 */
	private $_dataStorageCache = null;
	
	/**
	 * @var ffDataStorage_WPOptions_NamespaceFacede
	 */
	private $_dataStorageOptions = null;
	
	/**
	 * 
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;
	
	/**
	 * 
	 * @var ffVariableTransporter
	 */
	private $_variableTransporter = null;

	
	/**
	 * 
	 * @var lessc_freshframework
	 */
	private $_lessParser = null;
	
	/**
	 * 
	 * @var ffLessManager
	 */
	private $_lessManager = null;
	
	/**
	 * 
	 * @var ffLessSystemColorLibraryManager
	 */
	private $_lessSystemColorLibraryManager = null;
	
	/**
	 * 
	 * @var scssc
	 */
	private $_scssParser = null;
	
	private $_currentLessFileUrl = null;
	
	private $_variablesGathered = false;
	
	public function __construct( ffWPLayer $WPLayer, ffDataStorage_Cache $dataStorageCache, ffDataStorage_WPOptions_NamespaceFacede $dataStorageOptions, ffFileSystem $fileSystem, ffVariableTransporter $variableTransporter, $lessParser, ffLessManager $lessManager, ffLessSystemColorLibraryManager $lessSystemColorLibraryManager ) {
		//$c = ffContainer::getInstance();
		$this->_setWplayer( $WPLayer );
		$this->_setDatastoragecache( $dataStorageCache );
		$this->_setDatastorageoptions( $dataStorageOptions ); //$c->getDataStorageFactory()->createDataStorageWPOptionsNamespace( ffLessScssCompiler::EXTENDED_CACHING_DIR_NAMESPACE ) ) ;
		$this->_setFilesystem( $fileSystem );
		$this->_setVariabletransporter( $variableTransporter );
		$this->_setLessManager($lessManager);
		$this->_setLessparser( $lessParser );
		$this->_setLessSystemColorLibraryManager($lessSystemColorLibraryManager);
		// TODO SCSS
		//$this->_setScssparser( $c->getScssParser() );
		
		
		$this->_getWPLayer()->getHookManager()->addActionWPPrintStyles( array( $this, 'actPrintStyles'), 18 );
		$this->_getWplayer()->add_action('admin_footer', array( $this, 'actPrintStyles'));
		$deletedFiles = $this->_getDatastoragecache()->deleteOldFilesInNamespace( 'less_scss', $this->_getCachingIntervalCheck(), $this->_getCachingMaxFileOld() );
		if( !empty($deletedFiles) ) {
			$this->_getDatastorageoptions()->deleteNamespace();
		}
		
		
		
	}
	private function _gatherVariables() {
		if( $this->_variablesGathered ) {
			return;
		}
		
		$this->_variablesGathered = true;
		
		$variableTransporter = $this->_getVariabletransporter();
		$wpLayer = $this->_getWPLayer();
		$this->_getWPLayer()->getHookManager()->actionEnqueueScripts();
		
		$wpLayer->do_action( ffHookManager::ACTION_GATHER_LESS_SCSS_VARIABLES, $variableTransporter );
		$this->_setVariabletransporter($variableTransporter);
	}
	
	private function _getAdditonalVariables( $handle, $hash ) {
		$this->_gatherVariables();
		
		$variables = $this->_getVariabletransporter()->getVariableForHandle( $handle );
		
		if(  $variables !== null ) {
			$newHashingString = '';
			foreach( $variables as $name => $value ) {
				$newHashingString .= $name . $value;
			}
			$hash = md5( $hash . $newHashingString );
				
		}
		
		$codes = $this->_getVariabletransporter()->getImplodedCodeForHandle($handle);
		
		if( $codes !== null ) {
			$hash = md5( $hash . $codes );
		}
		
		return $hash;
	}
	
	private function _md5WithDependencies( $dependentFiles, $hash ) {
		$additionToHash = '';
		foreach( $dependentFiles as $oneFile ) {
			$filePath = $oneFile['path'];
			$fileModified = $this->_getFilesystem()->fileModifiedTime( $filePath );
			
			$additionToHash .= $filePath . $fileModified;
		}
		
		if( !empty( $additionToHash ) ) {
			$hash = md5($additionToHash . $hash );
		}
		
		return $hash;
	} 
	
	public function actPrintStyles() {
		$wpStyles = $this->_getWPLayer()->get_wp_styles();
		// IF EMPTY, GO AWAY
		if( empty($wpStyles->registered) ) {
			return;
		}
		
		foreach( $wpStyles->registered as $handle => $dependency ) {
			
			//Debugger::timer('handle');
			
			// ITS A LESS or SCC FILE ??
			$pathInfo = pathinfo($dependency->src);
			if( !(isset( $pathInfo['extension'] ) && ( $pathInfo['extension'] == 'less' ||  $pathInfo['extension'] == 'scss') ) ) {
				continue;
			}
			

			
			//var_dump( $dependency );
			
			//if( $pathInfo['filename'] == 'ff-admin') {
				//Debugger::timer('aa');
			//}
		//	var_dump( $pathInfo);
			
			
			$filePrefix = $pathInfo['filename'];

			//var_dump( isset( $dependency->extra['a']['b']['c']));
			
			//var_dump( $dependency->extra['ff_aitional_info']['scope']);
			
			
			$firstFile['scope'] = '';
			if( isset( $dependency->extra['ff_additional_info']['scope'] )) {
				$firstFile['scope'] =  $dependency->extra['ff_additional_info']['scope'];
			}
			
			if(  isset($dependency->extra['ff_additional_info']['is_admin_style'])) {
				$colorLibHash = $this->_getLessManager()->getHash( array(ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE));
			} else {
				$colorLibHash = $this->_getLessManager()->getHash( array(ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE, ffOneLessFile::TYPE_USER));
			}
			
			
			
			$firstFile['real_path'] = $this->_getFilesystem()->findFileFromUrl($dependency->src);
		
			if( $firstFile['real_path'] == false ) {
				continue;
			}
			
			$firstFile['md5_real_path'] = md5( $firstFile['real_path'] );
			$firstFile['last_modifed'] = $this->_getFilesystem()->fileModifiedTime( $firstFile['real_path'] );
			$firstFile['md5'] = md5( $firstFile['real_path'] . $firstFile['last_modifed'] . $firstFile['scope'] . $colorLibHash );
			$firstFile['md5_with_variables'] = $this->_getAdditonalVariables($handle, $firstFile['md5']);
			//$firstFile['dependent_files'] = $this->_getDatastorageoptions()->getOption( $firstFile['md5_with_variables'] );
		
			$dependentFilesInfo = $this->_getDatastorageoptions()->getOption( $firstFile['md5_real_path'] );
			
			if( $dependentFilesInfo['md5'] == $firstFile['md5_with_variables']  ) {
				$firstFile['dependent_files'] = $dependentFilesInfo['dependent_files'];
			} else {
				$firstFile['dependent_files'] = null;
				$this->_getDatastorageoptions()->deleteOption( $firstFile['md5_real_path'] );
			}
			
			// WE DONT HAVE DEPENDENCIES
			if( !empty( $firstFile['dependent_files'] ) ) {
				$firstFile['md5_with_dependencies'] = $this->_md5WithDependencies( $firstFile['dependent_files'], $firstFile['md5_with_variables'] );
				$firstFile['md5_filename_load'] = $firstFile['md5_with_dependencies'];
			} else {
				$firstFile['md5_filename_load'] = $firstFile['md5_with_variables'];
			}
			
			$fileExists = $this->_getDatastoragecache()->optionExists(ffLessScssCompiler::CACHE_NAMESPACE, $filePrefix .'-'. $firstFile['md5_filename_load'], 'css');
			
			if( !$fileExists ) {
				$this->_getLessSystemColorLibraryManager()->prepareColorLibraries();
				$compiledFile['list_of_included_files'] = array();
				
				$pathinfo = pathinfo( $firstFile['real_path'] );
				$dir = $pathinfo['dirname'];
			
				$firstFile['dependent_files_second_time'] = $this->_getAllImportedFiles($pathinfo['basename'] , $compiledFile['list_of_included_files'], $dir, null, $handle);
				array_shift( $firstFile['dependent_files_second_time'] );
				
				$firstFile['md5_filename_save'] = $firstFile['md5_filename_load'];
				if( !empty( $firstFile['dependent_files_second_time']) ) {
					
					$firstFile['md5_with_dependencies_second_time']= $this->_md5WithDependencies( $firstFile['dependent_files_second_time'], $firstFile['md5_with_variables'] );
					$firstFile['md5_filename_save'] = $firstFile['md5_with_dependencies_second_time'];
				}
				
				
				if( $this->_getFilesystem()->fileExists( $filePrefix .'-'.  $firstFile['md5_filename_save'] ) ) {
					$this->_getDatastoragecache()->touch(ffLessScssCompiler::CACHE_NAMESPACE, $filePrefix .'-'.  $firstFile['md5_filename_save'], 'css');
					
					
				} else {
					
					$dependentFilesInfo['md5'] = $firstFile['md5_with_variables'];
					$dependentFilesInfo['dependent_files'] = $firstFile['dependent_files_second_time'];
					$this->_getDatastorageoptions()->setOption( $firstFile['md5_real_path'], $dependentFilesInfo );
					
					$fileContent = $this->_getFilesystem()->getContents( $firstFile['real_path'] );
					
					
					$fileContent .= "\n\n\n\n\n\n";
					if(  isset($dependency->extra['ff_additional_info']['is_admin_style'])) {
						$fileContent .= $this->_getLessManager()->getVariableFilesString(array(ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE) );
					} else {
						$fileContent .= $this->_getLessManager()->getVariableFilesString(array(ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE, ffOneLessFile::TYPE_USER) );
						//$colorLibHash = $this->_getLessManager()->getHash( array(ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE, ffOneLessFile::TYPE_USER));
					}
					
					//var_Dump( $this->_getLessManager()->getVariableFilesString(array(ffOneLessFile::TYPE_USER) ) );
					
					//$fileContent .= $this->_getLessManager()->getVariableFilesString(array(ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE, ffOneLessFile::TYPE_USER) );
				
					
					$variables = $this->_getVariabletransporter()->getVariableForHandle( $handle );

					
					if( !empty( $variables ) ) {
						foreach( $variables as $name => $value ) {
							$fileContent .= "\n";
							$fileContent .= '@'.$name.':'.$value.';'; 
						}
						$variables = array();
					}
					
					//var_Dump( $fileContent );
					
					//$variables = array();
					//var_dump($variables, $fileContent );
					//die();
					//$variables .= $this->_getLessManager()->getVariableFilesString(array(ffOneLessFile::TYPE_BOOTSTRAP, ffOneLessFile::TYPE_PLUGIN, ffOneLessFile::TYPE_TEMPLATE, ffOneLessFile::TYPE_USER) );
					
					$codes = $this->_getVariabletransporter()->getImplodedCodeForHandle($handle);
					
					/// COMPILING THE LESS
					
					if( $pathinfo['extension'] == 'less' ) {
						
						// get less compiler
						$compiler = $this->_getLessparser();
						// to find the @import statements correctly
					
						$compiler->setImportDir( dirname( $firstFile['real_path'] ) );
					
						
						if( $variables !== null ) {
							$compiler->setVariables( $variables );
						}
						

						$fileContentCompiled = $compiler->compile( $codes . $fileContent );
						
						if( !empty($firstFile['scope']) ) {
							$fileContentScoped = '.' . $firstFile['scope'] . ' { ';
							$fileContentScoped .= $fileContentCompiled;
							$fileContentScoped .= ' } ';
							
						
							
							$fileContentCompiled = $compiler->compile( $fileContentScoped);
						}
						// COMPILING THE SCSS
					} else if ( $pathInfo['extension'] == 'scss' ) {
						$compiler = $this->_getScssparser();
					
						$compiler->setImportPaths(dirname( $firstFile['real_path'] ));
						//$compiler->setVariables($variables)
					
						$variableString = '';
						if( $variables !== null ) {
							foreach( $variables as $name => $value ) {
								$variableString .= '$'.$name.': '.$value.";\n";
							}
						}
					
						$fileContentCompiled = $compiler->compile( $variableString . $fileContent );
					}
					
					$this->_currentLessFileUrl = $dependency->src;
					$fileContentCompiledWithAbsoluteUrl = preg_replace_callback('|url\(\'?"?([^\"\')]*)\'?"?\)|', array( $this, '_cssRelativeUrlToAbsolute' ), $fileContentCompiled);
					$this->_currentLessFileUrl = null;
					
					// write it only if the item is not empty, so there is chance something is not screwed up
					if( !empty( $fileContentCompiled ) ) {
						$this->_getDatastoragecache()->setOption( ffLessScssCompiler::CACHE_NAMESPACE, $filePrefix .'-'. $firstFile['md5_filename_save'], $fileContentCompiledWithAbsoluteUrl, 'css');
					}
					
				}
				//$firstFile['md5_with_dependencies_second'] 
				$url = $this->_getDatastoragecache()->getOptionUrl(ffLessScssCompiler::CACHE_NAMESPACE, $filePrefix .'-'. $firstFile['md5_filename_save'], 'css');
			}
			// FILE EXISTS, SO TOUCH IT 
			else {
				$url = $this->_getDatastoragecache()->getOptionUrl(ffLessScssCompiler::CACHE_NAMESPACE, $filePrefix .'-'. $firstFile['md5_filename_load'], 'css');
				$this->_getDatastoragecache()->touch(ffLessScssCompiler::CACHE_NAMESPACE,$filePrefix .'-'.  $firstFile['md5_filename_load'], 'css');
			}
			
			
			$wpStyles->registered[ $handle ]->src = $url;

			

			//if( $pathInfo['filename'] == 'ff-admin') {
				//var_dump($pathInfo['filename'], Debugger::timer('aa') );
			//}
			
			
			//var_dump( $handle, Debugger::timer('handle') );
		}
		
		$this->_getWPLayer()->set_wp_styles( $wpStyles );
	}
	
	private function _cssRelativeUrlToAbsolute($matches) {
		// ../image.jpg
		$dirtyRelativeUrl = $matches[1];
	
		// url('../image.jpg')
		$dirtyWholeString = $matches[0];
	
		if( strpos($dirtyRelativeUrl,'http://') !== false ) {
			return $dirtyWholeString;
		}
	
		// server.com/aaa/../image.jpg
		$dirtyAbsoluteUrl = dirname( $this->_currentLessFileUrl ) . '/' . $dirtyRelativeUrl;
		// server.com/image.jpg
		$cleanAbsoluteUrl = $this->_getFilesystem()->canonicalizePath( $dirtyAbsoluteUrl );
	
		// url('server.com/image.jpg');
		$cleanWholeString = str_replace( $dirtyRelativeUrl, $cleanAbsoluteUrl, $dirtyWholeString );
	
		return $cleanWholeString;
	}
	
	private function _getAllImportedFiles( $filePath, $list, $originalDir, $newFileDir = null, $handle = null ) {
		
		$newPath = $this->_getFilesystem()->canonicalizePath( $originalDir .'/' . $filePath );
		
		if( !$this->_getFilesystem()->fileExists( $newPath ) && $newFileDir != null ) {
			$newPath = $this->_getFilesystem()->canonicalizePath( $newFileDir .'/' . $filePath );
			
			if( !$this->_getFilesystem()->fileExists( $newPath ) ) {
				return $list;
			}
			
		} else if( !$this->_getFilesystem()->fileExists( $newPath ) && $newFileDir == null ) {
			return $list;
		}
		
		$newListItem = array();
		$newListItem['path'] = $newPath;
		$newListItem['modified'] = $this->_getFilesystem()->fileModifiedTime( $newPath );
		$list[] = $newListItem;
		
		$newFilePathInfo = pathinfo( $newPath );
		
		if( $originalDir != $newFilePathInfo['dirname'] ) {
			$newFileDir = $newFilePathInfo['dirname'];
		}
		
		$fileContent = $this->_getFilesystem()->getContents( $newPath );	

		if( $handle != null ) {
			$fileContent = $this->_getVariabletransporter()->getImplodedCodeForHandle($handle) . $fileContent;
		}
		$imports = $this->_getAllImports( $fileContent );

		if( $imports != false ) {
			foreach( $imports as $oneImport ) {
				$list = $this->_getAllImportedFiles($oneImport, $list, $originalDir, $newFileDir );
			}
		}
		return $list;
	}

	
	
	private function _getAllImports( $fileContent ) {
		$import = preg_match_all("/\@import\s*[\'\\\"]([^\'\\\"]*)[\'\\\"]/", $fileContent, $files);
		$filtered = array_filter( $files );
			
		if( !empty( $filtered ) ) {
			return $filtered[1];
		}
		
		return false;
	}
	
	//private function _handleFile( $handle)
	
	
	private function _getCachingIntervalCheck() {
		return 60 * 60 * 24 * 3;
	}
	
	private function _getCachingMaxFileOld() {
		return 60 * 60 * 24 * 7;
	}
	

	/**
	 * @return ffWPLayer
	 */
	protected function _getWplayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWplayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	/**
	 * @return ffDataStorage_Cache
	 */
	protected function _getDatastoragecache() {
		return $this->_dataStorageCache;
	}
	
	/**
	 * @param ffDataStorage_Cache $_dataStorageCache
	 */
	protected function _setDatastoragecache(ffDataStorage_Cache $dataStorageCache) {
		$this->_dataStorageCache = $dataStorageCache;
		return $this;
	}

	/**
	 * @return ffDataStorage_WPOptions_NamespaceFacede
	 */
	protected function _getDatastorageoptions() {
		return $this->_dataStorageOptions;
	}
	
	/**
	 * @param ffDataStorage_WPOptions_NamespaceFacede $_dataStorageOptions
	 */
	protected function _setDatastorageoptions(ffDataStorage_WPOptions_NamespaceFacede $dataStorageOptions) {
		$this->_dataStorageOptions = $dataStorageOptions;
		return $this;
	}

	/**
	 * @return ffFileSystem
	 */
	protected function _getFilesystem() {
		return $this->_fileSystem;
	}
	
	/**
	 * @param ffFileSystem $_fileSystem
	 */
	protected function _setFilesystem(ffFileSystem $fileSystem) {
		$this->_fileSystem = $fileSystem;
		return $this;
	}

	/**
	 * @return ffVariableTransporter
	 */
	protected function _getVariabletransporter() {
		return $this->_variableTransporter;
	}
	
	/**
	 * @param ffVariableTransporter $variableTransporter
	 */
	protected function _setVariabletransporter(ffVariableTransporter $variableTransporter) {
		$this->_variableTransporter = $variableTransporter;
		return $this;
	}

	/**
	 * @return lessc_freshframework
	 */
	protected function _getLessparser() {
		return $this->_lessParser;
	}
	
	/**
	 * @param lessc_freshframework $_lessParser
	 */
	protected function _setLessparser(lessc_freshframework $lessParser) {
		$this->_lessParser = $lessParser;
		return $this;
	}
	
	/**
	 * @return scssc
	 */
	protected function _getScssparser() {
		return $this->_scssParser;
	}
	
	/**
	 * @param scssc $_scssParser
	 */
	protected function _setScssparser(scssc $scssParser) {
		$this->_scssParser = $scssParser;
		return $this;
	}
	
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
	 * @return ffLessSystemColorLibraryManager
	 */
	protected function _getLessSystemColorLibraryManager() {
		return $this->_lessSystemColorLibraryManager;
	}
	
	/**
	 *
	 * @param ffLessSystemColorLibraryManager $lessSystemColorLibraryManager        	
	 */
	protected function _setLessSystemColorLibraryManager(ffLessSystemColorLibraryManager $lessSystemColorLibraryManager) {
		$this->_lessSystemColorLibraryManager = $lessSystemColorLibraryManager;
		return $this;
	}
	
	
}