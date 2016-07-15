<?php

class ffLib_TwitterFeeder_OAuthFactory extends ffFactoryAbstract {
	public function getOAuthConnection( $consumerKey, $consumerSecret, $accessToken, $accessTokenSecret ) {
		$this->_getClassloader()->loadClass('extTwitterOAuth');
		$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
		return $connection;
	}
}