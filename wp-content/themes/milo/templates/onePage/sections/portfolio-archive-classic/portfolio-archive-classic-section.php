<?php
/**********************************************************************************************************************/
/* Blog Classic Archive
/**********************************************************************************************************************/
/** @var ffOneStructure $s  */
$s->startSection('portfolio-archive-classic', ffOneSection::TYPE_REPEATABLE_VARIATION)
	->addParam('section-name', 'Portfolio Archive Classic')
	->addParam('hide-default', true)

    ->addParam('advanced-picker-menu-title', 'Portfolio')
    ->addParam('advanced-picker-menu-id', 'portfolio')
	->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('portfolio-archive-classic'));


	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('portfolio-archive-classic').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
//
//		ff_load_section_options( '/templates/onePage/blocks/section-settings-block.php', $s);
//
//		ff_load_section_options( '/templates/onePage/blocks/section-background-block.php', $s);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Featured Image');
            $s->startSection('featured-image');

                $s->addOption(ffOneOption::TYPE_SELECT, 'link', 'Image points to', 'lightbox')
                    ->addSelectValue('Lightbox', 'lightbox')
                    ->addSelectValue('Same value as button', 'button')
                    ->addSelectValue('Nowhere', 'nowhere')
                    ;
                $s->addElement( ffOneElement::TYPE_NEW_LINE );


                $s->addOption( ffOneOption::TYPE_CHECKBOX, 'resize', 'Resize featurd image?', 1);
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addElement(ffOneElement::TYPE_DESCRIPTION, 'd', 'Original size is 533x300 px');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption( ffOneOption::TYPE_TEXT, 'width', 'Width (px)', 533);
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption( ffOneOption::TYPE_TEXT, 'height', 'Height (px)', 300);
                $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->endSection();

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');

            $s->addOption( ffOneOption::TYPE_TEXT, 'date-format', 'Date Format', 'd F Y');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );


            $s->addOption(ffOneOption::TYPE_CHECKBOX, 'readmore-show', 'Show Read More', 1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_TEXT, 'readmore-trans', 'Read More', 'Continue Reading');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Pagination');
            ff_load_section_options('pagination-block', $s );
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );



	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();
