<?php


////////////////////////////////////////////////////////////////////////////////////
// ID

$id = $query->get('id');
$id = trim($id);
if( !empty($id) ){
	echo ' id="'.esc_attr( $id ).'"';
}


////////////////////////////////////////////////////////////////////////////////////
// CLASS

echo ' class="section ';
if( ! empty($params['class']) ){
	echo ' '.esc_attr( $params['class'] ).' ';
}

if( ! empty($params['section']) ){
	echo ' section-'.esc_attr( $params['section'] ).' ';
}

echo esc_attr( $query->get('color-type') ).'"';


////////////////////////////////////////////////////////////////////////////////////
// DATA-SECTION

if( ! empty($params['section']) ){
	echo ' data-section="'.esc_attr( $params['section'] ).'"';
}

////////////////////////////////////////////////////////////////////////////////////
// CUSTOM STYLE

if( ! empty($params['style']) ){
	echo ' style="'.esc_attr($params['style']).'"';
}