<?php
/** @var $s ffOneStructure */
################################################################################
# PRICING MODELS START
################################################################################
$s->startSection('heading', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Heading')
    ->addParam('hide-default', false)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('heading'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('heading').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        ff_load_section_options( 'section-settings-block', $s );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');

            $s->startSection('heading');
            ff_load_section_options('heading-wrapped-block', $s);
            $s->endSection();
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# PRICING MODELS END
################################################################################
