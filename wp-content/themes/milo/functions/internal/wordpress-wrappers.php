<?php

if( !function_exists('ff_comment_form') ) {
    function ff_comment_form()
    {
        // See /templates/onePage/blocks/comments-form/comments-form.php
        comment_form();
    }
}

if( !function_exists('ff_the_tags') ) {
    function ff_the_tags()
    {
        // See /templates/onePage/blocks/blog-meta/blog-meta.php
        the_tags();
    }
}

if( !function_exists('ff_the_post_thumbnail') ) {
    function ff_the_post_thumbnail()
    {
        // See /templates/onePage/blocks/blog-featured-area/blog-featured-area.php
        // And maybe /templates/helpers/class.ff_Featured_Area.php
        // And maybe /templates/helpers/func.ff_Gallery.php
        the_post_thumbnail();
    }
}

if( !function_exists('ff_paginate_links') ) {
    function ff_paginate_links()
    {
        // See /templates/onePage/blocks/pagination/pagination.php
        paginate_links();
    }
}


