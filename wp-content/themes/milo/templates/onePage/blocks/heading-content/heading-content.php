<?php
    $query = $query->get('heading-content-block');
    foreach( $query->get('content') as $oneContent ) {
        $type = $oneContent->getVariationType();

        if( $type == 'one-line' ) {
            $tagType = $oneContent->get('type');
            $text = $oneContent->get('text');

            if( $tagType == 'br' ) {
                echo '<br/>';
            } else {
                echo '<'.esc_attr( $tagType );
                $animation = $oneContent->get('animation type');
                if( ! empty( $animation ) ){
                    echo ' class="wow ' . esc_attr( $animation ) . ' animated"';
                }
                echo '>'.ff_wp_kses( $text ).'</'.esc_attr( $tagType ).'>';
            }
        } else if( $type == 'one-button' ) {
            echo '<p';
            $animation = $oneContent->get('animation type');
            if( ! empty( $animation ) ){
                echo ' class="wow ' . esc_attr( $animation ) . ' animated"';
            }
            echo '>';
            ff_load_section_printer(
                'button'
                , $oneContent
            );
            echo '</p>';
        } else if( $type == 'one-html') {
            echo do_shortcode( $oneContent->get('html') );
        } else if( $type == 'one-icon') {
            $icon = $oneContent->get('icon');
            if( empty( $icon ) ){
                continue;
            }
            echo '<i class="'.esc_attr( $icon ).'"></i>';
        }
    }
?>