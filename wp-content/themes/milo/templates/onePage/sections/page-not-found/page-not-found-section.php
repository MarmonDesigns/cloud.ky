<?php

/** @var $s ffOneStructure */
################################################################################
# PAGE NOT FOUND START
################################################################################
$s->startSection('page-not-found', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Page not found')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Special')
    ->addParam('advanced-picker-menu-id', 'special')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('page-not-found'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );
    
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
    $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('page-not-found').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Error number');
        $s->addOption(ffOneOption::TYPE_TEXT, 'error-number', '', '404');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Error message');
        $s->addOption(ffOneOption::TYPE_TEXT, 'error-message', '', 'Page not found');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Error description');
        $s->addOption(ffOneOption::TYPE_TEXT, 'error-description', '', 'The page you are looking for could not be found.');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Additional info');
        $s->addOption(ffOneOption::TYPE_TEXTAREA, 'additional-info', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Button');
        $s->addOption(ffOneOption::TYPE_TEXT, 'button-title', 'Title', 'Go to home page');
        $s->addElement(ffOneElement::TYPE_NEW_LINE);
        $s->addOption(ffOneOption::TYPE_TEXT, 'button-link', 'Link', '');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# PAGE NOT FOUND END
################################################################################