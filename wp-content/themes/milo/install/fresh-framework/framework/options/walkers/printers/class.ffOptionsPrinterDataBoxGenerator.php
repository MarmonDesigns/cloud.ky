<?php

class ffOptionsPrinterDataBoxGenerator extends ffBasicObject {
	private $_elements = array();
	private $_components = array();
	/**
	 *
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	public function __construct( ffWPLayer $WPLayer ) {

		$this->_setWplayer($WPLayer);

		$this->_getWPLayer()->add_action('admin_footer', array( $this,'printDataBox') );
	}

    public function printAll() {
        $this->addPrintedComponent( ffOneOption::TYPE_NAVIGATION_MENU_SELECTOR );
        $this->addPrintedComponent( ffOneOption::TYPE_SELECT_CONTENT_TYPE );
//        $this->addPrintedComponent( ffOneOption::TYPE_CODE );
        $this->addPrintedComponent( ffOneOption::TYPE_SELECT2 );
        $this->addPrintedComponent( ffOneOption::TYPE_IMAGE );
        $this->addPrintedComponent( ffOneOption::TYPE_CHECKBOX );
        $this->addPrintedComponent( ffOneOption::TYPE_REVOLUTION_SLIDER );
    }

	public function hookAjax() {
		$this->_getWPLayer()->getHookManager()->addAjaxRequestOwner('ffOptionsPrinterDataBoxGenerator', array( $this, 'actDataBoxGeneratorAjax') );
	}
	public function actDataBoxGeneratorAjax(ffAjaxRequest $ajaxRequest) {
		switch( $ajaxRequest->specification['type'] ) {
			case 'select_content_type':
					$this->_selectContentType($ajaxRequest);
				break;
		}
	}

	public function addCallbackElement( $elementName, $callback ) {
		$this->_elements[ $elementName ]['callback'] = $callback;
	}

	public function addCallbackComponent( $componentName, $callback ) {
		$this->_components[ $componentName ]['callback'] = $callback;
	}

	public function addPrintedElement( $elementName ) {
		if( !isset( $this->_elements[ $elementName ] ) ) {
			$this->_elements[ $elementName ] = true;
		}
	}

	public function addPrintedComponent( $componentName ) {


		if( !isset( $this->_components[ $componentName ] ) ) {
			$this->_components[ $componentName ] = true;
		}
	}

	public function printDataBox() {
		ffContainer::getInstance()->getFrameworkScriptLoader()->requireSelect2()->requireFrsLib()->requireFrsLibOptions()->requireFfAdmin();
		
		$this->_printDataBoxComponents();
		$this->_printDataBoxElements();
	}



	private function _printDataBoxComponents() {

		if( empty( $this->_components ) ) {
			return false;
		}



		foreach( $this->_components as $componentName => $content ) {
			if( isset( $content['callback'] ) ) {
				call_user_func($content['callback'], $componentName );
			}

			echo '<div class="ff-printer-databox-generator hidden">';
				switch( $componentName ) {
                    case ffOneOption::TYPE_NAVIGATION_MENU_SELECTOR:
                            $this->_printNavigationMenuSelector();
                        break;
					case ffOneOption::TYPE_SELECT_CONTENT_TYPE:
							$this->_printSelectContentType();
						break;
				
					case ffOneOption::TYPE_CODE:
						$this->_printSelectCode();
						break;
				
					case ffOneOption::TYPE_SELECT2:
						$this->_printSelect2();
						break;
						
					case ffOneOption::TYPE_IMAGE: 
						$this->_printImage();
						break;
						
					case ffOneOption::TYPE_ICON:
							
						break;
						
					case ffOneOption::TYPE_COLOR_LIBRARY:
					
						
						break;

                    case ffOneOption::TYPE_CHECKBOX:
                        $this->_printRevolutionSlider();

                        break;
				}
			echo '</div>'; // END ff-printer-databox-generator
			
			switch( $componentName) {
				case ffOneOption::TYPE_COLOR_LIBRARY:
				ffContainer::getInstance()->getFrameworkScriptLoader()->requireMinicolors();
				ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryColor();
				break;
			}
			
			ffContainer::getInstance()->getModalWindowFactory()->printModalWindowSectionPicker();
			
			
		}
		
		$this->_printOptionsSectionLightbox();
	}

    private function _printNavigationMenuSelector() {
        echo '<div class="ff-navigation-menu-selector-content">';
            $WPLayer = ffContainer::getInstance()->getWPLayer();
            $registeredNavigationMenus = $WPLayer->get_all_navigation_menus();



            $navigationMenuArray = array();

            foreach( $registeredNavigationMenus as $oneMenu ) {
                $newNavMenu = array();
                $newNavMenu['name'] = $oneMenu->name;
                $newNavMenu['value'] = $oneMenu->term_id;

                $navigationMenuArray[] = $newNavMenu;
            }

            if( empty( $navigationMenuArray ) ) {
                $navigationMenuArray[0]['name'] = 'No menu detected';
                $navigationMenuArray[0]['value'] = 'no-menu-detected';
            }

            echo json_encode( $navigationMenuArray );
        echo '</div>';
    }

	private function _printRevolutionSlider() {

		global $wpdb;

		echo '<div class="ff-revolution-slider-select-content">';

		// This code is properly escaped, because there are no strange things in $wpdb->prefix
		if( NULL == $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "revslider_sliders'" ) ) {

			echo '<option value="none" selected="selected">Revolution slider is NOT INSTALLED, please install and activate it in order to use this section</option>';

		} else {

			// This code is properly escaped, because there are no strange things in $wpdb->prefix
			$results = $wpdb->get_results( "SELECT `title`, `alias` FROM `" . $wpdb->prefix . "revslider_sliders`", ARRAY_A );

			if( ! empty($results) ){
				foreach ($results as $row) {
					echo '<option value="' . esc_attr( $row['alias'] ) . '">' . esc_attr( $row['title'] ) . '</option>';
				}
			} else {
				echo '<option value="none" selected="selected">Revolution slider DOES NOT CONTAIN ANY SLIDERS</option>';
			}

		}

		echo '</div>';

	}

	private function _printOptionsSectionLightbox() {
		
	}
	
	
	private function _printImage() {
		
	}

	private function _printSelectCode() {
		//echo '<div class="ff-select-code">';
		ffContainer::getInstance()->getAceLoader()->loadAceEditor();
	}

	private function _printSelect2() {
		ffContainer::getInstance()->getFrameworkScriptLoader()->requireSelect2();

		//wp_enqueue_script('jquery-ui-sortable');
		ffContainer::getInstance()->getScriptEnqueuer()->addScript('jquery-ui-core');
		ffContainer::getInstance()->getScriptEnqueuer()->addScript('jquery-ui-sortable');
		ffContainer::getInstance()->getScriptEnqueuer()->addScriptFramework('ff-fw-freshlib', 'framework/adminScreens/assets/js/freshlib.js', array('jquery'));



	}

/******************************************************************************/
/* SELECT CONTENT TYPE
/******************************************************************************/
	private function _printSelectContentType() {
		$taxIdentificator = ffContainer::getInstance()->getCustomTaxonomyIdentificator();
		$activePostTypes = ffContainer::getInstance()->getCustomPostTypeIdentificator()->getActivePostTypesCollection();
		$wpLayer = ffContainer::getInstance()->getWPLayer();
		$activeTaxonomy = $taxIdentificator->getActiveTaxonomyCollection();

			echo '<div class="ff-select-content-type-data">';

				/******* TAXONOMIES ********/
				echo '<optgroup label="Taxonomy Archives">';
					foreach( $activeTaxonomy as $oneTax ) {
						echo '<option value="tax-|-'.$oneTax->id.'">'.$oneTax->labelSingular.' Archive</option>';
					}
				echo '</optgroup>';

				echo '<optgroup label="Posted in Taxonomy">';
					foreach( $activeTaxonomy as $oneTax ) {
						echo '<option value="posted-in-|-'.$oneTax->id.'">Posted in '.$oneTax->labelSingular.'</option>';
					}
				echo '</optgroup>';

				/******* POST TYPES ********/
				echo '<optgroup label="Post Types">';
					foreach( $activePostTypes as $onePost ) {
						echo '<option value="post-|-'.$onePost->id.'">'.$onePost->labelSingular.'</option>';
					}
					$options = array(
							array( 'name'=> 'Attachment', 'value'=>'post-|-attachment'),
					);
					$this->_printOptions($options);
				echo '</optgroup>';
				/******* POST EXTRA ********/
				echo '<optgroup label="Post Extra">';
					$postFormats = $this->_getWPLayer()->get_theme_support('post-formats');// get_theme_support( 'post-formats' );
					if( $postFormats != false ) {
						echo '<option value="post-extra-|-post-format">Post Format</option>';
					}
					$options = array(
							array( 'name'=> 'Page Template', 'value'=>'post-extra-|-page-template'),
							array( 'name'=> 'Page Type', 'value'=>'post-extra-|-page-type'),
							array( 'name'=> 'View', 'value'=>'post-extra-|-view'),
							array( 'name'=> 'Special Archive', 'value'=>'post-extra-|-archives'),
							array( 'name'=> 'Post Type Archive', 'value'=>'post-extra-|-post-type-archives'),
							array( 'name'=> 'Paged', 'value'=> 'post-extra-|-paged'),
					);
					$this->_printOptions($options);
				echo '</optgroup>';
				/******* USERS ********/
				/*
				echo '<optgroup label="Users">';
					$options = array(
							array( 'name'=> 'Author Archive', 'value'=>'users-|-author-archive'),
							array( 'name'=> 'User Logged', 'value'=>'users-|-user-logged'),
							array( 'name'=> 'User Role', 'value'=>'users-|-user-role'),
					);
					$this->_printOptions($options);
				echo '</optgroup>';
				*/
				/******* WPML ********/
				if( $wpLayer->getWPMLBridge()->isWPMLActive() ) {
					echo '<optgroup label="Plugins">';
						$options = array(
								array( 'name'=> 'WPML', 'value'=>'plugins-|-wpml'),
						);
						$this->_printOptions($options);
					echo '</optgroup>';
				}

				echo '<optgroup label="Modules">';
				$options = array(
						array( 'name'=> 'Active Theme', 'value'=>'modules-|-active-theme'),
						array( 'name'=> 'Active Plugin', 'value'=>'modules-|-active-plugin'),
				);
				$this->_printOptions($options);
				echo '</optgroup>';

				echo '<optgroup label="System">';
				$options = array(
						array( 'name'=> 'Device', 'value'=>'system-|-device'),
						array( 'name'=> 'Browser', 'value'=>'system-|-browser'),
				);
				$this->_printOptions($options);
				echo '</optgroup>';

				echo '<optgroup label="Time">';
				$options = array(
						array( 'name'=> 'Minute', 'value'=>'time-|-minute'),
						array( 'name'=> 'Hour', 'value'=>'time-|-hour'),
						array( 'name'=> 'Day', 'value'=>'time-|-day'),
						array( 'name'=> 'Weekday', 'value'=>'time-|-weekday'),
						array( 'name'=> 'Month', 'value'=>'time-|-month'),
						array( 'name'=> 'Year', 'value'=>'time-|-year'),
				);
				$this->_printOptions($options);
				echo '</optgroup>';

			echo '</div>'; // END ff-select-content-type-data
	}
/******************************************************************************/
/* SELECT CONTENT TYPE - AJAX
/******************************************************************************/
	private function _selectContentType( ffAjaxRequest $ajaxRequest ) {
		$selectValue = $ajaxRequest->data['select_value'];
		$splited = explode('-|-', $selectValue);

		$contentType = $splited[0];
		$contentSpecific = $splited[1];

		switch( $contentType ) {
			/********* POST **********/
			case 'post' :
				/********* POST **********/
				$postGetter = ffContainer::getInstance()->getPostLayer()->getPostGetter();
				$posts = $postGetter->setNumberOfPosts(-1)->getPostsByType( $contentSpecific );
				foreach( $posts as $onePost ) {
					echo '<option value="'.$onePost->getID().'">'.$onePost->getTitle().'</option>';
				}
				break;

			/********* TAX **********/
			case 'tax' :
			case 'posted-in' :
				$taxGetter = ffContainer::getInstance()->getTaxLayer()->getTaxGetter();//ffContainer::getInstance()->getTaxLayer()->getTaxGetter()->filterByTaxonomy('category')->getList());
				$tax = $taxGetter->filterByTaxonomy( $contentSpecific )->getList();
				//echo '<pre>';print_r($tax);echo '</pre>';

				foreach( $tax as $oneTax ) {
					echo '<option value="'.$oneTax->term_id.'">'.$oneTax->name.'</option>';
				}
				break;
			/********* POST EXTRA **********/
			case 'post-extra':
				/********* POST FORMAT **********/
				if( $contentSpecific == 'post-format' ) {
					$postFormats =  $this->_getWPLayer()->get_theme_support('post-formats');
					if( $postFormats != false ) {
						foreach( $postFormats[0] as $onePostFormat ) {
							echo '<option value="'.$onePostFormat.'">'.ucfirst( $onePostFormat ).'</option>';
						}
					}
				/********* PAGE TEMPLATE **********/
				} else if( $contentSpecific == 'page-template' ){
					$pageTemplates = get_page_templates();
					//echo '<optgroup label="Page Templates">';
					foreach( $pageTemplates as $value => $name ) {
						echo '<option value="'.$name.'">'.$value.'</option>';
					}

				/********* PAGE TYPE**********/
				} else if ( $contentSpecific == 'page-type' ) {
					$options = array(
							array( 'name' => 'Home', 'value' => ffConditionalLogicConstants::is_home ),
							array( 'name' => 'Front Page', 'value' => ffConditionalLogicConstants::is_front_page ),
							array( 'name' => 'Posts Page', 'value' => ffConditionalLogicConstants::is_post_page ),
							array( 'name' => 'Top Level Page ( parent of 0 )', 'value' => ffConditionalLogicConstants::is_top_level_page ),
							array( 'name' => 'Child Page (has parent)', 'value' => ffConditionalLogicConstants::is_child_page ),
							array( 'name' => 'Parent Page (has children)', 'value' => ffConditionalLogicConstants::has_childs ),
							array( 'name' => 'Page 404', 'value' => ffConditionalLogicConstants::is_404 ),
					);

					$this->_printOptions($options);

				/********* VIEW **********/
				} else if ( $contentSpecific == 'view' ) {

					$options = array(
							array( 'name' => 'Taxonomy (Category, Tag, Custom Post Category)', 'value' => ffConditionalLogicConstants::is_taxonomy ),
							array( 'name' => 'Archive ( Taxonomy, Search, Date archive )', 'value' => ffConditionalLogicConstants::is_archive ),
							array( 'name' => 'Single (Page, Post, Custom Post)', 'value' => ffConditionalLogicConstants::is_singular ),
					);

					$this->_printOptions($options);


				/********* ARCHIVES **********/
				} else if ( $contentSpecific == 'archives' ) {

					$options = array(
							array( 'name' => 'Author archive', 'value' => ffConditionalLogicConstants::is_author ),
							array( 'name' => 'Search archive', 'value' => ffConditionalLogicConstants::is_search, ),
							array( 'name' => 'Date archive', 'value' => ffConditionalLogicConstants::is_date, ),
							array( 'name' => 'Day archive', 'value' => ffConditionalLogicConstants::is_day, ),
							array( 'name' => 'Month archive', 'value' => ffConditionalLogicConstants::is_month, ),
							array( 'name' => 'Year archive', 'value' => ffConditionalLogicConstants::is_year, ),
					);

					$this->_printOptions($options);
				}else if( 'post-type-archives' == $contentSpecific ){

					$activePostTypes = ffContainer::getInstance()->getCustomPostTypeIdentificator()->getActivePostTypesCollection();
					foreach( $activePostTypes as $onePost ) {
						echo '<option value="'.$onePost->id.'">'.$onePost->labelSingular.'</option>';
					}

				} else if ( 'paged' == $contentSpecific ) {
					$options = array(
							array( 'name' => 'First page', 'value' => 'first-page' ),
							array( 'name' => 'Middle page', 'value' => 'middle-page' ),
							array( 'name' => 'Last page', 'value' => 'last-page' ),
							
					);
					
					for( $i = 1; $i <= 100; $i++ ) {
						$newPage = array( 'name' => 'Page '.$i, 'value' => 'special-page-'.$i);
						$options[] = $newPage;
					}
					
					
					$this->_printOptions($options);
				}
				break;

				/********* users **********/
			case 'users':
				if( $contentSpecific == 'author-archive' ) {
					foreach( ffContainer::getInstance()->getWPLayer()->get_users() as $oneUser ) {
						echo '<option value="'.$oneUser->data->ID.'">'.$oneUser->data->user_nicename.'</option>';
					}
				}
				else if( $contentSpecific == 'user-logged' ) {
					foreach( ffContainer::getInstance()->getWPLayer()->get_users() as $oneUser ) {
						echo '<option value="'.$oneUser->data->ID.'">'.$oneUser->data->user_nicename.'</option>';
					}
					echo '<option value="not-logged">Not Logged</option>';
				} else if( $contentSpecific =='user-role') {
					global $wp_roles;
					foreach( $wp_roles->roles as $value => $oneRole ) {
						echo '<option value="'.$value.'">'.$oneRole['name'].'</option>';
					}
					echo '<option value="no-role">No Role</option>';
				}
				break;

			case 'plugins' :
				if( $contentSpecific == 'wpml') {
					$options =  ffContainer::getInstance()->getWPLayer()->getWPMLBridge()->getListOfLanguages();
					$this->_printOptions($options);
				}
				break;
			case 'modules':
				$options = array();

				if( 'active-theme' == $contentSpecific ){
					foreach ($this->_getWplayer()->wp_get_themes() as $key => $themeInfo) {
						$options[] = array(
							'name'  => $themeInfo->name,
							'value' => $themeInfo->stylesheet,
						);
					}
				}else if( 'active-plugin' == $contentSpecific ){
					foreach( $this->_getWplayer()->get_plugins() as $pluginValue => $value ) {
						$options[] = array(
							'name' => $value['Name'],
							'value' => $pluginValue,
						);
					}
				}

				$this->_printOptions($options);
				break;

						// array( 'name'=> 'Device', 'value'=>'system-|-device'),
						// array( 'name'=> 'Browser', 'value'=>'system-|-browser'),

			case 'system':
				$options = array();

				if( 'device' == $contentSpecific ){
					$options[] = array( 'name'  => 'Mobile', 'value' => 'mobile', );
					$options[] = array( 'name'  => 'Desktop',       'value' => 'desktop',);
				}else if( 'browser' == $contentSpecific ){

					// see http://codex.wordpress.org/Global_Variables

					$options[] = array( 'value' => 'is_iphone' , 'name' => 'iPhone Safari'             );
					$options[] = array( 'value' => 'is_chrome' , 'name' => 'Google Chrome'             );
					$options[] = array( 'value' => 'is_safari' , 'name' => 'Safari'                    );
					$options[] = array( 'value' => 'is_NS4'    , 'name' => 'Netscape 4'                );
					$options[] = array( 'value' => 'is_opera'  , 'name' => 'Opera'                     );
					$options[] = array( 'value' => 'is_IE'     , 'name' => 'Internet Explorer'         );

					for( $ver = ffConditionalLogicConstants::min_IE_version; $ver <= ffConditionalLogicConstants::max_IE_version; $ver ++ ){
						$options[] = array( 'value' => 'is_IE'.$ver, 'name' => 'IE'.$ver);
					}
					$options[] = array( 'value' => 'is_macIE'  , 'name' => 'Mac Internet Explorer'     );
					$options[] = array( 'value' => 'is_winIE'  , 'name' => 'Windows Internet Explorer' );
					$options[] = array( 'value' => 'is_gecko'  , 'name' => 'Firefox'                   );
					$options[] = array( 'value' => 'is_lynx'   , 'name' => 'Lynx'                      );
				}

				$this->_printOptions($options);
				break;

			/********* TIME **********/
			case 'time':

				$options = array();

				switch( $contentSpecific ) {
					case 'minute':
						$_minutes_interval = array(
							'0' => '0 - 9',
							'1' => '10 - 19',
							'2' => '20 - 29',
							'3' => '30 - 39',
							'4' => '40 - 49',
							'5' => '50 - 59',
						);
						foreach ( $_minutes_interval as $minute_interval_key => $minute_interval_name) {
							$options[] = array( 'name' => $minute_interval_name, 'value' => $minute_interval_key );
						}
						break;
					case 'hour':
						foreach ( range(0, 23) as $hour) {
							$options[] = array( 'name' => $hour, 'value' => $hour );
						}
						break;
					case 'day':
						foreach ( range(1, 31) as $day) {
							$options[] = array( 'name' => $day, 'value' => $day );
						}
						break;
					case 'weekday':
                        $WPLayer =$this->_getWplayer();
						$_wd = array(
								$WPLayer->__( 'Monday', 'default' ),
								$WPLayer->__( 'Tuesday', 'default' ),
								$WPLayer->__( 'Wednesday', 'default' ),
								$WPLayer->__( 'Thursday', 'default' ),
								$WPLayer->__( 'Friday', 'default' ),
								$WPLayer->__( 'Saturday', 'default' ),
								$WPLayer->__( 'Sunday', 'default' ),
						);
						foreach ( $_wd as $week_key => $week_name) {
							$options[] = array( 'name' => $week_name, 'value' => 1 + $week_key );
						}
						break;
					case 'month':
                        $WPLayer =$this->_getWplayer();
						$mnth = array(
							$WPLayer->__( 'January', 'default' ),
							$WPLayer->__( 'February', 'default' ),
							$WPLayer->__( 'March', 'default' ),
							$WPLayer->__( 'April', 'default' ),
							$WPLayer->__( 'May', 'default' ),
							$WPLayer->__( 'June', 'default' ),
							$WPLayer->__( 'July', 'default' ),
							$WPLayer->__( 'August', 'default' ),
							$WPLayer->__( 'September', 'default' ),
							$WPLayer->__( 'October', 'default' ),
							$WPLayer->__( 'November', 'default' ),
							$WPLayer->__( 'December', 'default' ),
						);
						foreach ( $mnth as $mnth_key => $mnth_name) {
							$options[] = array( 'name' => $mnth_name, 'value' => 1 + $mnth_key );
						}
						break;
					case 'year':
						$years = array( 2013, 2014, 2015, 2016, 2017,  );
						foreach ( $years as $year ) {
							$options[] = array( 'name' => $year, 'value' => $year );
						}
						break;
				}

				$this->_printOptions($options);

				break;
		}


		return;
	}

	private function _printOptions( $data ) {
		foreach( $data as $oneOption ) {
			echo '<option value="'.$oneOption['value'].'">'.$oneOption['name'].'</option>';
		}
	}


	private function _printDataBoxElements() {

	}

	/**
	 * @return ffWPLayer
	 */
	protected function _getWplayer() {
		return $this->_WPLayer;
	}

	/**
	 * @param ffWPLayer $_WPLayer
	 */
	protected function _setWplayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

}