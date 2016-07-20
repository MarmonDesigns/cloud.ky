<?php

class ffLib_TwitterFeeder extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/	
	const FF_SECTION_NAME = 'fw_twitter';
	const FF_TWITTER_FEEDER_NAMESPACE = 'libtw';
	const FF_TWITTER_FEEDER_TIME_SUFFIX= '-time';
	
	/**
	 * 
	 * @var ffDataStorage_WPOptions
	 */
	private $_dataStorageWPOptions = null;
	
	/**
	 * 
	 * @var ffLib_TwitterFeeder_OAuthFactory
	 */
	private $_OAuthFactory = null;
	
	
	/**
	 * 
	 * @var ffLib_TwitterFeeder_TweetsCollection_Factory
	 */
	private $_tweetsCollectionFactory = null;
	
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffDataStorage_WPOptions $dataStorageWPOptions, ffLib_TwitterFeeder_OAuthFactory $OAuthFactory, ffLib_TwitterFeeder_TweetsCollection_Factory $tweetsCollectionFactory ) {
		$this->_setDatastoragewpoptions($dataStorageWPOptions);
		$this->_setOauthfactory($OAuthFactory);		
		$this->_setTweetscollectionfactory($tweetsCollectionFactory);
	}

	public function getTwitterFeed( ffOptionsQuery $query ) {
		$tweets = $this->_getTweets( $query );
		$tweetsCollection = $this->_getTweetscollectionfactory()->createTweetsCollection( $tweets );
		return $tweetsCollection;
	}
	
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	private function _getTweets( ffOptionsQuery $query ) {
		$tweets = $this->_getTweetsFromCache($query);
		// TODO FIX CACHING WHEN RETURNED ERROR
		if( $tweets instanceof  stdClass ) {
			$tweets = null;
		}
		if( $tweets == null ) {
			
			$connection = $this->_getOAuth( $query );
			$tweets = $this->_getTweetsFromTwitter( $connection, $query );
			$this->_cacheTweets( $tweets, $query );
		}
		
		return $tweets;
	}
	
	private function _getTweetsFromCache( ffOptionsQuery $query ) {
		$cachingInfo = $this->_getCachingInfo($query);
		
		$cachingTimeInSeconds = $query->get('caching-time-in-minutes') * 60;
		
		$tweetsStored = $this->_getDatastoragewpoptions()
								->getOption( $cachingInfo->namespace, $cachingInfo->nameOfTimestamp);
		if( $tweetsStored + $cachingTimeInSeconds >= $cachingInfo->currentTimestamp ) {
			$tweets = $this->_getDatastoragewpoptions()
							->getOption( $cachingInfo->namespace, $cachingInfo->name );
		} else {
			$tweets = null;
			$this->_deleteCache($query);
		}
		
		
		return $tweets;
	}
	
	private function _deleteCache( ffOptionsQuery $query ) {
		$cachingInfo = $this->_getCachingInfo($query);
		
		$this->_getDatastoragewpoptions()
				->deleteOption($cachingInfo->namespace, $cachingInfo->name);
		$this->_getDatastoragewpoptions()
				->deleteOption($cachingInfo->namespace, $cachingInfo->nameOfTimestamp);
	}
	
	private function _cacheTweets( $tweets, ffOptionsQuery $query ) {
		
		$cachingInfo = $this->_getCachingInfo( $query );
		
		$this->_getDatastoragewpoptions()
				->setOption($cachingInfo->namespace, $cachingInfo->name, $tweets);
		$this->_getDatastoragewpoptions()
				->setOption($cachingInfo->namespace, $cachingInfo->nameOfTimestamp, $cachingInfo->currentTimestamp);
	}
	
	private function _getCachingInfo( ffOptionsQuery $query ) {
		$cachingInfo = new stdClass();
		
		$cachingInfo->namespace = ffLib_TwitterFeeder::FF_TWITTER_FEEDER_NAMESPACE;
		$cachingInfo->name = $query->get('username');
		$cachingInfo->nameOfTimestamp = $cachingInfo->name . ffLib_TwitterFeeder::FF_TWITTER_FEEDER_TIME_SUFFIX;
		$cachingInfo->currentTimestamp = time();
		
		return $cachingInfo;
	}
	
	private function _getTweetsFromTwitter( $connection, ffOptionsQuery $query ) {
		$username = $query->get('username');
		$numberOfTweets = $query->get('number-of-tweets');
		return $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$username&count=$numberOfTweets");
	}
	
	private function _getOAuth( ffOptionsQuery $query ) {
		$consumerKey = $query->get('consumer-key');
		$consumerSecret = $query->get('consumer-secret');
		$accessToken = $query->get('access-token');
		$accessTokenSecret = $query->get('access-token-secret');
		
		
		$oAuth = null;
		if( 
			$consumerKey !== null &&
			$consumerSecret !== null &&
			$accessToken !== null &&
			$accessTokenSecret !== null  
			) {
			$oAuth = $this->_getOauthfactory()
							->getOAuthConnection($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
		}
		
		return $oAuth;
	}
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/

	/**
	 * @return ffDataStorage_WPOptions
	 */
	protected function _getDatastoragewpoptions() {
		return $this->_dataStorageWPOptions;
	}
	
	/**
	 * @param ffDataStorage_WPOptions $dataStorageWPOptions
	 */
	protected function _setDatastoragewpoptions(ffDataStorage_WPOptions $dataStorageWPOptions) {
		$this->_dataStorageWPOptions = $dataStorageWPOptions;
		return $this;
	}
	
	/**
	 * @return ffLib_TwitterFeeder_OAuthFactory
	 */
	protected function _getOauthfactory() {
		return $this->_OAuthFactory;
	}
	
	/**
	 * @param ffLib_TwitterFeeder_OAuthFactory $OAuthFactory
	 */
	protected function _setOauthfactory(ffLib_TwitterFeeder_OAuthFactory $OAuthFactory) {
		$this->_OAuthFactory = $OAuthFactory;
		return $this;
	}

	/**
	 * @return ffLib_TwitterFeeder_TweetsCollection_Factory
	 */
	protected function _getTweetscollectionfactory() {
		return $this->_tweetsCollectionFactory;
	}
	
	/**
	 * @param ffLib_TwitterFeeder_TweetsCollection_Factory $tweetsCollectionFactory
	 */
	protected function _setTweetscollectionfactory(ffLib_TwitterFeeder_TweetsCollection_Factory $tweetsCollectionFactory) {
		$this->_tweetsCollectionFactory = $tweetsCollectionFactory;
		return $this;
	}
	
	
}