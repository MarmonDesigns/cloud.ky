<?php

class ffModalWindowLibraryIconPickerIconPreparator extends ffBasicObject {

################################################################################
# CONSTANTS
################################################################################

################################################################################
# PRIVATE OBJECTS
################################################################################

	/**
	 *
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 *
	 * @var ffFileSystem
	 */
	private $_FileSystem = null;


################################################################################
# PRIVATE VARIABLES
################################################################################

################################################################################
# CONSTRUCTOR
################################################################################
	public function __construct( ffWPLayer $WPLayer, ffFileSystem $FileSystem ) {
		$this->_setWPLayer($WPLayer);
		$this->_setFileSystem($FileSystem);
	}
################################################################################
# ACTIONS
################################################################################

################################################################################
# PUBLIC FUNCTIONS
################################################################################
	public function getPreparedUserIcons( $selectedIconName = null ) {
		return array();
		// $userIcons = $this->_getUserIconLibrary()->getIcons();


		// if( empty( $userIcons ) ) {
		// 	return array();
		// }

		// $IconsSortedByGroup = array();

		// foreach( $userIcons as $oneIcon ) {
		// 	$groupSanitized = strtolower($this->_getWPLayer()->sanitize_only_letters_and_numbers( $oneIcon->getGroup() ));

		// 	$IconsSortedByGroup[ $groupSanitized ][] = $oneIcon;
		// }


		// return $IconsSortedByGroup;
	}

	public function getPreparedSystemIcons( $selectedIconName = null ) {

		$iconGroups = array();

		foreach( $this->getIconFontCSSList() as $font => $file ) {
			$iconGroups[ $font ] = $this->_createIcoDataFromFile( $font, $file );
		}

		return $iconGroups;

	}

	public function getIconFontCSSList(){
		return $this->_getWPLayer()->apply_filters( 'ff_fonts', array(
			'awesome'     => '/framework/extern/iconfonts/ff-font-awesome/ff-font-awesome.css',
			'awesome4'    => '/framework/extern/iconfonts/ff-font-awesome4/ff-font-awesome4.css',
			'bootstrap glyphicons'
			              => '/framework/extern/iconfonts/glyphicon/glyphicon.css',
			'brandico'    => '/framework/extern/iconfonts/ff-font-brandico/ff-font-brandico.css',
			'elusive'     => '/framework/extern/iconfonts/ff-font-elusive/ff-font-elusive.css',
			'entypo'      => '/framework/extern/iconfonts/ff-font-entypo/ff-font-entypo.css',
			'et-line'     => '/framework/extern/iconfonts/ff-font-et-line/ff-font-et-line.css',
			'flaticons-mat' =>  '/framework/extern/iconfonts/ff-font-flaticon-mat/ff-font-flaticon-mat.css',
			'fontelico'   => '/framework/extern/iconfonts/ff-font-fontelico/ff-font-fontelico.css',
			'iconic'      => '/framework/extern/iconfonts/ff-font-iconic/ff-font-iconic.css',
			'linecons'    => '/framework/extern/iconfonts/ff-font-linecons/ff-font-linecons.css',
			'maki'        => '/framework/extern/iconfonts/ff-font-maki/ff-font-maki.css',
			'meteocons'   => '/framework/extern/iconfonts/ff-font-meteocons/ff-font-meteocons.css',
			'mfglabs'     => '/framework/extern/iconfonts/ff-font-mfglabs/ff-font-mfglabs.css',
			'miu'         => '/framework/extern/iconfonts/ff-font-miu/ff-font-miu.css',
			'modernpics'  => '/framework/extern/iconfonts/ff-font-modernpics/ff-font-modernpics.css',
			'typicons'    => '/framework/extern/iconfonts/ff-font-typicons/ff-font-typicons.css',
			'simple line icons'
			              => '/framework/extern/iconfonts/ff-font-simple-line-icons/ff-font-simple-line-icons.css',
			'weathercons' => '/framework/extern/iconfonts/ff-font-weathercons/ff-font-weathercons.css',
			'websymbols'  => '/framework/extern/iconfonts/ff-font-websymbols/ff-font-websymbols.css',
			'zocial'      => '/framework/extern/iconfonts/ff-font-zocial/ff-font-zocial.css',
		) );
	}


################################################################################
# PRIVATE FUNCTIONS
################################################################################

	private function _createIcoDataFromFile( $font, $file ) {
		$icons = array();

		$file = $this->_getWPLayer()->getFrameworkDir() . $file;
		$font_file = $this->_getFileSystem()->file( $file );

		foreach ($font_file as $line) {
			$line = str_replace("content:'", "content: '", $line);
			if( FALSE === strpos($line, ':before') ){
				continue;
			}

			if( FALSE === strpos($line, "content: '\\") ){
				continue;
			}

			$class = explode(':before', $line);
			$class = $class[0];
			$class = trim(str_replace('.', ' ', $class));

			$tags = explode('/*', $line);
			if( empty($tags[1]) ){
				$tags = '';
			}else{
				$tags = $tags[1];
				$tags = str_replace("*/", '', $tags);
			}

			$tags = ' ' . $tags;// . ' ' . $class . ' ';
			$tags = str_replace(array("'",'"'), array('',''), $tags);
			$tags = str_replace('-', ' ', $tags);
			$tags = str_replace(' icon ', ' ', $tags);
			$tags = str_replace('.', ' ', $tags);
			$tags = str_replace('  ', ' ', $tags);
			$tags = str_replace('  ', ' ', $tags);
			$tags = str_replace('  ', ' ', $tags);
			$tags = trim($tags);

			$tags_tmp = explode( ' ', $tags );
			$tags = array();
			foreach ($tags_tmp as $value) {
				$tags[ $value ] = $value;
			}
			$tags = implode(', ', $tags);
			$tags = $tags . ',' . str_replace(' ', ',', $class);
			$tags = str_replace( 'ff-', '', $tags);

			$content = explode("content: '\\", $line);
			if( empty($content[1]) ){
				$content = "????";
			}else{
				$content = explode("'", $content[1]);
				$content = $content[0];
			}

			$tags = $tags . ',' . $content;
			$tags = $tags . ',&#x' . $content.';';

			$icons[] = array(
				'tags'    => $tags,
				'content' => $content,
				'font'    => $font,
				'class'   => $class,
			);
		}

		return $icons;
	}

################################################################################
# GETTERS AND SETTERS
################################################################################

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


	/**
	 *
	 * @return ffFileSystem
	 */
	protected function _getFileSystem() {
		return $this->_FileSystem;
	}

	/**
	 *
	 * @param ffFileSystem $ffFileSystem
	 */
	protected function _setFileSystem(ffFileSystem $ffFileSystem) {
		$this->_FileSystem = $ffFileSystem;
		return $this;
	}

}