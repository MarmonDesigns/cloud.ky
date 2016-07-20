<?php
switch ( $query->get('sidebar') ) {
	case 'none': $contentClass = ''; break;
	case 'right': $contentClass = 'col-sm-9'; break;
	case 'left': $contentClass = 'col-sm-9 pull-right'; break;
}

the_post();

?>
<div class="container">
	<div class="row">
		<div id="post-<?php the_ID(); ?>" <?php	post_class( $contentClass ); ?>>

			<div class="blog-article">
				<?php
					ff_load_section_printer(
						'blog-featured-area'
						, $query->get('blog-meta featured-image')
						, array('section'=>'blog-classic')
					);
				?>
				<?php
					ff_load_section_printer(
						'blog-meta'
						, $query
						, array('section'=>'blog-classic')
					);
				?>

				<div class="post-content clearfix">
				<?php
					the_content('');
					wp_link_pages();
				?>
				</div>

			</div><!-- blog-article -->

			<?php
				if( $query->get('author-box show') ) {
					$postMetaGetter = ffContainer()->getThemeFrameworkFactory()->getPostMetaGetter();
					?>
					<div class="blog-article-author">

						<p>
							<?php echo  $postMetaGetter->getPostAuthorImage(80); ?>
							<?php echo ff_wp_kses( $postMetaGetter->getPostAuthorName() ); ?>
						</p>

						<div class="blog-article-author-details clearfix">

							<h4><?php echo ff_wp_kses( $query->get('author-box title') ); ?></h4>
							<p>
								<?php echo ff_wp_kses( $postMetaGetter->getPostAuthorDescription() ); ?>
							</p>

						</div>
						<!-- blog-article-author-details -->

					</div><!-- blog-article-author -->
				<?php
				}
			?>
			<?php
				ffTemporaryQueryHolder::setQuery('comments-form', $query->get('comments-form'));
				ffTemporaryQueryHolder::setQuery('comments-list', $query->get('comments-list'));
				comments_template();
				ffTemporaryQueryHolder::deleteQuery('comments-form');
				ffTemporaryQueryHolder::deleteQuery('comments-list');
			?>

		</div><!-- col -->
		<?php

			if( $query->get('sidebar') != 'none' ) {
				echo '<div class="col-sm-3';
				if( $query->get('sidebar') == 'left' ) {
					echo ' pull-left';
				}
				echo '">';
					if( is_active_sidebar('sidebar-content') ) {
						dynamic_sidebar('sidebar-content');
					}
				echo '</div>';
			}
		?>
	</div><!-- row -->
</div><!-- ontainer -->
