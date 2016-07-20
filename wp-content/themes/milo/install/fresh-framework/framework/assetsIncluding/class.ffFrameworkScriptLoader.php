<?php

class ffFrameworkScriptLoader extends ffBasicObject {

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

	public function __construct( ffWPLayer $WPLayer, ffScriptEnqueuer $scriptEnqueuer, ffStyleEnqueuer $styleEnequeuer ) {
		$this->_setScriptEnqueuer( $scriptEnqueuer );
		$this->_setStyleEnqueuer( $styleEnequeuer );
		$this->_setWPLayer( $WPLayer );
	}

	public function requireFrsLib() {
		$this->_getScriptEnqueuer()->addScriptFramework(
			'ff-frslib',
			'/framework/frslib/src/frslib.js',
			array( 'jquery' )
		);

		return $this;
	}

    public function requireJqueryCookie() {

        $this->_getScriptEnqueuer()->addScriptFramework('ff-jquery-cookie', '/framework/extern/jquery-cookie/jquery.cookie.js', array('jquery'));
    }
	
	public function requireFrsLibLess() {
		$this->requireFrsLib();
		
		$this->_getScriptEnqueuer()->addScriptFramework('ff-less-compiler', '/framework/extern/less/js-compiler/less.js');
		$this->_getScriptEnqueuer()->addScriptFramework('ff-frslib-less-compiler', '/framework/frslib/src/frslib-less-compiler.js');
	}
	
	public function requireMinicolors() {
		$this->requireFrsLib();
		$this->_getScriptEnqueuer()->addScriptFramework('ff-minicolors', '/framework/extern/minicolors/jquery.minicolors.js', array('jquery'));
		$this->_getStyleEnqueuer()->addStyleFramework('ff-minicolors', '/framework/extern/minicolors/jquery.minicolors.css');
		
		return $this;
	}

	public function requireFrsLibOptions() {
		$this->_getScriptEnqueuer()->addScript('jquery-ui-core');
		$this->_getScriptEnqueuer()->addScript('jquery-ui-sortable');
		$this->_getScriptEnqueuer()->addScript('jquery-ui-datepicker');

        $this->_getScriptEnqueuer()->addScript('wp-color-picker');
        $this->_getStyleEnqueuer()->addStyle('wp-color-picker');

        $this->requireFrsLibModal();

        $this->_getScriptEnqueuer()->addScriptFramework(
			'ff-frslib-options-walkers-walker',
			'/framework/frslib/src/frslib-options-walkers-walker.js',
			array( 'ff-frslib' )
		);

            $this->_getScriptEnqueuer()->addScriptFramework(
			'ff-frslib-options-walkers-printerBoxed',
			'/framework/frslib/src/frslib-options-walkers-printerBoxed.js',
			array( 'ff-frslib' )
		);

		
		$this->_getScriptEnqueuer()->addScriptFramework(
			'ff-frslib-options',
			'/framework/frslib/src/frslib-options.js',
			array( 'ff-frslib' )
		);
		

		$this->_getStyleEnqueuer()->addStyleFramework('jquery-ui-datepicker', 'framework/extern/jquery-ui/datepicker.css');

		return $this;
	}

	public function requireFrsLibModal() {
		
		$this->requireMinicolors();
		$this->_getScriptEnqueuer()->addScriptFramework(
			'ff-frslib-classes',
			'/framework/frslib/src/frslib-classes.js',
			array( 'ff-frslib' )
		);

		$this->_getScriptEnqueuer()->addScriptFramework(
			'ff-class.modalWindow',
			'/framework/frslib/src/frslib-class.modalWindow.js',
			array( 'jquery', 'ff-frslib-classes' )
		);

		$this->_getScriptEnqueuer()->addScriptFramework(
			'ff-class.modalWindow_aPicker',
			'/framework/frslib/src/frslib-class.modalWindow_aPicker.js',
			array( 'ff-class.modalWindow' )
		);

		$this->_getScriptEnqueuer()->addScriptFramework(
			'ff-class.modalWindow_aBasic',
			'/framework/frslib/src/frslib-class.modalWindow_aBasic.js',
			array( 'ff-class.modalWindow' )
		);

		$this->_getScriptEnqueuer()->addScriptFramework(
			'ff-class.modalWindowColorPicker',
			'/framework/frslib/src/frslib-class.modalWindowColorPicker.js',
			array( 'ff-class.modalWindow_aPicker' )
		);

		$this->_getScriptEnqueuer()->addScriptFramework(
			'ff-class.modalWindowColorEditor',
			'/framework/frslib/src/frslib-class.modalWindowColorEditor.js',
			array( 'ff-class.modalWindowColorPicker' )
		);

		$this->_getScriptEnqueuer()->addScriptFramework(
				'ff-class.modalWindowColorLibraryColor',
				'/framework/frslib/src/frslib-class.modalWindowColorLibraryColor.js',
				array( 'ff-class.modalWindow_aPicker' )
		);

		$this->_getScriptEnqueuer()->addScriptFramework(
				'ff-class.modalWindowIconPicker',
				'/framework/frslib/src/frslib-class.modalWindowIconPicker.js',
				array( 'ff-class.modalWindow_aPicker' )
		);

		$this->_getScriptEnqueuer()->addScriptFramework(
				'ff-class.modalWindowColorAddGroup',
				'/framework/frslib/src/frslib-class.modalWindowColorAddGroup.js',
				array( 'ff-class.modalWindow' )
		);

		$this->_getScriptEnqueuer()->addScriptFramework(
				'ff-class.modalWindowColorDeleteGroup',
				'/framework/frslib/src/frslib-class.modalWindowColorDeleteGroup.js',
				array( 'ff-class.modalWindow' )
		);
		
		$this->_getScriptEnqueuer()->addScriptFramework(
				'ff-class.modalWindowSectionPicker',
				'/framework/frslib/src/frslib-class.modalWindowSectionPicker.js',
				array( 'ff-class.modalWindow' )
		);

		$this->_getScriptEnqueuer()->addScriptFramework(
			'ff-frslib-modaxl',
			'/framework/frslib/src/frslib-modal.js',
				array()
			//array( 'ff-frslib', 'ff-class.modalWindowColorPicker')
		);

		return $this;
	}

