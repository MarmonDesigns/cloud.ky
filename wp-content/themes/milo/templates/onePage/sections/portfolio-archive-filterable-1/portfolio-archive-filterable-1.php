<?php
    $fwc = ffContainer::getInstance();
    $postMeta = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas();
 	rewind_posts();
    $postCounter = 0;
    global $post;

	$tags = ff_get_all_portfolio_tags();


?>

<?php
/**********************************************************************************************************************/
/* TAG LOOP
/**********************************************************************************************************************/
    if( !empty( $tags ) && $query->get('show-filterable') ) {
?>

<?php ff_print_before_section( $query->get('section-settings-sortable section-settings')); ?>

            <div class="row">
                <div class="col-sm-12">

                    <ul class="filter">
                        <li>
                            <a class="active" href="#" data-filter="*"><?php echo ff_wp_kses( $query->get('trans-button-all') ); ?></a>
                        </li>
                        <?php
                            foreach( $tags as $oneTag ) {
                                echo '<li>';
                                    echo '<a href="#" data-filter=".ff-tag-'.absint( $oneTag->term_id ).'">'.ff_wp_kses( $oneTag->name ).'</a>';
                                echo '</li>';
                            }
                        ?>
                    </ul>

                </div>
                <!-- col -->
            </div>
            <!-- row -->

<?php ff_print_after_section( $query->get('section-settings-sortable section-settings')); ?>

<?php
    }

/**********************************************************************************************************************/
/* NUMBER OF COLUMNS
/**********************************************************************************************************************/
    $numberOfColums = $query->get('number-of-columns');

    $columnsClass = 'col-'.absint( $numberOfColums );
?>

<?php ff_print_before_section( $query->get('section-settings-portfolio section-settings')); ?>

            <div class="row">
                <div class="col-sm-12">
                    <div class="isotope <?php echo esc_attr( $columnsClass ); ?> clearfix">
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
/**********************************************************************************************************************/
/* TAGS AND SUB HEADING
/**********************************************************************************************************************/
            $tags = ff_get_all_tags_for_one_portfolio_item();
            $subtitle = '';
            $sortableClasses = '';
            if( !empty( $tags ) ) {
                foreach( $tags as $oneTag ) {
                    if( empty( $subtitle ) ) {
                        $subtitle = $oneTag->name;
                    }

                    $sortableClasses .= ' ff-tag-'.absint( $oneTag->term_id );
                }
            }


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

            if ($postQuery->get('general button different-url')) {
                $buttonUrl = $postQuery->get('general button url');
            } else {
                $buttonUrl = get_permalink($post->ID);
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

            if( $featuredImageQuery->get('resize') ) {
                $imageUrlResized = fImg::resize( $imageUrlNonresized, $width, $height, true );
            }


?>



                        <div class="isotope-item <?php echo esc_attr( $sortableClasses ); ?>">

                            <div class="portfolio-item">

                                <div class="portfolio-item-thumbnail">

                                    <?php
                                        if( $featuredImageQuery->get('link') == 'button') {
                                            echo '<a href="'.esc_url( $buttonUrl ).'">';
                                        }
                                    ?>
                                        <img src="<?php echo esc_url( $imageUrlResized );?>" alt="">


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

                                <div class="portfolio-item-description">

                                    <h3><a href="<?php echo esc_url( $buttonUrl );?>"><?php echo get_the_title(); ?></a></h3>
                                    <h5><?php echo ff_wp_kses( $subtitle ); ?></h5>

                                    <p>
                                        <?php echo ff_wp_kses( $postQuery->get('general description description') ); ?>
                                    </p>

                                    <a class="btn btn-default" href="<?php echo esc_url( $buttonUrl );?>"><?php echo ff_wp_kses( $buttonCaption ); ?></a>

                                </div>
                                <!-- portfolio-item-description -->

                            </div>
                            <!-- portfolio-item -->

                        </div>
                        <!-- isotope-item -->
<?php
        }
    }
?>
                    </div><!-- isotope -->
                </div><!-- col -->
            </div><!-- row -->
    <?php
        ff_load_section_printer('pagination', $query );
    ?>

<?php ff_print_after_section( $query->get('section-settings-portfolio section-settings')); ?>


