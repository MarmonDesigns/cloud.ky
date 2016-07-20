<?php

$s->startSection('buttons-more');
	$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show', 'Show', 1);
	$s->addElement( ffOneElement::TYPE_NEW_LINE );

	$s->addOption( ffOneOption::TYPE_SELECT, 'text-align', 'Buttons block align', 'center')
			->addSelectValue('Default (left)', '')
			->addSelectValue('Center', 'text-center')
			->addSelectValue('Right', 'text-right')
			->addSelectValue('Justify', 'text-justify');
	$s->addElement( ffOneElement::TYPE_NEW_LINE );

	$s->startSection('buttons', ffOneSection::TYPE_REPEATABLE_VARIABLE );
		$s->startSection( 'button', ffOneSection::TYPE_REPEATABLE_VARIATION )->addParam('section-name', 'Button');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				ff_load_section_options( 'button-block', $s);
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$s->endSection();
	$s->endSection();

$s->endSection();
