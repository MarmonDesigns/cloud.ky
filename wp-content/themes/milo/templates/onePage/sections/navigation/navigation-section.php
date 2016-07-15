<?php


################################################################################
# NAVIGATION START
################################################################################
$s->startSection('navigation', ffOneSection::TYPE_REPEATABLE_VARIATION)
	->addParam('section-name', 'Header - Logo and Menu')
	->addParam('hide-default', true)

	->addParam('advanced-picker-menu-title', 'Header')
	->addParam('advanced-picker-menu-id', 'header')
	->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('navigation'));


	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('navigation').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->startSection('header-backgrounds');
            ff_load_section_options( 'section-settings-block', $s );
        $s->endSection();

		$s->startSection('logo');

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Desktop Logo');
                    $s->addOption( ffOneOption::TYPE_IMAGE, 'image', 'Desktop Logo' );
					$s->addElement( ffOneElement::TYPE_NEW_LINE );
					$s->addOption( ffOneOption::TYPE_CHECKBOX, 'is_retina', 'This logo image is in retina resolution', 1);
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

			$s->startSection('tablet');
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Tablet Logo');
					$s->addOption( ffOneOption::TYPE_IMAGE, 'image', 'Tablet Logo' );
					$s->addElement( ffOneElement::TYPE_NEW_LINE );
					$s->addOption( ffOneOption::TYPE_CHECKBOX, 'is_retina', 'This logo image is in retina resolution', 1);
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->endSection();
			$s->startSection('phone');
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Phone Logo');
					$s->addOption( ffOneOption::TYPE_IMAGE, 'image', 'Phone Logo' );
					$s->addElement( ffOneElement::TYPE_NEW_LINE );
					$s->addOption( ffOneOption::TYPE_CHECKBOX, 'is_retina', 'This logo image is in retina resolution', 1);
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->endSection();
		$s->endSection();

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');

			$s->addOption( ffOneOption::TYPE_NAVIGATION_MENU_SELECTOR, 'navigation-menu-id', 'Navigation Menu');

            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_SELECT, 'color-type', 'Submenu Background Color ', '')
                ->addSelectValue('Light', '')
                ->addSelectValue('Dark', 'dark' )
            ;

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Search');
			$s->startSection('search');
				$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show', 'Show', 0);
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addOption( ffOneOption::TYPE_TEXT, 'placeholder', 'Placeholder', 'Enter your keyword here and then press enter...');
			$s->endSection();

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# NAVIGATION END
################################################################################
