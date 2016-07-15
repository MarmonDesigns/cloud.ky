<?php

class ffThemeViewIdentificator extends ffBasicObject {
	
	private $_identifiedView = null;
	
	private $_WPLayer = null;
	
	public function __construct( ffWPLayer $WPLayer ) {
		$this->_setWPLayer($WPLayer);
	}
	
	public function getCurrentView() {
		
		if( !$this->_getWPLayer()->action_been_executed('parse_query') ) {
			throw new Exception('USING THEME VIEW IDENTIFICATOR BEFORE PARSE QUERY');
		}
		
		if( $this->_identifiedView == null ) {
			if( is_404() ) {
				$this->_identifiedView = ffConstThemeViews::PAGE_404;
			} else if( is_search() ) {
				$this->_identifiedView = ffConstThemeViews::SEARCH;
			} else if( is_front_page() ) {
				$this->_identifiedView = ffConstThemeViews::FRONT_PAGE;
			} else if( is_home() ) {
				$this->_identifiedView = ffConstThemeViews::HOME;
			} else if( is_post_type_archive() ) {
				$this->_identifiedView = ffConstThemeViews::ARCHIVE_POST_TYPE;
			} else if( is_tax() ) {
				$this->_identifiedView = ffConstThemeViews::TAX;				
			} else if( is_attachment() ) {
				$this->_identifiedView = ffConstThemeViews::ATTACHMENT;
			} else if( is_single() ) {
				$this->_identifiedView = ffConstThemeViews::SINGLE;
			} else if( is_page() ) {
				$this->_identifiedView = ffConstThemeViews::PAGE;
			} else if( is_category() ) {
				$this->_identifiedView = ffConstThemeViews::CATEGORY;
			} else if( is_tag() ) {
				$this->_identifiedView = ffConstThemeViews::TAG;
			} else if( is_author() ) {
				$this->_identifiedView = ffConstThemeViews::AUTHOR;
			} else if( is_date() ) {
				$this->_identifiedView = ffConstThemeViews::DATE;
			} else if( is_archive() ) {
				$this->_identifiedView = ffConstThemeViews::ARCHIVE;
			} else if( is_comments_popup() ) {
				$this->_identifiedView = ffConstThemeViews::COMMENTS_POPUP;
			} else if( is_paged() ) {
				$this->_identifiedView = ffConstThemeViews::PAGED;
			} else {
				$this->_identifiedView = ffConstThemeViews::INDEX;
			}
 
		}
		
		return $this->_identifiedView;
	}
	
	private function _setWPLayer($WPLayer) {
		$this->_WPLayer = $WPLayer;
	}
	
	/**
	 * 
	 * @return ffWPLayer
	 */
	private function _getWPLayer() {
		return $this->_WPLayer;
	}

}