<?php

class ffLib_TwitterFeeder_TweetsCollection_Factory extends ffFactoryAbstract {
	/**
	 * 
	 * @var ffLib_TwitterFeeder_OneTweet_Factory
	 */
	private $_oneTweetFactory = null;
	
	public function __construct( ffClassLoader $classLoader, ffLib_TwitterFeeder_OneTweet_Factory $oneTweetFactory ) {
		$this->_setOnetweetfactory($oneTweetFactory);
		parent::__construct($classLoader);
	}
	
	public function createTweetsCollection( $tweetsFromTwitter ) {
		$this->_getClassloader()->loadClass('ffLib_TwitterFeeder_TweetsCollection');
		$tweetsCollection = new ffLib_TwitterFeeder_TweetsCollection($tweetsFromTwitter, $this->_getOnetweetfactory() );
		return $tweetsCollection;
	}

	/**
	 * @return ffLib_TwitterFeeder_OneTweet_Factory
	 */
	protected function _getOnetweetfactory() {
		return $this->_oneTweetFactory;
	}
	
	/**
	 * @param ffLib_TwitterFeeder_OneTweet_Factory $oneTweetFactory
	 */
	protected function _setOnetweetfactory(ffLib_TwitterFeeder_OneTweet_Factory $oneTweetFactory) {
		$this->_oneTweetFactory = $oneTweetFactory;
		return $this;
	}
	

}