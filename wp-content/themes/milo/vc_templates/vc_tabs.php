<?php
$output = $title = $interval = $el_class = '';
extract( shortcode_atts( array(
	'title' => '',
	'interval' => 0,
	'el_class' => ''
), $atts ) );

wp_enqueue_script( 'jquery-ui-tabs' );

$el_class = $this->getExtraClass( $el_class );

$element = 'nav-tabs';
if ( 'vc_tour' == $this->shortcode ) {
	$element = 'vertical-tabs';
}

preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();

if ( isset( $matches[1] ) ) {
	$tab_titles = $matches[1];
}
$tabs_nav = '';

$tabs_nav .= '<ul class="nav nav-tabs">';
$is_first = true;
foreach ( $tab_titles as $tab ) {
	$tab_atts = shortcode_parse_atts( $tab[0] );
	if ( isset( $tab_atts['title'] ) ) {
		$tabs_nav .= '<li';
		if( $is_first ){
			$tabs_nav .= ' class="active"';
			$is_first = false;
		}
		$tabs_nav .= '>';
		$tabs_nav .= '<a href="#tab-' . ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) ) . '" data-toggle="tab">';
		$tabs_nav .= $tab_atts['title'] . '</a></li>';
	}
}
$tabs_nav .= '</ul>' . "\n";

if( 'vertical-tabs' == $element ) {
	$output .= '<div class="vertical-tabs">';
}else{
	$output .= '<div>';
}
$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => $element . '_heading' ) );
$output .= $tabs_nav;
$output .= '<div class="tab-content">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div> ' .  $this->endBlockComment( '.wpb_wrapper' );
$output .= '</div> ' .  $this->endBlockComment( $element );

echo  $output;



