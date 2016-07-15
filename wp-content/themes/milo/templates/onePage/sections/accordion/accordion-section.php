<?php

/** @var $s ffOneStructure */
################################################################################
# ACCORDION START
################################################################################
$s->startSection('accordion', ffOneSection::TYPE_REPEATABLE_VARIATION)
	->addParam('section-name', 'Accordion (Accordeon)')
	->addParam('hide-default', true)
	->addParam('advanced-picker-menu-title', 'Common')
	->addParam('advanced-picker-menu-id', 'common')
	->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('accordion'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
		$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('accordion').'" width="250">');
	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	ff_load_section_options( 'section-settings-block', $s );

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Settings')
		->addParam('section-name', 'Settings');
		$s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'We answer your questions');
	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'accordion');
		$s->startSection('accordion', ffOneSection::TYPE_REPEATABLE_VARIABLE);
			$s->startSection('one-accordion', ffOneSection::TYPE_REPEATABLE_VARIATION)
				->addParam('section-name', 'One accordion');
			$s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'How do you work?');
			$s->addElement(ffOneElement::TYPE_NEW_LINE);
			$s->addOption(ffOneOption::TYPE_TEXTAREA, 'description', 'Description', 'Phasellus rhoncus non mi sed faucibus. Donec sollicitudin posuere ante, in tristique velit pellentesque id. Nulla nibh arcu, cursus eu consectetur ut, tincidunt ac magna. Donec vitae orci nunc.');
			$s->endSection();
		$s->endSection();
	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# ACCORDION END
################################################################################