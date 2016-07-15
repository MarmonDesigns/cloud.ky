<?php

/** @var $s ffOneStructure */
################################################################################
# IMAGE SLIDER START
################################################################################
$s->startSection('image-slider', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Image slider')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('image-slider'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('image-slider').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        ff_load_section_options('section-settings-block', $s);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Image size');
            $s->startSection('image-dimensions');
                $s->addOption(ffOneOption::TYPE_TEXT, 'width', 'Width (in px)', 1140);
                $s->addElement(ffOneElement::TYPE_DESCRIPTION, '', 'Default width is 1140');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);

                $s->addOption(ffOneOption::TYPE_TEXT, 'height', 'Height (in px)', 400);
                $s->addElement(ffOneElement::TYPE_DESCRIPTION, '', 'Default height is 400');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->endSection();
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

 		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Images');
            $s->startSection('images', ffOneSection::TYPE_REPEATABLE_VARIABLE);
                $s->startSection('one-image', ffOneSection::TYPE_REPEATABLE_VARIATION)
                    ->addParam('section-name', 'One image');
                    $s->addOption(ffOneOption::TYPE_IMAGE, 'image', 'Image', '');
                $s->endSection();
            $s->endSection();
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# IMAGE SLIDER END
################################################################################
