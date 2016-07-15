<?php

$dataToReturn = '';

$classes = array();
if( $query->get('xs') != 'no' ) {
    $classes[] = 'col-xs-'.absint( $query->get('xs') );
}

if( $query->get('sm') != 'no' ) {
    $classes[] = 'col-sm-'.absint( $query->get('sm') );
}

if( $query->get('md') != 'no' ) {
    $classes[] = 'col-md-'.absint( $query->get('md') );
}

if( $query->get('lg') != 'no' ) {
    $classes[] = 'col-lg-'.absint( $query->get('lg') );
}


$dataToReturn =  implode( ' ', $classes );