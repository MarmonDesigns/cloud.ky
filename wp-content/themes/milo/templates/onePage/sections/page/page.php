<?php

$pageIDs = $query->getMultipleSelect('page');

if( empty($pageIDs) ){
	echo '<section>';
	echo '<div class="container">';
	echo '<div class="section-content row">';
	echo '<h1>No Page ID specified</h1>';
	echo '</div>';
	echo '</div>';
	echo '</section>';
	return;
}

$fwc = ffContainer::getInstance();

foreach ($pageIDs as $pageID) {

	$page_template = $fwc->getWPLayer()->get_post_meta($pageID, '_wp_page_template', true);

	if( 'page-onepage.php' == $page_template ){
		$postMeta = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade( $pageID );
		$onePage = $postMeta->getOption( 'onepage');

		$onePage = unserialize( base64_decode( $onePage ));
		$sectionQuery = ffContainer::getInstance()->getOptionsFactory()->createQuery( $onePage, 'ffComponent_Theme_OnePageOptions');

	    foreach( $sectionQuery->get('sections') as $oneSection ) {
	        /** @var ffOptionsQuery $oneSection */
	        $variation = $oneSection->getVariationType();
	        ff_print_section_callback( $oneSection, $variation );
	    }

	}else{
		echo '<div class="container">';
		echo '<div class="row">';
		echo '<div class="col-sm-12">';

		$page = ffContainer::getInstance()->getPostLayer()->getPostGetter()->getPostByID( $pageID );
		$pageContent = $page->getContent();
		$pageContent = apply_filters( 'the_content', $pageContent );
		$pageContent = str_replace( ']]>', ']]&gt;', $pageContent );

		echo  $pageContent;

		$great_vc = substr_count( $pageContent, '<div') - substr_count( $pageContent, '</div');
		if( $great_vc > 0 ){
			echo str_repeat('</div>', $great_vc);
		}

		echo '</div>';
		echo '</div>';
		echo '</div>';

	}
}



