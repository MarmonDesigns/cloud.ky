<?php
    $query = ffTemporaryQueryHolder::getQuery('comments-list');

    if( $query->queryExists('comments-list') ) {
        $query = $query->get('comments-list');

    }
?>

<?php
/**********************************************************************************************************************/
/* HEADING
/**********************************************************************************************************************/
    if( $query->get('heading show') ) {
        $postMetaGetter = ffContainer()->getThemeFrameworkFactory()->getPostMetaGetter();
        $headingQuery = $query->get('heading');
        $heading = $postMetaGetter->getPostCommentsText( $headingQuery->get('trans-zero'),  $headingQuery->get('trans-one'),  $headingQuery->get('trans-more') );
?>
    <h3 class="commentlist-title" id="comments"><?php echo ff_wp_kses( $heading ); ?></h3>
<?php
    }
?>
    <ul class="commentlist">
<?php
/**********************************************************************************************************************/
/* PRINTING COMMENT
/**********************************************************************************************************************/
        function ff_comments_list_callback($comment, $args, $depth) {
            global $ff_global_comment_depth;
            $ff_global_comment_depth++;

            $query = ffTemporaryQueryHolder::getQuery('comments-list');

            if( $query->queryExists('comments-list') ) {
                $query = $query->get('comments-list');

            }

            $postMetaGetter = ffContainer()->getThemeFrameworkFactory()->getPostMetaGetter();
            $commentDateFormat = $query->get('one-comment date-format');

            // <LI> tag is ended in the another callback
?>
                        <li id="<?php echo esc_attr( $postMetaGetter->getPostCommentsId() ); ?>" class="comment even thread-even depth-1">
                            <div class="comment-body">

                                <div class="comment-meta">

                                    <div class="comment-author vcard">

                                        <?php echo  $postMetaGetter->getCommentAuthorImage(80); ?>
                                        <a class="fn" href="<?php echo  esc_url($postMetaGetter->getCommentAuthorUrl()); ?>"><?php echo ff_wp_kses( $postMetaGetter->getCommentAuthorName() ); ?></a>
                                    </div><!-- comment-author vcard -->

                                <?php if( $query->get('one-comment show-date') ) { ?>
                                    <div class="comment-metadata">
                                        <a href="#"><?php echo ff_wp_kses( $postMetaGetter->getCommentDate($commentDateFormat) ); ?></a>
                                    </div><!-- comment-metadata -->
                                <?php } ?>

                                </div><!-- comment-meta -->

                                <div class="comment-content">

                                    <?php
                                        if ( '0' == $comment->comment_approved ) {
                                            echo '<em class="comment-awaiting-moderation">';
                                                echo ff_wp_kses( $query->get('one-comment trans-moderation') );
                                            echo '</em>';
                                            echo '</br>';
                                            echo '</br>';
                                        }

                                    echo ff_wp_kses(get_comment_text());
                                    ?>

                                </div><!--  comment-content -->

                                <div class="reply">
                                    <?php echo  $postMetaGetter->getCommentReplyLink( $query->get('one-comment trans-reply'), $args, $depth ); ?>
                                </div><!-- replay -->

                            </div><!-- comment-body -->
<?php
                        }
/**********************************************************************************************************************/
/* ACTUAL COMMENT CALLACK
/**********************************************************************************************************************/
        	wp_list_comments(
                array(
                    'style' => 'ul',
                    'callback' => 'ff_comments_list_callback',
                    'end-callback' => 'ff_comments_list_callback_end',
                )
        	);
?>


    </ul>
<?php
/**********************************************************************************************************************/
/* END LI CALLBACK
/**********************************************************************************************************************/
function ff_comments_list_callback_end(){
	global $ff_global_comment_depth;
	echo '</li>';

	$ff_global_comment_depth--;
}