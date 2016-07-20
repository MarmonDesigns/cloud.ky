<?php

$wrapWithSection = $query->get('wrap-with-section');

if( $wrapWithSection ) {
    ff_print_before_section( $query->get('html-section-settings section-settings' ) );
}

// Special section, that enable user to insert any HTML
echo do_shortcode( $query->get('html') );

if( $wrapWithSection ) {
    ff_print_after_section( $query->get('html-section-settings section-settings' ) );
}
