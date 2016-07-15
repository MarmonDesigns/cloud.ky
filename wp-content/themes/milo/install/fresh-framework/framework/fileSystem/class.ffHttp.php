<?php

class ffHttp extends ffBasicObject {
	const ARG_TIMEOUT = 'timeout';
	const ARG_USER_AGENT = 'user-agent';
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $WPLayer = null;
	
	public function __construct( ffWPLayer $WPLayer ) {
		$this->_setWPLayer($WPLayer);
	}
	
	
	/*$args = array(
			'timeout'     => 5,
			'redirection' => 5,
			'httpversion' => '1.0',
			'user-agent'  => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' ),
			'blocking'    => true,
			'headers'     => array(),
			'cookies'     => array(),
			'body'        => null,
			'compress'    => false,
			'decompress'  => true,
			'sslverify'   => true,
			'stream'      => false,
			'filename'    => null
	);*/ 
	
	public function get( $url, $arguments = array() ) {
		if( !isset($arguments['user-agent']) ) {
			$arguments['user-agent'] = 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; Trident/7.0; rv:11.0) like Gecko';
		}
		
		return $this->_getWPLayer()->wp_remote_get( $url, $arguments );
	}
	
	/*
	 * $response = wp_remote_post( $url, array(
	'method' => 'POST',
	'timeout' => 45,
	'redirection' => 5,
	'httpversion' => '1.0',
	'blocking' => true,
	'headers' => array(),
	'body' => array( 'username' => 'bob', 'password' => '1234xyz' ),
	'cookies' => array()
    )
);
	 */
	
	public function post( $url, $post, $arguments = array() ) {
		$arguments['body'] = $post;
		return wp_remote_post( $url, $arguments );
	}
	
	/**
	 * 
	 * @param unknown $url
	 * @param number $timeout
	 */
	public function download( $url, $timeout = 300 ) {
		return $this->_getWPLayer()->download_url( $url, $timeout );
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
	protected function _setWPLayer($WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
}