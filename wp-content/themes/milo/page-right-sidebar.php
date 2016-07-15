<?php
/**
 * Template Name: Page Right Sidebar
 *
 * @package WordPress
 * @subpackage Milo
 * @since Milo 1.0
 */

get_header();

?>

	<div class="container">
		<div class="row">
			<div class="col-sm-9">
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
			<div class="col-sm-3">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>

<?php

get_footer();

