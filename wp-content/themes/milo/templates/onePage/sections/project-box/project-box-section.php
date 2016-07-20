<?php
/** @var $s ffOneStructure */
################################################################################
# PRICING MODELS START
################################################################################
$s->startSection('project-box', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Project box')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('project-box'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('project-box').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        ff_load_section_options( 'section-settings-block', $s );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');
            $s->addOption( ffOneOption::TYPE_IMAGE, 'image', 'Main section image');
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Content');
            $s->startSection('content');
            ff_load_section_options('heading-content-block', $s);
            $s->endSection();
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# PRICING MODELS END
################################################################################
