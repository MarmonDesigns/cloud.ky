<?php

/** @var $s ffOneStructure */
################################################################################
# PROJECT SLIDER START
################################################################################
$s->startSection('project-slider', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Project slider')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('project-slider'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
        $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('project-slider').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


    $s->startSection('section-settings-navigation');
        ff_load_section_options( 'section-settings-block', $s, array('title'=>'Section Options Navigation'));
    $s->endSection();

    $s->startSection('section-settings-slider');
        ff_load_section_options( 'section-settings-block', $s, array('title'=>'Section Options Slider'));
    $s->endSection();

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Dimensions');
        $s->addOption(ffOneOption::TYPE_TEXT, 'slider-height', 'Slider Height (in px)', 765);
        $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Default value is 765 pixels');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Projects');
        $s->startSection('projects', ffOneSection::TYPE_REPEATABLE_VARIABLE);
            $s->startSection('one-project', ffOneSection::TYPE_REPEATABLE_VARIATION)
                ->addParam('section-name', 'One project');

                $s->addOption(ffOneOption::TYPE_TEXT, 'project-name', 'Project Menu (navigation) name', 'Projects');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);

                $s->addOption(ffOneOption::TYPE_IMAGE, 'project-image', 'Project Image (as background)', '');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);

                ff_load_section_options( 'heading-content-block', $s );


            $s->endSection();
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# PROJECT SLIDER END
################################################################################