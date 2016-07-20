<?php

if( !function_exists('ff_boostrap_grid_translator')) {
    function ff_boostrap_grid_translator($numberOfParts)
    {
        return (int)(12 / $numberOfParts);
    }
}

if( !function_exists('ff_boostrap_grid_translator')) {
    function ff_boostrap_grid_translator()
    {
        global $post;
        if (strpos($post->post_content, '<!--more-->') === false) {
            return false;
        } else {
            return true;
        }
    }
}

if( !class_exists( 'ffTemporaryQueryHolder' ) ) {
    class ffTemporaryQueryHolder
    {
        private static $_queries = array();

        public static function setQuery($name, $query)
        {
            self::$_queries[$name] = $query;
        }

        public static function getQuery($name)
        {
            if (isset(self::$_queries[$name])) {
                return self::$_queries[$name];
            } else {
                return null;
            }
        }

        public static function deleteQuery($name)
        {
            unset(self::$_queries[$name]);
        }
    }
}

if( !function_exists('ff_get_all_portfolio_tags')) {
    function ff_get_all_portfolio_tags($numberOfPosts = 0)
    {
        $portfolioTagsArray = array();

        $postCounter = 0;
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                $postCounter++;

                if ($numberOfPosts > 0 && $postCounter > $numberOfPosts) {
                    break;
                }


                global $post;
                $t = wp_get_post_terms($post->ID, 'ff-portfolio-tag');
                if (!empty($t)) foreach ($t as $onePortfolioTag) {
                    $portfolioTagsArray[$onePortfolioTag->slug] = $onePortfolioTag;
                }
            }
        }
        rewind_posts();
        // Escaped HTML with tags
        return $portfolioTagsArray;
    }
}

if( !function_exists('ff_get_all_tags_for_one_portfolio_item')) {
    function ff_get_all_tags_for_one_portfolio_item()
    {
        global $post;

        return wp_get_post_terms($post->ID, 'ff-portfolio-tag');
    }
}

################################################################################
# SPECIAL HOOKS FOR WP ADMIN MENU
################################################################################
if( !function_exists('ff_milo__menu__admin_enqueue_scripts')) {
    function ff_milo__menu__admin_enqueue_scripts()
    {

        $js = ffContainer::getInstance()->getScriptEnqueuer();

        wp_enqueue_media();

        $js->getFrameworkScriptLoader()->requireFrsLib();

        $js->getFrameworkScriptLoader()->requireFrsLibOptions();

        $js->addScriptFramework('ff-fw-adminScreens', 'framework/adminScreens/assets/js/adminScreens.js', array('jquery'));
        $js->addScriptFramework('ff-fw-options', 'framework/options/assets/options.js', array('jquery'));

        ffContainer::getInstance()->getFrameworkScriptLoader()->requireFfAdmin();
    }
}

if( !function_exists('ff_milo__image__admin_footer')) {
    function ff_milo__image__admin_footer()
    {

        ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryIcon();

        ?>
        <script type="text/javascript">
            (function ($) {


                function make_icon_from_description($field) {
                    var _name_ = $field.attr('name');
                    var _id_ = $field.attr('id');
                    var _val_ = $field.val();
                    var _src_ = '';
                    var _h_ = 0;
                    var _w_ = 0;
                    var _style_ = '';

                    var re_1, re_2, patt, _imgObj_, _src_;

                    if (_val_) {
                        re_1 = new RegExp('<?php echo "\xE2\x80\x9C";?>', 'g');
                        re_2 = new RegExp('<?php echo "\xE2\x80\x9D";?>', 'g');
                        patt = new RegExp('{"id":');

                        _val_ = _val_.replace(re_1, '"');
                        _val_ = _val_.replace(re_2, '"');

                        if (patt.test(_val_)) {
                            _imgObj_ = JSON.parse(_val_);
                            _src_ = _imgObj_.url;
                            _w_ = _imgObj_.width;
                            _h_ = _imgObj_.height;
                            if (_w_ > 600) {
                                _style_ = 'width: 600px; height: auto;';
                            } else {
                                _style_ = 'width: ' + _w_ + 'px; height: auto;';
                            }
                        }
                    }

                    var img_picker_html = '';
                    img_picker_html += '<div class="ff-open-library-button-wrapper ff-open-image-library-button-wrapper" style="display:block">';
                    img_picker_html += '<a class="ff-open-library-button ff-open-image-library-button">';
                    img_picker_html += '<span class="ff-open-library-button-preview">';
                    img_picker_html += '<span class="ff-open-library-button-preview-image" style="background-image:url(\'' + _src_ + '\');"></span>';
                    img_picker_html += '</span>';
                    img_picker_html += '<span class="ff-open-library-button-title">Image</span>';
                    img_picker_html += '<input type="hidden" name="' + _name_ + '" id="' + _id_ + '" class="ff-image" value=\'' + _val_ + '\'>';
                    img_picker_html += '<span class="ff-open-library-button-preview-image-large-wrapper" style="z-index:9999">';
                    img_picker_html += '<img class="ff-open-library-button-preview-image-large" src="' + _src_ + '" width="' + _w_ + '" height="' + _h_ + '" style="' + _style_ + '">';
                    img_picker_html += '</span>';
                    img_picker_html += '</a>';
                    img_picker_html += '<a class="ff-open-library-remove" title="Clear"></a>';
                    img_picker_html += '</div>';

                    $field.replaceWith(img_picker_html);
                }

                window.setInterval(function () {
                    $('.field-description textarea').each(function () {
                        make_icon_from_description($(this));
                    });
                }, 1618);

            })(jQuery);
        </script>
        <style type="text/css"> .field-description {
                display: block !important;
            } </style>
    <?php
    }
}

