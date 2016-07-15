<?php
/**
 * Template Name: One Page (No Comments)
 *
 * @package WordPress
 * @subpackage Milo
 * @since Milo 1.0
 */

/**
 * Hi there, content of this page template is almost identical to single-portfolio.php. It displays only and exclusively
 * our sections, so please do not customize this, because there is nothign you can gain from customizing this file :)
 * For more info please look to single-portfolio.php
 */


get_header();

	$fwc = ffContainer::getInstance();
	$postMeta = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade( $post->ID );
	$onePage = $postMeta->getOption( 'onepage' );

	$onePage = unserialize( base64_decode( $onePage ));
	$sectionQuery = ffContainer::getInstance()->getOptionsFactory()->createQuery( $onePage, 'ffComponent_Theme_OnePageOptions');


	foreach( $sectionQuery->get('sections') as $oneSection ) {
		/** @var ffOptionsQuery $oneSection */
		$variation = $oneSection->getVariationType();
		ff_print_section_callback( $oneSection, $variation );
	}

get_footer();