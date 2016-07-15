<?php

$prev = get_previous_comments_link();
$next = get_next_comments_link();

if( !empty( $prev ) or !empty( $next ) ){
	ob_start();
	paginate_comments_links( array(
		'prev_text' => '&lsaquo;',
		'next_text' => '&rsaquo;')
	);
	$pagin = ob_get_clean();

	$pagin = str_replace( '<a ','<li><a ', $pagin );
	$pagin = str_replace( '</a>','</a></li>', $pagin );

	$pagin = str_replace( '<span ','<li class="active"><a href="'.get_the_permalink().'" ', $pagin );
	$pagin = str_replace( '</span>','</a></li>', $pagin );

	$pagin = preg_replace('/>\s+</', '><', $pagin);

	echo '<div class="row">';
	echo '<div class="col-sm-12">';
	echo '<ul class="pagination">';

	echo  $pagin;

	echo '</ul>';
	echo '</div>';
	echo '</div>';
}
