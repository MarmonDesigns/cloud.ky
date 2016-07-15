<?php

if( !function_exists('ff_get_font_selectors') ) {
    function ff_get_font_selectors($font)
    {
        switch ($font) {
            case 'body'   :
                return 'html, body';
            case 'headers':
                return 'h1, h2, h3, h4, h5, h6';
            case 'inputs' :
                return 'button, input, select, textarea';
            case 'code'   :
                return 'code, kbd, pre, samp';
        }
        return '';
    }
}