<?php

if( !function_exists('ff_filter_query_get_icon') ) {
    function ff_filter_query_get_icon( $value ) {
        $replaced = str_replace('ff-font-awesome4 icon-', 'fa fa-', $value);
        return $replaced;
    }
    add_filter( ffConstActions::FILTER_QUERY_GET_ICON, 'ff_filter_query_get_icon');
}

if( !function_exists('ff_filter_get_fonts') ) {
    // enable just few fonts.
    add_filter( 'ff_fonts', ffConstActions::FILTER_GET_FONTS );
    function ff_filter_get_fonts( $fonts ){

        $iconfont = ffThemeOptions::getQuery('iconfont');

        foreach ($fonts as $key => $value) {

            if( 'awesome4' == $key ){
                continue;
            }

            if( 'bootstrap_glyphicons' == $key ){
                continue;
            }

            if( 'awesome4' == $key ){
                continue;
            }

            if( 'miu' == $key ){
                continue;
            }

            if( 'awesome' == $key ){
                unset( $fonts[$key] );
                continue;
            }

            $_name_ = str_replace(' ', '_', $key );
            if( ! $iconfont->queryExists( $_name_ ) ){
                unset( $fonts[$_name_] );
                continue;
            }

            if( $iconfont->get( str_replace(' ', '_', $key ) ) ){
                continue;
            }

            unset( $fonts[$key] );

        }
        return $fonts;
    }
}