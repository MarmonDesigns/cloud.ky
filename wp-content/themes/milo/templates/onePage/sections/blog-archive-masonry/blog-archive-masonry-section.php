<?php
/**********************************************************************************************************************/
/* Blog Archive Masonry
/**********************************************************************************************************************/
/** @var ffOneStructure $s  */
$s->startSection('blog-archive-masonry', ffOneSection::TYPE_REPEATABLE_VARIATION)
	->addParam('section-name', 'Blog Archive Masonry')
	->addParam('hide-default', true)

	->addParam('advanced-picker-menu-title', 'Blog')
	->addParam('advanced-picker-menu-id', 'blog')
	->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('blog-archive-masonry'));


	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('blog-archive-masonry').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        ff_load_section_options( 'section-settings-block', $s );
//
//		ff_load_section_options( '/templates/onePage/blocks/section-settings-block.php', $s);
//
//		ff_load_section_options( '/templates/onePage/blocks/section-background-block.php', $s);

        ff_load_section_options( 'blog-meta-block', $s);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');

            $s->addOption(ffOneOption::TYPE_SELECT, 'number-of-columns', 'Number of columns', 3)
                ->addSelectNumberRange(1,5)
                ;
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_TEXT, 'number-of-posts', 'Number of posts', '0');
            $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Set how many posts should be rendered. This does not influence WP loop (use our Fresh Custom Loops plugin for that)');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption(ffOneOption::TYPE_CHECKBOX, 'readmore-show', 'Show Read More', 1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_TEXT, 'readmore-trans', 'Read More', 'Read More');
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Categories');
            ff_load_section_options('loop-influence-post-block', $s );
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Pagination');
            ff_load_section_options('pagination-block', $s );
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );



	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();
