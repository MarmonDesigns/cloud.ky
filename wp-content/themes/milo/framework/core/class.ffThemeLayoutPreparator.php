<?php
/*
 * 1. go through all layouts
 * 2. if the layout is not fallback, then add it normally
 * 3. if it's fallback, then add it to fallback group, BUT with the conditional logic
 * 
 */
class ffThemeLayoutPreparator {

	const TYPE_HEADER = 'header';
	const TYPE_BEFORE_CONTENT = 'before-content';
	const TYPE_CONTENT = 'content';
	const TYPE_AFTER_CONTENT = 'after-content';
	const TYPE_FOOTER = 'footer';

	/**
	 *
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;


	private $_defaultLayouts = array();
	
	private $_layouts = array();

	public function __construct( ffWPLayer $WPLayer ) {
		$this->_WPLayer = $WPLayer;

		$this->_getWPLayer()->add_action('get_header', array($this, 'prepareLayouts') );
	}

	public function getLayoutInfo( $layoutId ) {
	}

	private function _loadLayoutData() {
	}


	public function prepareLayouts() {

		$fwc = ffContainer();
		
		$data = $fwc->getDataStorageFactory()->createDataStorageOptionsPostType()->getOptionCoded( ffThemeContainer::THEME_NAME_LOW.'-layouts', 'placements');
		$evaluator = $fwc->getLibManager()->createConditionalLogicEvaluator();
		$postMeta = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas();
		
		if( empty( $data ) ) {
			return false;
		}

		foreach( $data as $layoutId => $layoutPlacementData ) {
			$condition = $layoutPlacementData['condition'];
			$conditionQuery = $fwc->getOptionsFactory()->createQuery( $condition,'ffComponent_Theme_LayoutConditions');

			$placement = $layoutPlacementData['placement'];
			$placementQuery = $fwc->getOptionsFactory()->createQuery( $placement, 'ffComponent_Theme_LayoutPlacement');

			$default = $placementQuery->get('radio default');
			
			
			if( $default ) {
				$layout = new stdClass();

				$layout->placementType = $placementQuery->get('radio placement');
				$layout->placementPriority = $placementQuery->get('radio priority');
				$layout->conditionQuery = $conditionQuery;
				$layout->data = $postMeta->getOptionCoded( $layoutId, 'onepage');
				
				$this->_addDefaultLayout($layout);
			} else {

				if ( $evaluator->evaluate( $conditionQuery->get('conditions show-where') ) ) {
					$placementType = $placementQuery->get('radio placement');
					$placementPriority = $placementQuery->get('radio priority');
					$onePageData = $postMeta->getOptionCoded( $layoutId, 'onepage');
					$this->_addLayout( $placementType, $placementPriority, $onePageData);
				}
			}
		}
		


	}

	private function _getFallbackData( $type ) {
		if( isset( $this->_defaultLayouts[ $type ] ) ) {
			return $this->_defaultLayouts[ $type ];
		} else {
			return null;
		}
	}

	public function printLayout( $type ) {

		if( in_array($type, array('header', 'content', 'footer') ) && !isset($this->_layouts[$type]) ) {
			
			$defaultData = $this->_getDefaultData($type);
		 
			if( $defaultData !== null ) {
				$this->_layouts[ $type ] = $defaultData;
			} else {
				
			}
			
		} else if( isset($this->_layouts[$type]) ) {
			
		}
		
		
		if( isset( $this->_layouts [ $type ] ) ) {
			
			ksort( $this->_layouts [ $type ] );
			foreach( $this->_layouts[ $type ] as $priority => $content ) {
				foreach( $content as $oneSection ) {
					$postQuery = ffContainer::getInstance()->getOptionsFactory()->createQuery( $oneSection,'ffComponent_Theme_LayoutOptions');
					ffSectionTemplateManager::requireSectionsFromQuery( $postQuery->get('sections') );
				}
			}
		
			if( ffThemeOptions::getQuery('layout enable-developer-mode') ) {
				echo '<div style="background-color:red;">'.ff_wp_kses( $type ).'</div>';
			}
		
		}		

	}
	
	private function _getDefaultData( $type ) {
		if( !isset( $this->_defaultLayouts[ $type ] ) ) {
			return null;
		}
		
		$evaluator = ffContainer()->getLibManager()->createConditionalLogicEvaluator();
		
		ksort( $this->_defaultLayouts[ $type ] );
		$availableLayouts = array();
		foreach( $this->_defaultLayouts[ $type ] as $priority=> $layouts) {
			
			foreach( $layouts as $oneLayout ) {
				
				if ( $evaluator->evaluate( $oneLayout->conditionQuery->get('conditions show-where') )) {
					$availableLayouts[] = $oneLayout->data;
				}
			}
			
		}
		
		$arrayToReturn = array();
		$arrayToReturn[5] = $availableLayouts;
		
		return $arrayToReturn;
	}

	private function _addDefaultLayout( $layout) {
		$this->_defaultLayouts[ $layout->placementType ][ $layout->placementPriority ][] = $layout;
	}

	private function _addLayout( $type, $priority, $data ) {
		$this->_layouts[ $type ][ $priority ][] = $data;
	}

	private function _getWPLayer() {
		return $this->_WPLayer;
	}
}