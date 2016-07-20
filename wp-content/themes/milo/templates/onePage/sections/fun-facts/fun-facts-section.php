<?php
/** @var $s ffOneStructure */
################################################################################
# FUN FACTS START
################################################################################
$s->startSection('fun-facts', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Fun facts')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('fun-facts'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
        $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('fun-facts').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    ff_load_section_options( 'section-settings-block', $s);

//    ff_load_section_options( '/templates/onePage/blocks/section-background-block.php', $s);

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Fun facts');

        $s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-heading', 'Show Heading', 0);
        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        ff_load_section_options('heading-wrapped-block', $s);

        $s->addElement( ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'not-selected-part-color', 'Not Selected Part color', '#000000')
            ->addParam('class', 'ff-default-wp-color-picker');

        $s->addElement( ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_CHECKBOX, 'use-this-color-instead-accent', 'Use color below (instead of accent color)', 0);

        $s->addOption( ffOneOption::TYPE_TEXT, 'selected-part-color', 'Selected Part color', '#bca480')
            ->addParam('class', 'ff-default-wp-color-picker');


    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Fun facts');
        $s->startSection('facts', ffOneSection::TYPE_REPEATABLE_VARIABLE);
            $s->startSection('one-fact', ffOneSection::TYPE_REPEATABLE_VARIATION)
                ->addParam('section-name', 'One fact');
            ff_load_section_options('bootstrap-columns-block', $s, array('md'=>3));
            $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Pure love');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'percentage', 'Percentage', '75');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->endSection();
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# FUN FACTS END
################################################################################