	public function requireFrsLibMetaboxes() {
		$this->_getScriptEnqueuer()
				->addScriptFramework('ff-frslib-metaboxes', '/framework/frslib/src/frslib-metaboxes.js', array('ff-frslib'));

		return $this;
	}

	public function requireSelect2() {
		$this->_getStyleEnqueuer()->addStyleFramework('select2', '/framework/extern/select2/jquery.select2.css');
		$this->_getScriptEnqueuer()->addScriptFramework('select2', '/framework/extern/select2/jquery.select2.min.js');
		$this->_getScriptEnqueuer()->addScriptFramework('select2-tools', '/framework/extern/select2/select2-tools.js');

		return $this;
	}

	public function requireJsTree() {
		$this->_getStyleEnqueuer()->addStyleFramework('ff-jstree-style', '/framework/extern/jstree/themes/default/style.min.css');
		$this->_getScriptEnqueuer()->addScriptFramework('ff-jstree-script', '/framework/extern/jstree/jstree.js', array('jquery'));
	}

    public function requireDataTables() {
        $this->_getStyleEnqueuer()->addStyleFramework('ff-datatables-style', '/framework/extern/dataTables/datatables.min.css');
		$this->_getScriptEnqueuer()->addScriptFramework('ff-datatables-script', '/framework/extern/dataTables/datatables.min.js', array('jquery'));
    }

	public function requireFfAdmin() {
		$this->_getStyleEnqueuer()->addStyleFrameworkAdmin('ff-admin', 'framework/adminScreens/assets/css/ff-admin.less', null, null, null, null);

		$this->addAdminColorsToStyle('ff-admin');
		$this->_getStyleEnqueuer()->addLessVariable('ff-admin','fresh-framework-url', '"'.ffContainer::getInstance()->getWPLayer()->getFrameworkUrl().'"' );
		//$this->_getStyleEnqueuer()->addStyle()

		return $this;
	}

	public function addAdminColorsToStyle( $styleName ){

		$userID      = $this->_getWPlayer()->get_current_user_id();
		$admin_color = $this->_getWPlayer()->get_the_author_meta( 'admin_color', $userID );

		$_wp_admin_css_colors = $this->_getWPlayer()->get_wp_admin_css_colors();

		if( empty( $_wp_admin_css_colors[ $admin_color ] ) ){
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_0',            '#222');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_1',            '#333');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_2',            '#0074a2');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_3',            '#2ea2cc');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_base',    '#999');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_focus',   '#2ea2cc');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_current', '#fff');
		}else{
			$colors = $_wp_admin_css_colors[ $admin_color ];
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_0',            $colors->colors['0']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_1',            $colors->colors['1']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_2',            $colors->colors['2']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_3',            $colors->colors['3']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_base',    $colors->icon_colors['base']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_focus',   $colors->icon_colors['focus']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_current', $colors->icon_colors['current']);
		}
	}

	/**
	 * @return ffScriptEnqueuer
	 */
	protected function _getScriptEnqueuer() {
		return $this->_scriptEnqueuer;
	}

	/**
	 * @param ffScriptEnqueuer $scriptEnqueuer
	 */
	protected function _setScriptEnqueuer($scriptEnqueuer) {
		$this->_scriptEnqueuer = $scriptEnqueuer;
		return $this;
	}

	/**
	 *
	 * @return ffStyleEnqueuer
	 */
	protected function _getStyleEnqueuer() {
		return $this->_styleEnqueuer;
	}

	/**
	 *
	 * @param ffStyleEnqueuer $_styleEnqueuer
	 */
	protected function _setStyleEnqueuer(ffStyleEnqueuer $_styleEnqueuer) {
		$this->_styleEnqueuer = $_styleEnqueuer;
		return $this;
	}

	/**
	 * @return ffWPLayer instance of ffWPLayer
	 */
	protected function _getWPlayer() {
		return $this->_WPLayer;
	}

	/**
	 * @param ffWPLayer $_WPLayer
	 * @return ffLessWPOptions_Factory caller instance of ffLessWPOptions_Factory
	 */
	protected function _setWPlayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

}