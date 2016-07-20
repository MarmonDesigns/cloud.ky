<?php
/**********************************************************************************************************************/
/* Blog Classic Archive
/**********************************************************************************************************************/
/** @var ffOneStructure $s  */
$s->startSection('blog-archive-classic', ffOneSection::TYPE_REPEATABLE_VARIATION)
	->addParam('section-name', 'Blog Archive Classic')
	->addParam('hide-default', true)

    ->addParam('advanced-picker-menu-title', 'Blog')
    ->addParam('advanced-picker-menu-id', 'blog')
	->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('blog-archive-classic'));


	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('blog-archive-classic').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        ff_load_section_options( 'section-settings-block', $s );
//
//		ff_load_section_options( '/templates/onePage/blocks/section-settings-block.php', $s);
//
//		ff_load_section_options( '/templates/onePage/blocks/section-background-block.php', $s);

        ff_load_section_options( 'blog-meta-block', $s);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');

            $s->addOption(ffOneOption::TYPE_SELECT, 'sidebar', 'Sidebar', 'right')
                ->addSelectValue('None', 'none')
                ->addSelectValue('Left', 'left')
                ->addSelectValue('Right', 'right')
                ;
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_TEXT, 'number-of-posts', 'Number of posts', '0');
            $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Set how many posts should be rendered. This does not influence WP loop (use our Fresh Custom Loops plugin for that)');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption(ffOneOption::TYPE_CHECKBOX, 'readmore-show', 'Show Read More', 1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_TEXT, 'readmore-trans', 'Read More', 'Continue Reading');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Categories');
        ff_load_section_options('loop-influence-post-block', $s );
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Search');
            $s->addOption( ffOneOption::TYPE_TEXTAREA, 'search-not-found', 'Nothing found in search', 'Sorry, but nothing matched your search terms. Please try again with some different keywords.' );
            $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This is applied only if this section is used for search.' );
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Pagination');
            ff_load_section_options('pagination-block', $s );
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_END );




$s->endSection();
