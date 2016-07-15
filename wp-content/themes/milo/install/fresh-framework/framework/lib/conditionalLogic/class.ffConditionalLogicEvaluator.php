<?php


class ffConditionalLogicEvaluator extends ffBasicObject {

	private $_WPLayer = null;

	public function __construct( ffWPLayer $WPLayer ) {
		$this->_setWPLayer($WPLayer);
	}

public function evaluate( ffOptionsQuery $query ) {
		$logicUseOrNot = $query->get('logic-use-or-not logic_use_or_not');

		if( $logicUseOrNot == 0 ) {
			return true;
		}

//        $query->debug_dump();

		$logicOr = $query->get('logic-or');

		//$logicalStructure->debug_dump();
		$print = false;
		foreach( $logicOr as $oneOr ) {
			
		
			$allConditionsAreGood = true;
			
			foreach( $oneOr->get('logic-and') as $oneAnd ) {
				
				//$oneAnd->debug_dump();
				
				$andContent = array();
				$andContent['content_id'] = $oneAnd->get('content_id');
				$andContent['equal'] = $oneAnd->get('equal');
				$andContent['content_type'] = $oneAnd->get('content_type');
				


				$idArray = is_array($andContent['content_id'])
				? $andContent['content_id']
				: explode('--||--', $andContent['content_id'])
				;
					
				
				$content_type = $andContent['content_type'];
				$groupInfo = $this->_getGroupInfo( $content_type );
				
				$type     = $groupInfo['type'];
				$equality = $andContent['equal'];
				
				switch( $groupInfo['group'] ) {
					case 'tax' :        $allConditionsAreGood = $this->_tax(        $type, $equality, $idArray); break;
					case 'posted-in' :  $allConditionsAreGood = $this->_postedIn(   $type, $equality, $idArray); break;
					case 'post':        $allConditionsAreGood = $this->_postType(   $type, $equality, $idArray); break;
					case 'post-extra' : $allConditionsAreGood = $this->_postExtra(  $type, $equality, $idArray); break;
					// case 'users' :      $allConditionsAreGood = $this->_users(      $type, $equality, $idArray); break;
					case 'plugins' :    $allConditionsAreGood = $this->_plugins(    $type, $equality, $idArray); break;
					case 'modules' :    $allConditionsAreGood = $this->_modules(    $type, $equality, $idArray); break;
					case 'system' :     $allConditionsAreGood = $this->_system(     $type, $equality, $idArray); break;
					case 'time' :       $allConditionsAreGood = $this->_time(       $type, $equality, $idArray); break;
				
				}

				if( $allConditionsAreGood == false ) {
					break;
				}
				
			}
			
			if( $allConditionsAreGood == true ) {
				$print = true;
				break;
			}
			
			
		}
		
	 	return $print;
	}


	private function _tax( $taxSlug, $equality, $idArray ) {
		if( ( !$this->_getWPLayer()->is_taxonomy() ) and ( $equality == 'equal'     ) ){ return false; }
		if( ( !$this->_getWPLayer()->is_taxonomy() ) and ( $equality == 'not_equal' ) ){ return true;  }

		$WP_object = $this->_getWPLayer()->get_queried_object();

		if( ( $WP_object->taxonomy != $taxSlug ) and ( $equality == 'not_equal' ) ) { return true; }
		if( ( $WP_object->taxonomy != $taxSlug ) and ( $equality == 'equal'     ) ) { return false; }

		// empty array() = all
		$arrayImploded = implode('',$idArray);
		if( empty( $arrayImploded ) ) {
			return ( $equality == 'equal' );
		}

		// ID same ?
		return ( $equality == 'equal' )
		?   in_array( $WP_object->term_id, $idArray )
		: ! in_array( $WP_object->term_id, $idArray )
		;

	}

