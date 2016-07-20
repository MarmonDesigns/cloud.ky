<?php

// Please, see
// https://codex.wordpress.org/Function_Reference/get_allowed_mime_types
// for inspiration

/*

There are 3 hooks tou should look at:

 - upload_mimes
 - post_mime_types
 - ext2type

*/

class ffMimeTypesManager extends ffBasicObject {

	protected $_mimes = array();
	protected $_post_mime_types = array();
	protected $_ext2type = array();

	/**
	 * 
	 * @var ffWPLayer
	 */
	protected $_WPLayer;

	public function __construct( ffWPLayer $WPLayer ) {
		$this
			->_setWPLayer( $WPLayer )
			->_addHook_upload_mimes( )
			->_addHook_post_mime_types( )
			->_addHook_ext2type( )
			;
		
		/* fce setWPLayer musi but vracet WPLayer nebo nic
		 * 
		 */
		//$this->_getWPLayer()->add_action('', $function_to_add)
	}
	
	/*
	 * GETTERY a SETTERY musi byt uplne na konci classy
	 */
	
	/**
	 * @return ffWPLayer
	 */
	protected function _getWplayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $_WPLayer
	 */
	protected function _setWplayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	//////////////////////////////////////////////////////////////////////
	// Hook for 'asf' => 'video/x-ms-asf'
	//////////////////////////////////////////////////////////////////////

	protected function _addHook_upload_mimes(){
		$this->_getWplayer()->add_action( 'mime_types', array( $this, 'hookFunction_upload_mimes' ) );
		return $this;
	}
	
	/*
	 * hookFunction -> vsechny akce maji prefix "act", v tomto pripade neco jako
	 * 
	 * actUploadMimes
	 */

	public function hookFunction_upload_mimes( $WP_mimes ){
		if( empty( $this->_mimes ) ){
			return $WP_mimes;
		}

		foreach ($this->_mimes as $ext => $ext_mime) {
			$WP_mimes[ $ext ] = $ext_mime;
		}

		return $WP_mimes;
	}

	//////////////////////////////////////////////////////////////////////
	// Hook for tab in media
	//////////////////////////////////////////////////////////////////////

	protected function _addHook_post_mime_types(){
		$this->_getWplayer()->add_action( 'post_mime_types', array( $this, 'hookFunction_post_mime_types' ) );
		return $this;
	}

	public function hookFunction_post_mime_types( $WP_post_mime_types ){
		if( empty( $this->_post_mime_types ) ){
			return $WP_post_mime_types;
		}

		foreach ($this->_post_mime_types as $mime => $settings) {
			$WP_post_mime_types[ $mime ] = $settings;
		}

		return $WP_post_mime_types;
	}

	//////////////////////////////////////////////////////////////////////
	// Hook for connection media + mime
	//////////////////////////////////////////////////////////////////////

	protected function _addHook_ext2type(){
		$this->_getWplayer()->add_action( 'ext2type', array( $this, 'hookFunction_ext2type' ) );
		return $this;
	}

	public function hookFunction_ext2type( $WP_ext2type ){
		if( empty( $this->_ext2type ) ){
			return $WP_ext2type;
		}

		foreach ($this->_ext2type as $mime => $settings) {
			$WP_ext2type[ $mime ] = $settings;
		}

		//echo '<pre>';print_r($WP_ext2type);echo '</pre>';
		return $WP_ext2type;
	}


	/*
	public function addAudio(){

		$this->_mimes[ 'mp3'  ] = 'audio/mpeg';
		$this->_mimes[ 'm4a'  ] = 'audio/mpeg';
		$this->_mimes[ 'm4b'  ] = 'audio/mpeg';
		$this->_mimes[ 'ra'   ] = 'audio/x-realaudio';
		$this->_mimes[ 'ram'  ] = 'audio/x-realaudio';
		$this->_mimes[ 'wav'  ] = 'audio/wav';
		$this->_mimes[ 'ogg'  ] = 'audio/ogg';
		$this->_mimes[ 'oga'  ] = 'audio/ogg';
		$this->_mimes[ 'mid'  ] = 'audio/midi';
		$this->_mimes[ 'midi' ] = 'audio/midi';
		$this->_mimes[ 'wma'  ] = 'audio/x-ms-wma';
		$this->_mimes[ 'wax'  ] = 'audio/x-ms-wax';
		$this->_mimes[ 'mka'  ] = 'audio/x-matroska';

        return $this;

	}
	*/

