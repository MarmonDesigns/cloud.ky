<?php

class ffDataStorage_OptionsPostTypeRegistrator extends ffBasicObject {
	const OPTIONS_POST_TYPE_SLUG = 'ff-options';
	
	/**
	 * 
	 * @var ffPostTypeRegistratorManager
	 */
	private $_postTypeRegistratorManager = null;
	
	public function __construct( ffPostTypeRegistratorManager $postTypeRegistratorManager ) {
		$this->_setPostTypeRegistratorManager( $postTypeRegistratorManager );
	}
	
	public function registerOptionsPostType() {
		$registrator = $this->_getPostTypeRegistratorManager()
						->addHiddenPostTypeRegistrator( ffDataStorage_OptionsPostTypeRegistrator::OPTIONS_POST_TYPE_SLUG, 'Options');

		$registrator->getSupports()
			->set('revisions', false);
	}
	
	/**
	 *
	 * @return ffPostTypeRegistratorManager
	 */
	protected function _getPostTypeRegistratorManager() {
		return $this->_postTypeRegistratorManager;
	}
	
	/**
	 *
	 * @param ffPostTypeRegistratorManager $postTypeRegistratorManager        	
	 */
	protected function _setPostTypeRegistratorManager(ffPostTypeRegistratorManager $postTypeRegistratorManager) {
		$this->_postTypeRegistratorManager = $postTypeRegistratorManager;
		return $this;
	}
	
	
	/*
	 * 
	 * $frameworkContainer = $this->_getContainer()
		->getFrameworkContainer();

		$registrator = $frameworkContainer->getPostTypeRegistratorManager()
			->addHiddenPostTypeRegistrator( ffPluginFreshCustomCode::CUSTOMCODE_POST_TYPE_SLUG , 'Custom Code');

		$registrator->getArgs()
			->set('show_in_menu', 'themes.php');

		$registrator->getSupports()
			->set('revisions', false);

		$registrator->getLabels()
			->set('all_items', 'Custom Code');
	 */
}