	private function _postedIn( $taxSlug, $equality, $idArray ) {
		if( ( !$this->_getWPLayer()->is_singular() ) and ( $equality == 'equal'     ) ){ return false; }
		if( ( !$this->_getWPLayer()->is_singular() ) and ( $equality == 'not_equal' ) ){ return true;  }

		$WP_object = $this->_getWPLayer()->get_queried_object();

		$postTaxIDs = $this->_getWPLayer()->wp_get_object_terms( $WP_object->ID, $taxSlug, array( 'fields' => 'ids' ) );

		// intersection of IDs ?

		$intersection = array_intersect( $postTaxIDs, $idArray );
		return ( $equality == 'equal' )
			? ! empty( $intersection )
			:   empty( $intersection )
			;

	}


	private function _postType( $postTypeSlug, $equality, $idArray ) {

		// Singular ?
		if( ! $this->_getWPLayer()->is_singular() ){
			return ( $equality != 'equal' );
		}

		$WP_object = $this->_getWPLayer()->get_queried_object();

		// Same post type ?
		if( $WP_object->post_type != $postTypeSlug ){
			return ( $equality != 'equal' );
		}

		// empty array() = all

		$arrayImploded = implode('',$idArray);
		if( empty( $arrayImploded ) ) {
			return ( $equality == 'equal' );
		}

		// ID same ?
		return ( $equality == 'equal' )
				?   in_array( $WP_object->ID, $idArray )
				: ! in_array( $WP_object->ID, $idArray )
				;
	}

