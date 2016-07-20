<?php
/** @var $s ffOneStructure */
################################################################################
# NUMBERED SERVICES START
################################################################################
$s->startSection('numbered-services', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Numbered services')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('numbered-services'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
        $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('numbered-services').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    ff_load_section_options( 'section-settings-block', $s );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Numbered services');
        $s->startSection('numbered-services', ffOneSection::TYPE_REPEATABLE_VARIABLE);
            $s->startSection('one-service', ffOneSection::TYPE_REPEATABLE_VARIATION)
                ->addParam('section-name', 'One service');

//                    $s->addElement( ffOneElement::TYPE_TABLE_START );
                    ff_load_section_options( 'bootstrap-columns-block', $s, array('sm'=>3));


//                    $s->addElement( ffOneElement::TYPE_TABLE_END );

                $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Identity');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);
                $s->addOption(ffOneOption::TYPE_TEXTAREA, 'description', 'Description', 'Lorem ipsum dolor sit amet, unde lactus ur elit, sed do eiusmod omis.');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);
                $s->addOption(ffOneOption::TYPE_TEXT, 'link', 'Link', '#');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);
                $s->addOption(ffOneOption::TYPE_TEXT, 'link-text', 'Link Text', 'Read More');

            $s->endSection();
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# NUMBERED SERVICES START
################################################################################