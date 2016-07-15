<?php
	$numberOfPostsInColumn = $query->get('number-of-columns');
	$numberOfPosts = $query->get('number-of-posts');
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">

			<div class="isotope col-<?php echo esc_attr( $numberOfPostsInColumn); ?> clearfix">
				<?php
					$postCounter = 0;
					if ( have_posts() ) {
						while (have_posts()) {

							$postCounter++;
							if( $numberOfPosts > 0 && $postCounter > $numberOfPosts ) {
								break;
							}
							the_post();
							?>
					<div id="post-<?php the_ID(); ?>" <?php post_class("isotope-item"); ?>>

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
									, array('section'=>'blog-masonry')
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
						}
					}
				?>
			</div>

		</div>
	</div>
	<?php
		ff_load_section_printer('pagination', $query );
	?>
</div>
