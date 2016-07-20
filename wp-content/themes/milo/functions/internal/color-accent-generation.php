<?php

if( !function_exists('ff_get_color_accent_file_content') ) {
    function ff_get_color_accent_file_content() {
        $colorAccentCSSFilePath = get_template_directory() .'/assets/css/colors-accent.css';

        $fileSystem = ffContainer()->getFileSystem();

        if( !$fileSystem->fileExists( $colorAccentCSSFilePath ) ) {
            throw new ffException('MILO - requesting color accent file, but it does not exists');
        }

        $fileContent = $fileSystem->getContents( $colorAccentCSSFilePath );

        return $fileContent;
    }
}

if( !function_exists('ff_generate_and_print_color_accent') ) {
    function ff_generate_and_print_color_accent()
    {
        $defaultAccentColorString = '#bca480';


        $useAccent = ffThemeOptions::getQuery('layout use-picker');
        if( !$useAccent ) {
            return false;
        }

        // new color in format #aabbcc
        $colorHEX = ffThemeOptions::getQuery('layout color');

        // caching for directory wp-content/uploads/freshframework/ NAMESPACE / VALUE . EXTENSION
        $dataStorageCache = ffContainer()->getInstance()->getDataStorageCache();

        // #aabbcc -> aabbcc
        $colorWithoutHex = str_replace('#', '', $colorHEX );

        $optionName = 'accent-'.esc_attr( $colorWithoutHex );

        if( !$dataStorageCache->optionExists('milo_accents', $optionName, 'css') ) {

            $dataStorageCache->deleteOldFilesInNamespace('milo_accents', 60*60*24*7, 60*60*24*3);

            // with #bca480
            $colorAccentFileContent = ff_get_color_accent_file_content();

            $newColorAccentFile = str_replace( $defaultAccentColorString, $colorHEX, $colorAccentFileContent );

            $dataStorageCache->setOption('milo_accents', $optionName, $newColorAccentFile, 'css');
        }

        $accentUrl = $dataStorageCache->getOptionUrl('milo_accents', $optionName, 'css');

        wp_enqueue_style('ff-milo-color-accent', $accentUrl );



    }
    add_action('wp_enqueue_scripts', 'ff_generate_and_print_color_accent', 99);
}
