<?php
/**********************************************************************************************************************/
/* LAYOUT FUNCTIONALITY INITIALISATION
/**********************************************************************************************************************/
if( !function_exists('ff_init_layouts') ) {
    function ff_init_layouts()
    {
        $layoutManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getThemeLayoutManager();

        $layoutManager->setThemeName(ffThemeContainer::THEME_NAME_LOW);
        $layoutManager->setLayoutsOptionsHolderClassName('ffComponent_Theme_LayoutOptions');
        $layoutManager->addLayoutSupport();

        ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutPrinter()->setPrintSectionCallback('ff_print_section_callback');
        ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutPrinter()->setCallbackForEmptyPosition('ff_print_empty_section_callback');
    }
    ff_init_layouts();
}

if( !function_exists('ff_print_section_callback') ) {
    function ff_print_section_callback($section, $variation)
    {
//	    ffContainer()->getThemeFrameworkFactory()->getThemeAssetsIncluder()->addPrintedSection();
	    ffContainer()->getThemeFrameworkFactory()->getThemeAssetsIncluder()->addPrintedSectionMiloAssets( $variation );
        ff_load_section_printer($variation, $section, array(), true);
    }
}

/**
 * Load default data for section settings, then return these default data as array or something
 */
if( !function_exists('ff_print_empty_section_callback') ) {
    function ff_print_empty_section_callback($placement)
    {

        $defaultDataFileName = null;
        switch( $placement ) {
            case 'header':
                    if( ffThemeOptions::getQuery('layout default header') ) {
                        $defaultDataFileName = 'header';
                    }
                break;
            case 'content':
                if( ffThemeOptions::getQuery('layout default content') ) {
                    if (is_404() ) {
                        $defaultDataFileName = 'content-404';
                    } else if( is_search() && !have_posts() ) {
                        $defaultDataFileName = 'content-blog-classic';
                    } else if (is_category() || is_tag() || is_home() || is_date() || is_search() || is_author()) {
                        $defaultDataFileName = 'content-blog-classic';
                    } else if (is_single()) {
                        $defaultDataFileName = 'content-blog-single';
                    } else if (is_tax('ff-portfolio-category') || is_tax('ff-portfolio-tag')) {
                        $defaultDataFileName = 'content-portfolio-classic';
                    }
                }
                break;
            case 'footer':
                if( ffThemeOptions::getQuery('layout default footer') ) {
                   $defaultDataFileName = 'footer';
                }
                break;
        }


        if( $defaultDataFileName != null ) {
            require get_template_directory().'/default_section_data/'.  $defaultDataFileName. '.php';
            return $data;
        }

        return null;
    }
}
