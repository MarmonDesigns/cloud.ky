<?php
switch ( $query->get('sidebar') ) {
	case 'none': $contentClass = ''; break;
	case 'right': $contentClass = 'col-sm-9'; break;
	case 'left': $contentClass = 'col-sm-9 pull-right'; break;
}

$numberOfPosts = $query->get('number-of-posts');
?>

<div class="row">
	<div class="<?php echo esc_attr( $contentClass ); ?>">
	<?php
		$postCounter = 0;
		if ( have_posts() ) {
			while (have_posts()) {
				the_post();

				$postCounter++;

				if( $numberOfPosts > 0 && $postCounter > $numberOfPosts ) {
					break;
				}
				?>
					<div id="post-<?php the_ID(); ?>" <?php post_class("blog-article"); ?>>
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
							if( is_search() || has_excerpt() || get_option('rss_use_excerpt') ){
								the_excerpt();
							}else{
								the_content('');
								wp_link_pages();
							}
						?>
						</div>

						<?php
							if( ( ff_has_read_more() || has_excerpt() || get_option('rss_use_excerpt') ) && $query->get('readmore-show') ) {
								if( $query->get('readmore-trans') ){
									echo '<a class="btn btn-default" href="'.get_the_permalink().'">'.ff_wp_kses( $query->get('readmore-trans') ).'</a>';
								}
							}
						?>

					</div>
			<?php
				}
			}else{
				echo '<p>';
				echo ff_wp_kses( $query->get('search-not-found') );
				echo '</p>';
				echo '<div class="widget_search">';
				get_search_form();
				echo '</div>';
			}
		?>
	</div>
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

</div>

<?php
	ff_load_section_printer('pagination', $query );
?>