	private function _postExtra( $type, $equality, $idArray ) {
		switch( $type ) {

			case 'post-format':
				// Singular ?
				if( ! $this->_getWPLayer()->is_singular() ){
					return ( $equality != 'equal' );
				}

				$WP_object = $this->_getWPLayer()->get_queried_object();
				$post_format = $this->_getWPLayer()->get_post_format( $WP_object->ID );

				// empty array() = all
				if( empty( $idArray ) ) {
					return ( $equality == 'equal' );
				}

				return ( $equality == 'equal' )
						?   in_array( $post_format, $idArray )
						: ! in_array( $post_format, $idArray )
						;

			case 'page-template':

				// Not page ?
				if( ( ! $this->_getWPLayer()->is_page() ) ){
					return ( $equality != 'equal' );
				}

				// empty array() = all
				if( empty( $idArray ) ) {
					return ( $equality == 'equal' );
				}

				$WP_object = $this->_getWPLayer()->get_queried_object();
				$page_template = $this->_getWPLayer()->get_post_meta( $WP_object->ID, '_wp_page_template', true );

				return ( $equality == 'equal' )
						?   in_array( $page_template, $idArray )
						: ! in_array( $page_template, $idArray )
						;

			case 'page-type':


				// Special case: home - may not be page

				if( $this->_getWPLayer()->is_home() ){
					if( empty( $idArray ) or in_array( ffConditionalLogicConstants::is_home, $idArray ) ){
						return ( $equality == 'equal' );
					}
				}


				// const is_404
				if( $this->_getWPLayer()->is_404() ){
					if( empty( $idArray ) or in_array( ffConditionalLogicConstants::is_404, $idArray ) ){
						return ( $equality == 'equal' );
					}
				}


				if( ( ! $this->_getWPLayer()->is_page() ) && !$this->_getWPLayer()->is_posts_page() ){
					return ( $equality != 'equal' );
				}



				// empty array() = all pages
				if( empty( $idArray ) ) {
					return ( $equality == 'equal' );
				}

				// const is_front_page
				if( in_array( ffConditionalLogicConstants::is_front_page, $idArray ) ){
					if( $this->_getWPLayer()->is_front_page() ){
						return ( $equality == 'equal' );
					}
				}

				// const is_post_page
				if( in_array( ffConditionalLogicConstants::is_post_page, $idArray ) ){

					if( ! $this->_getWPLayer()->is_front_page() and $this->_getWPLayer()->is_home() ){
						return ( $equality == 'equal' );
					}
				}

				// const is_top_level_page
				if( in_array( ffConditionalLogicConstants::is_top_level_page, $idArray ) ){
					$WP_object = $this->_getWPLayer()->get_queried_object();
					if( empty( $WP_object->post_parent ) ){
						return ( $equality == 'equal' );
					}
				}

				// const is_child_page
				if( in_array( ffConditionalLogicConstants::is_child_page, $idArray ) ){
					$WP_object = $this->_getWPLayer()->get_queried_object();
					if( ! empty( $WP_object->post_parent ) ){
						return ( $equality == 'equal' );
					}
				}

				// const has_childs
				if( in_array( ffConditionalLogicConstants::has_childs, $idArray ) ){
					$WP_object = $this->_getWPLayer()->get_queried_object();
					$sub_page_arr = $this->_getWPLayer()->get_posts( array( 'post_parent' => $WP_object->ID ) );
					if( ! empty( $sub_page_arr ) ){
						return ( $equality == 'equal' );
					}
				}

				return ( $equality != 'equal' );


			case 'view':

				// empty array() = all pages
				if( empty( $idArray ) ) {
					return ( $equality == 'equal' );
				}

				// is_taxonomy
				if( in_array( ffConditionalLogicConstants::is_taxonomy, $idArray ) ){
					if( $this->_getWPLayer()->is_tax()
					 or $this->_getWPLayer()->is_category()
					 or $this->_getWPLayer()->is_tag()
					){
						return ( $equality == 'equal' );
					}
				}

				// is_archive
				if( in_array( ffConditionalLogicConstants::is_archive, $idArray ) ){
					if( $this->_getWPLayer()->is_archive() ){
						return ( $equality == 'equal' );
					}
				}

				// is_singular
				if( in_array( ffConditionalLogicConstants::is_singular, $idArray ) ){
					if( $this->_getWPLayer()->is_singular() ){
						return ( $equality == 'equal' );
					}
				}

				return ( $equality != 'equal' );


			case 'archives':

				// empty array() = all pages
				if( empty( $idArray ) ) {
					return ( $equality == 'equal' );
				}

				// is_author
				if( in_array( ffConditionalLogicConstants::is_author, $idArray ) ){
					if( $this->_getWPLayer()->is_author() ){
						return ( $equality == 'equal' );
					}
				}

				// is_search
				if( in_array( ffConditionalLogicConstants::is_search, $idArray ) ){
					if( $this->_getWPLayer()->is_search() ){
						return ( $equality == 'equal' );
					}
				}

				// is_date
				if( in_array( ffConditionalLogicConstants::is_date, $idArray ) ){
					if( $this->_getWPLayer()->is_date() ){
						return ( $equality == 'equal' );
					}
				}

				// is_day
				if( in_array( ffConditionalLogicConstants::is_day, $idArray ) ){
					if( $this->_getWPLayer()->is_day() ){
						return ( $equality == 'equal' );
					}
				}

				// is_month
				if( in_array( ffConditionalLogicConstants::is_month, $idArray ) ){
					if( $this->_getWPLayer()->is_month() ){
						return ( $equality == 'equal' );
					}
				}

				// is_year
				if( in_array( ffConditionalLogicConstants::is_year, $idArray ) ){
					if( $this->_getWPLayer()->is_year() ){
						return ( $equality == 'equal' );
					}
				}

				return ( $equality != 'equal' );


			case 'post-type-archives':

				if( ! $this->_getWPLayer()->is_post_type_archive() ){
					return ( $equality != 'equal' );
				}

				if( empty( $idArray ) or empty( $idArray[0] ) ) {
					return ( $equality == 'equal' );
				}

				$curent_post_type = $this->_getWPLayer()->get_post_type();

				if( $this->_getWPLayer()->is_post_type_archive( $curent_post_type ) ){
					return ( $equality == 'equal' );
				}

				return ( $equality != 'equal' );
				
			case 'paged' :
					// front-page, middle-page, last-page
					$currentPage = $this->_getWPLayer()->get_paged();

					foreach( $idArray as $oneValue ) {
						if( $oneValue == 'first-page') {
							if( $currentPage == 1 ) {
								return ( $equality == 'equal' );
							}
						}
						
						if( $oneValue == 'middle-page' ) {
							$wpQuery = $this->_getWPLayer()->get_wp_query();
							//$currentPage = $this->_getWPLayer()->get_paged();
							$numberOfPagesOverall = $wpQuery->max_num_pages;
							
							if( $currentPage < $numberOfPagesOverall ) {
								return ( $equality == 'equal' );
							}
						}
						
						if( $oneValue == 'last-page' ) {
							$wpQuery = $this->_getWPLayer()->get_wp_query();
							$numberOfPagesOverall = $wpQuery->max_num_pages;
							
							if( $currentPage == $numberOfPagesOverall ) {
								return ( $equality == 'equal' );
							}
						}
						
						if( strpos( $oneValue, 'special-page-') !== false ) {
							$wishedPageNumberString = str_replace('special-page-', '', $oneValue);
							$wishedPagenNumberInt = intval( $wishedPageNumberString );
							
							if( $currentPage == $wishedPagenNumberInt ) {
								return ( $equality == 'equal' );
							}
						} 
					}
				
				
				return ( $equality != 'equal' );

		}

		return false;

	}

