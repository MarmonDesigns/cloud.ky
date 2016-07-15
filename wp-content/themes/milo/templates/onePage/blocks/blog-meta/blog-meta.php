<?php

global $post;

$metaQuery = $query->get('blog-meta');


$imageUrlNonresized = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
$imageUrlResized = null;
$featuredImageQuery = $metaQuery->get('featured-image');
$style = '';


if( $imageUrlNonresized != null && $featuredImageQuery->get('show') ) {
	$width = $featuredImageQuery->get('width');
	$height = $featuredImageQuery->get('height');


	if( absint($width) == 0 ) {
		$width = null;
	}

	if( absint($height) == 0 ) {
		$height = null;
	}
	$crop = false;

	if( $width != null || $height != null ) {
		$style = 'style="';

		if( $width != null ) {
			$style .= 'width:'.absint($width).'px;';
		}

		if( $height != null ) {
			$style .= 'height:'.absint($height).'px;';
		}

		$style .= '"';
		$style = '';
		$imageUrlResized = fImg::resize( $imageUrlNonresized, $width, $height, true );
	} else {
		$imageUrlResized = $imageUrlNonresized;
	}
}

$postMetaGetter = ffContainer()->getThemeFrameworkFactory()->getPostMetaGetter();

if( 'small' == $metaQuery->get('size') ) {
	$line_1_tag = 'h6';
	$line_2_tag = 'h4';
}else{
	$line_1_tag = 'h4';
	$line_2_tag = 'h2';
}


?>
<div class="blog-article-details">
<?php

	if( $metaQuery->get('date show') ) {
		echo '<' .  $line_1_tag . '>';
		echo get_the_date( $metaQuery->get('date format') );
		echo '</' .  $line_1_tag . '>';
	}

	echo '<' .  $line_2_tag . '>';
		echo '<a href="'; the_permalink(); echo '">';
			the_title();
		echo '</a>';
	echo '</' .  $line_2_tag . '>';

	$basicMeta = array();

	if( $metaQuery->get('author show') ) {
		$authorMeta = '';
		$authorMeta .= '<span class="post-meta-object">';
		$authorMeta .= '<i class="miu-icon-business_namecard_contact_info_outline_stroke"></i> ';
		$authorMeta .= '<a href="'.esc_url( $postMetaGetter->getPostAuthorUrl() ).'">';
		$authorMeta .= $postMetaGetter->getPostAuthorName();
		$authorMeta .= '</a>';
		$authorMeta .= '</span>';

		$basicMeta[] = $authorMeta;
	}

	if( $metaQuery->get('categories show') ) {
		$categoryMeta = '';

		if( has_category() ){
			$categoryMeta .= '<span class="post-meta-object">';
            $categoryMeta .= '<i class="miu-icon-editor_folder_add_outline_stroke"></i> ';
            $categoryMeta .= $postMetaGetter->getPostCategoriesHtml();
			$categoryMeta .= '</span>';
        }

		$basicMeta[] = $categoryMeta;

	}

	if( $metaQuery->get('tags show') ) {
		$tagMeta = '';


		if( has_tag() ) {
			$tagMeta .= '<span class="post-meta-object">';
			$tagMeta .= '<i class="miu-icon-common_tag_2_general_price_outline_stroke"></i> ';
			$tagMeta .= $postMetaGetter->getPostTagsHtml();
			$tagMeta .= '</span>';
		}

		$basicMeta[] = $tagMeta;

	}

	if( $metaQuery->get('comments show') ) {
		$commentsMeta = '';

		$commentsMeta .= '<span class="post-meta-object">';
		$commentsMeta .= '<i class="miu-icon-other_conversation_review_comment_bubble_talk_outline_stroke"></i> ';
		$commentsMeta .= $postMetaGetter->getPostCommentsLinkText('0','1','%s');
		$categoryMeta .= '</span>';

		$basicMeta[] = $commentsMeta;
	}

	if( !empty ( $basicMeta ) ) {
		echo '<p>';
		echo( implode('<br class="visible-xs"> ', $basicMeta ) );
		echo '</p>';
	}

?>
</div><!-- blog-article-details -->
