<?php
/** @var ffOneStructure $s */


//$s->startSection('general');
	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');

		$s->addOption( ffOneOption::TYPE_TEXT, 'id', 'Section ID ', '' );
		$s->addElement( ffOneElement::TYPE_HTML, '', ' <span class="description">Option is used for linking. Leave blank for no ID.</span>');
		$s->addElement( ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_CHECKBOX, 'fullwidth', 'Fullwidth', 1);
        $s->addElement( ffOneElement::TYPE_NEW_LINE );
		$s->addOption( ffOneOption::TYPE_SELECT, 'color-type', 'Color type', 'light')
			->addSelectValue('Light BG / Dark text', 'light')
			->addSelectValue('Dark BG / Light text', 'dark')
			;
        $s->addElement( ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_SELECT, 'padding-top', 'Padding top (px)', 'default')
            ->addSelectValue('Default', 'default')
            ->addSelectNumberRange(0, 250, 5)
            ;

        $s->addElement( ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_SELECT, 'padding-bottom', 'Padding bottom (px)', 'default')
            ->addSelectValue('Default', 'default')
            ->addSelectNumberRange(0, 250, 5)
            ;
        $s->addElement( ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_SELECT, 'margin-top', 'Margin top (px)', 'default')
            ->addSelectValue('Default', 'default')
            ->addSelectNumberRange(0, 250, 5)
            ;
        $s->addElement( ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_SELECT, 'margin-bottom', 'Margin bottom (px)', 'default')
            ->addSelectValue('Default', 'default')
            ->addSelectNumberRange(0, 250, 5)
            ;
        $s->addElement( ffOneElement::TYPE_NEW_LINE );

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
//$s->endSection();