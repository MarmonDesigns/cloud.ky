<?php
################################################################################
# PAGE START
################################################################################

$s->startSection('page', ffOneSection::TYPE_REPEATABLE_VARIATION)
	->addParam('section-name', 'Page')
	->addParam('hide-default', true)

	->addParam('advanced-picker-menu-title', 'Special')
	->addParam('advanced-picker-menu-id', 'special')
	->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('page'));


	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('page').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		// ff_load_section_options( '/templates/onePage/blocks/section-setwkground-block.php', $s);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Page');

			$s->addOption( ffOneOption::TYPE_POST_SELECTOR, 'page', 'Page', '')
				->addParam('type', 'multiple');

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_END );

$s->endSection();

################################################################################
# PAGE END
################################################################################
