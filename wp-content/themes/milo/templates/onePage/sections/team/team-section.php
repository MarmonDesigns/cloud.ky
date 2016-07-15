<?php

/** @var $s ffOneStructure */
################################################################################
# TEAM START
################################################################################
$s->startSection('team', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Team')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('team'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('team').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        ff_load_section_options('section-settings-block', $s);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Person');

            $s->startSection('persons', ffOneSection::TYPE_REPEATABLE_VARIABLE);
                $s->startSection('one-person', ffOneSection::TYPE_REPEATABLE_VARIATION)
                    ->addParam('section-name', 'One person');
                    ff_load_section_options('bootstrap-columns-block', $s, array('sm'=>4 ) );

                    $s->addElement(ffOneElement::TYPE_NEW_LINE);
                    $s->addOption(ffOneOption::TYPE_TEXT, 'name', 'Name', 'Alex Andrews');
                    $s->addElement(ffOneElement::TYPE_NEW_LINE);
                    $s->addOption(ffOneOption::TYPE_TEXT, 'position', 'Position', 'founder');
                    $s->addElement(ffOneElement::TYPE_NEW_LINE);
                    $s->addOption(ffOneOption::TYPE_IMAGE, 'image', 'Photo', '');
                    $s->addElement(ffOneElement::TYPE_NEW_LINE);
                    $s->addOption(ffOneOption::TYPE_TEXTAREA, 'social', 'Social links', '');
                $s->endSection();
            $s->endSection();

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# TEAM END
################################################################################
