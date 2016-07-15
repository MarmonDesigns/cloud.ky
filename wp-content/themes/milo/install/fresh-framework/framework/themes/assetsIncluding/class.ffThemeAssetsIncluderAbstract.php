<?php

abstract class ffThemeAssetsIncluderAbstract extends ffBasicObject {

################################################################################
# CONSTANTS
################################################################################

################################################################################
# PRIVATE OBJECTS
################################################################################
	
	
	/**
	 * 
	 * @var ffStyleEnqueuer
	 */
	private $_styleEnqueuer = null;
	
	
	/**
	 * 
	 * @var ffScriptEnqueuer
	 */
	private $_scriptEnqueuer = null;
	
	
	/**
	 * 
	 * @var ffLessWPOptionsManager
	 */
	private $_lessWPOptionsManager = null;
	
	
################################################################################
# PRIVATE VARIABLES	
################################################################################	

################################################################################
# CONSTRUCTOR
################################################################################	

	
	public function __construct( ffStyleEnqueuer $styleEnqueuer, ffScriptEnqueuer $scriptEnqueuer, ffLessWPOptionsManager $lessWPOptionsManager ) {
		$this->_setStyleEnqueuer($styleEnqueuer);
		$this->_setScriptEnqueuer($scriptEnqueuer);
		$this->_setLessWPOptionsManager($lessWPOptionsManager);
	}
	
	
	public function isAdmin() {
		
	}
	
	public function isNotAdmin() {
		
	}
	
	public function isGlobal() {
		
	}
	
	public function isTaxonomy( $type = null ) {
		
	}
	
	public function isSingular( $type = null  ) {
		
	}
	
	public function isPage( $template = null ) {
		
	}
	
	public function isCategory( $id = null ) {
		
	}

    public function actionWPFooter() {

    }

    public function addPrintedSection( $name ) {

    }
	
################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	
	
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	 
################################################################################
# GETTERS AND SETTERS
################################################################################	
	
	
	/**
	 *
	 * @return ffStyleEnqueuer
	 */
	protected function _getStyleEnqueuer() {
		return $this->_styleEnqueuer;
	}
	
	/**
	 *
	 * @param ffStyleEnqueuer $styleEnqueuer
	 */
	protected function _setStyleEnqueuer(ffStyleEnqueuer $styleEnqueuer) {
		$this->_styleEnqueuer = $styleEnqueuer;
		return $this;
	}
	
	/**
	 *
	 * @return ffScriptEnqueuer
	 */
	protected function _getScriptEnqueuer() {
		return $this->_scriptEnqueuer;
	}
	
	/**
	 *
	 * @param ffScriptEnqueuer $scriptEnqueuer
	 */
	protected function _setScriptEnqueuer(ffScriptEnqueuer $scriptEnqueuer) {
		$this->_scriptEnqueuer = $scriptEnqueuer;
		return $this;
	}
	
	/**
	 *
	 * @return ffLessWPOptionsManager
	 */
	protected function _getLessWPOptionsManager() {
		return $this->_lessWPOptionsManager;
	}
	
	/**
	 *
	 * @param ffLessWPOptionsManager $lessWPOptionsManager        	
	 */
	protected function _setLessWPOptionsManager(ffLessWPOptionsManager $lessWPOptionsManager) {
		$this->_lessWPOptionsManager = $lessWPOptionsManager;
		return $this;
	}
	
	
}