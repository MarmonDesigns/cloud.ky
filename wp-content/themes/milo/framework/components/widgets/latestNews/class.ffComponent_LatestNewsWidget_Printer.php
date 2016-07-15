<?php

class ffComponent_LatestNewsWidget_Printer extends ffBasicObject {
	public function printComponent( $args, ffOptionsQuery $query) {
		$categories = $query->getMultipleSelect('latest-news categories');
		$numberOfPosts = $query->get('latest-news number-of-posts');

		$postGetter = ffContainer()->getPostLayer()->getPostGetter();

		$posts = $postGetter->setFilterRelation_OR()->setNumberOfPosts($numberOfPosts)->filterByCategory( $categories )->getAllPosts();

		echo  $args['before_widget'];

		echo  $args['before_title'];
		echo ff_wp_kses( $query->get('latest-news title') );
		echo  $args['after_title'];

		echo '<ul';
		if( 'alt' == $query->get('latest-news style') ){
			echo ' class="alt"';
		}
		echo '>';

		if( 'alt' == $query->get('latest-news style') ){
			foreach( $posts as $onePost ) {
				$featuredImageUrl = $onePost->getFeaturedImage();

				if( empty( $featuredImageUrl ) ) {
					continue;
				}

				$featuredImageUrlResized = fImg::resize( $featuredImageUrl, 65, 65, true );
				echo '<li>';
					echo '<img src="'.esc_url( $featuredImageUrlResized ).'" alt="">';
					echo '<a href="'.get_permalink( $onePost->getID() ).'" class="post-title">'.ff_wp_kses( $onePost->getTitle() ).'</a>';
					echo '<p class="post-date">'.ff_wp_kses( $onePost->getDateFormated( 'F d, Y' ) ).'</p>';
				echo '</li>';
			}
		}else{
			foreach( $posts as $onePost ) {
				$featuredImageUrl = $onePost->getFeaturedImage();

				if( empty( $featuredImageUrl ) ) {
					continue;
				}

				$featuredImageUrlResized = fImg::resize( $featuredImageUrl, 80, 80, true );
				echo '<li>';
					echo '<img src="'.esc_url( $featuredImageUrlResized ).'" alt="">';
					echo '<p class="news-title">';
					echo '<a href="'.get_permalink( $onePost->getID() ).'">'.ff_wp_kses( $onePost->getTitle() ).'</a>';
					echo '</p>';
					echo '<p class="news-date">'.ff_wp_kses( $onePost->getDateFormated( 'F d, Y' ) ).'</p>';
				echo '</li>';
			}
		}

		echo '</ul>';

		echo  $args['after_widget'];
	}
}