<?php

/** @var $s ffOneStructure */
################################################################################
# SERVICE WITHOUT NUMBERS START
################################################################################
$s->startSection('services-without-numbers', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Services without numbers')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('services-without-numbers'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
        $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('services-without-numbers').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    ff_load_section_options( 'section-settings-block', $s );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Numbered services');
        $s->startSection('numbered-services', ffOneSection::TYPE_REPEATABLE_VARIABLE);
            $s->startSection('one-service', ffOneSection::TYPE_REPEATABLE_VARIATION)
                ->addParam('section-name', 'One service');

                ff_load_section_options( 'bootstrap-columns-block', $s, array('sm'=>4));

                $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Retina Ready');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);

                $s->addOption(ffOneOption::TYPE_TEXT, 'link', 'Link', '#');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);

                $s->addOption(ffOneOption::TYPE_TEXT, 'subtitle', 'Subtitle', 'Nice & Clean');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);
                $s->addOption(ffOneOption::TYPE_TEXTAREA, 'description', 'Description', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam remaperiam, eaque ipsa.');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);

            $s->endSection();
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# SERVICE WITHOUT NUMBERS END
################################################################################