<?php

/** @var $s ffOneStructure */
################################################################################
# GENERAL SERVICE START
################################################################################
$s->startSection('general-service', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'General service')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('general-service'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );
    
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
    $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('general-service').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    ff_load_section_options('section-settings-block', $s);

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Title');

    ff_load_section_options('heading-content-block', $s);

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Content');


        $s->startSection('content', ffOneSection::TYPE_REPEATABLE_VARIABLE );
            $s->startSection('one-paragraph', ffOneSection::TYPE_REPEATABLE_VARIATION )->addParam('section-name', 'One Paragraph');

                $description = 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.';
                $s->addOption(ffOneOption::TYPE_TEXTAREA, 'text', '', $description);

            $s->endSection();

        $s->endSection();

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Button');

        ff_load_section_options('button-block', $s);

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Image');
        $s->startSection('image');
            $s->addOption( ffOneOption::TYPE_SELECT, 'position', 'Image Position', 'right')
                ->addSelectValue('Right', 'right')
                ->addSelectValue('Left', 'left');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addOption(ffOneOption::TYPE_IMAGE, 'image', 'Photo', '');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            ff_load_section_options('animation-block', $s);
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# GENERAL SERVICE END
################################################################################