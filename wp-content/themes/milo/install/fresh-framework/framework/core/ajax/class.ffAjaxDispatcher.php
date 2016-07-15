<?php
/**
 * This class automatically loads all necessary files. It will be also used
* across the whole template, when you need to load something dynamically
* @author freshface
* @since 1.1.2
*/
class ffAjaxDispatcher extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffAjaxRequestFactory
	 */
	private $ajaxRequestFactory = null;

/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffWPLayer $WPLayer, ffAjaxRequestFactory $ajaxRequestFactory) {
		$this->_setWPLayer($WPLayer);
		$this->_setAjaxRequestFactory($ajaxRequestFactory);
	}
	
	public function ajaxRequest() {
		$request = $this->_getAjaxRequestFactory()->createAjaxRequest();
		$this->_getWPLayer()->getHookManager()->doAjaxRequest($request);
		$this->_getWPLayer()->getHookManager()->doActionAjaxShutdown();
		die();
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	public function hookActions() {
		if( $this->_getWPLayer()->is_admin() ) {
			$this->_getWPLayer()->getHookManager()->addActionAjax( array( $this, 'ajaxRequest') );
		}
	}
	
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	
	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	/**
	 * @return ffAjaxRequestFactory
	 */
	protected function _getAjaxRequestFactory() {
		return $this->_ajaxRequestFactory;
	}
	
	/**
	 * @param ffAjaxRequestFactory $ajaxRequestFactory
	 */
	protected function _setAjaxRequestFactory(ffAjaxRequestFactory $ajaxRequestFactory) {
		$this->_ajaxRequestFactory = $ajaxRequestFactory;
		return $this;
	}
	
	
}