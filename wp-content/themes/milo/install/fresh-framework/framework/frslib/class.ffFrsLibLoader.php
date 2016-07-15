<?php

class ffFrsLibLoader extends ffBasicObject {
	
	/**
	 * 
	 * @var ffScriptEnqueuer
	 */
	private $_scriptEnqueuer = null;
	
	public function __construct( ffScriptEnqueuer $scriptEnqueuer ) {
		$this->_setScriptEnqueuer($scriptEnqueuer);
	}

	public function requireFrsLib() {
		$this->_getScriptEnqueuer()
			->addScriptFramework( 'ff-frslib', '/framework/frslib/src/frslib.js', array('jquery'));
	}
	

	/**
	 * @return ffScriptEnqueuer
	 */
	protected function _getScriptEnqueuer() {
		return $this->_scriptEnqueuer;
	}
	
	/**
	 * @param ffScriptEnqueuer $scriptEnqueuer
	 */
	protected function _setScriptEnqueuer($scriptEnqueuer) {
		$this->_scriptEnqueuer = $scriptEnqueuer;
		return $this;
	}
	
}