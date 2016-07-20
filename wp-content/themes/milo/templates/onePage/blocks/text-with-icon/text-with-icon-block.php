<?php

$s->addElement( ffOneElement::TYPE_TABLE_START );
	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Icon');

		$s->addOption( ffOneOption::TYPE_ICON, 'icon', '', '');
		$s->addElement( ffOneElement::TYPE_NEW_LINE );

		ff_load_section_options(
			'color-attr',
			$s, array(
				'name' => 'icon-background'
				, 'title' => 'Background'
				, 'default' => 'blue'
		));

		$s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addOption( ffOneOption::TYPE_SELECT, 'icon-size', 'Size', '')
				->addSelectValue( 'Small' , 'small' )
				->addSelectValue( 'Default' , '' )
				->addSelectValue( 'Medium' , 'medium' )
				->addSelectValue( 'Large' , 'large' )
			;

		$s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addOption( ffOneOption::TYPE_SELECT, 'shape', 'Shape', 'circle')
				->addSelectValue( 'No Shape, just icon' , '' )
				->addSelectValue( 'Circle' , 'circle' )
				->addSelectValue( 'Square' , 'square' )
			;

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Text');

		$s->addOption( ffOneOption::TYPE_TEXT, 'title', 'Title', 'Global Company')
			->addParam('class', 'edit-repeatable-item-title');
		$s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addOption( ffOneOption::TYPE_SELECT, 'title-size', 'Title Size', '4')
				->addSelectValue( 'Small h5' , '5' )
				->addSelectValue( 'Default h4' , '4' )
				->addSelectValue( 'Medium h3' , '3' )
				->addSelectValue( 'Large h2' , '2' )
			;

		$s->addOption( ffOneOption::TYPE_TEXTAREA, 'description', 'Description', 'Lorem ipsum Eu tempor anim Excepteur consectetur cillum tempor id exercitation nostrud do consequat sunt in consectetur commodo in exercitation.' );

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Button');
		$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-button', 'Show button', 1);
	$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


	ff_load_section_options( 'button-block', $s);

$s->addElement( ffOneElement::TYPE_TABLE_END );

