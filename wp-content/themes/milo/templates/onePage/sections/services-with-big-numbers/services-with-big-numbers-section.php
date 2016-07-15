<?php

/** @var $s ffOneStructure */
################################################################################
# SERVICE WITH BIG NUMBERS START
################################################################################
$s->startSection('services-with-big-numbers', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Services with big numbers')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('services-with-big-numbers'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
        $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('services-with-big-numbers').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    ff_load_section_options('section-settings-block', $s);

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Numbered services');
        $s->startSection('numbered-services', ffOneSection::TYPE_REPEATABLE_VARIABLE);
            $s->startSection('one-service', ffOneSection::TYPE_REPEATABLE_VARIATION)
                ->addParam('section-name', 'One service');

            ff_load_section_options('bootstrap-columns-block', $s, array('sm'=>4));

            ff_load_section_options('animation-block', $s );

            $s->addElement(ffOneElement::TYPE_NEW_LINE);

            $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Discuss Ideas');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption( ffOneOption::TYPE_TEXT, 'url', 'URL', '#');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption(ffOneOption::TYPE_SELECT, 'target', 'Open in', '_blank')
                ->addSelectValue('Same Window', '')
                ->addSelectValue('New Window', '_blank');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'subtitle', 'Subtitle', 'Designing in Photoshop');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXTAREA, 'description', 'Description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->endSection();
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# SERVICE WITH BIG NUMBERS END
################################################################################