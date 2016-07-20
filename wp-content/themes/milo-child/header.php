<?php
/**
 * Hi there!
 *
 * As opposite of other themes (where you usually find here navigation code and other), in this theme, you'll
 * find only code for printing layouts of placement "Header" and "Before Content". These layouts could be
 * created in WP Admin -> Layouts.
 *
 * Typically here will be printed (but it depends at you of course)
 * - Header navigation
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
    <?php wp_head(); ?>
</head>
<?php

$body_extra_class = array();
if( ffThemeOptions::getQuery('layout boxed-layout' ) ){
    $body_extra_class[] = "boxed";
}

?>

<body <?php body_class( $body_extra_class ); ?>>
<?php

$body_extra_class = array();
if( ffThemeOptions::getQuery('layout boxed-layout' ) ){
    ff_load_section_printer(
        'section-background'
        , ffThemeOptions::getQuery('layout background' )
    );
}

?>
	<div id="page-wrapper">
	<?php
    ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutPrinter()
        ->printLayoutHeader()
        ->printLayoutBeforeContent();
	?>
