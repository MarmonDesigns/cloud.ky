<?php

class ffComponent_TwitterWidget_OptionsHolder extends ffOptionsHolder {
	public function getOptions() {
		$s = $this->_getOnestructurefactory()->createOneStructure( 'twitter-structure' );
		$s->startSection('twitter', 'Twitter');

			$s->addElement( ffOneElement::TYPE_HTML, '', '<p>' );
				$s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Twitter Feeds');
			$s->addElement( ffOneElement::TYPE_HTML, '', '</p>' );

            $s->startSection('fw_twitter');
				$s->addOption(ffOneOption::TYPE_TEXT, 'username', 'Username', '_freshface');
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addOption(ffOneOption::TYPE_TEXT, 'number-of-tweets', 'Number of Tweets', '5');
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addOption(ffOneOption::TYPE_TEXT, 'caching-time-in-minutes', 'Caching time in minutes', '60');
				$s->addElement( ffOneElement::TYPE_NEW_LINE );

				// $this->_auth['consumerKey'], $this->_auth['consumerSecret'], $this->_auth['accessToken'], $this->_auth['accessTokenSecret']

				$s->addOption(ffOneOption::TYPE_TEXT, 'consumer-key', 'Consumer Key');
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addOption(ffOneOption::TYPE_TEXT, 'consumer-secret', 'Consumer Secret');
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addOption(ffOneOption::TYPE_TEXT, 'access-token', 'Access Token');
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addOption(ffOneOption::TYPE_TEXT, 'access-token-secret', 'Access Token Secret');
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
			$s->endSection();
		$s->endSection();
		return $s;
	}
}

