<?php

class ffLib_TwitterFeeder_OneTweet_Factory extends ffFactoryAbstract {
	public function createTweet( $tweetFromTwitter ) {
		$this->_getClassloader()->loadClass('ffLib_TwitterFeeder_OneTweet');
		$tweet = new ffLib_TwitterFeeder_OneTweet();
		
		$tweet->date = $tweetFromTwitter->created_at;
		$tweet->id = $tweetFromTwitter->id;
		$tweet->profileImage = $tweetFromTwitter->user->profile_image_url;
		$tweet->profileName = $tweetFromTwitter->user->name;
		$tweet->profileScreenName = $tweetFromTwitter->user->screen_name;
		$tweet->source = $tweetFromTwitter->source;
		$tweet->text = $tweetFromTwitter->text;
		$tweet->textWithLinks = $this->_linkIt( $tweet->text );
		
		return $tweet;
	}


	private function _linkIt($text)
	{
		$text = $this->_linkify( $text );
		// username replacing
		$text = preg_replace('/(?<=^|\s)@([a-z0-9_]+)/i',
				'<a href="http://www.twitter.com/$1">@$1</a>',
				$text);

		$text = preg_replace('/(#\w+)/i',
				'<a href="http://www.twitter.com/hashtag/##_replace_#$1">$1</a>',
				$text);

				$text = str_replace('##_replace_##', '', $text );
		return($text);
	}

	public function _linkify_helper($matches){
		$input = $matches[0];
		$url = preg_match('!^https?://!i', $input) ? $input : "http://$input";
		return '<a href="' . $url . '" rel="nofollow" target="_blank">' . "$input</a>";
	}

	private function _linkify( $text ) {
		$pattern = '(?xi)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?]))';
		return preg_replace_callback("#$pattern#i", array($this,'_linkify_helper'), $text);
	}
}