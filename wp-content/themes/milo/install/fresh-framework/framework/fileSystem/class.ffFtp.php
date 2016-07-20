<?php
class ffFtp extends ffBasicObject {
	
	/**
	 * 
	 * @var dgFtp
	 */
	private $_ftp = null;
	
	public function __construct( dgFtp $ftp ) {
		$this->_setFtp($ftp);
	}
	
	public function connect( $url, $username, $password ) {
		$this->_getFtp()->connect( $url );
		return $this->_getFtp()->login( $username, $password);
	}
	
	public function disconnect() {
		return $this->_getFtp()->close();
	}
	
	public function dirlist( $path = '') {
		return $this->_getFtp()->nlist( $path );
	} 
	
	public function chdir( $dir = '') {
		return $this->_getFtp()->chdir( $dir );
	} 
	
	public function putFile( $localSource, $ftpDestination ) {
		return $this->_getFtp()->put($ftpDestination, $localSource, FTP_BINARY);
	}
	
	public function getFile( $ftpSource, $localDestination) {
		return $this->_getFtp()->get( $localDestination, $ftpSource, FTP_BINARY);
	}

	/**
	 * 
	 * @return dgFtp
	 */
	protected function _getFtp() {
		return $this->_ftp;
	}
	
	protected function _setFtp(dgFtp $ftp) {
		$this->_ftp = $ftp;
		return $this;
	}
	
}