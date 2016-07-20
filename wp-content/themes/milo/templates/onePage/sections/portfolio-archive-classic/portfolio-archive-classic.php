<?php
 $fwc = ffContainer::getInstance();
 $postMeta = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas();
 	rewind_posts();
    $postCounter = 0;
 global $post;
	if ( have_posts() ) {

		while ( have_posts() ) {
 			the_post();
/**********************************************************************************************************************/
/* VARIABLE INIT
/**********************************************************************************************************************/
            $postCounter++;
 			$currentPostId = $post->ID;

            $data = $postMeta->getOption( $currentPostId, 'portfolio_category_options');
            $postQuery = $fwc->getOptionsFactory()->createQuery( $data,'ffComponent_Theme_MetaboxPortfolio_CategoryView');

//            $postQuery->debug_dump();

/**********************************************************************************************************************/
/* POST TITLE
/**********************************************************************************************************************/
            $postTitle = '';
            if( $postQuery->get('general title different') ) {
                $postTitle = $postQuery->get('general title title');
            } else {
                $postTitle = get_the_title();
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
                return;
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

            if( $featuredImageQuery->get('resize') ) {
                $imageUrlResized = fImg::resize( $imageUrlNonresized, $width, $height, true );
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

                if ($postQuery->get('general button different-url')) {
                    $buttonUrl = $postQuery->get('general button url');
                } else {
                    $buttonUrl = get_permalink($post->ID);
                }
            }

/**********************************************************************************************************************/
/* PORTFOLIO SUB TITLE
/**********************************************************************************************************************/

            $subTitle = '';
            if( $postQuery->get('general subtitle different') ) {
                $subTitle = $postQuery->get('general subtitle subtitle');
            } else {
                $tags = wp_get_post_terms( $post->ID, 'ff-portfolio-tag' );

                if( !empty( $tags ) ) {
                    $firstTag = reset( $tags );

                    $subTitle = $firstTag->name;
                }

            }

?>
            <div class="container">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="portfolio-item classic">

                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="portfolio-item-thumbnail">

                                            <?php
                                                if( $featuredImageQuery->get('link') == 'button') {
                                                    echo '<a href="'.esc_url( $buttonUrl ).'">';
                                                }
                                            ?>
                                                <img src="<?php echo esc_url( $imageUrlResized); ?>" alt="">


                                            <?php
                                                if( $featuredImageQuery->get('link') == 'button') {
                                                    echo '</a>';
                                                }
                                            ?>


                                            <?php
                                                if( $featuredImageQuery->get('link') == 'lightbox') {
                                            ?>

                                                    <div class="portfolio-item-hover">
                                                        <a class="fancybox-portfolio-gallery zoom-action" href="<?php echo esc_url( $imageUrlNonresized ); ?>">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </div><!-- portfolio-item-hover -->
                                            <?php
                                                }
                                            ?>
                                        </div><!-- portfolio-item-thumbnail -->

                                    </div><!-- col -->
                                    <div class="col-sm-6">

                                        <div class="portfolio-item-description">

                                            <h6><?php echo ff_wp_kses( $postDate ); ?></h6>
                                            <h3><a href="<?php echo esc_url( $buttonUrl ); ?>"><?php echo ff_wp_kses( $postTitle ); ?></a></h3>
                                            <h5><?php echo ff_wp_kses( $subTitle ); ?></h5>

                                            <p>
                                                <?php echo ff_wp_kses( $postQuery->get('general description description') ); ?>
                                            </p>

                                            <?php
                                                if( $query->get('readmore-show') ) {
                                            ?>
                                                <a class="btn btn-default" href="<?php echo esc_url( $buttonUrl ); ?>"><?php echo ff_wp_kses( $buttonCaption ); ?></a>
                                            <?php
                                                }
                                            ?>

                                        </div><!-- portfolio-item-description -->

                                    </div><!-- col -->
                                </div><!-- row -->
                            </div><!-- portfolio-item -->
                        </div><!-- col -->
                    </div><!-- row -->
                </div><!-- container -->
<?php
		}
	}
?>


