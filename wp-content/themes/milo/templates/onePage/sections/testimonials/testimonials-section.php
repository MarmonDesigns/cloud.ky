<?php

/** @var $s ffOneStructure */
################################################################################
# TESTIMONIAL START
################################################################################
$s->startSection('testimonials', ffOneSection::TYPE_REPEATABLE_VARIATION)
	->addParam('section-name', 'Testimonials')
	->addParam('hide-default', true)
	->addParam('advanced-picker-menu-title', 'Common')
	->addParam('advanced-picker-menu-id', 'common')
	->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('testimonials'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
		$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('testimonials').'" width="250">');
	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	ff_load_section_options( 'section-settings-block', $s );

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Settings')
		->addParam('section-name', 'Settings');
		$s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'What people say');
		$s->addElement(ffOneElement::TYPE_NEW_LINE);
		$s->addOption(ffOneOption::TYPE_SELECT, 'type', 'Show on bottom ', '')
			->addSelectValue('Images', '')
			->addSelectValue('Images in Circle', 'img-circle')
			->addSelectValue('Dots', 'dots');
	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Testimonials');
		$s->startSection('testimonials', ffOneSection::TYPE_REPEATABLE_VARIABLE);
			$s->startSection('one-testimonial', ffOneSection::TYPE_REPEATABLE_VARIATION)
				->addParam('section-name', 'One testimonial');
			$s->addOption(ffOneOption::TYPE_TEXTAREA, 'text', 'Text', 'Quisque neque orci, dictum eu egestas eget, porta vel dolor. Etiam vel nunc pulvinar, suscipit urna sit amet, efficitur nibh. Nulla convallis ut lectus a tempor. Nullam tincidunt pulvinar sodales. Nunc sed erat et risus luctus sollicitudin.');
			$s->addElement(ffOneElement::TYPE_NEW_LINE);
			$s->addOption(ffOneOption::TYPE_TEXT, 'author', 'Author', 'John Smith, Crazytown inc.');
			$s->addElement(ffOneElement::TYPE_NEW_LINE);
			$s->addOption(ffOneOption::TYPE_IMAGE, 'photo', 'Photo', '');
			$s->endSection();
		$s->endSection();
	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# TESTIMONIAL END
################################################################################