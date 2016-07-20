<?php

/**
 * Class ffMenuOptionsManager
 *
 * If there is set options holder, then it hooks WP Nav Menu admin screen and it print and creates options, which are
 * added to the navigation menu.
 */


class ffMenuOptionsManager extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    /**
     * @var ffOptions_Factory
     */
    private $_optionsFactory = null;

    /**
     * @var ffScriptEnqueuer
     */
    private $_scriptEnqueuer = null;

    /**
     * @var ffDataStorage_OptionsPostType_NamespaceFacade
     */
    private $_dataStoragePostType = null;

    /**
     * @var string
     */
    private $_optionsHolderClassName = null;

    /**
     * @var ffRequest
     */
    private $_request = null;


    /**
     * @var ffModalWindowFactory
     */
    private $_modalWindowFactory = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

    private $_themeName = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct(
        ffWPLayer $WPLayer,
        ffOptions_Factory $optionsFactory,
        ffScriptEnqueuer $scriptEnqueuer,
        ffDataStorage_OptionsPostType_NamespaceFacade $dataStoragePostType,
        ffRequest $request,
        ffModalWindowFactory $modalWindowFactory
    ) {

        $this->_setWPLayer( $WPLayer );

        $this->_setOptionsFactory( $optionsFactory );
        $this->_setModalWindowFactory( $modalWindowFactory );

        $WPLayer->add_action('current_screen', array($this, 'actCurrentScreen'));
        $WPLayer->add_action('wp_update_nav_menu', array( $this, 'actUpdateMenu') );
        $WPLayer->add_action('admin_footer', array( $this, 'actAdminFooter') );


        $this->_setScriptEnqueuer( $scriptEnqueuer );
        $this->_setDataStoragePostType( $dataStoragePostType );
        $dataStoragePostType->setNamespace( $this->_getOptionsNamespace() );
        $this->_setRequest( $request );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function setOptionsHolderClassName( $className ) {
        $this->_setOptionsHolderClassName( $className );
    }

    public function getQueryForMenuItem( $menuId, $itemId ) {
        $data = $this->_getWholeOption();


        $query = null;
        if( isset( $data[ $menuId ] ) && isset( $data[ $menuId ][ $itemId ] ) ) {
            $optionsHolder = $this->_getOptionsHolder();
            $query = $this->_getOptionsFactory()->createQuery( $data[ $menuId ][ $itemId], $optionsHolder );
        }

        return $query;
    }

    public function actUpdateMenu() {


    }

    public function actCurrentScreen() {


        if( !$this->_getWPLayer()->is_admin() ) {
            return false;
        }

        $currentScreen = $this->_getWPLayer()->get_current_screen();

        if( $currentScreen->base != 'nav-menus' ) {
            return false;
        }


        if( !$this->_getRequest()->postEmpty() ) {

            $data = $this->_getWholeOption();
            $menuSettings = ( $this->_getRequest()->post('ff-menu-item-settings') );
            $menuId = $this->_getRequest()->post('menu');

            $menuSettingsNew = array();

            if( !empty( $menuSettings ) )  {
                foreach( $menuSettings as $key => $value ) {
                    $decoded = $this->_objectToArray( json_decode($value) );
                    $menuSettingsNew[ $key ] = $decoded[ 'default' ];
                }
                $data[ $menuId ] = $menuSettingsNew;
                $this->_setWholeOption( $data );
            }
        }



        if( $this->_getRequest()->get('menu') !== 0 ) {
            $this->_getScriptEnqueuer()->addScriptFramework('ff-menu-options', '/framework/themes/menuOptions/assets/menuOptions.js', null, null, true);
            $this->_getScriptEnqueuer()->getFrameworkScriptLoader()->requireFrsLib()->requireFrsLibOptions()->requireFfAdmin()->requireSelect2()->requireFrsLibModal();

        }

    }



    public function actAdminFooter() {

        $currentScreen = $this->_getWPLayer()->get_current_screen();

        if( !(isset( $currentScreen->base ) && $currentScreen->base == 'nav-menus') ) {
            return false;
        }

        $this->_getModalWindowFactory()->printModalWindowManagerLibraryIcon();
        $optionsHolder = $this->_getOptionsHolder();

        $jswalker = $this->_getOptionsFactory()->createOptionsPrinterJavascriptConvertor( null, $optionsHolder->getOptions() );

        $jswalker->setAutomaticallyInitialiseAtFrontend( false);

        $data = $this->_getWholeOption();
        $dataString = '';

        if( $data != null ) {
//            var_dump( $data );
            $dataString = json_encode($data);
        }

        echo '<div class="ff-menu-options-wrapper">';
            echo '<div class="ff-menu-options-holder">';
                echo $jswalker->walk();
            echo '</div>';

            echo '<textarea class="ff-menu-data-holder">';
                echo $dataString;
            echo '</textarea>';
        echo '</div>';
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
    public function setThemeName( $themeName ) {
        $this->_themeName = $themeName;
    }
/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _getOptionsHolder() {
        return $this->_getOptionsFactory()->createOptionsHolder( $this->_getOptionsHolderClassName() );
    }

    private function _getOptionsNamespace() {
        return 'ff-menu-options-' . $this->_getThemeName();
    }

    private function _objectToArray($d) {
         if (is_object($d)) {
             // Gets the properties of the given object
             // with get_object_vars function
             $d = get_object_vars($d);
         }

         if (is_array($d)) {
             /*
             * Return array converted to object
             * Using __FUNCTION__ (Magic constant)
             * for recursive call
             */
             return array_map(array( $this, '_objectToArray'), $d);
         }
         else {
             // Return array
             return $d;
         }
    }

        private function _getWholeOption() {
        $data = $this->_getDataStoragePostType()->getOptionCoded('menu-data');

        return $data;
    }

    private function _setWholeOption( $data ) {
        $this->_getDataStoragePostType()->setOptionCoded('menu-data', ($data) );
    }


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return ffWPLayer
     */
    private function _getWPLayer()
    {
        return $this->_WPLayer;
    }

    /**
     * @param ffWPLayer $WPLayer
     */
    private function _setWPLayer($WPLayer)
    {
        $this->_WPLayer = $WPLayer;
    }

    /**
     * @return null
     */
    private function _getOptionsHolderClassName()
    {
        return $this->_optionsHolderClassName;
    }

    /**
     * @param null $optionsHolderClassName
     */
    private function _setOptionsHolderClassName($optionsHolderClassName)
    {
        $this->_optionsHolderClassName = $optionsHolderClassName;
    }

    /**
     * @return ffOptions_Factory
     */
    private function _getOptionsFactory()
    {
        return $this->_optionsFactory;
    }

    /**
     * @param ffOptions_Factory $optionsFactory
     */
    private function _setOptionsFactory($optionsFactory)
    {
        $this->_optionsFactory = $optionsFactory;
    }

    /**
     * @return ffScriptEnqueuer
     */
    private function _getScriptEnqueuer()
    {
        return $this->_scriptEnqueuer;
    }

    /**
     * @param ffScriptEnqueuer $scriptEnqueuer
     */
    private function _setScriptEnqueuer($scriptEnqueuer)
    {
        $this->_scriptEnqueuer = $scriptEnqueuer;
    }

    /**
     * @return ffDataStorage_OptionsPostType_NamespaceFacade
     */
    private function _getDataStoragePostType()
    {
        return $this->_dataStoragePostType;
    }

    /**
     * @param ffDataStorage_OptionsPostType_NamespaceFacade $dataStoragePostType
     */
    private function _setDataStoragePostType($dataStoragePostType)
    {
        $this->_dataStoragePostType = $dataStoragePostType;
    }

    /**
     * @return null
     */
    private function _getThemeName()
    {
        return $this->_themeName;
    }

    /**
     * @return ffRequest
     */
    private function _getRequest()
    {
        return $this->_request;
    }

    /**
     * @param ffRequest $request
     */
    private function _setRequest($request)
    {
        $this->_request = $request;
    }

    /**
     * @return ffModalWindowFactory
     */
    private function _getModalWindowFactory()
    {
        return $this->_modalWindowFactory;
    }

    /**
     * @param ffModalWindowFactory $modalWindowFactory
     */
    private function _setModalWindowFactory($modalWindowFactory)
    {
        $this->_modalWindowFactory = $modalWindowFactory;
    }



}