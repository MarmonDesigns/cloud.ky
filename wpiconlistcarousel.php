<?php
/**
* Plugin Name: WP Responsive Testimonial Slider
* Description: WP Responsive Testimonial Slider Plugin is for Add Testimonials with this Shortcode '[testimonials]'.
* Version: 1.0.0
* Author: umakant_dataman
* Author URI: https://profiles.wordpress.org/umakant_dataman
* License: GPL2
*/

function wprts_testimonial_list() {
  $labels = array(
    'name'               => _x( 'Testimonials', 'post type general name' ),
    'singular_name'      => _x( 'Testimonial', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'Testimonial' ),
    'add_new_item'       => __( 'Add New Testimonial' ),
    'edit_item'          => __( 'Edit Testimonial' ),
    'new_item'           => __( 'New Testimonial' ),
    'all_items'          => __( 'All Testimonials' ),
    'view_item'          => __( 'View Testimonial' ),
    'search_items'       => __( 'Search Testimonials' ),
    'not_found'          => __( 'No Testimonials found' ),
    'not_found_in_trash' => __( 'No Testimonials found in the Trash' ), 
    'menu_name'          => 'Testimonials'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our Testimonials and Testimonial specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor' ),
    'has_archive'   => true,
  );
  register_post_type( 'testimonials', $args ); 
}
add_action( 'init', 'wprts_testimonial_list' );
add_image_size( 'testimoniallist_thumb', 120, 120, true);

// create shortcode to list all Testimonials which come in blue
add_shortcode( 'testimonials', 'wprts_testimonials_query' );
function wprts_testimonials_query( $atts ) {
    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'testimonials',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'title',
    ) );
    if ( $query->have_posts() ) { ?>
        <div id="owl-testimonial" class="owl-carousel">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="item darkCyan"  id="post-<?php the_ID(); ?>">
                <?php content(); ?>
				<h3><?php the_title(); ?></h3>
            </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}

add_action('wp_footer', 'wprts_wptech_register_scripts');
function wprts_wptech_register_scripts() {
    if (!is_admin()) {
        // register
        wp_register_script('wprts_wptechnology_Testimonials_script', plugins_url('js/owl.carousel.min.js', __FILE__));
		// enqueue
        wp_enqueue_script('wprts_wptechnology_Testimonials_script');
        wp_enqueue_script( 'jquery' );
    }
}

add_action('wp_footer', 'wprts_wptechscript_register_scripts');
function wprts_wptechscript_register_scripts() {
    if (!is_admin()) { ?>
       	<!-- Frontpage Demo -->
       <style>
		.inner-col1 .owl-buttons div {
			  top: 54%;
			}
			.owl-buttons .owl-prev {
			  left: -53px;
			}
			.owl-buttons div {
				
			  background: url("<?php plugins_url( '/images/arrow.png', __FILE__ ); ?>") no-repeat;
			  height: 45px;
			  margin-top: -30px;
			  outline: 0 none;
			  position: absolute;
			  text-indent: -9999px;
			  top: 50%;
			  width: 45px;
			  z-index: 9;
			}
			.owl-buttons .owl-next {
			  right: -53px;
			  background-position: -69px 0;
			}
			.owl-buttons div {
			  background: url("<?php plugins_url( '/images/arrow.png', __FILE__ ); ?>") no-repeat ;
			  height: 45px;
			  margin-top: -30px;
			  outline: 0 none;
			  position: absolute;
			  text-indent: -9999px;
			  top: 50%;
			  width: 45px;
			  z-index: 9;
			}
       </style>
    <script>
    $(document).ready(function($) {
       jQuery("#owl-testimonial").owlCarousel({
        autoPlay: true,
        navigation: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        pagination: false,
        items: 1,
        itemsCustom: [
            [0, 1],
            [450, 1],
            [600, 2],
            [700, 2],
            [768, 3],
            [1000, 3],
            [1200, 4],
            [1400, 4],
            [1600, 4]
        ]
    });
    jQuery("#owl-testimonial .owl-controls .owl-prev").click(function() {
        var owl = jQuery("#owl-demo-product");
        owl.trigger('owl.prev');
    });
    jQuery("#owl-testimonial .owl-controls .owl-next").click(function() {
        var owl = jQuery("#owl-demo-product");
        owl.trigger('owl.next');
    });
    });
    </script>
    <?php
    }
}

add_action('wp_footer', 'wptech_register_styles');
function wptech_register_styles() {
	// register
    wp_register_style('wprts_wptechnology_Testimonials_styles', plugins_url('css/owl.carousel.css', __FILE__));
    wp_register_style('wprts_wptechnology_Testimonials_styles_theme', plugins_url('css/owl.theme.css', __FILE__));
    // enqueue
    wp_enqueue_style('wprts_wptechnology_Testimonials_styles');
    wp_enqueue_style('wprts_wptechnology_Testimonials_styles_theme');
    }
?>
