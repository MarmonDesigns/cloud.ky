<?php
    $query = $query->get('post-classic-meta');
    global $post;
    $featuredImageQuery = $query->get('featured-image');
    $dateQuery = $query->get('date');
    $authorQuery = $query->get('author');
    $categoriesQuery = $query->get('categories');
    $commentsQuery = $query->get('comments');

    $imageUrlNonresized = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
    $imageUrlResized = null;
    if( $imageUrlNonresized != null && $featuredImageQuery->get('show') ) {
        $width = $featuredImageQuery->get('width');
        $height = $featuredImageQuery->get('height');

        if( absint($width) == 0 ) {
            $width = null;
        }

        if( absint($height) == 0 ) {
            $height = null;
        }

        $crop = false;

        if( $width != null || $height != null ) {
            $imageUrlResized = fImg::resize( $imageUrlNonresized, $width, $height, true );
        } else {
            $imageUrlResized = $imageUrlNonresized;
        }
    }

    $postMetaGetter = ffContainer()->getThemeFrameworkFactory()->getPostMetaGetter();


?>

<header class="entry-header">
    <?php if( $dateQuery->get('show') ) { ?>
    <div class="entry-date"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_date( $dateQuery->get('format') ); ?></a></div>
    <?php } ?>
    <h2 class="entry-title"><a href="<?php echo get_the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

    <?php
        $entryMeta = '';

        if( $authorQuery->get('show') ) {
            $entryMeta .= '<span>' . ff_wp_kses( $authorQuery->get('text-before') ).'</span>';
            $entryMeta .= '<span class="entry-author">';
            $entryMeta .= '<a href="'.esc_url( $postMetaGetter->getPostAuthorUrl() ).'">';
            $entryMeta .= ' ';
            $entryMeta .= $postMetaGetter->getPostAuthorName();
            $entryMeta .= '</a>';
            $entryMeta .= '</span>';
        }

        if( $categoriesQuery->get('show') ) {
            $entryMeta .= ' ';
            $entryMeta .= '<span>' . esc_attr( $categoriesQuery->get('text-before') ) . '</span>';
            $entryMeta .= ' ';
            $entryMeta .= '<span class="entry-cats">';

            $entryMeta .= $postMetaGetter->getPostCategoriesHtml();
            $entryMeta .= '</span>';

        }

        if( $commentsQuery->get('show') ) {
            $entryMeta .= ' <span>&dash;</span> ';
            $entryMeta .= '<span class="entry-comments">';
            $entryMeta .= $postMetaGetter->getPostCommentsLinkText(
                $commentsQuery->get('zero'),
                $commentsQuery->get('one'),
                $commentsQuery->get('more')
            );
            $entryMeta .= '</span>';
        }

        if( !empty( $entryMeta ) ) {
            echo '<div class="entry-meta">';
                echo  $entryMeta;
            echo '</div>';
        }
    ?>
</header>

<?php if( $imageUrlResized != null ) { ?>
<section class="entry-featured">
    <figure>
        <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo esc_url( $imageUrlResized); ?>" alt=""></a>
    </figure>
</section>
<?php } ?>