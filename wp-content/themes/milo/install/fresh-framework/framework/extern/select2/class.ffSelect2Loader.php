<?php

class ffSelect2Loader extends ffBasicObject {
	
	/**
	 * 
	 * @var ffScriptEnqueuer
	 */
	private $_scriptEnqueuer = null;
	
	/**
	 * 
	 * @var ffStyleEnqueuer
	 */
	private $_styleEnqueuer = null;
	
	private $_filesHasBeenIncluded = false;
	
	public function __construct( ffScriptEnqueuer $scriptEnqueuer, ffStyleEnqueuer $styleEnqueuer ) {
		$this->_setScriptEnqueuer($scriptEnqueuer);
		$this->_setStyleEnqueuer($styleEnqueuer);
	}

	
	public function loadSelect2() {
		
		if ( $this->_filesHasBeenIncluded ) {
			return;
		} 
		
		$this->_filesHasBeenIncluded = true;
		
		
		$scriptEnqueuer = $this->_getScriptEnqueuer();
		$styleEnqueuer = $this->_getStyleEnqueuer();
		
		$scriptEnqueuer->addScriptFramework('ff-select2', '/framework/extern/select2/jquery.select2.min.js');
		$styleEnqueuer->addStyleFramework('ff-select2','/framework/extern/select2/jquery.select2.css');
	}
	
	/**
	 * @return ffScriptEnqueuer
	 */
	protected function _getScriptEnqueuer() {
		return $this->_scriptEnqueuer;
	}
	
	/**
	 * @param ffScriptEnqueuer $_scriptEnqueuer
	 */
	protected function _setScriptEnqueuer($scriptEnqueuer) {
		$this->_scriptEnqueuer = $scriptEnqueuer;
		return $this;
	}

	public function _getStyleEnqueuer() {
		return $this->_styleEnqueuer;
	}
	
	public function _setStyleEnqueuer(ffStyleEnqueuer $styleEnqueuer) {
		$this->_styleEnqueuer = $styleEnqueuer;
		return $this;
	}
	
	
}