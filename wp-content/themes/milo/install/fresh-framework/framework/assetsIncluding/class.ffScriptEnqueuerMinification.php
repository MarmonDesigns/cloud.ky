<?php

class ffScriptEnqueuerMinification extends ffScriptEnqueuer {

	/**
	 * 
	 * @var ffMinificator
	 */
	private $_minificator = null;
	
	public function __construct($WPLayer, $scriptFactory, $minificator) {
		parent::__construct($WPLayer, $scriptFactory);
		$this->_setMinificator( $minificator );
	}
	
	public function actionEnqueueScripts() {
		
		$this->_enqueueNonMinificableScripts();
		if( !empty($this->_scripts) ) {
			$this->_getMinificator()->startBatchJs('javascript');
			$this->_getMinificator()->addScriptArray( $this->_scripts );
			$minifiedJsUrl = $this->_getMinificator()->proceedBatchJs();
			$this->_getWplayer()->wp_enqueue_script('javascript-min', $minifiedJsUrl );
		}
	}

	/**
	 * @return ffMinificator
	 */
	protected function _getMinificator() {
		return $this->_minificator;
	}
	
	/**
	 * @param ffMinificator $_minificator
	 */
	protected function _setMinificator(ffMinificator $minificator) {
		$this->_minificator = $minificator;
		return $this;
	}
	
}