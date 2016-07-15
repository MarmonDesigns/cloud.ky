<?php

class ffContainer extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	private static $_instance = null;
	
	private $_configuration = null;
	
	/**
	 * 
	 * @var ffClassLoader
	 */
	private $_classLoader = null;


	/**
	 * 
	 * @var ffFileManager
	 */
	private $_fileManager= null;
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffPluginLoader 
	 */
	private $_pluginLoader = null;
	
	
	/**
	 * 
	 * @var ffScriptEnqueuer
	 */
	private $_scriptEnqueuer = null;
	
	/**
	 *
	 * @var ffStyleEnqueuer
	 */
	private $_styleEnqueuer = null;
	
	/**
	 * 
	 * @var ffMimeTypesManager
	 */
	private $_mimeTypesManager = null;
	
	/**
	 * 
	 * @var ffOptions_Factory
	 */
	private $_optionsFactory = null;
	
	
	/**
	 * 
	 * @var ffComponent_Factory
	 */
	private $_componentFactory = null;
	
	/**
	 * 
	 * @var ffDataStorage_Factory
	 */
	private $_dataStorageFactory = null;
	
	/**
	 * 
	 * @var ffLibManager
	 */
	private $_libManager = null;
	
	/**
	 * 
	 * @var ffWidgetManager
	 */
	private $_widgetManager = null;
	
	
	/**
	 * 
	 * @var ffMenuManager
	 */
	private $_menuManager = null;
	
	/**
	 * 
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;
	
	/**
	 * 
	 * @var ffDataStorage_Cache
	 */
	private $_dataStorageCache = null;
	
	/**
	 * 
	 * @var ffMinificator
	 */
	private $_minificator = null;
	
	/**
	 * 
	 * @var ffAdminScreenManager
	 */
	private $_adminScreenManager = null;

	/**
	 *
	 * @var ffPluginIdentificator
	 */
	private $_pluginIdentificator = null;

	/**
	 *
	 * @var ffThemeIdentificator
	 */
	private $_themeIdentificator = null;

	/**
	 * 
	 * @var ffPluginInstaller
	 */
	private $_pluginInstaller = null;
	
	/**
	 * 
	 * @var ffAceLoader
	 */
	private $_aceLoader = null;
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public static function getInstance() {
		if( self::$_instance == null ) {
			self::$_instance = new ffContainer();
		}
		
		return self::$_instance;
	}

    private $_helpersFactory = null;
    public function getHelpersFactory() {
        if( $this->_helpersFactory == null ) {
            $this->getClassLoader()->loadClass('ffHelpersFactory');
            $this->_helpersFactory = new ffHelpersFactory( $this->getClassLoader() );
        }

        return $this->_helpersFactory;
    }

    public function getEnvatoApi() {
        $this->getClassLoader()->loadClass('ffEnvatoApi');

        $envatoApi = new ffEnvatoApi( $this->getHttp() );

        return $envatoApi;
    }


    private $_userNamespaceFactory = null;
    public function getUserNamespaceFactory() {
        if( $this->_userNamespaceFactory == null ) {
            $this->getClassLoader()->loadClass('ffUserNamespaceFactory');
            $this->_userNamespaceFactory = new ffUserNamespaceFactory( $this->getClassLoader() );
        }

        return $this->_userNamespaceFactory;
    }

    public function getEnvatoApiModern() {
        $this->getClassLoader()->loadClass('ffEnvatoApiModern');

        $envatoApi = new ffEnvatoApiModern( $this->getHttp(), $this->getRequest() );

        return $envatoApi;
    }

	public function getCiphers() {
		$this->getClassLoader()->loadClass('ffCiphers');
		return new ffCiphers();
	}
	
	private $_select2Loader = null;
	
	public function getSelect2Loader() {
		if( $this->_select2Loader == null ) {
			$this->getClassLoader()->loadClass('ffSelect2Loader');
			$this->_select2Loader = new ffSelect2Loader( $this->getScriptEnqueuer(), $this->getStyleEnqueuer());
		}
		
		return $this->_select2Loader;
	}


    public function getCompatibilityTester() {
        $this->getClassLoader()->loadClass('ffCompatibilityTester');

        $compatibilityTester = new ffCompatibilityTester( $this->getWPLayer() );

        return $compatibilityTester;
    }
	
	
	/**
	 * 
	 * @var ffModalWindowFactory
	 */
	private $_modalWindowFactory = null;


	/**
	 * @return ffModalWindowFactory
	 */
	public function getModalWindowFactory() {
		if( $this->_modalWindowFactory == null ) {
			$this->getClassLoader()->loadClass('ffModalWindowFactory');

			$this->_modalWindowFactory = new ffModalWindowFactory( $this->getClassLoader() );
		}

		return $this->_modalWindowFactory;
	}

    public function getUrlRewriter() {
        $this->getClassLoader()->loadClass('ffUrlRewriter');

        $urlRewriter = new ffUrlRewriter();

        return $urlRewriter;
    }


    private $_httpAction = null;

    public function getHttpAction() {
        if( $this->_httpAction == null ) {
            $this->getClassLoader()->loadClass('ffHttpAction');

            $this->_httpAction = new ffHttpAction();
        }

        return $this->_httpAction;
    }

	/**
	 * 
	 * @var ffAjaxDispatcher
	 */
	private $_ajaxDispatcher = null;
	
	public function getAjaxDispatcher() {
		if( $this->_ajaxDispatcher == null ) {
			$this->getClassLoader()->loadClass('ffAjaxRequestFactory');
			$this->getClassLoader()->loadClass('ffAjaxDispatcher');
			
			$ajaxRequestFactory = new ffAjaxRequestFactory($this->getClassLoader(), $this->getRequest());
			$this->_ajaxDispatcher = new ffAjaxDispatcher( $this->getWPLayer(), $ajaxRequestFactory);
		}
		
		return $this->_ajaxDispatcher;
	}
	
	private $_metaBoxes = null;
	
	/**
	 * 
	 * @return ffMetaBoxes
	 */
	public function getMetaBoxes() {
		if( $this->_metaBoxes == null ) {
			$this->getClassLoader()->loadClass('ffMetaBoxes');
			$this->_metaBoxes = new ffMetaBoxes( $this->getClassLoader(), $this );
		}
		
		return $this->_metaBoxes;
	}
	
	/**
	 * 
	 * @var ffModalWindowAjaxManager
	 */
	private $_modalWindowAjaxManager = null;
	
	public function getModalWindowAjaxManager() {
		if( $this->_modalWindowAjaxManager == null ) {
			$this->getClassLoader()->loadClass('ffModalWindowAjaxManager');
			$this->getClassLoader()->loadClass('ffModalWindowFactory');
			$modalWindowFactory = new ffModalWindowFactory( $this->getClassLoader() );
			$this->_modalWindowAjaxManager = new ffModalWindowAjaxManager($this->getWPLayer(), $modalWindowFactory);
		}
		
		return $this->_modalWindowAjaxManager;
	}
	
	
	public function getAceLoader() {
		if( $this->_aceLoader == null ) {
			$this->getClassLoader()->loadClass('ffAceLoader');
		
			$this->_aceLoader = new ffAceLoader( $this->getScriptEnqueuer(), $this->getStyleEnqueuer() );
		}
		
		return $this->_aceLoader;
	}
	
	public function getPluginInstaller() {
		if( $this->_pluginInstaller == null ) {
			$this->getClassLoader()->loadClass('ffPluginInstaller');
		
			$this->_pluginInstaller = new ffPluginInstaller($this->getWPLayer(), $this->getFileSystem(), $this->getPluginIdentificator());
		}
		return $this->_pluginInstaller;
	}
	
	public function setConfiguration( $configuration ) {
		$this->_configuration = $configuration;
	}

	/**
	 * 
	 * @var ffAttachmentLayer
	 */
	private $_attachmentLayer = null;

	public function getAttachmentLayer() {
		if( !empty($this->_attachmentLayer) ){
			return $this->_attachmentLayer;
		}
		$this->getClassLoader()->loadClass('ffAttachmentLayer');

		return $this->_attachmentLayer = new ffAttachmentLayer( $this->getWPLayer(), $this->getAttachmentLayer_Factory() );
	}
	
	/**
	 * 
	 * @var ffAttachmentCollection_Factory
	 */
	private $_attachmentCollection_Factory = null;

	public function getAttachmentCollection_Factory() {
		if( !empty($this->_attachmentCollection_Factory) ){
			return $this->_attachmentCollection_Factory;
		}
		$this->getClassLoader()->loadClass('ffAttachmentCollection_Factory');

		return $this->_attachmentCollection_Factory = new ffAttachmentCollection_Factory( $this->getClassLoader(), $this->getWPLayer() );
	}

	/**
	 * 
	 * @var ffLessManager
	 */
	private $_lessManager = null;
	
	public function getLessManager() {
		if( $this->_lessManager == null ) {
			$this->getClassLoader()->loadClass('ffLessManager');
			$this->_lessManager = new ffLessManager();
		}
		return $this->_lessManager;
	}
	
	private $_assetsIncludingFactory = null;
	
	/**
	 * 
	 * @return ffAssetsIncludingFactory
	 */
	public function getAssetsIncludingFactory() {
		if( $this->_assetsIncludingFactory == null ) {
			
			
			$this->getClassLoader()->loadClass('ffAssetsIncludingFactory');
			
			$this->_assetsIncludingFactory = new ffAssetsIncludingFactory( $this->getClassLoader() );
		}
		
		return $this->_assetsIncludingFactory;
	}
	
	/**
	 * 
	 * @var ffLessColorVariableDataStorage
	 */
	private $_lessColorVariableDataStorage = null;
	
	public function getLessColorVariableDataStorage() {
		if( $this->_lessColorVariableDataStorage == null ) {
			$this->getClassLoader()->loadClass('ffLessColorVariableDataStorage');
			
			$this->_lessColorVariableDataStorage = new ffLessColorVariableDataStorage();
		}
		
		return $this->_lessColorVariableDataStorage;
	}
	
	/**
	 * 
	 * @var ffLessColorLibraryManager
	 */
	private $_lessColorLibraryManager = null;
	
	public function getLessColorLibraryManager() {
		if( $this->_lessColorLibraryManager == null ) {
			$this->getClassLoader()->loadClass('ffLessColorLibraryManager');
			$this->_lessColorLibraryManager = new ffLessColorLibraryManager();
		}
		
		return $this->_lessColorLibraryManager;
	}
	
	private $_lessSystemColorLibrary = null;
	
	public function getLessSystemColorLibrary() {
		if( $this->_lessSystemColorLibrary == null ) {
			$this->getClassLoader()->loadClass('ffLessSystemColorLibrary');
			$this->_lessSystemColorLibrary = new ffLessSystemColorLibrary();
		}
		
		return $this->_lessSystemColorLibrary;
	}
	
	/**
	 * 
	 * @return ffLessVariableParser
	 */
	public function getLessVariableParser() {
		$this->getClassLoader()->loadClass('ffLessVariableParser');
		
		return new ffLessVariableParser();
	}
	
	public function getLessScssCompiler() {
		if( $this->_configuration['less_and_scss_compilation'] == false ) {
			return;
		}

		$this->getClassLoader()->loadClass('ffVariableTransporter');
		$this->getClassLoader()->loadClass('ffLessScssCompiler');

		$lessScssCompiler = new ffLessScssCompiler( 
														$this->getWPLayer(),
														$this->getDataStorageCache(),
														$this->getDataStorageFactory()->createDataStorageWPOptionsNamespace(  ffLessScssCompiler::EXTENDED_CACHING_DIR_NAMESPACE ),
														$this->getFileSystem(),
														new ffVariableTransporter(),
														$this->getLessParser(),
														$this->getAssetsIncludingFactory()->getLessManager(),
														$this->getAssetsIncludingFactory()->getLessSystemColorLibraryManager()
													);

		return $lessScssCompiler;
	}

	/**
	 * @var ffLessWPOptions_Factory
	 */
	private $_lessWPOptions_Factory = null;

	/**
	 * 
	 * @return ffLessWPOptions_Factory
	 */
	public function getLessWPOptions_Factory(){
		if( empty( $this->_lessWPOptions_Factory ) ){
			$this->getClassLoader()->loadClass('ffLessWPOptions_Factory');
			$this->_lessWPOptions_Factory = new ffLessWPOptions_Factory(
				$this->getClassLoader()
				, $this->getWPLayer()
				, $this->getOptionsFactory()
			);
		}
		return $this->_lessWPOptions_Factory;
	}

	/**
	 * @var ffLessWPOptionsManager
	 */
	private $_lessWPOptionsManager = null;

	/**
	 * @return ffLessWPOptionsManager
	 */
	public function getLessWPOptionsManager(){
		if( empty( $this->_lessWPOptionsManager ) ){
			$this->getClassLoader()->loadClass('ffLessWPOptionsManager');
			$this->_lessWPOptionsManager = new ffLessWPOptionsManager(
				$this->getWPLayer()
				, $this->getLessWPOptions_Factory()
				, $this->getDataStorageFactory()
				, $this->getStyleEnqueuer()
			);
		}
		return $this->_lessWPOptionsManager;
	}

	/**
	 *
	 * @var ffAttachmentLayer_Factory
	 */
	private $_attachmentLayer_Factory = null;

	public function getAttachmentLayer_Factory(){
		if( $this->_attachmentLayer_Factory == null ) {
			$this->getClassLoader()->loadClass( 'ffAttachmentLayer_Factory' );
			$this->_attachmentLayer_Factory = 
				new ffAttachmentLayer_Factory( 
					$this->getClassLoader()
					, $this->getWPLayer()
					, $this->getAttachmentCollection_Factory() 
				);
		}
		return $this->_attachmentLayer_Factory;
	}	
	
	/**
	 * 
	 * @var ffPostAdminColumnManager
	 */
	private $_postAdminColumnManager = null;

	public function getpostAdminColumnManager(){
		if( $this->_postAdminColumnManager == null ) {
			$this->getClassLoader()->loadClass( 'ffPostAdminColumnManager' );
			$this->_postAdminColumnManager = new ffPostAdminColumnManager(
				$this->getWPLayer(),
				$this->getDataStorageFactory()->createDataStorageWPPostMetas()
			);
		}
		return $this->_postAdminColumnManager;
	}

	/**
	 * 
	 * @var ffPostTypeRegistratorManager
	 */
	private $_PostTypeRegistratorManager = null;

	public function getPostTypeRegistratorManager(){
		if( $this->_PostTypeRegistratorManager == null ) {
			$this->getClassLoader()->loadClass( 'ffPostTypeRegistratorManager' );
			$this->_PostTypeRegistratorManager = new ffPostTypeRegistratorManager( $this->getWPLayer(), $this->getPostTypeRegistratorFactory() );
		}
		return $this->_PostTypeRegistratorManager;
	}

	/**
	 * 
	 * @var ffPostTypeRegistrator_Factory
	 */
	private $_PostTypeRegistrator_Factory = null;

	public function getPostTypeRegistratorFactory(){
		if( $this->_PostTypeRegistrator_Factory == null ) {
			$this->getClassLoader()->loadClass( 'ffPostTypeRegistrator_Factory' );
			$this->_PostTypeRegistrator_Factory = new ffPostTypeRegistrator_Factory( $this->getClassLoader() );

		}
		return $this->_PostTypeRegistrator_Factory;
	}
	
	/**
	 * 
	 * @var ffPostLayer
	 */
	private $_postLayer = null;

	public function getPostLayer() {
		if( !empty($this->_postLayer) ){
			return $this->_postLayer;
		}
		$this->getClassLoader()->loadClass('ffPostLayer');

		return $this->_postLayer = new ffPostLayer( $this->getWPLayer(), $this->getPostLayer_Factory() );
	}
	
	/**
	 * 
	 * @var ffPostCollection_Factory
	 */
	private $_postCollection_Factory = null;

	public function getPostCollection_Factory() {
		if( !empty($this->_postCollection_Factory) ){
			return $this->_postCollection_Factory;
		}
		$this->getClassLoader()->loadClass('ffPostCollection_Factory');

		return $this->_postCollection_Factory = new ffPostCollection_Factory( $this->getClassLoader(), $this->getWPLayer() );
	}

	/**
	 * 
	 * @var ffPostLayer_Factory
	 */
	private $_postLayer_Factory = null;

	public function getPostLayer_Factory(){
		if( $this->_postLayer_Factory == null ) {
			$this->getClassLoader()->loadClass( 'ffPostLayer_Factory' );
			$this->_postLayer_Factory = 
				new ffPostLayer_Factory( 
					$this->getClassLoader()
					, $this->getWPLayer()
					, $this->getPostCollection_Factory() 
				);
		}
		return $this->_postLayer_Factory;
	}	

	/**
	 * 
	 * @var ffCustomTaxonomyManager
	 */
	private $_customTaxonomyManager = null;

	public function getCustomTaxonomyManager(){
		if( $this->_customTaxonomyManager == null ) {
			$this->getClassLoader()->loadClass( 'ffCustomTaxonomyManager' );
			$this->_customTaxonomyManager = new ffCustomTaxonomyManager( $this->getWPLayer(), $this->getCustomTaxonomyFactory() );
		}
		return $this->_customTaxonomyManager;
	}

	/**
	 * 
	 * @var ffCustomTaxonomy_Factory
	 */
	private $_customTaxonomy_Factory = null;

	public function getCustomTaxonomyFactory(){
		if( $this->_customTaxonomy_Factory == null ) {

			$this->getClassLoader()->loadClass( 'ffCustomTaxonomy_Factory' );

			$this->getClassLoader()->loadClass( 'ffCustomTaxonomy' );
			$this->getClassLoader()->loadClass( 'ffCustomTaxonomyArgs' );
			$this->getClassLoader()->loadClass( 'ffCustomTaxonomyLabels' );
			//$this->getClassLoader()->loadClass( 'ffCustomTaxonomyMessages' );

			$this->_customTaxonomy_Factory = new ffCustomTaxonomy_Factory( $this->getClassLoader(), $this->getWPLayer() );

		}
		return $this->_customTaxonomy_Factory;
	}

	
	/**
	 * 
	 * @var ffTaxLayer
	 */
	private $_taxLayer = null;

	public function getTaxLayer() {
		if( !empty($this->_taxLayer) ){
			return $this->_taxLayer;
		}
		$this->getClassLoader()->loadClass('ffTaxLayer');

		return $this->_taxLayer = new ffTaxLayer( $this->getWPLayer(), $this->getTaxLayer_Factory() );
	}

	/**
	 * 
	 * @var ffTaxLayer_Factory
	 */
	private $_taxLayer_Factory = null;

	public function getTaxLayer_Factory(){
		if( $this->_taxLayer_Factory == null ) {
			$this->getClassLoader()->loadClass( 'ffTaxLayer_Factory' );
			$this->_taxLayer_Factory = new ffTaxLayer_Factory( $this->getClassLoader(), $this->getWPLayer() );
		}
		return $this->_taxLayer_Factory;
	}	



	public function getMinificator() {
		if( $this->_minificator == null ) {
			
			$this->getClassLoader()->loadClass('externCssMin');
			$this->getClassLoader()->loadClass('externJsMinPlus');
			$this->getClassLoader()->loadClass('externJsMinPlus_Adapteur');
			$this->getClassLoader()->loadClass('ffMinificator');
			
			
			$cssMin = new CSSmin();
			$jsMinPlus = new JsMinPlus_Adapteur();
			$this->_minificator = new ffMinificator($this->getWPLayer(), $cssMin, $jsMinPlus, $this->getDataStorageCache(), $this->getFileSystem(), $this->getScriptFactory(), $this->getStyleFactory(), $this->_configuration['minificator']['cache_files_max_old'], $this->_configuration['minificator']['cache_check_interval']);
		}
		
		return $this->_minificator;
	}
	
	public function getFrontendQueryIdentificator() {
		$this->getClassLoader()->loadClass('ffFrontendQueryIdentificator');
		return new ffFrontendQueryIdentificator( $this->getWPLayer() );
	}
	
	public function getHtaccess() {
		$this->getClassLoader()->loadClass('ffHtaccess');
		return new ffHtaccess();
	}
	
	public function getDataStorageCache() {
		if( $this->_dataStorageCache == null ) {
			$this->getClassLoader()->loadClass('ffIDataStorage');
			$this->getClassLoader()->loadClass('ffDataStorage_Cache');
			$this->_dataStorageCache = new ffDataStorage_Cache( $this->getFileSystem(), $this->getWPLayer(), $this->getDataStorageFactory()->createDataStorageWPOptionsNamespace() );
		}
		return $this->_dataStorageCache;
	}
	
	/**
	 * 
	 * @return ffLibManager
	 */
	public function getLibManager() {
		if( $this->_libManager == null ) {
			$this->getClassLoader()->loadClass('ffLibManager');
			$this->_libManager = new ffLibManager( $this->getClassLoader(), $this);
		}
		
		return $this->_libManager;
	}
	
	/**
	 * 
	 * @return ffWidgetManager
	 */
	public function getWidgetManager() {
		if( $this->_widgetManager == null ) {
			$this->getClassLoader()->loadClass('ffWidgetManager');
			$this->_widgetManager = new ffWidgetManager( $this->getWPLayer(), $this->getClassLoader() );
		}
		
		return $this->_widgetManager;
	}
	
	public function getAdminScreenAjaxFactory() {
		$this->getClassLoader()->loadClass('ffAdminScreenAjaxFactory');
		
		$adminScreenAjaxFactory = new ffAdminScreenAjax_Factory( $this->getClassLoader(), $this->getRequest());
		
		return $adminScreenAjaxFactory;
	}
	
	
	
	/**
	 * 
	 * @return ffDataStorage_Factory
	 */
	public function getDataStorageFactory() {
		if( $this->_dataStorageFactory == null ) {
			$this->getClassLoader()->loadClass('ffDataStorage_Factory');
			$this->_dataStorageFactory = new ffDataStorage_Factory( $this->getClassLoader(), $this->getWPLayer());
		}
		
		return $this->_dataStorageFactory;
	}
	
	public function getComponentFactory() {
		if( $this->_componentFactory == null ) {
			$this->getClassLoader()->loadClass('ffComponent_Factory');
			$optionsHolderFactory = $this->getOptionsHolderFactory();
			$this->_componentFactory = new ffComponent_Factory( $this->getClassLoader(),  $optionsHolderFactory );
		}
		
		return $this->_componentFactory;
	}
	
	public function getOptionsHolderFactory() {
		$this->getClassLoader()->loadClass('ffOptionsHolder_Factory');
		$optionsHolderFactory = new ffOptionsHolder_Factory( $this->getClassLoader(), $this->_getOneStructureFactory());
		return $optionsHolderFactory;
	}
	
	public function getFramework() {
		$this->getClassLoader()->loadClass('ffFramework');
		return new ffFramework( $this, $this->getPluginLoader(), $this->getThemeLoader() );
	}
	
	public function getThemeLoader() {
		$this->getClassLoader()->loadClass('ffThemeLoader');
		$this->getClassLoader()->loadClass('ffThemeAbstract');
		$this->getClassLoader()->loadClass('ffThemeContainerAbstract');
		return new ffThemeLoader( $this->getWPLayer(), $this->getFileSystem(), $this->getClassLoader() );
	}
	
	public function getRequest() {
		$this->getClassLoader()->loadClass('ffRequest_Factory');
		$factory = new ffRequest_Factory( $this->getClassLoader() );
		$request = $factory->createRequest();
		return $request;
	}

    public function getAttrHelper() {
        $this->getClassLoader()->loadClass('ffAttrHelper');
        $helper = new ffAttrHelper();
        return $helper;
    }

    public function getOneStructureFactory() {
        return $this->_getOneStructureFactory();
    }
	
	private function _getOneStructureFactory() {
		$this->getClassLoader()->loadClass('ffOneOption_Factory');
		$this->getClassLoader()->loadClass('ffOneSection_Factory');
		$this->getClassLoader()->loadClass('ffOneStructure_Factory');
		
		$oneOptionFactory = new ffOneOption_Factory( $this->getClassLoader() );
		$oneSectionFactory = new ffOneSection_Factory( $this->getClassLoader() );
		$oneStructureFactory = new ffOneStructure_Factory( $this->getClassLoader(), $oneOptionFactory, $oneSectionFactory);
		
		return $oneStructureFactory;
	}

	/**
	 * Returns factory to create Options
	 * @return ffOptions_Factory
	 */
	public function getOptionsFactory() {
		if( $this->_optionsFactory == null ) {

			$this->getClassLoader()->loadClass('ffOptionsArrayConvertor_Factory');
			$this->getClassLoader()->loadClass('ffOptionsQuery_Factory');
			$this->getClassLoader()->loadClass('ffOptions_Factory');
			$this->getClassLoader()->loadClass('ffOptionsHolder_Factory');

			$oneStructureFactory = $this->_getOneStructureFactory();

			$optionsArrayConvertorFactory = new ffOptionsArrayConvertor_Factory( $this->getClassLoader() );
			$optionsQueryFactory = new ffOptionsQuery_Factory($this->getClassLoader(), $optionsArrayConvertorFactory, $this->getOptionsHolderFactory() );

			$optionsHolderFactory = new ffOptionsHolder_Factory( $this->getClassLoader(), $oneStructureFactory);

			$this->_optionsFactory = new ffOptions_Factory($oneStructureFactory, $optionsQueryFactory, $optionsHolderFactory, $this->getClassLoader() );
		}

		return $this->_optionsFactory;
	}

	public function getFileSystem() {
		if( $this->_fileSystem == null ) {
			$this->getClassLoader()->loadClass('ffFileSystem_Factory');
			$fileSystemFactory = new ffFileSystem_Factory( $this->getClassLoader() );
			$this->_fileSystem = $fileSystemFactory->createFileSystem( $this->getWPLayer() );
		}
		return $this->_fileSystem;
	}
	
	public function getFtp() {
		$this->getClassLoader()->loadClass('externDgFtp');
		$this->getClassLoader()->loadClass('ffFtp');
		
		$dgFtp = new dgFtp();
		
		$ftp = new ffFtp( $dgFtp );
		return $ftp;
	}
	
	public function getFileManager() {
		if( $this->_fileManager == null ) {
			$this->getClassLoader()->loadClass('ffFileManager_Factory');
			$factory = new ffFileManager_Factory( $this->getClassLoader() );
			$this->_fileManager = $factory->createFileManager();
		}
		
		return $this->_fileManager;
	}
	
	public function getScriptFactory() {
		$this->getClassLoader()->loadClass('ffScript_Factory');
		$factory = new ffScript_Factory( $this->getClassLoader() );
		return $factory;
	}
	
	
	public function getStyleFactory() {
		$this->getClassLoader()->loadClass('ffStyle_Factory');
		$factory = new ffStyle_Factory( $this->getClassLoader() );
		return $factory;
	}
	
	public function getStyleEnqueuer() {
		if( $this->_styleEnqueuer == null ) {
			$this->getClassLoader()->loadClass('ffStyleEnqueuer');
			
			if( $this->_configuration['style_minification'] == true) {
				$this->getClassLoader()->loadClass('ffStyleEnqueuerMinification');
				
				$this->_styleEnqueuer = new ffStyleEnqueuerMinification( $this->getWPLayer(), $this->getStyleFactory(), $this->getMinificator() );
			} else {
				$this->_styleEnqueuer = new ffStyleEnqueuer( $this->getWPLayer(), $this->getStyleFactory(), $this->getFileSystem() );
			}
		}
		
		return $this->_styleEnqueuer;
	}
	
	public function getFrameworkScriptLoader() {
		$this->getClassLoader()->loadClass('ffFrameworkScriptLoader');
		$frameworkScriptLoader = new ffFrameworkScriptLoader( 
			$this->getWPLayer() ,
			$this->getScriptEnqueuer() ,
			$this->getStyleEnqueuer()
		);
		return $frameworkScriptLoader;
	}
	
	public function getScriptEnqueuer() {
		if( $this->_scriptEnqueuer == null ) {
			$this->getClassLoader()->loadClass('ffScriptEnqueuer');
			
			if( $this->_configuration['script_minification'] == true) {
				$this->getClassLoader()->loadClass('ffScriptEnqueuerMinification');
				$this->_scriptEnqueuer = new ffScriptEnqueuerMinification( $this->getWPLayer(), $this->getScriptFactory(), $this->getMinificator() );
			} else {
				$this->_scriptEnqueuer = new ffScriptEnqueuer( $this->getWPLayer(), $this->getScriptFactory(), $this->getFileSystem() );
			}
			
			$this->_scriptEnqueuer->setFrameworkScriptLoader( $this->getFrameworkScriptLoader() );
		}
		
		return $this->_scriptEnqueuer;
	}	
	
	public function getMimeTypesManager() {
		if( empty( $this->_mimeTypesManager ) ){
			$this->getClassLoader()->loadClass('ffMimeTypesManager');
			$this->_mimeTypesManager = new ffMimeTypesManager( $this->getWPLayer() );
		}
		
		return $this->_mimeTypesManager;
	}
	
	public function getWPLayer() {
		if( $this->_WPLayer == null ) {
			$this->getClassLoader()->loadClass('ffWPLayer');
			$this->getClassLoader()->loadClass('ffHookManager');
			$this->getClassLoader()->loadClass('ffWPMLBridge');
			$this->getClassLoader()->loadClass('ffAssetsSourceHolder');
			$this->_WPLayer = new ffWPLayer( FF_FRAMEWORK_URL );
			$hookManager = new ffHookManager( $this->_WPLayer);
			$wpmlBridge = new ffWPMLBridge( $this->_WPLayer );
			$assetsSourceHolder = new ffAssetsSourceHolder( $this->_WPLayer );
			$this->_WPLayer->setWPMLBridge($wpmlBridge);
			$this->_WPLayer->setHookManager($hookManager);	
			$this->_WPLayer->setAssetsSourceHolder($assetsSourceHolder);	
				
		}		
				
		return $this->_WPLayer;
	}
	
	public function getPluginLoader() {
		if( $this->_pluginLoader == null ) {
			$this->getClassLoader()->loadClass('ffPluginLoader');
			//$factory = new ffPluginLoader_Factory( $this->getClassLoader(), $this->getWPLayer(), $this->getFileSystem(), $this );
			$this->_pluginLoader = new ffPluginLoader( $this->getWPLayer(), $this->getFileSystem(), $this, $this->getPluginIdentificator());
		}
		
		return $this->_pluginLoader;
	}
	
	public function getMenuFactory() {
		$this->getClassLoader()->loadClass('ffMenuFactory');
		$menuFactory = new ffMenuFactory( $this->getClassLoader() );
		return $menuFactory;
	}
	
	public function getMenuManager() {
		if( $this->_menuManager == null ) {
			$this->getClassLoader()->loadClass('ffMenuManager');
			$this->_menuManager = new ffMenuManager( $this->getWPLayer() );
		}
		return $this->_menuManager;
	}
	
	public function getCustomPostTypeIdentificator() {
		$this->getClassLoader()->loadClass('ffCustomPostTypeIdentificator');
		
		$this->getClassLoader()->loadClass('ffCustomPostTypeCollection_Factory');
		$this->getClassLoader()->loadClass('ffCustomPostTypeCollectionItem_Factory');
		$itemFactory = new ffCustomPostTypeCollectionItem_Factory( $this->getClassLoader() );
		$factory = new ffCustomPostTypeCollection_Factory( $this->getClassLoader(), $itemFactory );
		$customPostTypeIdentificator = new ffCustomPostTypeIdentificator( $this->getWPLayer(), $factory );
		return $customPostTypeIdentificator;
	}
	



	public function getCustomTaxonomyIdentificator() {
		$this->getClassLoader()->loadClass('ffCustomTaxonomyIdentificator');
		$this->getClassLoader()->loadClass('ffCustomTaxonomyCollection_Factory');
		$this->getClassLoader()->loadClass('ffCustomTaxonomyCollectionItem_Factory');
		$itemFactory = new ffCustomTaxonomyCollectionItem_Factory( $this->getClassLoader() );
		$factory = new ffCustomTaxonomyCollection_Factory( $this->getClassLoader(), $itemFactory, $this->getWPLayer() );
		$taxonomyIdentificator = new ffCustomTaxonomyIdentificator( $this->getWPLayer(), $factory );
		
		return $taxonomyIdentificator;
	}

	public function getTaxonomyGetter() {
		$this->getClassLoader()->loadClass('ffTaxonomyGetter');
		
		$taxonomyGetter = new ffTaxonomyGetter( $this->getWPLayer() );
		return $taxonomyGetter;
	}
	
	public function getAdminScreenManager() {
		if( $this->_adminScreenManager == null ) {
			$this->getClassLoader()->loadClass('ffMenuManager');
			$this->getClassLoader()->loadClass('ffMenuFactory');
			$this->getClassLoader()->loadClass('ffAdminScreen');
			
			$this->getClassLoader()->loadClass('ffAdminScreenViewFactory');
			$this->getClassLoader()->loadClass('ffAdminScreenFactory');
			$this->getClassLoader()->loadClass('ffAdminScreenManager');
			
			
			$adminScreenViewFactory = new ffAdminScreenViewFactory($this->getClassLoader(), $this->getRequest(), $this->getScriptEnqueuer(), $this->getStyleEnqueuer(), $this->getWPLayer() );
			$adminScreenFactory = new ffAdminScreenFactory( $this->getClassLoader(), $this->getMenuFactory(), $adminScreenViewFactory );
			$menuFactory = new ffMenuFactory( $this->getClassLoader() );
			$menuManager = new ffMenuManager($this->getWPLayer(), $menuFactory);
			$this->_adminScreenManager = new ffAdminScreenManager($this->getWPLayer(), $menuManager, $adminScreenFactory, $this->getRequest(), $this->getAdminScreenAjaxFactory() );
		}
		return $this->_adminScreenManager;
	}
	
	/**
	 * 
	 * @return ffChecksumCalculator
	 */
	public function getChecksumCalculator() {
		$this->getClassLoader()->loadClass('ffChecksumCalculator');
		return new ffChecksumCalculator( $this->getFileSystem() );
	}
	
	public function getHttp() {
		$this->getClassLoader()->loadClass('ffHttp');
		return new ffHttp( $this->getWPLayer() );
	}

	public function getPluginIdentificator() {
		if( $this->_pluginIdentificator == null ) {
			$this->getClassLoader()->loadClass('ffPluginIdentificator');
			$this->_pluginIdentificator = new ffPluginIdentificator( $this->getWPLayer(), $this->getFileSystem() );
		}

		return $this->_pluginIdentificator;
	}

	public function getThemeIdentificator() {
		if( $this->_themeIdentificator == null ) {
			$this->getClassLoader()->loadClass('ffThemeIdentificator');
			$this->_themeIdentificator = new ffThemeIdentificator( $this->getWPLayer(), $this->getFileSystem() );
		}

		return $this->_themeIdentificator;
	}

	/**
	 * @return ffRemoteBridge
	 */
	public function getRemoteBridge() {
		$this->getClassLoader()->loadClass('ffRemoteBridge');
		$this->getClassLoader()->loadClass('ffRemoteBridgeFreshface');
		
		return new ffRemoteBridgeFreshface( $this->getHttp(), $this->getPluginIdentificator() );
	}
	
	public function getUpdateStepFactory() {
		$this->getClassLoader()->loadClass('ffUpdateStepFactory');
		
		return new ffUpdateStepFactory($this->getClassLoader(), $this->getPluginIdentificator(), $this->getHttp(), $this->getRemoteBridge(), $this->getChecksumCalculator(), $this->getFileSystem(), $this->getUpdatePluginDataFactory() );
	}
	
	public function getUpdater() {
		$this->getClassLoader()->loadClass('ffUpdater');
	
		return new ffUpdater( $this->getUpdateStepFactory() );
	}
	
	public function getUpdatePluginDataFactory() {
		$this->getClassLoader()->loadClass('ffUpdatePluginDataFactory');
		return new ffUpdatePluginDataFactory( $this->getClassLoader() );
	}
	
	public function getWPUpgrader() {
		$this->getClassLoader()->loadClass('ffWPUpgrader');
		
		return new ffWPUpgrader(
			$this->getWPLayer(),
			$this->getPluginIdentificator(),
			$this->getHttp(),
			$this->getDataStorageFactory()->createDataStorageWPOptionsNamespace(),
			$this->_configuration['freshface-server-upgrading-url'],
			$this->_configuration['freshface-server-theme-upgrading-url']
		);
	}
	
	private $_themeFrameworkFactory = null;
	
	public function getThemeFrameworkFactory() {
		if( $this->_themeFrameworkFactory == null ) {
			$this->getClassLoader()->loadClass('ffThemeFrameworkFactory');
			$this->_themeFrameworkFactory = new ffThemeFrameworkFactory( $this->getClassLoader() );
		} 
		
		return $this->_themeFrameworkFactory;
	}
	
	
	public function getLessParser() {
		if( !class_exists('lessc_freshframework') ) {
			$this->getClassLoader()->loadClass('lessc_freshframework');
		}

		/*
		if( !class_exists('lessc_freshframework') ) {
			$this->getClassLoader()->loadClass('lessc_freshframework');
		}
		
		$cachingDir = $this->getWPLayer()->wp_upload_dir();
		var_dump( $cachingDir['basedir'].'/kokot' );
		//die();
		$options =  array('cache_callback_set'=>'ff_less_kokot', 'sourceMap'=>true);
		$less = new lessc_freshframework( );
		$less->setOptions($options);
		return $less;*/
		
		//$cachingDir = $this->getWPLayer()->wp_upload_dir();
		//$options =  array( 'cache_dir'=> $cachingDir['basedir'].'/kokot', 'sourceMap'=>true);
		$less = new lessc_freshframework();
		//$less->setOptions($options);
		return $less;
	}
	
	public function getScssParser() {
		if( !class_exists('scssc') ) {
			$this->getClassLoader()->loadClass('scssCss');
		}
		return new scssc();
	}
	
	
	/**
	 * 
	 * @var ffShortcodesNamespaceFactory
	 */
	private $_shortcodesNamespaceFactory = null;
	
	public function getShortcodesNamespaceFactory() {
		if( $this->_shortcodesNamespaceFactory == null ) {
			$this->getClassLoader()->loadClass('ffShortcodesNamespaceFactory');
			
			$this->_shortcodesNamespaceFactory = new ffShortcodesNamespaceFactory( $this->getClassLoader() );
		}
		
		return $this->_shortcodesNamespaceFactory;
	}
	
	
	/**
	 * 
	 * @var ffGraphicFactory
	 */
	private $_graphicFactory = null;
	
	public function getGraphicFactory() {
		if( $this->_graphicFactory == null ) {
			$this->getClassLoader()->loadClass('ffGraphicFactory');
			
			$this->_graphicFactory = new ffGraphicFactory( $this->getClassLoader() );
		}
		
		return $this->_graphicFactory;
	}

    public function createNewCollection() {
        $this->getClassLoader()->loadClass('ffCollection');
        $collection = new ffCollection();
        return $collection;
    }
	
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/	
	
	public function getClassLoader() {
		return $this->_classLoader;
	}
	
	public function setClassLoader(ffClassLoader $classLoader) {
		$this->_classLoader = $classLoader;
        $fileSystem = $this->getFileSystem();
        $this->_classLoader->setFileSystem( $fileSystem );
		return $this;
	}
	
}
