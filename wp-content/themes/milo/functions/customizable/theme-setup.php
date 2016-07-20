<?php


if( !function_exists('ff_theme_setup') ) {
    add_action( 'after_setup_theme', 'ff_theme_setup' );
    function ff_theme_setup() {
        register_nav_menus(
            array(
                'main-nav' => __( 'Main Navigation', '' ),
            )
        );
    }
}

if( !function_exists('ff_theme_support') ) {
    function ff_theme_support() {
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-formats', array(
        // 'aside',
        'gallery',
        // 'link',
        'image',
        // 'quote',
        // 'status',
        'video',
        // 'audio',
        // 'chat',
        ) );

        add_theme_support('title-tag');
    }
    ff_theme_support();
}


if( !function_exists('ff_handle_featured_areas') ) {
    function ff_handle_featured_areas() {
        locate_template('templates/helpers/class.ff_Featured_Area.php', true, true);
        locate_template('templates/helpers/func.ff_Gallery.php', true, true);

        add_filter('wp_audio_shortcode_override', array('ff_Featured_Area', 'actionHijackFeaturedShortcode' ), 10, 2);
        add_filter('post_playlist',     array('ff_Featured_Area', 'actionHijackFeaturedShortcode' ), 10, 2);
        add_filter('embed_oembed_html', array('ff_Featured_Area', 'actionHijackFeaturedShortcode' ), 10, 2);
        add_filter('post_gallery',      array('ff_Featured_Area', 'actionHijackFeaturedShortcode' ), 10, 2);
    }
    ff_handle_featured_areas();
}