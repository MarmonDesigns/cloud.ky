<?php

class ffThemeOptions{

	/**
	 * @var ffThemeOptions
	 */
	private static $_instance = null;

	// const OPTIONS_NAMESSPACE = 'theme_mix';
	// const OPTIONS_NAME = 'theme_options';
	const OPTIONS_NAMESPACE = ffThemeContainer::OPTIONS_NAMESPACE ;
	const OPTIONS_NAME      = ffThemeContainer::OPTIONS_NAME;

	private $_options = null;
	private $_html_to_remove = array();
	private $_optionsHasBeenInitialised = false;
	private $_query = null;

	private $_currentOptions = array();
	/**
	 * @return ffThemeOptions
	 */
	public static function getInstance() {
		if( self::$_instance == null ) {
			self::$_instance = new ffThemeOptions();
		}
		return self::$_instance;
	}

	public static function getQuery( $path = null  ) {
		$query =  self::getInstance()->_getQuery();

		if( $path != null ) {
			$path = 'theme_options '.  $path;
			return $query->get( $path );
		} else {
			return $query;
		}
	}

	public static function get( $name, $default = null ){
		return self::getInstance()->_get( $name, $default );
	}

	public static function addFeaturedAreaToRemoveFromContent( $html ){
		return self::getInstance()->_addFeaturedAreaToRemoveFromContent( $html );
	}

	public static function removeFeaturedAreaToRemoveFromContent( $html ){
		return self::getInstance()->_removeFeaturedAreaToRemoveFromContent( $html );
	}

	public static function getCurrentOption( $name ) {
		return self::getInstance()->_getCurrentOption($name);
	}

	public static function setCurrentOption( $name, $value ) {
		return self::getInstance()->_setCurrentOption($name, $value);
	}

	protected function _setCurrentOption( $name, $value ) {
		$this->_currentOptions[ $name ] = $value;
	}

	protected function _getCurrentOption( $name ) {
		if( isset( $this->_currentOptions[ $name ] ) ) {
			return $this->_currentOptions[ $name ];
		} else {
			return null;
		}
	}

	protected function _getQuery() {
		$this->_initOptions();
		return $this->_query;
	}

	protected function _initOptions() {
		if( $this->_optionsHasBeenInitialised == true ) {
			return;

		}

		if( null === $this->_options ){
			$data = ffContainer::getInstance()
			->getDataStorageFactory()
			->createDataStorageWPOptionsNamespace( ffThemeOptions::OPTIONS_NAMESPACE )
			->getOption( ffThemeOptions::OPTIONS_NAME );

			if( null === $data ){
				$this->_options = array();
			}else if( empty( $data[ ffThemeOptions::OPTIONS_NAME ] ) ){
				$this->_options = array();
			}else{
				$this->_options = $data[ ffThemeOptions::OPTIONS_NAME ];
			}

			$query = ffContainer::getInstance()->getOptionsFactory()->createQuery($data, 'ffThemeOptionsHolder' );

			$this->_query = $query;
		}
	}

	protected function _get($name, $default){
		if( ! class_exists('ffContainer') ){
			return $default;
		}

		$this->_initOptions();


		return isSet( $this->_options[ $name ] )
				? $this->_options[ $name ]
				: $default
				;
	}

	protected function _addFeaturedAreaToRemoveFromContent( $html ){
		$this->_html_to_remove[] = $html;
	}

	protected function _removeFeaturedAreaToRemoveFromContent( $html ){
		foreach ($this->_html_to_remove as $remove) {
			$html = str_replace( $remove , '' , $html );
		}
		$html = str_replace('<p><iframe ', '<p class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" ', $html);
		$html = str_replace('<p><embeded ', '<p class="embed-responsive embed-responsive-16by9"><embeded class="embed-responsive-item" ', $html);
		return $html;
	}

}