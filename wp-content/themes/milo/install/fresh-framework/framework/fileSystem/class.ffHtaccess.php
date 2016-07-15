<?php
/**
 * This class automatically loads all necessary files. It will be also used
* across the whole template, when you need to load something dynamically
* @author freshface
* @since 0.1
*/

class ffHtaccess extends ffBasicObject {

/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 *
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;
	
	private $_htaccessContent = null;
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct() {
		$c = ffContainer::getInstance();
		$this->_setFileSystem( $c->getFileSystem() );
	}
		
	public function setSection( $name, $value ) {
		$this->_loadHtaccessContent();
		//vaR_dump(  $this->_getSectionPureContent($name) );
		// !sectionExists
		if( $this->_getSectionPureContent($name) === false ) {
			
			$content = $this->_getSectionStartName($name). "\n";
			$content .= $value ."\n";
			$content .= $this->_getSectionEndName($name) . "\n";
			
			$this->_htaccessContent = $content . $this->_htaccessContent;
			$this->_saveHtaccess();
		} else {
			$replace =  $this->_getSectionContent($name);
			$content = $this->_getSectionStartName($name). "\n";
			$content .= $value ."\n";
			$content .= $this->_getSectionEndName($name) . "\n";
			$this->_htaccessContent = str_replace( $replace, $content, $this->_htaccessContent );
			$this->_saveHtaccess();
		}
	}
	
	public function getSection( $name ) {
		$this->_loadHtaccessContent();
		return $this->_getSectionPureContent($name);
	}
	
	public function deleteSection( $name ) {
		$this->_loadHtaccessContent();
		
		$replace = $this->_getSectionContent($name);
		
		if( $replace === false ) return;
		
		$this->_htaccessContent = str_replace( $replace, '', $this->_htaccessContent);
		$this->_saveHtaccess();
	}
	//TODO
	public function getAllSections() {
		echo 'NOT IMPLEMENTED YET';
		die();
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	private function _saveHtaccess() {
		$absolutePath = $this->_getFileSystem()->getAbsPath();
		$htaccessPath = $absolutePath.'/.htaccess';
		$this->_getFileSystem()->putContents($htaccessPath, $this->_htaccessContent);
	}
	
	private function _getSectionContent($name ) {
		$startPos = $this->_findSectionStart($name );// + strlen( $this->_getSectionStartName($name));
		if( $startPos === false ) return false;
		
		//$startPos = $startPos + strlen( $this->_getSectionStartName($name));
		$endPos = $this->_findSectionEnd($name);// - strlen( $this->_getSectionEndName($name));
		return( substr( $this->_htaccessContent, $startPos, $endPos - $startPos ));
	}
	
	private function _getSectionPureContent($name) {
		
		$startPos = $this->_findSectionStart($name );// + strlen( $this->_getSectionStartName($name));
		if( $startPos === false ) return false;
		
		$startPos = $startPos + strlen( $this->_getSectionStartName($name));
		$endPos = $this->_findSectionEnd($name) - strlen( $this->_getSectionEndName($name));
		return( substr( $this->_htaccessContent, $startPos, $endPos - $startPos ));
	}
	
	private function _getSectionEndName( $name ) {
		return '# END '.$name;
	}
	
	private function _getSectionStartName( $name ) {
		return '# BEGIN '.$name;
	} 
	private function _findSectionEnd( $name ) {
		$stringToFind = $this->_getSectionEndName($name);
		$position = strpos( $this->_htaccessContent, $stringToFind );
		$lastChar = strlen( $stringToFind );
		return $position + $lastChar;
	}
	
	private function _findSectionStart( $name ) {
		$stringToFind = $this->_getSectionStartName($name);
		return strpos( $this->_htaccessContent, $stringToFind );
	}
	
	private function _loadHtaccessContent() {
		if( $this->_htaccessContent != null ) return;
		$absolutePath = $this->_getFileSystem()->getAbsPath();
		$htaccessPath = $absolutePath.'/.htaccess';
		
		if( !$this->_getFileSystem()->fileExists( $htaccessPath ) ) {
			$this->_getFileSystem()->putContents( $htaccessPath, ' ');
		}
		
		$this->_htaccessContent =  $this->_getFileSystem()->getContents( $htaccessPath );
	}
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	
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