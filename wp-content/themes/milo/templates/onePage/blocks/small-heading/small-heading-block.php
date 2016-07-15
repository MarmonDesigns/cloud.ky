<?php
$s->startSection('small-heading');
	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Small Heading');

		$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-whole', 'Show Headings', 1);
		$s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-title', 'Show Title &nbsp; ', 1);
		$s->addOption( ffOneOption::TYPE_TEXT, 'title', '', 'Our Services');
		$s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-description', 'Show Description', 1);
		$s->addElement( ffOneElement::TYPE_NEW_LINE );
		$s->addOption( ffOneOption::TYPE_SELECT, 'description-style', 'Description style', 'lead')
				->addSelectValue('Smaller', '')
				->addSelectValue('Bigger', 'lead');

		$s->addElement( ffOneElement::TYPE_NEW_LINE );
		$s->addOption( ffOneOption::TYPE_TEXTAREA, 'description', '', 'Lorem ipsum veniam adipisicing cupidatat dolor do adipisicing commodo');
		$s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-points', 'Show points', 1);
		$s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addOption( ffOneOption::TYPE_SELECT, 'text-align', 'Heading align', 'text-center')
				->addSelectValue('Left', '')
				->addSelectValue('Center', 'text-center')
				->addSelectValue('Right', 'text-right')
				->addSelectValue('Justify', 'text-justify');

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
$s->endSection();