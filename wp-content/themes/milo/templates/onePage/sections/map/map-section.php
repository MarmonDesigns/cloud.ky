<?php
/** @var $s ffOneStructure */
################################################################################
# PRICING MODELS START
################################################################################
$s->startSection('map', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Map')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('map'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('map').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        ff_load_section_options( 'section-settings-block', $s );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');
            $s->addOption(ffOneOption::TYPE_TEXT, 'address', 'Address', 'San Jose, California, USA');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addOption(ffOneOption::TYPE_TEXT, 'description', 'Description', 'MILO Office');

            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addOption(ffOneOption::TYPE_SELECT, 'zoom', 'Zoom', 11)
                ->addSelectNumberRange(0,20)
                ;

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# PRICING MODELS END
################################################################################
