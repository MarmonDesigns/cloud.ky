<?php

/** @var $s ffOneStructure */
################################################################################
# FUN FACTS WITH COUNTERS START
################################################################################
$s->startSection('fun-facts-with-counters', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Fun facts with counters')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('fun-facts-with-counters'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
        $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('fun-facts-with-counters').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    ff_load_section_options('section-settings-block', $s );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Fun facts');
        $s->startSection('facts', ffOneSection::TYPE_REPEATABLE_VARIABLE);
            $s->startSection('one-fact', ffOneSection::TYPE_REPEATABLE_VARIATION)
                ->addParam('section-name', 'One fact');

            ff_load_section_options('bootstrap-columns-block', $s, array('sm'=>3 ) );

            $s->addOption( ffOneOption::TYPE_ICON, 'icon', '', 'ff-font-miu icon-chat56');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);

            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Satisfied clients');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'quantity', 'Quantity', '139');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->endSection();
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# FUN FACTS WITH COUNTERS END
################################################################################

