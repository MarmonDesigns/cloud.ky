<?php

class ffAceLoader extends ffBasicObject {
	
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
	
	public function __construct( ffScriptEnqueuer $scriptEnqueuer, ffStyleEnqueuer $styleEnqueuer ) {
		$this->_setScriptEnqueuer($scriptEnqueuer);
		$this->_setStyleEnqueuer($styleEnqueuer);
	}

	
	public function loadAceEditor() {


		$scriptEnqueuer = $this->_getScriptEnqueuer();
		$styleEnqueuer = $this->_getStyleEnqueuer();
		
		$scriptEnqueuer->addScriptFramework('ff-ace', '/framework/extern/ace/src-min-noconflict/ace.js');
		$scriptEnqueuer->addScriptFramework('ff-ace-emmet', '/framework/extern/ace/src-min-noconflict/ext-emmet.js');
		$scriptEnqueuer->addScriptFramework('ff-emmet', '/framework/extern/ace/files/emmet.min.js');
		$scriptEnqueuer->addScriptFramework('ff-editor-initiation', '/framework/extern/ace/files/editor-initiation.js');
		
	
		$styleEnqueuer->addStyleFramework('ff-editor-initiation','/framework/extern/ace/files/editor-initiation.css');
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