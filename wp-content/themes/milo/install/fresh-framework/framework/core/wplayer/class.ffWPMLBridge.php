<?php

class ffWPMLBridge extends ffBasicObject {
	
	public function isWPMLActive() {
		return class_exists('SitePress');
	}
	
	public function getListOfLanguages() {
		
		if( !$this->isWPMLActive() ) {
			return array();
		}
		
		$langs = array();
		global $sitepress;
	
		foreach ($sitepress->get_active_languages() as $key => $value) {
			$oneLanguage = array(
				'name' => $value['native_name'],
				'value' =>  strtolower( $key ),
			);
			$langs[] = $oneLanguage;
		}
		
		return $langs;
	}
	
	public function getCurrentLanguage() {
		
		if( !$this->isWPMLActive() ) {
			return null;
		}
		
		global $sitepress;
		$active_lang = $sitepress->get_current_language();
		return $active_lang;
	}
}