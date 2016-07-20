<?php
/**
 * This class automatically loads all necessary files. It will be also used
* across the whole template, when you need to load something dynamically
* @author freshface
* @since 1.1.2
*/
class ffAjaxRequestFactory extends ffFactoryAbstract {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffRequest
	 */
	private $_request = null;

/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffClassLoader $classLoader, ffRequest $request ) {
		$this->_setRequest($request);
		parent::__construct($classLoader);
	}
	
	public function createAjaxRequest() {
		$this->_getClassloader()->loadClass('ffAjaxRequest');
		$request = new ffAjaxRequest();
		
		if( isset( $_POST['owner'] ) ) { 
			$request->owner = $_POST['owner'];
		}
		
		if( isset( $_POST['specification'] ) ) {
			$request->specification = $_POST['specification'];
		}
		
		if( isset( $_POST['data'] ) ) {
			$request->data = $_POST['data'];
		}
		
		return $request;
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/	
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	
	/**
	 * @return ffRequest
	 */
	protected function _getRequest() {
		return $this->_request;
	}
	
	/**
	 * @param ffRequest $_request
	 */
	protected function _setRequest(ffRequest $request) {
		$this->_request = $request;
		return $this;
	}
}