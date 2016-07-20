<?php
$numberOfPostsInColumn = $query->get('number-of-columns');

$oneColumnNumber = ff_boostrap_grid_translator( $numberOfPostsInColumn );
$oneColumnCss = 'col-sm-'.absint( $oneColumnNumber );

global $wp_query;
global $post;
$postsFound = $wp_query->found_posts;

$postLimited = $query->get('number-of-posts');

?>

<div class="container">
	<div class="row">
		<?php
			$postCounter = 0;
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					$postCounter++;

					?>
					<div id="post-<?php the_ID(); ?>" <?php post_class($oneColumnCss); ?>>
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
							?>
							</div>

							<?php
								if( ff_has_read_more() && $query->get('readmore-show') ) {
									if( $query->get('readmore-trans') ){
										echo '<a class="btn btn-default" href="'.get_the_permalink().'">'.ff_wp_kses( $query->get('readmore-trans') ).'</a>';
									}
								}
							?>

						</div>
						</div>
				<?php
						if( $postLimited == $postCounter ) break;
						if( ($postCounter % $numberOfPostsInColumn == 0 )&& ( $wp_query->current_post < ($wp_query->found_posts-1) || $postCounter < $postLimited )  ) {
							echo '</div></div>';
							echo '<div class="container"><div class="row">';
						}
					}
				}
			?>

	</div>
	<?php
		ff_load_section_printer('pagination', $query );
	?>
</div>



