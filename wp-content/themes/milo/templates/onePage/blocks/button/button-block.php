<?php
$s->startSection('button');
//	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Button Link');

		$s->addOption( ffOneOption::TYPE_TEXT, 'title', 'Title', 'Follow the project');
		$s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addOption( ffOneOption::TYPE_TEXT, 'url', 'URL', '#');
		$s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addOption(ffOneOption::TYPE_SELECT, 'target', 'Open in', '_blank')
			->addSelectValue('Same Window', '')
			->addSelectValue('New Window', '_blank')
		;

//	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
//
//	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Button Style');

        $s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addOption( ffOneOption::TYPE_CHECKBOX, 'use-icon', 'Use icon &nbsp; ', 0);
		$s->addOption( ffOneOption::TYPE_ICON, 'icon', '', '');

//	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
$s->endSection();







