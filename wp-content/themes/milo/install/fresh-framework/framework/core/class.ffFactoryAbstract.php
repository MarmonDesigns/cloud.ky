<?php

abstract class ffFactoryAbstract {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffClassLoader
	 */
	protected $_classLoader = null;	
	
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffClassLoader $classLoader ) {
		$this->_setClassloader( $classLoader );
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	/**
	 * @return ffClassLoader
	 */
	protected function _getClassloader() {
		return $this->_classLoader;
	}
	
	/**
	 * @param ffClassLoader $classLoader
	 */
	protected function _setClassloader(ffClassLoader $classLoader) {
		$this->_classLoader = $classLoader;
		return $this;
	}	
}