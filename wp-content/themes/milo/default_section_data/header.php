<?php

$query = ffThemeOptions::getQuery('layout');


$defaultLogo = '';

if( $query->get('default header-logo-use') ) {
    $defaultLogo =  $query->get('default header-logo');
}


$data = array (
  'sections' =>
  array (
    '0-|-navigation' =>
    array (
      'navigation' =>
      array (
        'logo' =>
        array (
          'image' => $defaultLogo,
          'image_is_retina' => '0',
        ),
        'navigation-menu-id' => '',
        'color-type' => '',
        'search' =>
        array (
          'show' => '1',
          'placeholder' => 'Enter your keyword here and then press enter...',
        ),
      ),
    ),
  ),
);