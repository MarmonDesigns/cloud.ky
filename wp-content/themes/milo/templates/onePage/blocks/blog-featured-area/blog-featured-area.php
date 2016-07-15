<?php

global $ff_featured_width;
global $ff_featured_height;

$ff_featured_width = $query->get('width');
$ff_featured_height = $query->get('height');


ff_Featured_Area::setIgnoreFirstFeatured( false );
$featured_img = ff_Featured_Area::getFeaturedImage();
list( $featured_img_w, $featured_img_h  ) = ff_Featured_Area::getFeaturedImageSizes();

switch ( get_post_format() ) {
	case 'audio':
		$featured_primary = ff_Featured_Area::getFeaturedAudio();
		break;

	case 'video':
		$featured_primary = ff_Featured_Area::getFeaturedVideo();
		break;

	case 'gallery':
		ff_Featured_Area::setFeaturedPrinter( 'ff_Gallery' );
		$featured_primary = get_post_gallery( get_the_ID() );
		ff_Featured_Area::setFeaturedPrinter( false );
		break;

	default:
		$featured_primary = '';
		break;
}

global $featured_height;

if( ! empty( $featured_primary ) ){
	// Modified default WP featured areas
	echo  $featured_primary;

	ff_Featured_Area::setIgnoreFirstFeatured( true );
}else if( ! empty( $featured_img ) ) {
	global $post;

	$imageUrlNonresized = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	$imageUrlResized = null;
	if( $imageUrlNonresized != null && $query->get('show') ) {
		if( absint($ff_featured_width) == 0 ) {
			$ff_featured_width = null;
		}

		if( absint($ff_featured_height) == 0 ) {
			$ff_featured_height = null;
		}

		$crop = false;

		if( $ff_featured_width != null || $ff_featured_height != null ) {
			$imageUrlResized = fImg::resize( $imageUrlNonresized, $ff_featured_width, $ff_featured_height, true );
		} else {
			$imageUrlResized = $imageUrlNonresized;
		}
	}


	if( $imageUrlResized != null ) {
		?>

		<div class="blog-article-thumbnail">
			<img  src="<?php echo esc_url( $imageUrlResized ); ?>" alt="">

			<?php if( $query->get('lightbox') ) { ?>
			<div class="blog-article-hover">
				<a class="fancybox-blog-gallery zoom-action" href="<?php echo esc_url( $imageUrlNonresized ); ?>"><i class="fa fa-eye"></i></a>
			</div>
			<?php } ?>
		</div>
		<?php
	}
}

