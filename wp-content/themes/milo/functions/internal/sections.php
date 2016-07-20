<?php

if( !function_exists('ff_load_section_options') ) {
    function ff_load_section_options( $sectionName, ffOneStructure $s, $params = array() ) {

        $relativePath = ff_get_section_path( $sectionName );
        if( $relativePath == null ) {
            throw new ffException('Cannot load section options for :'.ff_wp_kses( $sectionName) );
        }


        ff_load_nonstandard_section_options( $relativePath, $s, $params );
    }
}

if( !function_exists('ff_load_nonstandard_section_options') ) {
    function ff_load_nonstandard_section_options( $relativePath, ffOneStructure $s, $params = array() ) {
        $fileSystem = ffContainer()->getFileSystem();
        $absolutePath = $fileSystem->locateFileInChildTheme($relativePath);

        if( $fileSystem->fileExists( $absolutePath) ) {
            require $absolutePath;
        } else {
            throw new Exception('Failed to include section:'.  $relativePath);
        }
    }
}

if( !function_exists('ff_get_section_path') ) {
    function ff_get_section_path($sectionName)
    {

        $sectionNameClean = str_replace('-section', '', $sectionName);
        $sectionNameClean = str_replace('-block', '', $sectionNameClean);

        $fileSystem = ffContainer()->getFileSystem();
        $relativePathSection = '/templates/onePage/sections/' .  $sectionNameClean . '/' .  $sectionName . '.php';

        $absolutePathSection = get_template_directory() .  $relativePathSection;

        if ($fileSystem->fileExists($absolutePathSection)) {
            return $relativePathSection;
        }


        $relativePathSection = '/templates/onePage/blocks/' .  $sectionNameClean . '/' .  $sectionName . '.php';

        $absolutePathSection = get_template_directory() .  $relativePathSection;

        if ($fileSystem->fileExists($absolutePathSection)) {
            return $relativePathSection;
        }


        $relativePathSection = '/templates/onePage/attrs/' .  $sectionNameClean . '/' .  $sectionName . '.php';

        $absolutePathSection = get_template_directory() .  $relativePathSection;

        if ($fileSystem->fileExists($absolutePathSection)) {
            return $relativePathSection;
        }
    }
}




if( !function_exists('ff_load_section_printer') ) {
    function ff_load_section_printer($sectionName, ffOptionsQuery $query, $params = array(), $isFirstLevel = false)
    {

        //loop-influence-portfolio-block
        $fileSystem = ffContainer()->getFileSystem();

        $relativePath = ff_get_section_path($sectionName);


        $absolutePath = $fileSystem->locateFileInChildTheme($relativePath);

        if ($query->queryExists('section-settings') && $isFirstLevel) {
            ff_print_before_section($query->get('section-settings'));
        }

        if (($query->queryExists('loop-influence-portfolio-block') || $query->queryExists('loop-influence-post-block')) && !is_search() && !is_archive() && !( is_home() && is_front_page() ) ) {

            if ($query->queryExists('loop-influence-portfolio-block')) {
                $taxonomyIds = $query->get('loop-influence-portfolio-block')->getMultipleSelect('categories');
                $taxType = 'ff-portfolio-category';
                $postType = 'portfolio';
            } else {
                $taxonomyIds = $query->get('loop-influence-post-block')->getMultipleSelect('categories');
                $postType = 'post';
                $taxType = 'category';
            }
            $args = array(
                'post_type' => $postType
            );

            $taxonomies = $taxonomyIds;

            if (1 == count($taxonomies)) {
                if (isSet($taxonomies[0]) and empty($taxonomies[0])) {
                    $taxonomies = null;
                }
            }

            if (!empty($taxonomies)) {

                $args['tax_query'] = array();
                if (1 < count($taxonomies)) {
                    $args['tax_query']['relation'] = 'OR';
                }

                foreach ($taxonomies as $tax_ID) {
                    $args['tax_query'][] = array(
                        'taxonomy' => $taxType,
                        'field' => 'id',
                        'terms' => absint($tax_ID),
                    );
                }
            }

            global $wp_query;
            $backuped_main_query = clone $wp_query;


            $wp_query = new WP_Query($args);
        }

        if ($fileSystem->fileExists($absolutePath)) {
            require $absolutePath;
        } else {
            throw new Exception('Failed to include section:' .  $relativePath);
        }

        // if( ($query->queryExists('loop-influence-portfolio-block') || $query->queryExists('loop-influence-post-block')) && !is_archive() ) {
        if (!empty($backuped_main_query)) {
            global $wp_query;
            $wp_query = $backuped_main_query;
        }
        if ($query->queryExists('section-settings') && $isFirstLevel) {
            ff_print_after_section($query->get('section-settings'));
        }

        if (isset($dataToReturn)) {
            return $dataToReturn;
        }

        return null;
    }
}