if( !function_exists('ff_milo__megamenu_select__admin_footer')) {
    function ff_milo__megamenu_select__admin_footer()
    {

        ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryIcon();

        ?>
        <script type="text/javascript">
            (function ($) {
                function make_select_from_class_input($field) {
                    var _name_ = $field.attr('name');
                    var _id_ = $field.attr('id');
                    var _val_ = $field.val();
                    _val_ = _val_.replace(/[<>\"\']/g, '');

                    var select_picker_html = '';
                    select_picker_html += '<select type="hidden" name="' + _name_ + '" id="' + _id_ + '" value="' + _val_ + '">';
                    select_picker_html += '<option value="">Just menu item</option>';
                    select_picker_html += '<option value="megamenu">Columns in submenu</option>';
                    select_picker_html += '<option value="show-image">Print just image, no link</option>';
                    select_picker_html += '</select>';

                    var $select_picker = $(select_picker_html);

                    $field.replaceWith($select_picker);
                    if (( 'show-image' == _val_ ) || ( 'megamenu' == _val_ )) {
                        $select_picker.val(_val_);
                    }

                    $('.field-css-classes').removeClass('description-thin');
                }

                window.setInterval(function () {
                    $('.field-css-classes input').each(function () {
                        make_select_from_class_input($(this));
                    });
                }, 1000);

            })(jQuery);
        </script>
        <style type="text/css"> .field-css-classes {
                display: block !important;
            } </style>
    <?php
    }
}

if( !function_exists('ff_hook_admin_menu_actions') ) {
    function ff_hook_admin_menu_actions() {
        if( FALSE !== strpos( $_SERVER['REQUEST_URI'], '/nav-menus.php') ){
            add_action( 'admin_enqueue_scripts', 'ff_milo__menu__admin_enqueue_scripts' );
            add_action( 'admin_footer', 'ff_milo__image__admin_footer', 99 );
            add_action( 'admin_footer', 'ff_milo__megamenu_select__admin_footer', 99 );
        }
    }

    ff_hook_admin_menu_actions();
}

################################################################################
# USER DATA ESCAPING FUNCTION
################################################################################
if( !function_exists('ff_wp_kses') ) {
// Sorry I know that this is ugly global variable, but I want to call
// this function just once

    global $__ff__wp_kses_allowed_html;
    $__ff__wp_kses_allowed_html = wp_kses_allowed_html('post');

    function ff_wp_kses( $html ){
        global $__ff__wp_kses_allowed_html;
        $html = wp_kses( $html, $__ff__wp_kses_allowed_html );
        return $html;
    }
}

if( function_exists('vc_disable_frontend') ){
	vc_disable_frontend();
}
if( !function_exists('ff_has_read_more') ) {
    function ff_has_read_more()
    {
        global $post;
        if (strpos($post->post_content, '<!--more-->') === false) {
            return false;
        } else {
            return true;
        }
    }
}


if( !function_exists('ff_theme_accent_color_hex') ) {
    function ff_theme_accent_color_hex() {
        $mainColor = '';

        if( ffThemeOptions::getQuery('layout use-picker') ) {
            $mainColor = ffThemeOptions::getQuery('layout color');
        } else {
            $skin = ffThemeOptions::getQuery('layout accent');

            switch( $skin ) {
                case 'default':
                    $mainColor = '#bca480';
                    break;
                case 'yellow':
                    $mainColor = '#e3ac4e';
                    break;
                case 'green':
                    $mainColor = '#a0ce4e';
                    break;
                case 'blue':
                    $mainColor = '#74b2ff';
                    break;
            }
        }

        return $mainColor;
    }
}

add_action('admin_footer', 'ff_import_notice');

function ff_import_notice() {

    if( ffContainer()->getRequest()->get('import') == 'wordpress' ){
        $listOfActivePlugins = ffContainer()->getPluginLoader()->getActivePluginClasses();

        if( !isset( $listOfActivePlugins['p-milo-core'] ) && !isset( $listOfActivePlugins['milo-core'] )  ) {
            ?>
            <script>
                jQuery(document).ready(function($){
                    var htmlToInsert = '';

                    htmlToInsert += '<div style="background-color:red; color:white; padding: 20px; margin: 20px 0;">';
                        htmlToInsert += 'Before you can start using the Milo theme, you need to activate the Milo Theme Core plugin first.';
                    htmlToInsert += '<div>';


                    $('.wrap h2').after( htmlToInsert );

                    $('#import-upload-form').hide();
                    $('.narrow').hide();
                });
            </script>
            <?php
        }

    }


}


/**********************************************************************************************************************/
/* EXCLUDE REVOLUTION SLIDER JS FROM MINIFICATION
/**********************************************************************************************************************/
if( !function_exists('ff_theme_banned_js_minification') ) {

    function ff_theme_banned_js_minification( $bannedFiles ) {

        if( !is_array( $bannedFiles ) ) {
            $bannedFiles = array();
        }
        $bannedFiles = array_merge( array('tp-tools', 'revmin'), $bannedFiles);

        return( $bannedFiles );
    }

    add_action('ff_performance_cache_banned_js', 'ff_theme_banned_js_minification');

}