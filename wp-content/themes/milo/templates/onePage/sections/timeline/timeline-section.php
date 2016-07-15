<?php

/** @var $s ffOneStructure */
################################################################################
# GENERAL SERVICE START
################################################################################
$s->startSection('timeline', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Timeline')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('timeline'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
    $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('timeline').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


    ff_load_section_options( 'section-settings-block', $s);

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Timeline');
        $s->startSection('timeline-items', ffOneSection::TYPE_REPEATABLE_VARIABLE);
            $s->startSection('one-timeline-item', ffOneSection::TYPE_REPEATABLE_VARIATION)
                ->addParam('section-name', 'One timeline item');
            $s->addOption(ffOneOption::TYPE_TEXT, 'date', 'Date', 'September 2014');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Best website award');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'link', 'Link', '');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
                $s->startSection('date-items', ffOneSection::TYPE_REPEATABLE_VARIABLE);
                    $s->startSection('one-date-item', ffOneSection::TYPE_REPEATABLE_VARIATION)
                        ->addParam('section-name', 'One date item');
                    $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Best original website 2014');
                    $s->endSection();
                $s->endSection();
            $s->endSection();
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# GENERAL SERVICE END
################################################################################