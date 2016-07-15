<?php


if( !function_exists('ff_theme_register_sidebars') ) {
    function ff_theme_register_sidebars()
    {
        if (!function_exists('register_sidebar')) {
            return;
        }

        register_sidebar(array(
            'name' => 'Content Sidebar',
            'id' => 'sidebar-content',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        ));

        $numberOfFooterSidebars = 4;
        for ($i = 1; $i <= 4; $i++) {
            register_sidebar(array(
                'name' => 'Footer Sidebar #' .  $i,
                'id' => 'sidebar-footer-' .  $i,
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            ));
        }
    }

    add_action('widgets_init', 'ff_theme_register_sidebars');
}