<?php

/**********************************************************************************************************************/
/* NOTIFICATION HIDE
/**********************************************************************************************************************/
if( !function_exists('ff_external_plugins_notification_removal') ) {
    function ff_external_plugins_notification_removal() {
        echo '<style>.rs-update-notice-wrap, .vc_license-activation-notice {display:none;}</style>';
    }
    add_action('admin_print_styles', 'ff_external_plugins_notification_removal');
}





