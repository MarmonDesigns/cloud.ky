<?php
/**********************************************************************************************************************/
/* Blog Classic Archive
/**********************************************************************************************************************/
/** @var ffOneStructure $s  */
$s->startSection('portfolio-archive-filterable-2', ffOneSection::TYPE_REPEATABLE_VARIATION)
	->addParam('section-name', 'Portfolio Archive Filterable 2')
	->addParam('hide-default', true)

    ->addParam('advanced-picker-menu-title', 'Portfolio')
    ->addParam('advanced-picker-menu-id', 'portfolio')
	->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('portfolio-archive-filterable-2'));


	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('portfolio-archive-filterable-2').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->startSection('section-settings-sortable');
            ff_load_section_options( 'section-settings-block', $s, array('title'=>'Section Options Sortable panel'));
        $s->endSection();

        $s->startSection('section-settings-portfolio');
            ff_load_section_options( 'section-settings-block', $s, array('title'=>'Section Options Portfolio'));
        $s->endSection();


		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Featured Image');
            $s->startSection('featured-image');

                $s->addOption(ffOneOption::TYPE_SELECT, 'link', 'Link points to', 'lightbox')
                    ->addSelectValue('Specified in portfolio single (item or external link)', 'button')
                    ->addSelectValue('Nowhere', 'nowhere')
                    ;
                $s->addElement( ffOneElement::TYPE_NEW_LINE );


                $s->addOption( ffOneOption::TYPE_CHECKBOX, 'resize', 'Resize featured image?', 1);
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addElement(ffOneElement::TYPE_DESCRIPTION, 'd', 'Original size is 360x240 px');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption( ffOneOption::TYPE_TEXT, 'width', 'Width (px)', 360);
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption( ffOneOption::TYPE_TEXT, 'height', 'Height (px)', 240);
                $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->endSection();

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');

            $s->addOption( ffOneOption::TYPE_TEXT, 'number-of-posts', 'Number of posts', 0);
            $s->addElement( ffOneElement::TYPE_DESCRIPTION,'', 'Leave 0 for show all posts. Adjust better via Fresh Custom Loops plugin (delivered with this theme for free) ');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-filterable', 'Show Filterable panel', 1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_CHECKBOX, 'nospace', 'Items have padding', 1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_TEXT, 'trans-button-all', 'All the work (tag filter button)', 'All the work');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_SELECT, 'number-of-columns', 'Number of columns', '3')
                ->addSelectNumberRange(1,8)
                ;
            $s->addElement( ffOneElement::TYPE_NEW_LINE );


		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Categories');
            ff_load_section_options('loop-influence-portfolio-block', $s );
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Pagination');
            ff_load_section_options('pagination-block', $s );
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );



	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();