	// private function _users( $type, $equality, $idArray ) {

	// 	switch( $type ) {

	// 		case 'author-archive':
	// 		case 'user-logged':
	// 		case 'user-role':
	// 			return true;
	// 	}

	// 	return false;

	// }

	private function _plugins( $pluginName, $equality, $idArray ) {
		switch( $pluginName ) {
			case 'wpml' :
				if( !$this->_getWPLayer()->getWPMLBridge()->isWPMLActive() ) {
					return false;
				}
				$currentLanguage = $this->_getWPLayer()->getWPMLBridge()->getCurrentLanguage();
				$arrayImploded = implode('',$idArray);
				if( empty( $arrayImploded ) ) {
					return ( $equality == 'equal' );
				}
				$inArray =  in_array($currentLanguage, $idArray);
				if( $equality == 'equal' ) {
					return $inArray;
				} else {
					return !$inArray;
				}
				break;
		}
		return false;
	}


	private function _modules( $type, $equality, $idArray ) {
		switch( $type ) {

			case 'active-theme':
				// Actual theme?
				$theme = $this->_getWPLayer()->wp_get_theme()->stylesheet;

				return ( $equality == 'equal' )
						? ( $theme == $idArray )
						: ( $theme != $idArray )
						;

			case 'active-plugin':
				$arrayImploded = implode('',$idArray);
				if( empty( $arrayImploded ) ) {
					return ( $equality == 'equal' );
				}

				$activePluginsArray = $this->_getWPLayer()->get_option('active_plugins');

				foreach( $idArray as $oneId ) {
					$inArray = in_array( $oneId, $idArray );

					if( $inArray && $equality == 'equal' ) {
						return true;
					} else if ( !$inArray && $equality == 'not_equal' ) {
						return false;
					}
				}

				return false;
		}
	}


