<?php
/**
 * Hi there!
 *
 * This file might seem a little bit messy for you. Anyway single portfolio could be build only from sections,
 * nothing else, and this code here is doing this:
 *
 * 1.) load header
 *
 * 2.) load post meta "onepage" for current portfolio single
 *
 * 3.) unserialize this post meta ( its also base64 coded as well
 *
 * 4.) go through the data and print all the sections
 *
 * 5.) load footer
 */
get_header();

$fwc = ffContainer::getInstance();
$postMeta = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade( $post->ID );
$onePage = $postMeta->getOption( 'onepage' );

$onePage = unserialize( base64_decode( $onePage ));
$sectionQuery = ffContainer::getInstance()->getOptionsFactory()->createQuery( $onePage, 'ffComponent_Theme_OnePageOptions');


foreach( $sectionQuery->get('sections') as $oneSection ) {
	$variation = $oneSection->getVariationType();
	ff_print_section_callback( $oneSection, $variation );
}

get_footer();