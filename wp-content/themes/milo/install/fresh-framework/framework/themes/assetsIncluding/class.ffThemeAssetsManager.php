<?php

class ffThemeAssetsManager extends ffBasicObject {

################################################################################
# CONSTANTS
################################################################################

################################################################################
# PRIVATE OBJECTS
################################################################################
	
	/**
	 * 
	 * @var ffThemeAssetsIncluder
	 */
	private $_themeAssetsIncluder = null;
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
################################################################################
# PRIVATE VARIABLES	
################################################################################	

################################################################################
# CONSTRUCTOR
################################################################################	

	
	public function __construct( ffThemeAssetsIncluder $themeAssetsIncluder, ffWPLayer $WPLayer ) {
		$this->_setThemeAssetsIncluder( $themeAssetsIncluder );
		$this->_setWPLayer($WPLayer);
		
		$this->_getWPLayer()->getHookManager()->addActionPreEnqueueScripts( array($this, 'actionPreEnqueueScripts'));
        $this->_getWPLayer()->add_action('wp_footer', array($this, 'actionWPFooter'), 1);
	}
	
################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	
    public function actionWPFooter() {
        $this->_getThemeAssetsIncluder()->actionWPFooter();
    }

	
	public function actionPreEnqueueScripts() {
		$this->_callProperFunctionsBasedOnReflection();
		
		/*
		$a = microtime( true );
		$ref = new ReflectionClass($this->_getThemeAssetsIncluder());
		
		$ref->getMethods();
		$ref->getMethods();
		$ref->getMethods();
		
		var_dump( microtime(true) - $a );
		var_Dump( $ref->getMethods() );
		//var_dump( get_class_methods( 'ffThemeAssetsIncluder'));
		//var_dump( get_class_methods( $this->_getThemeAssetsIncluder() ));
		die();*/
	}
	
	
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	private function _evalIsAdmin() {
		if( $this->_getWPLayer()->is_admin() ) {
			$this->_getThemeAssetsIncluder()->isAdmin();
		}
	}
	
	private function _evalIsNotAdmin() {
		if( !$this->_getWPLayer()->is_admin() ) {
			$this->_getThemeAssetsIncluder()->isNotAdmin();
		}
	}
	
	private function _evalIsGlobal() {
		$this->_getThemeAssetsIncluder()->isGlobal();
	}
	
	private function _evalIsTaxonomy() {
		$this->_getThemeAssetsIncluder()->isTaxonomy();
	}
	
	private function _evalIsSingular() {
		$this->_getThemeAssetsIncluder()->isSingular();
	}
	
	private function _evalIsPage() {
		$this->_getThemeAssetsIncluder()->isPage();
	}
	
	private function _evalIsCategory() {
		$this->_getThemeAssetsIncluder()->isCategory();
	}
	
	
	private function _callProperFunctionsBasedOnReflection() {
		$cleanMethods = $this->_getAllImplementedMethods();
		
		foreach( $cleanMethods as $oneMethod ) {
			switch( $oneMethod ) {
				case 'isNotAdmin':
						$this->_evalIsNotAdmin();
					break;
				
				case 'isAdmin':
						$this->_evalIsAdmin();
					break;
				case 'isGlobal':
						$this->_evalIsGlobal();
					break;
					
				case 'isTaxonomy':
						$this->_evalIsTaxonomy();
					break;
				case 'isSingular':
						$this->_evalIsSingular();
					break;
				case 'isPage':
						$this->_evalIsPage();
					break;
				case 'isCategory':
						$this->_evalIsCategory();
					break;
			}
		}
	}
	
	private function _getAllImplementedMethods() {
		$reflection = new ReflectionClass( $this->_getThemeAssetsIncluder() );
		$methods = $reflection->getMethods();
		
		$methodsToReturn = array();
		
		foreach( $methods as $oneMethod ) {
			if( $oneMethod->class == 'ffThemeAssetsIncluder') {
				$methodsToReturn[] = $oneMethod->name;
			}
		}
		
		return $methodsToReturn;
	}
	
################################################################################
# GETTERS AND SETTERS
################################################################################	
	
	
	/**
	 *
	 * @return ffThemeAssetsIncluder
	 */
	protected function _getThemeAssetsIncluder() {
		return $this->themeAssetsIncluder;
	}
	
	/**
	 *
	 * @param ffThemeAssetsIncluder $themeAssetsIncluder
	 */
	protected function _setThemeAssetsIncluder(ffThemeAssetsIncluder $themeAssetsIncluder) {
		$this->themeAssetsIncluder = $themeAssetsIncluder;
		return $this;
	}
	
	/**
	 *
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 *
	 * @param ffWPLayer $WPLayer        	
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
	
	
}