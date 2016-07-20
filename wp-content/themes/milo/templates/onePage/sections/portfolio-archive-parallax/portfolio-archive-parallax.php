<?php
    $fwc = ffContainer::getInstance();
    $postMeta = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas();
 	rewind_posts();
    $postCounter = 0;
    global $post;

?>

<?php
/**********************************************************************************************************************/
/* POST LOOP START
/**********************************************************************************************************************/
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
/**********************************************************************************************************************/
/* VARIABLE INIT
/**********************************************************************************************************************/
            $currentPostId = $post->ID;

            $data = $postMeta->getOption( $currentPostId, 'portfolio_category_options');
            $postQuery = $fwc->getOptionsFactory()->createQuery( $data,'ffComponent_Theme_MetaboxPortfolio_CategoryView');
            $subtitle = '';


/**********************************************************************************************************************/
/* PORTFOLIO SUB TITLE
/**********************************************************************************************************************/

            if( $postQuery->get('general subtitle different') ) {
                $subtitle = $postQuery->get('general subtitle subtitle');
            }

/**********************************************************************************************************************/
/* BUTTON CAPTION & URL
/**********************************************************************************************************************/
            $buttonCaption = '';
            $buttonUrl = '';

            if( $query->get('readmore-show') ) {

                if ($postQuery->get('general button different-caption')) {
                    $buttonCaption = $postQuery->get('general button caption');
                } else {
                    $buttonCaption = $query->get('readmore-trans');
                }
            }


            if( $query->get('featured-image link') == 'button') {
                if ($postQuery->get('general button different-url')) {
                    $buttonUrl = $postQuery->get('general button url');
                } else {
                    $buttonUrl = get_permalink($post->ID);
                }
            }
/**********************************************************************************************************************/
/* POST DATE
/**********************************************************************************************************************/
            // 05 March 2015 -- d F Y
            $postDate = '';
            if( $postQuery->get('general date different') ) {
                $postDate = $postQuery->get('general date date');
            } else {
                $postDate = get_the_date( $query->get('date-format'));
            }


/**********************************************************************************************************************/
/* FEATURED IMAGE
/**********************************************************************************************************************/
            $imageUrlNonresized = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

            if( $imageUrlNonresized == null ) {
                continue;
            }

            $imageUrlResized = $imageUrlNonresized;

            $featuredImageQuery = $query->get('featured-image');

            $width = $featuredImageQuery->get('width');
            $height = $featuredImageQuery->get('height');


            if( absint($width) == 0 ) {
                $width = null;
            }

            if( absint($height) == 0 ) {
                $height = null;
            }


            $imageUrlToPrint = $imageUrlNonresized;
            if( $featuredImageQuery->get('resize') ) {
                $imageUrlToPrint = fImg::resize( $imageUrlNonresized, $width, $height, true );
            }

?>
            <div class="portfolio-item parallax" style="background-image:url(<?php echo esc_attr( $imageUrlToPrint ); ?>);">

                <div class="pattern"></div>

                <div class="portfolio-item-description">

                    <h3><?php echo ff_wp_kses( $postDate ); ?></h3>
                    <h1><a href="<?php echo esc_url( $buttonUrl ); ?>"><?php echo get_the_title(); ?></a></h1>
                    <h2><?php echo ff_wp_kses( $subtitle ); ?></h2>

                    <a class="btn btn-default" href="<?php echo esc_url( $buttonUrl ); ?>"><?php echo ff_wp_kses( $buttonCaption ); ?></a>

                </div><!-- portfolio-item-description -->

            </div><!-- portfolio-item -->

<?php
        }
    }
?>

    <?php
        ff_load_section_printer('pagination', $query );
    ?>