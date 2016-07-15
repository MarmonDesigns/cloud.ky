<?php

abstract class ffAdminScreenView extends ffBasicObject implements ffIAdminScreenView {
	
	protected $_menuSlug = null;
	
	protected $_viewName = null;
	/**
	 * 
	 * @var ffScriptEnqueuer
	 */
	protected $_scriptEnqueuer = null;
	
	/**
	 * 
	 * @var ffStyleEnqueuer
	 */
	protected $_styleEnqueuer = null;
	
	protected $_WPLayer = null;
	
	public function __construct( $menuSlug, $viewName, ffScriptEnqueuer $scriptEnqueuer, ffStyleEnqueuer $styleEnqueuer, ffWPLayer $WPLayer ) {
		$this->_menuSlug = $menuSlug;
		$this->_viewName = $viewName;
		$this->_setScriptEnqueuer($scriptEnqueuer);
		$this->_setStyleEnqueuer($styleEnqueuer);
		$this->_setWPLayer($WPLayer);
		
		$this->_getWPLayer()->getHookManager()->addActionPreEnqueueScripts( array( $this, 'requireAssets' ) );
		
		$this->_setDependencies();
	}
	
	
	public function render() {
		$this->_renderViewIdentification();
		$this->_render();
	}

	protected function _renderOptions( $optionHolderName, $optionsPrefix, $optionsNamespace, $optionsName ){
		$cont = ffContainer::getInstance();

		$struct = $cont->getOptionsHolderFactory()->createOptionsHolder( $optionHolderName )->getOptions();

		$postReader = $cont->getOptionsFactory()->createOptionsPostReader();
		$postReader->setOptionsStructure( $struct );
		$postData = $postReader->getData( $optionsPrefix );
		// prefix[a][b]
		$dataStorage = $cont->getDataStorageFactory()->createDataStorageWPOptionsNamespace( $optionsNamespace );
		if( ! empty($postData) ){
			$dataStorage->setOption( $optionsName, $postData);
		}
		$data = $dataStorage->getOption( $optionsName );

		$printer = $cont->getOptionsFactory()->createOptionsPrinterBoxed( $data, $struct );
		$printer->setIdprefix( $optionsPrefix );
		$printer->setNameprefix( $optionsPrefix );
		$printer->walk();
	}


	public function actionSave( ffRequest $request ) {
	
	}
	
	public function ajaxRequest( ffAdminScreenAjax $ajax ) {
		
	}
	
	public function requireAssets() {
 
		wp_enqueue_media();
 
		//wp_enqueue_style('buttons');
		// http://localhost:8888/framework/wp-admin/load-styles.php?c=1&dir=ltr&load=dashicons,admin-bar,wp-admin,buttons,wp-auth-check,media-views&ver=3.9.1
 
		// TODO upravit pico;
		//wp_enqueue_script('jquery-ui-core');
		//wp_enqueue_script('jquery-ui-sortable');
		$this->_getScriptEnqueuer()->addScript('jquery-ui-core');
		$this->_getScriptEnqueuer()->addScript('jquery-ui-sortable');
		$this->_getScriptEnqueuer()->addScript('jquery-ui-datepicker');
		$this->_getStyleEnqueuer()->addStyleFramework('jquery-ui-datepicker', 'framework/extern/jquery-ui/datepicker.css');
		$this->_getScriptEnqueuer()->addScriptFramework('ff-fw-freshlib', 'framework/adminScreens/assets/js/freshlib.js', array('jquery'));

		$this->_getScriptEnqueuer()
				->getFrameworkScriptLoader()
				->requireFrsLib();

		$this->_getScriptEnqueuer()
		->getFrameworkScriptLoader()
		->requireFrsLibOptions();

		$this->_getScriptEnqueuer()->addScriptFramework('ff-fw-adminScreens', 'framework/adminScreens/assets/js/adminScreens.js', array('jquery'));
		$this->_getScriptEnqueuer()->addScriptFramework('ff-fw-options', 'framework/options/assets/options.js', array('jquery'));
		$this->_requireAssets();
		//$this->_getStyleEnqueuer()->addStyleFramework('ff-admin', 'framework/adminScreens/assets/css/ff-admin.less', null, null, null, null);
		//( $handle = null, $source = null, $dependencies = null, $version = null, $media = null, $type = null, $additionalInfo = null )

		// TODO rewrite info framework stuff
		//ffContainer::getInstance()->getFrameworkScriptLoader()->addAdminColorsToStyle('ff-admin');
		ffContainer::getInstance()->getFrameworkScriptLoader()->requireFfAdmin();
		// TODO END

		//$this->_getStyleEnqueuer()->addLessVariable('ff-admin', 'aaaa', 'blue');
		
		$this->_getStyleEnqueuer()->addStyleFramework('ff-fw-options', 'framework/options/assets/options.css');
		
	}
	
	private function _renderViewIdentification() {
		$text = '';
		$text .= '<div class="ff-view-identification" style="display:none;">';
			$text .= '<div class="admin-screen-name">'.$this->_menuSlug.'</div>';
			$text .= '<div class="admin-view-name">'.$this->_viewName.'</div>';
		$text .= '</div>';
		
		echo $text;
	}
	
	
	abstract protected function _render();
	abstract protected function _requireAssets();
	abstract protected function _setDependencies();
	

	/**
	 * @return ffScriptEnqueuer
	 */
	protected function _getScriptEnqueuer() {
		return $this->_scriptEnqueuer;
	}
	
	/**
	 * @param ffScriptEnqueuer $scriptEnqueuer
	 */
	protected function _setScriptEnqueuer(ffScriptEnqueuer $scriptEnqueuer) {
		$this->_scriptEnqueuer = $scriptEnqueuer;
		return $this;
	}
	
	/**
	 * @return ffStyleEnqueuer
	 */
	protected function _getStyleEnqueuer() {
		return $this->_styleEnqueuer;
	}
	
	/**
	 * @param ffStyleEnqueuer $styleEnqueuer
	 */
	protected function _setStyleEnqueuer(ffStyleEnqueuer $styleEnqueuer) {
		$this->_styleEnqueuer = $styleEnqueuer;
		return $this;
	}
	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	protected function _setWPLayer($WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
	
}