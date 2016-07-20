<?php
class ffThemeIdentificator extends ffBasicObject {
	// const FF_PLUGIN_NAME = 'freshtheme.php';
	// const FF_PLUGIN_INFO_NAME = 'info.php';
	/**
	 * @var ffWPLayer
	 */
	private $WPLayer = null;

	/**
	 *
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;

	private $_ourActiveThemes = null;

	private $_ourActiveThemesInfo = array();

	private $_ourActiveThemesInfoFile = array();

	private $_ourAllThemes = null;

	private $_themeDir = null;

	public function __construct( ffWPLayer $WPLayer, ffFileSystem $fileSystem ) {
		$this->_setWPLayer($WPLayer);
		$this->_setFileSystem($fileSystem);
	}
	
	private function _isThemeActive( $folderName ) {
		$activeThemes = $this->getOurActiveThemes();
		if( !is_array( $activeThemes ) ) {
			return false;
		}
		return in_array( $folderName, $activeThemes);
	}
	
	public function getAllThemeInfo() {
		return $this->_getWPLayer()->get_themes();
	}
	
	public function getAllThemesInfo() {
		return $this->_getWPLayer()->wp_get_themes();
	}

	/**
	 * Find if the theme exists, doesn't matter if its active or not. The
	 * name is from the info file, like "Fresh Minificator" or "Twitter Widget"
	 * @param string $themeName
	 */
	public function findThemeByName( $themeName ) {
		$allOurThemes = $this->getOurAllThemes();

		if( empty( $allOurThemes ) ) {
			return false;
		}

		$foundThemes = array();

		foreach( $allOurThemes as $oneTheme ) {
			$oneThemeInfo = $this->getOurThemeInfo( $oneTheme );
			if( $oneThemeInfo['Name'] == $themeName ) {
				$oneThemeInfo['FolderName'] = $oneTheme;
				$oneThemeInfo['IsActive'] = $this->_isThemeActive($oneTheme);
				$foundThemes[] = $oneThemeInfo;
			}
		}

		if( empty( $foundThemes ) ) {
			return false;
		}

		return $foundThemes;
	}

	public function getOurActiveThemes() {
		if( $this->_ourActiveThemes == null ) {
			$this->_identificateOurActiveThemes();
		}
		if( empty( $this->_ourActiveThemes ) ) {
			$this->_ourActiveThemes = array();
		}
		return $this->_ourActiveThemes;
	}

	public function getOurAllThemes() {
		if( $this->_ourAllThemes == null ) {
			$this->_identificateOurAllThemes();
		}

		return $this->_ourAllThemes;
	}

	public function getOurThemeVersion( $themeName ) {
		$this->getOurThemeInfo( $themeName );
		if( !isset( $this->_ourActiveThemesInfo[ $themeName]['Version'] ) ) {
			throw new Exception('Theme :'.$themeName .' does not have version defined');
		}

		return $this->_ourActiveThemesInfo[ $themeName ]['Version'];
	}

	public function getOurThemeInfo( $themeName ) {
		if( !isset( $this->_ourActiveThemesInfo[ $themeName ] ) ) {
			$fileDir = $this->_getThemeDir() . '/' . $themeName . '/';
			if( !$this->_getFileSystem()->fileExists( $fileDir) ) {
				return false;
			}

			$this->_ourActiveThemesInfo[ $themeName ] = $this->getThemeInfoFromPath( $fileDir );
		}
		return $this->_ourActiveThemesInfo[ $themeName ];
	}

	public function getThemeInfoFromPath( $path ) {
		$default_headers = array(
				'Name' => 'Theme Name',
				'Version' => 'Version',
		);
		$ret = $this->_getWPLayer()->get_file_data( $path . 'style.css', $default_headers );

		if( $this->_getFileSystem()->fileExists($path.'install/freshplugins.php') ){
			require_once $path.'install/freshplugins.php';
			$ret['Dependency'] = $freshplugins;
		}else{
			$ret['Dependency'] = array();
		}

		return $ret;
	}

	public function getOurThemeInfoFile( $themeName ) {
		if( !isset( $this->_ourActiveThemesInfoFile[ $themeName ] ) ) {
			$fileDir = $this->_getThemeDir() . '/' . $themeName . '/' . ffThemeIdentificator::FF_PLUGIN_INFO_NAME;
			if( !$this->_getFileSystem()->fileExists( $fileDir ) ) {
				return false;
			}
			require_once $fileDir;
			$this->_ourActiveThemesInfoFile[ $themeName ] = $info;
		}

		return $this->_ourActiveThemesInfoFile[ $themeName ];
	}

	public function identificateOurAllThemes() {
		$ourThemes =  $this->_identificateOurAllThemes();
		if( empty( $ourThemes ) ) return array();
		return $ourThemes;
	}
	
	private function _identificateOurAllThemes() {
		$wpThemeDir = $this->_getFileSystem()->getDirThemes();
		
		$wpThemeDirList= $this->_getFileSystem()->dirlist( $wpThemeDir );
		
		if( empty( $wpThemeDirList ) ) return false;
		
		foreach( $wpThemeDirList as $oneDir ) {
			if( $oneDir['type'] !== 'd' ) continue;
			if( 't-' != substr($oneDir['name'], 0,2) ){
				continue;
			}
			$this->_ourAllThemes[] = $oneDir['name'];
		}
		
		return $this->_ourAllThemes;
	}
	
	private function _identificateOurActiveThemes() {
		$allActiveThemes = $this->_getWPLayer()->wp_get_themes();
		
		if( empty( $allActiveThemes ) ) {
			return false;
		}
		
		foreach( $allActiveThemes as $oneActiveTheme ) {
			if( false !== strpos( $oneActiveTheme, ffThemeIdentificator::FF_PLUGIN_NAME ) ) {
				$themeName = str_replace('/'. ffThemeIdentificator::FF_PLUGIN_NAME, '', $oneActiveTheme );
				$this->_ourActiveThemes[] = $themeName;
			}	
		}
		
		return true;
	}
	
	
	private function _getThemeDir() {
		if( $this->_themeDir == null ) {
			$this->_themeDir = $this->_getFileSystem()->getDirThemes();
		}
		
		return $this->_themeDir;
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

	/**
	 * @return ffFileSystem
	 */
	protected function _getFileSystem() {
		return $this->_fileSystem;
	}
	
	/**
	 * @param ffFileSystem $fileSystem
	 */
	protected function _setFileSystem(ffFileSystem $fileSystem) {
		$this->_fileSystem = $fileSystem;
		return $this;
	}
	
	
}