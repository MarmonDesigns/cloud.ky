<?php
/**********************************************************************************************************************/
/* Twitter sections
/**********************************************************************************************************************/

$s->startSection('twitter', ffOneSection::TYPE_REPEATABLE_VARIATION)
	->addParam('section-name', 'Twitter')
	->addParam('hide-default', true)

	->addParam('advanced-picker-menu-title', 'Common')
	->addParam('advanced-picker-menu-id', 'common')
	->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('twitter'));


	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('twitter').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
//
		ff_load_section_options( 'section-settings-block', $s);
//
//		ff_load_section_options( '/templates/onePage/blocks/section-background-block.php', $s);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Twitter');

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

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();
