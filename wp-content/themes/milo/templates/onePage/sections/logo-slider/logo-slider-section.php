<?php

/** @var $s ffOneStructure */
################################################################################
# LOGO SLIDER START
################################################################################
$s->startSection('logo-slider', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Logo showcase')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('logo-slider'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
        $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('logo-slider').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    ff_load_section_options('section-settings-block', $s );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Logo showcase');
        $s->startSection('logos', ffOneSection::TYPE_REPEATABLE_VARIABLE);
            $s->startSection('one-logo', ffOneSection::TYPE_REPEATABLE_VARIATION)
                ->addParam('section-name', 'One logo');
            $s->addOption(ffOneOption::TYPE_IMAGE, 'picture', 'Picture', '');
            $s->endSection();
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# LOGO SLIDER END
################################################################################