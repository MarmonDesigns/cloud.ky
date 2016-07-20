<?php
if( ! post_password_required() ) {   
	if ( comments_open() or ( get_comments_number() > 0 ) ) {
        get_template_part('templates/onePage/blocks/comments-list/comments-list');
        get_template_part('templates/onePage/blocks/comments-pagination/comments-pagination');
        get_template_part('templates/onePage/blocks/comments-form/comments-form');
    }
}
