<?php


/** @var $s ffOneStructure */
################################################################################
# BOXES WITH ICONS START
################################################################################
$s->startSection('boxes-with-icons', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Boxes with icons')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('boxes-with-icons'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
        $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('boxes-with-icons').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    ff_load_section_options('section-settings-block', $s);



    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Box with icons on the left side');

        $s->startSection('box-left');

            ff_load_section_options('animation-block', $s );
             $s->addElement(ffOneElement::TYPE_NEW_LINE);

            $s->addOption(ffOneOption::TYPE_ICON, 'icon', 'Icon', '');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Developement');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'url', 'Url', '#');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);

            $s->addOption(ffOneOption::TYPE_TEXTAREA, 'description', 'Description', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->endSection();

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );



    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Box with icons on the right side');

        $s->startSection('box-right');
            ff_load_section_options('animation-block', $s );
            $s->addElement(ffOneElement::TYPE_NEW_LINE);

            $s->addOption(ffOneOption::TYPE_ICON, 'icon', 'Icon', '');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Developement');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'url', 'Url', '#');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXTAREA, 'description', 'Description', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->endSection();

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );



    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# BOXES WITH ICONS END
################################################################################

