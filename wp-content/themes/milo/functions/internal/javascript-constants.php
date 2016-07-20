<?php

if( !function_exists('ff_print_js_constants') ) {
    function ff_print_js_constants()
    {
        echo '<script type="text/javascript">';
        echo "\n";
        echo 'var ajaxurl = "' . admin_url('admin-ajax.php') . '";';
        echo "\n";
        echo 'var ff_template_url = "' . get_template_directory_uri() . '";';
        echo "\n";
        echo '</script>';
        echo "\n";
    }
    add_action('wp_head', 'ff_print_js_constants', 1);
}