if( !function_exists('ff_print_after_section') ) {
    function ff_print_after_section($query)
    {
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}


if( !function_exists('ff_print_before_section') ) {
    function ff_print_before_section(ffOptionsQuery $query)
    {

        /**********************************************************************************************************************/
        /* FULLWIDTH SECTION SETTINGS
        /**********************************************************************************************************************/
        $general = $query->get('general');
        $boxed = $query->get('boxed');
        $container = $query->get('container');


        // html ID
        $id = '';
        if ($general->get('id') != '') {
            $id = 'id="' .  $general->get('id') . '"';
        }

        $colorClass = '';
        if ($general->get('color-type') == 'dark') {
            $colorClass = ' full-section';
        }

        $fullscreenClass = '';
        if ($container->get('is-fulscreen')) {
            $fullscreenClass = ' full-screen';
        }

        $fullwidth = $query->get('fullwidth');

        $style = array();
        $styleString = '';
        if ($fullwidth->get('apply')) {
            if ($fullwidth->get('padding-top') != 'default') {
                $style[] = 'padding-top:' . absint( $fullwidth->get('padding-top') ) . 'px;';
            }

            if ($fullwidth->get('padding-bottom') != 'default') {
                $style[] = 'padding-bottom:' . absint( $fullwidth->get('padding-bottom') ) . 'px;';
            }

            if ($fullwidth->get('margin-top') != 'default') {
                $style[] = 'margin-top:' . absint( $fullwidth->get('margin-top') ) . 'px;';
            }

            if ($fullwidth->get('margin-bottom') != 'default') {
                $style[] = 'margin-bottom:' . absint( $fullwidth->get('margin-bottom') ) . 'px;';
            }
        }

        if (!empty($style)) {
            $styleString = 'style="' . esc_attr( implode(' ', $style) ) . '"';
        }


        echo '<div class="ff-section-fullwidth' . esc_attr( $colorClass .  $fullscreenClass ) . '" ' .  $styleString . ' ' .  $id . '>';

        if ($fullwidth->get('apply')) {
            ff_load_section_printer(
                'section-background'
                , $fullwidth->get('background')
            );
        }

        /**********************************************************************************************************************/
        /* BOXED
        /**********************************************************************************************************************/

        $style = array();
        $styleString = '';
        if ($boxed->get('apply')) {

            if ($boxed->get('width-type') == 'from-input') {
                if ($boxed->get('maxwidth') != '') {
                    $style[] = 'max-width:' . absint( $boxed->get('maxwidth') ) . 'px;';
                }
            } else {
                $style[] = 'max-width:none;';
            }

            if ($boxed->get('padding-top') != 'default') {
                $style[] = 'padding-top:' . absint( $boxed->get('padding-top') ) . 'px;';
            }

            if ($boxed->get('padding-bottom') != 'default') {
                $style[] = 'padding-bottom:' . absint( $boxed->get('padding-bottom') ) . 'px;';
            }
        }

        $fullscreenClass = '';
        if ($container->get('is-fulscreen')) {
            $fullscreenClass = ' full-section-content';
        }

        if (!empty($style)) {
            $styleString = 'style="' . esc_attr( implode(' ', $style) ) . '"';
        }
        echo '<div class="ff-section-boxed' . esc_attr( $fullscreenClass ) . '" ' .  $styleString . '>';

        if ($fullwidth->get('apply')) {
            ff_load_section_printer(
                'section-background'
                , $boxed->get('background')
            );
        }

        /**********************************************************************************************************************/
        /* CONTAINER
        /**********************************************************************************************************************/

        $class = 'container';

        if ($container->get('apply')) {
            if ($container->get('type') == 'not') {
                $class = 'container';
            } else if ($container->get('type') == 'fluid') {
                $class = 'container-fluid';
            } else if ($container->get('type') == 'fullwidth') {
                $class = 'container-fullwidth';
            }
        }

        if ($container->get('apply') && $container->get('type') == 'fluid') {
            $class = 'container-fluid';
        }

        echo '<div class="' . esc_attr( $class ) . '">';
    }
}


if( !function_exists('ff_get_section_preview_image_url') ) {
    function ff_get_section_preview_image_url($name)
    {
        // return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        return get_template_directory_uri() . '/templates/onePage/sections/' .  $name . '/' .  $name . '.jpg';
    }
}

if( !function_exists('ff_get_section_inside_preview_image_url') ) {
    function ff_get_section_inside_preview_image_url($name)
    {
        return get_template_directory_uri() . '/templates/onePage/sections/' .  $name . '/' .  $name . '.jpg';
    }
}

if( !function_exists('ff_get_section_options_dir') ) {
    function ff_get_section_options_dir()
    {
        return get_template_directory() . '/framework/components/sectionOptions.php';
    }
}

if( !function_exists('ff_get_section_home_options_dir') ) {
    function ff_get_section_home_options_dir()
    {
        return get_template_directory() . '/framework/components/sectionHomeOptions.php';
    }
}