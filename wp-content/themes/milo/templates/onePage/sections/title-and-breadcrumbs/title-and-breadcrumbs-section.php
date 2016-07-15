<?php

/** @var $s ffOneStructure */
################################################################################
# GENERAL SERVICE START
################################################################################
$s->startSection('title-and-breadcrumbs', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Title and Breadcrumbs')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Header')
    ->addParam('advanced-picker-menu-id', 'header')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('title-and-breadcrumbs'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
    $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('title-and-breadcrumbs').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    // ff_load_section_options( 'section-settings-block', $s );
    $s->startSection('background');
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Color type');
            $s->addOption( ffOneOption::TYPE_SELECT, 'color-type', '', '')
                ->addSelectValue('Light BG / Dark text', '')
                ->addSelectValue('Dark BG / Light text, version #1', 'dark-1' )
                ->addSelectValue('Dark BG / Light text, version #2', 'dark-2' );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addOption( ffOneOption::TYPE_SELECT, 'margin-bottom', 'Margin bottom (px)', 'default')
                ->addSelectValue('Default', 'default')
                ->addSelectValue('0', '0')
                ->addSelectNumberRange(5, 250, 5)
            ;
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Background');
            ff_load_section_options( 'section-background-block', $s);
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
    $s->endSection();

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Title');
        $s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-title', 'Show title', 1);
        $s->addElement( ffOneElement::TYPE_NEW_LINE );

        $s->startSection('translation');

            $s->addOption( ffOneOption::TYPE_TEXT, 'title-front-page', 'Front Page', get_bloginfo('name') );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addOption( ffOneOption::TYPE_TEXT, 'title-posts-page', 'Posts Page', 'Blog' );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addOption( ffOneOption::TYPE_TEXT, 'title-404', '404', '404 Not Found' );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_TEXT, 'title-post', 'Post', '%s' );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addOption( ffOneOption::TYPE_TEXT, 'title-category', 'Category', 'Category %s' );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addOption( ffOneOption::TYPE_TEXT, 'title-tag', 'Tag', 'Tagged as %s' );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_TEXT, 'title-author', 'Author', 'Author %s' );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addOption( ffOneOption::TYPE_TEXT, 'title-search', 'Search', 'Search results for: %s' );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_TEXT, 'title-day', 'Day', 'Day %s' );
            $s->addOption( ffOneOption::TYPE_TEXT, 'title-day-format', 'Day Format', 'F j, Y' );
            $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'For right date format please see <a href="//php.net/manual/en/function.date.php" target="_blank">Date PHP function manual</a>.' );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_TEXT, 'title-month', 'Month', 'Month %s' );
            $s->addOption( ffOneOption::TYPE_TEXT, 'title-month-format', 'Month Format', 'F Y' );
            $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'For right date format please see <a href="//php.net/manual/en/function.date.php" target="_blank">Date PHP function manual</a>.' );
            $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->addOption( ffOneOption::TYPE_TEXT, 'title-year', 'Year', 'Year %s' );
            $s->addOption( ffOneOption::TYPE_TEXT, 'title-year-format', 'Year Format', 'Y' );
            $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'For right date format please see <a href="//php.net/manual/en/function.date.php" target="_blank">Date PHP function manual</a>.' );

        $s->endSection();
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->startSection('breadcrumbs');
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Breadcrumbs');
            $s->addOption( ffOneOption::TYPE_CHECKBOX, 'show', 'Show', 1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->addOption( ffOneOption::TYPE_TEXT, 'homepage', 'Text Homepage', 'Home');
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
    $s->endSection();

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# GENERAL SERVICE END
################################################################################