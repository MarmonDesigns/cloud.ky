<?php

class ffLessWPOptionsManager extends ffBasicObject {



	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * @var ffLessWPOptions_Factory
	 */
	private $_LessWPLessWPOptions_Factory = null;

	/**
	 * @var ffDataStorage_Factory
	 */
	private $_DataStorage_Factory = null;

	/**
	 * @var ffStyleEnqueuer
	 */
	private $_StyleEnqueuer = null;



	/**
	 * class constructor
	 * @param ffWPLayer               $WPLayer
	 * @param ffLessWPOptions_Factory $LessWPOptions_Factory
	 * @param ffDataStorage_Factory   $DataStorage_Factory
	 */
	function __construct(
			ffWPLayer $WPLayer
			, ffLessWPOptions_Factory $LessWPOptions_Factory
			, ffDataStorage_Factory $DataStorage_Factory
			, ffStyleEnqueuer $StyleEnqueuer
		){
		$this->_setWPlayer($WPLayer);
		$this->_setLessWPOptions_Factory($LessWPOptions_Factory);
		$this->_setDataStorage_Factory($DataStorage_Factory);
		$this->_setStyleEnqueuer($StyleEnqueuer);
	}



	// Bootstrap links, files



	/**
	 * @return string Path to bootstrap variables.less file
	 */
	public function getFrameworkBootstrapVariablesLessFilePath(){
		return $this->_getWPlayer()->getFrameworkDir().'/framework/extern/bootstrap/less/variables.less';
	}

	/**
	 * @return string URL to bootstrap variables.less file
	 */
	public function getFrameworkBootstrapVariablesLessUrl(){
		return $this->_getWPlayer()->getFrameworkUrl().'/framework/extern/bootstrap/less/variables.less';
	}


	/**
	 * @return string Path to bootstrap mixins.less file
	 */
	public function getFrameworkBootstrapMixinsLessFilePath(){
		return $this->_getWPlayer()->getFrameworkDir().'/framework/extern/bootstrap/less/mixins.less';
	}

	/**
	 * @return string URL to bootstrap mixins.less file
	 */
	public function getFrameworkBootstrapMixinsLessUrl(){
		return $this->_getWPlayer()->getFrameworkUrl().'/framework/extern/bootstrap/less/mixins.less';
	}


	/**
	 * @return string Path to main framework bootstrap.less link
	 */
	public function getFrameworkBootstrapLessFilePath(){
		return $this->_getWPlayer()->getFrameworkDir().'/framework/extern/bootstrap/less/bootstrap.less';
	}

	/**
	 * @return string URL to main framework bootstrap.less link
	 */
	public function getFrameworkBootstrapLessUrl(){
		return $this->_getWPlayer()->getFrameworkUrl().'/framework/extern/bootstrap/less/bootstrap.less';
	}


	/**
	 * @return string Path to fresh ff-mixins.less file
	 */
	public function getFrameworkFreshMixinsLessFilePath(){
		return $this->_getWPlayer()->getFrameworkDir().'/framework/adminScreens/assets/css/ff-mixins.less';
	}

	/**
	 * @return string URL to fresh ff-mixins.less file
	 */
	public function getFrameworkFreshMixinsLessUrl(){
		return $this->_getWPlayer()->getFrameworkUrl().'/framework/adminScreens/assets/css/ff-mixins.less';
	}


	/**
	 * Enque framework bootstrap less file into page
	 * @param string $handle [description]
	 */
	public function addFrameworkBootstrap( $handle ){
		$this->_getStyleEnqueuer()->addStyleFramework( $handle, '/framework/extern/bootstrap/less/bootstrap.less' );
	}



	// Variables / Options structures



	public function getOptionsFromFile( $optionsName, $file ){
		return $this->_getLessWPOptions_Factory()->createWPOptionsStructureFromFile(
			$file
			, $optionsName
		);
	}

