<?php

/** @var $s ffOneStructure */
################################################################################
# STEPS START
################################################################################
$s->startSection('steps', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Steps')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('steps'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('steps').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        ff_load_section_options('section-settings-block', $s );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Steps');
        $s->startSection('steps', ffOneSection::TYPE_REPEATABLE_VARIABLE);
            $s->startSection('one-step', ffOneSection::TYPE_REPEATABLE_VARIATION)
                ->addParam('section-name', 'One step');
            $s->addOption(ffOneOption::TYPE_ICON, 'icon', 'Icon', '');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_TEXT, 'description', 'Description', 'Land project');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->endSection();
        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# STEPS END
################################################################################


