<?php
/**
 * The template for displaying fullwidth pages
 *
 * @package WordPress
 * @subpackage Milo
 * @since Milo 1.0
 */

/**
 * Hi there!
 *
 * This is a standard page. Only strange thing you can see is wrapping the function "comments_template"
 * with our "ffTemporaryQueryHolder" object. This is because the comments_template is used across the website
 * in different usages, as a POST comment form, and PAGE comment form. POST comment form could be translated
 * through the Layouts functionality, but PAGE comments form have to be translated through theme options....
 */

get_header();

$fwc = ffContainer::getInstance();
$postMeta = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade( $post->ID );
$pageTitle = $postMeta->getOption( 'page_title' );
$pageTitle = unserialize( base64_decode( $pageTitle ));
$sectionQuery = ffContainer::getInstance()->getOptionsFactory()->createQuery( $pageTitle, 'ffComponent_Theme_MetaboxPage_TitleView');

if( $sectionQuery->get('general show') ){
?>

<div class="ff-section-fullwidth">
	<div class="ff-section-boxed">
		<div class="container">
			<div class="headline style-1">
				<h2><?php
					the_title();
					?></h2>
			</div>
		</div>
	</div>
</div>

<?php } ?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div id="post-<?php the_ID(); ?>" <?php post_class("page-article page-content clearfix"); ?>>
				<?php
					the_post();
					the_content();
					wp_link_pages();
				?>
			</div>

			<?php
				ffTemporaryQueryHolder::setQuery('comments-form', ffThemeOptions::getQuery('translation') ); //   $query->get('comments-form'));
				ffTemporaryQueryHolder::setQuery('comments-list',  ffThemeOptions::getQuery('translation') ); //$query->get('comments-list'));
					comments_template();
				ffTemporaryQueryHolder::deleteQuery('comments-form');
				ffTemporaryQueryHolder::deleteQuery('comments-list');
			?>
		</div>
	</div>
</div>

<?php get_footer(); ?>