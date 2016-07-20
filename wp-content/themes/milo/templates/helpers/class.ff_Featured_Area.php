<?php

/**
 *  ff_Featured_Area
 *
 *  @author freshface
 */

class ff_Featured_Area {

	/**
	 * @var ff_Featured_Area
	 */
	private static $_instance = null;

	private static $_ignore_first_featured = false;
	private static $_featured_shortcode_printer = null;

	/**
	 * @return ff_Featured_Area
	 */
	public static function getInstance() {
		if( self::$_instance == null ) {
			self::$_instance = new ff_Featured_Area();
		}
		return self::$_instance;
	}

	public static function getFeaturedImage(){
		return wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
	}

	public static function getFeaturedImageSizes(){
		$featured_size = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		return $featured_size
			? array( $featured_size[1], $featured_size[2] )
			: array( null, null )
			;
	}

	public static function getFeaturedAudio(){
		$featured_audio = null;
		if ( preg_match_all( '/' . get_shortcode_regex() . '/s', get_the_content(), $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $shortcode ) {
				if ( ( 'audio' === $shortcode[2] ) or ('playlist' === $shortcode[2] ) ) {
					$featured_audio = trim( do_shortcode_tag( $shortcode ) );
					if ( $featured_audio ) {
						break;
					}
				}
			}
		}
		return $featured_audio;
	}

	public static function getFeaturedVideo(){
		$featured_video = null;
		foreach ( explode( "\n", get_the_content() ) as $key => $value) {
			$value = trim($value);
			if( empty( $value ) ) continue;
			$featured_video = wp_oembed_get( $value );
			if( ! empty($featured_video) ) break;
		}
		return ff_Featured_Area::wrapEmbeded( $featured_video );;
	}

	public static function setIgnoreFirstFeatured( $state ){
		ff_Featured_Area::$_ignore_first_featured = $state;
	}

	public static function setFeaturedPrinter( $printer ){
		ff_Featured_Area::$_featured_shortcode_printer = $printer;
	}

	public static function wrapEmbeded( $html ){
		// Video fix

		global $ff_featured_width;
		global $ff_featured_height;

		if( ( 0 != $ff_featured_width ) and ( 0 != $ff_featured_height ) ){
			$ratio = 0.01 * absint( 10000 * $ff_featured_height / $ff_featured_width );
			$div = '<div class="embed-responsive" style="padding-bottom: '.  $ratio.'%">';

			$html = str_replace('<iframe ', '<div class="blog-article-thumbnail">' .  $div . '<iframe'."\t".'class="embed-responsive-item" ', $html);
			$html = str_replace('<embed ', '<div class="blog-article-thumbnail">' .  $div . '<embed'."\t".'class="embed-responsive-item" ', $html);
		}else{
			$html = str_replace('<iframe ', '<div class="blog-article-thumbnail"><div class="embed-responsive embed-responsive-16by9"><iframe'."\t".'class="embed-responsive-item" ', $html);
			$html = str_replace('<embed ', '<div class="blog-article-thumbnail"><div class="embed-responsive embed-responsive-16by9"><embed'."\t".'class="embed-responsive-item" ', $html);
		}
		$html = str_replace('</iframe>', '</iframe></div></div>', $html);
		$html = str_replace('</embed>', '</embed></div></div>', $html);

		return $html;
	}

	public static function actionHijackFeaturedShortcode( $html, $attr ) {
		if( ff_Featured_Area::$_ignore_first_featured ){
			ff_Featured_Area::$_ignore_first_featured = false;
			return ' ';
		}

		return ( ff_Featured_Area::$_featured_shortcode_printer )
				? call_user_func( ff_Featured_Area::$_featured_shortcode_printer, $html, $attr )
				: ff_Featured_Area::wrapEmbeded( $html )
				;
	}

}


