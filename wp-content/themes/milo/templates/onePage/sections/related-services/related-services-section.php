<?php

/** @var $s ffOneStructure */
################################################################################
# RELATED SERVICES START
################################################################################
$s->startSection('related-services', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Related services')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('related-services'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
        $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('related-services').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    ff_load_section_options( 'section-settings-block', $s);

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'services');
        $s->startSection('services', ffOneSection::TYPE_REPEATABLE_VARIABLE);
            $s->startSection('one-service', ffOneSection::TYPE_REPEATABLE_VARIATION)
                ->addParam('section-name', 'One service');

            ff_load_section_options('bootstrap-columns-block', $s, array('sm'=>4) );

            $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Retina Ready');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'link', 'Link', '');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'subtitle', 'Subtitle', 'Nice & Clean');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXTAREA, 'description', 'Description', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->endSection();
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# RELATED SERVICES END
################################################################################