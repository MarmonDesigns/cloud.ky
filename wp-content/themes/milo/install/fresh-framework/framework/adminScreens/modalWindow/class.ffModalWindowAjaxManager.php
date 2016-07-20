<?php
/**
 * This class automatically loads all necessary files. It will be also used
* across the whole template, when you need to load something dynamically
* @author freshface
* @since 1.1.2
*/
class ffModalWindowAjaxManager extends ffBasicObject {

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
	 * @var ffModalWindowFactory
	 */
	private $_modalWindowFactory = null;

/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffWPLayer $WPLayer, ffModalWindowFactory $modalWindowFactory ) {
		$this->_setWPLayer($WPLayer);
		$this->_setModalWindowFactory($modalWindowFactory);
	}
	
	public function hookAjax() {
		$this->_getWPLayer()->getHookManager()->addAjaxRequestOwner('ffModalWindow', array( $this, 'actModalWindowAjax') );
	}
	
	public function actModalWindowAjax( ffAjaxRequest $request ) {
		 
		// ffModalWindowManagerTest
		$managerClass = $request->specification['managerClass'];
		// ModalWindowManagerTest
		$managerClassWithoutFF = substr( $managerClass, 2 );//str_replace('ff', '', $managerClass);
		// getModalWindowManagerTest
		$managerClassMethodName = 'get'.$managerClassWithoutFF;

		$factory = $this->_getModalWindowFactory();

		if( method_exists( $factory, $managerClassMethodName) ) {
			// create a modal window
			$modalWindowManager = call_user_func( array( $factory, $managerClassMethodName) );
			
			$requestModalClass = $request->specification['modalClass'];
			foreach( $modalWindowManager->getModalWindows() as $oneModalWindow ) {
				if( $oneModalWindow instanceof $requestModalClass ) {
					$requestViewClass = $request->specification['viewClass'];
					
					foreach( $oneModalWindow->getViews() as $oneView ) {
						if( $oneView instanceof  $requestViewClass ) {
							$oneView->proceedAjax( $request );
						}
					}
					
				}
			}
		}
		
		
		//var_dump($this->_getModalWindowFactory());
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/	
	
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
	 * @return ffModalWindowFactory
	 */
	protected function _getModalWindowFactory() {
		return $this->_modalWindowFactory;
	}
	
	/**
	 * @param ffModalWindowFactory $modalWindowFactory
	 */
	protected function _setModalWindowFactory(ffModalWindowFactory $modalWindowFactory) {
		$this->_modalWindowFactory = $modalWindowFactory;
		return $this;
	}	
}