	public function getOptionsFromFrameworkBootstrap( $optionsName ){
		return $this->_getLessWPOptions_Factory()->createWPOptionsStructureFromFile(
			$this->getFrameworkBootstrapVariablesLessFilePath()
			, $optionsName
		);
	}



	// Variables / Options data



	/**
	 * Creates WP Options Data from file parameter
	 * @param  string $optionsName name of options
	 * @return array
	 */
	public function addWPOptionsDataFrom_POST( $optionsName ){
		global $_POST;

		$dataStorage = $this->_getDataStorage_Factory()->createDataStorageWPOptionsNamespace( $optionsName );
		if( isSet($_POST[$optionsName]) ){
			foreach ($_POST[$optionsName][$optionsName] as $key => $value) {
				if( '' === $value ){
					unset( $_POST[ $optionsName ][ $optionsName ][ $key] );
				}
			}
			$dataStorage->setOption($optionsName, $_POST[ $optionsName ]);
		}
		return null;
	}

	public function getWPOptionsData( $optionsName ){
		return $this->_getDataStorage_Factory()
				->createDataStorageWPOptionsNamespace( $optionsName )
				->getOption( $optionsName );
	}

	/**
	 * @return array data loaded from DB by file, updates it by _POST
	 */
	public function createWPOptionsData( $optionsName ){
		$this->addWPOptionsDataFrom_POST( $optionsName );
		$ret = $this->getWPOptionsData( $optionsName );
		if( empty($ret) ){
			$ret = array();
		}
		return $ret;
	}

	public function addLessVariablesFromWPOptionsData( $handle, $optionsName ){
		$variables = $this->getWPOptionsData( $optionsName );
		if( empty($variables[ $optionsName ]) ){
			return;
		}

		$styleEnqueuer = $this->_getStyleEnqueuer();
		foreach ($variables[ $optionsName ] as $variable => $value) {
			$styleEnqueuer->addLessVariable( $handle, $variable, $value );
		}
	}



	// Getter / Setters



	/**
	 * @return ffWPLayer instance of ffWPLayer
	 */
	protected function _getWPlayer() {
		return $this->_WPLayer;
	}

	/**
	 * @param ffWPLayer $_WPLayer
	 * @return ffLessWPOptionsManager caller instance of ffLessWPOptionsManager
	 */
	protected function _setWPlayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}



	/**
	 * @return ffLessWPOptions_Factory instance of ffDataStorage_Factory
	 */
	protected function _getLessWPOptions_Factory() {
		return $this->_LessWPOptions_Factory;
	}

	/**
	 * @param ffLessWPOptions_Factory $_LessWPOptions_Factory
	 * @return ffLessWPOptions_Factory caller instance of ffLessWPOptions_Factory
	 */
	protected function _setLessWPOptions_Factory(ffLessWPOptions_Factory $LessWPOptions_Factory) {
		$this->_LessWPOptions_Factory = $LessWPOptions_Factory;
		return $this;
	}



	/**
	 * @return ffDataStorage_Factory instance of ffDataStorage_Factory
	 */
	protected function _getDataStorage_Factory() {
		return $this->_DataStorage_Factory;
	}

	/**
	 * @param ffDataStorage_Factory $_DataStorage_Factory
	 * @return ffLessWPOptions_Factory caller instance of ffLessWPOptions_Factory
	 */
	protected function _setDataStorage_Factory(ffDataStorage_Factory $DataStorage_Factory) {
		$this->_DataStorage_Factory = $DataStorage_Factory;
		return $this;
	}



	/**
	 * @return ffStyleEnqueuer instance of ffStyleEnqueuer
	 */
	protected function _getStyleEnqueuer() {
		return $this->_StyleEnqueuer;
	}

	/**
	 * @param ffStyleEnqueuer $_StyleEnqueuer
	 * @return ffLessWPOptions_Factory caller instance of ffLessWPOptions_Factory
	 */
	protected function _setStyleEnqueuer(ffStyleEnqueuer $StyleEnqueuer) {
		$this->_StyleEnqueuer = $StyleEnqueuer;
		return $this;
	}

}


