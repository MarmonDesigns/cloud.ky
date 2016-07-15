<?php

function ff_Gallery($output, $attr) {

	static $instance = 0;
	$instance++;

	global $post;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] ){
			unset( $attr['orderby'] );
		}
	}

	extract(shortcode_atts(array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post->ID,
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => ''
	), $attr));

	$gallery_ID = $id = intval($id);

	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	$output = "";

	global $ff_featured_width;
	global $ff_featured_height;

	$output .= '<div class="images-slider-2 blog-article-thumbnail">';
	$output .= '<ul>';

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$url = wp_get_attachment_url( $id );
		if( empty( $url ) ) continue;

		$url = fImg::resize($url, $ff_featured_width, $ff_featured_height, true );
		$output .= '<li>';
		$output .= '<img src="'.esc_url( $url ). '" alt="">';
		$output .= '</li>'."\n";
	}

	$output .= '</ul>';
	$output .= '</div>';

	return $output;
}