	private function _system( $type, $equality, $idArray ) {
		switch( $type ) {

			case 'device':
				if( empty( $idArray ) ) {
					return ( $equality == 'equal' );
				}
				
				if( $equality == 'equal' ) {
					if( in_array( 'mobile', $idArray ) &&  $this->_getWPLayer()->wp_is_mobile() ){
						return true;
					}
						
					if( in_array( 'desktop', $idArray ) &&  !$this->_getWPLayer()->wp_is_mobile() ){
						return true;
					}
				} else {
					$toReturn = true;
					if( in_array( 'mobile', $idArray ) &&  $this->_getWPLayer()->wp_is_mobile() ){
						$toReturn = false;
					}
					
					if( in_array( 'desktop', $idArray ) &&  !$this->_getWPLayer()->wp_is_mobile() ){
						$toReturn = false;
					}
					
					return $toReturn;
				}
				

				/*
				if( in_array( 'mobile', $idArray ) ){
					var_Dump( ( $equality == 'equal' )
							?   $this->_getWPLayer()->wp_is_mobile()
							: ! $this->_getWPLayer()->wp_is_mobile()
							);
					return ( $equality == 'equal' )
							?   $this->_getWPLayer()->wp_is_mobile()
							: ! $this->_getWPLayer()->wp_is_mobile()
							;
					
					
				}

				if( in_array( 'desktop', $idArray ) ){
					var_Dump( ( $equality == 'equal' )
							? ! $this->_getWPLayer()->wp_is_mobile()
							:   $this->_getWPLayer()->wp_is_mobile()
					);
					
					return ( $equality == 'equal' )
							? ! $this->_getWPLayer()->wp_is_mobile()
							:   $this->_getWPLayer()->wp_is_mobile()
							;
				}

				return ( $equality == 'equal' )
						? ( $theme == $idArray )
						: ( $theme != $idArray )
						;*/

			case 'browser':

				if( empty( $idArray ) ) {
					return ( $equality == 'equal' );
				}

				$browser_arr = array();
				// see http://codex.wordpress.org/Global_Variables

				if( $this->_getWPLayer()->get_is_iphone () ) $browser_arr[] = 'is_iphone' ;
				if( $this->_getWPLayer()->get_is_chrome () ) $browser_arr[] = 'is_chrome' ;
				if( $this->_getWPLayer()->get_is_safari () ) $browser_arr[] = 'is_safari' ;
				if( $this->_getWPLayer()->get_is_NS4    () ) $browser_arr[] = 'is_NS4'    ;
				if( $this->_getWPLayer()->get_is_opera  () ) $browser_arr[] = 'is_opera'  ;
				if( $this->_getWPLayer()->get_is_macIE  () ) $browser_arr[] = 'is_macIE'  ;
				if( $this->_getWPLayer()->get_is_winIE  () ) $browser_arr[] = 'is_winIE'  ;
				if( $this->_getWPLayer()->get_is_gecko  () ) $browser_arr[] = 'is_gecko'  ;
				if( $this->_getWPLayer()->get_is_lynx   () ) $browser_arr[] = 'is_lynx'   ;
				if( $this->_getWPLayer()->get_is_IE     () ) $browser_arr[] = 'is_IE'     ;

				for( $ver = ffConditionalLogicConstants::min_IE_version; $ver <= ffConditionalLogicConstants::max_IE_version; $ver ++ ){
					if(preg_match('/(?i)msie '.$ver.'/',$_SERVER['HTTP_USER_AGENT'])){
						$browser_arr[] = 'is_IE'.$ver;
					}
				}

				$intersection = array_intersect( $browser_arr, $idArray );
				return ( $equality == 'equal' )
					? ! empty( $intersection )
					:   empty( $intersection )
					;
		}
	}

	private function _time( $type, $equality, $idArray ) {

		if( empty( $idArray ) ) {
			return ( $equality == 'equal' );
		}

		// If you think, that something wrong is with the time, tham go to:
		//
		// WP Admin menu > General > Timezone
		//
		// and set the right timezone !!!

		switch( $type ) {
			case 'minute':
				$minute_interval = substr( Date('i'), 0, 1 );
				if( in_array( $minute_interval, $idArray ) ){
					return ( $equality == 'equal' );
				}
				break;

			case 'hour':    if( in_array( 1 * Date('G'), $idArray ) ){ return ( $equality == 'equal' ); } break;
			case 'day':     if( in_array( 1 * Date('j'), $idArray ) ){ return ( $equality == 'equal' ); } break;
			case 'weekday': if( in_array( 1 * Date('N'), $idArray ) ){ return ( $equality == 'equal' ); } break;
			case 'month':   if( in_array( 1 * Date('n'), $idArray ) ){ return ( $equality == 'equal' ); } break;
			case 'year':    if( in_array( 1 * Date('Y'), $idArray ) ){ return ( $equality == 'equal' ); } break;
		}

		return false;
	}

	// equal / not_equal
	private function _checkEquality( $equality, $idArray ) {
		if( $idArray && $equality == 'equal' || !$idArray && $equality == 'not_equal' ) {
			return true;
		}  else {
			return false;
		}
 	}


	private function _getGroupInfo( $name ) {
		$info = explode('-|-', $name);
		$return['group'] = $info[0];
		$return['type'] = $info[1];

		return $return;
	}

	/**
	 *
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}

	/**
	 *
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer($WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}


}