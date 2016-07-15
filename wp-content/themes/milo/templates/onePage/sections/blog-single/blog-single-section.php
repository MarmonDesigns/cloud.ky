<?php
/**********************************************************************************************************************/
/* Blog Classic Archive
/**********************************************************************************************************************/
/** @var ffOneStructure $s  */
$s->startSection('blog-single', ffOneSection::TYPE_REPEATABLE_VARIATION)
	->addParam('section-name', 'Blog Single')
	->addParam('hide-default', true)

    ->addParam('advanced-picker-menu-title', 'Blog')
    ->addParam('advanced-picker-menu-id', 'blog')
	->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('blog-single'));


	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('blog-single').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
//
//		ff_load_section_options( '/templates/onePage/blocks/section-settings-block.php', $s);
//
//		ff_load_section_options( '/templates/onePage/blocks/section-background-block.php', $s);

        ff_load_section_options( 'blog-meta-block', $s);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Author Box');
            $s->startSection('author-box');
                $s->addOption(ffOneOption::TYPE_CHECKBOX, 'show', 'Show author box', 1);
                $s->addElement(ffOneElement::TYPE_NEW_LINE );

                $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'About the Author');
                $s->addElement(ffOneElement::TYPE_NEW_LINE );

            $s->endSection();
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Sidebar');
                $s->addOption(ffOneOption::TYPE_SELECT, 'sidebar', 'Sidebar', 'right')
                    ->addSelectValue('None', 'none')
                    ->addSelectValue('Left', 'left')
                    ->addSelectValue('Right', 'right')
                ;
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Comments List');
            ff_load_section_options( 'comments-list-block', $s);
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Comments Form');
            ff_load_section_options( 'comments-form-block', $s);
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();