	public function addCompressed(){

		$this->_mimes [ 'tar'  ] = 'application/x-tar';
		$this->_mimes [ 'zip'  ] = 'application/zip';
		$this->_mimes [ 'gz'   ] = 'application/x-gzip';
		$this->_mimes [ 'gzip' ] = 'application/x-gzip';
		$this->_mimes [ 'rar'  ] = 'application/rar';
		$this->_mimes [ '7z'   ] = 'application/x-7z-compressed';

        return $this;

	}

	public function addFonts(){

		// Define Mimes

/*		
		// This is right, but WP does not understand ... :(

		$this->_mimes[ 'ttf'  ] = 'application/octet-stream';
		$this->_mimes[ 'eot'  ] = 'application/vnd.ms-fontobject';
		$this->_mimes[ 'svg'  ] = 'image/svg+xml';
		$this->_mimes[ 'woff' ] = 'application/x-font-woff';
		$this->_mimes[ 'css'  ] = 'text/css';
*/

		// This is only one stupid possubility how to add fonts to special tab, sorry ...

		$this->_mimes[ 'ttf'  ] = 'font/ttf';
		$this->_mimes[ 'eot'  ] = 'font/eot';
		$this->_mimes[ 'svg'  ] = 'font/svg';
		$this->_mimes[ 'woff' ] = 'font/woff';
		$this->_mimes[ 'css'  ] = 'font/css';

		// Define tab in Media Library
        $WPLayer = $this->_getWplayer();
		$this->_post_mime_types[ 'font' ] = array( 
			0 => $WPLayer->__( 'Fonts', 'default' ) ,
			1 => $WPLayer->__( 'Manage Fonts', 'default' ),
			2 => array(
				0          => $WPLayer->__( 'Font <span class="count">(%s)</span>', 'default' ),
				1          => $WPLayer->__( 'Fonts <span class="count">(%s)</span>', 'default' ),
				'singular' => $WPLayer->__( 'Font <span class="count">(%s)</span>', 'default' ),
				'plural'   => $WPLayer->__( 'Fonts <span class="count">(%s)</span>', 'default' ),
				'context'  => '',
				'domain'   => '',
			),
		);

		// Define connection mime + tab

		$this->_ext2type[ 'font' ] = array( 'ttf', 'eot', 'svg', 'woff', 'css');

		return $this;

	}


	public function addVideo(){

		$this->_mimes[ 'asf'  ] = 'video/x-ms-asf';
		$this->_mimes[ 'asx'  ] = 'video/x-ms-asf';
		$this->_mimes[ 'wmv'  ] = 'video/x-ms-wmv';
		$this->_mimes[ 'wmx'  ] = 'video/x-ms-wmx';
		$this->_mimes[ 'wm'   ] = 'video/x-ms-wm';
		$this->_mimes[ 'avi'  ] = 'video/avi';
		$this->_mimes[ 'divx' ] = 'video/divx';
		$this->_mimes[ 'flv'  ] = 'video/x-flv';
		$this->_mimes[ 'mov'  ] = 'video/quicktime';
		$this->_mimes[ 'qt'   ] = 'video/quicktime';
		$this->_mimes[ 'mpeg' ] = 'video/mpeg';
		$this->_mimes[ 'mpg'  ] = 'video/mpeg';
		$this->_mimes[ 'mpe'  ] = 'video/mpeg';
		$this->_mimes[ 'mp4'  ] = 'video/mp4';
		$this->_mimes[ 'm4v'  ] = 'video/mp4';
		$this->_mimes[ 'ogv'  ] = 'video/ogg';
		$this->_mimes[ 'webm' ] = 'video/webm';
		$this->_mimes[ 'mkv'  ] = 'video/x-matroska';

        return $this;

	}


	public function addText(){
		$this->addPlainText();
	}

	public function addPlainText(){

		$this->_mimes[ 'txt'  ] = 'text/plain';
		$this->_mimes[ 'asc'  ] = 'text/plain';
		$this->_mimes[ 'c'    ] = 'text/plain';
		$this->_mimes[ 'cc'   ] = 'text/plain';
		$this->_mimes[ 'h'    ] = 'text/plain';
		$this->_mimes[ 'csv'  ] = 'text/csv';
		$this->_mimes[ 'tsv'  ] = 'text/tab-separated-values';
		$this->_mimes[ 'ics'  ] = 'text/calendar';
		$this->_mimes[ 'rtx'  ] = 'text/richtext';
		$this->_mimes[ 'css'  ] = 'text/css';
		$this->_mimes[ 'htm'  ] = 'text/html';
		$this->_mimes[ 'html' ] = 'text/html';

        return $this;

	}
}


