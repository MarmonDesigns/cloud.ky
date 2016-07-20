<?php

/** @var $s ffOneStructure */
################################################################################
# INFO SLIDER START
################################################################################
$s->startSection('info-slider', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Info slider')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('info-slider'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    ff_load_section_options( 'section-settings-block', $s );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Info slider');
        $s->startSection('items', ffOneSection::TYPE_REPEATABLE_VARIABLE);
            $s->startSection('one-item', ffOneSection::TYPE_REPEATABLE_VARIATION)
                ->addParam('section-name', 'One item');
            $s->addOption(ffOneOption::TYPE_TEXT, 'over-title', 'Over title', 'It\'s responsive');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Take a look');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXTAREA, 'description', 'Description', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totamrem aperiam, eaque ipsa quae ab illo invent ore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit.');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_IMAGE, 'picture', 'Photo', '');
            $s->endSection();
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# INFO SLIDER START
################################################################################