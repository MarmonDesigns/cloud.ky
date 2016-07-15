<?php

class ffLib_TwitterFeeder_TweetsCollection extends ffBasicObject implements Iterator {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	private $_iteratorPointer = null;
	
	private $_tweetsFromTwitter = null;
	
	/**
	 * 
	 * @var ffLib_TwitterFeeder_OneTweet_Factory
	 */
	private $_oneTweetFactory = null;
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( $tweetsFromTwitter, ffLib_TwitterFeeder_OneTweet_Factory $oneTweetFactory ) {
		$this->_setTweetsfromtwitter($tweetsFromTwitter);
		$this->_setOnetweetfactory($oneTweetFactory);
	}
/******************************************************************************/
/* ITERATOR INTERFACE
/******************************************************************************/	
	/**
	 * (non-PHPdoc)
	 * @see Iterator::current()
	 * @return ffLib_TwitterFeeder_OneTweet
	 */
	public function current () {
		return $this->_getOnetweetfactory()
						->createTweet(
							$this->_tweetsFromTwitter[ $this->_iteratorPointer ]
									);
						
	}
	public function key () {
		return $this->_iteratorPointer;
	}
	public function next () {
		$this->_iteratorPointer++;
	}
	public function rewind () {
		$this->_iteratorPointer = 0;
	}
	public function valid () {
		if( empty($this->_iteratorPointer) ){
			$this->rewind();
		}
		if( !is_array($this->_tweetsFromTwitter) ){
			return false;
		}
		return isset( $this->_tweetsFromTwitter[ $this->_iteratorPointer ] );
	}

/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/	

	/**
	 * @return unknown_type
	 */
	protected function _getTweetsfromtwitter() {
		return $this->_tweetsFromTwitter;
	}
	
	/**
	 * @param unknown_type $tweetsFromTwitter
	 */
	protected function _setTweetsfromtwitter($tweetsFromTwitter) {
		$this->_tweetsFromTwitter = $tweetsFromTwitter;
		return $this;
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