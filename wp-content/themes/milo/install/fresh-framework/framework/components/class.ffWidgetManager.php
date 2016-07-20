<?php
/**
 * Layer between wordpress and our widgets. Mainly handle registration of all
 * widgets. Here is also handled the class loading, so the classes are loaded
 * only in case when really needed
 * 
 * @since 0.1
 * @author FRESHFACE
 */

class ffWidgetManager extends ffBasicObject {
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
	 * @var ffClassLoader
	 */
	private $_classLoader = null;
	
	/**
	 * checks if we already hooked "widgets_init" action for registering
	 * our widgets
	 * @var bool
	 */
	private $_widgetRegistrationHasBeenHooked = false;
	
	private $_widgetClassNames = array();
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffWPLayer $WPLayer, ffClassLoader $classLoader ) {
		$this->_setWPLayer($WPLayer);
		$this->_setClassLoader( $classLoader );
	}	
	
	/**
	 * Hooked action for registering widgets. Widget classes are loaded strictly
	 * here, so we are not wasting resources.
	 */
	public function actionRegisterWidget() {
		foreach( $this->_getWidgetClassNames() as $oneWidgetClassName ) {
			$this->_getClassLoader()->loadClass( $oneWidgetClassName );
			$this->_getWPLayer()->register_widget( $oneWidgetClassName );
		}
	}
	
	public function addWidgetClassName( $widgetClassName ) {
		$this->_hookWidgetRegistration();
		$this->_widgetClassNames[] = $widgetClassName;
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	/**
	 * Hooking register widgets
	 */
	private function _hookWidgetRegistration() {
		
		$this->_getClassLoader()->loadClass('ffWidgetDecoratorAbstract');
		if( false == $this->_getWidgetRegistrationHasBeenHooked() ) {
			$this->_getWPLayer()->getHookManager()->addActionWidgetsInit( array( $this, 'actionRegisterWidget' ) );
			$this->_setWidgetRegistrationHasBeenHooked( true );
		}
	}
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	private function _getWidgetClassNames() {
		return $this->_widgetClassNames;
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
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	/**
	 * @return bool
	 */
	protected function _getWidgetRegistrationHasBeenHooked() {
		return $this->_widgetRegistrationHasBeenHooked;
	}
	
	/**
	 * @param  $widgetRegistrationHasBeenHooked
	 */
	protected function _setWidgetRegistrationHasBeenHooked( $widgetRegistrationHasBeenHooked) {
		$this->_widgetRegistrationHasBeenHooked = $widgetRegistrationHasBeenHooked;
		return $this;
	}

	/**
	 * @return ffClassLoader
	 */
	protected function _getClassLoader() {
		return $this->_classLoader;
	}
	
	/**
	 * @param ffClassLoader $classLoader
	 */
	protected function _setClassLoader(ffClassLoader $classLoader) {
		$this->_classLoader = $classLoader;
		return $this;
	}
	
	
}