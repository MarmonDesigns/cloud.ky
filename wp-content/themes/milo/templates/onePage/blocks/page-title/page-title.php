<?php

if( is_404() ){
	$query->printText('title-404');
}else if( is_page() ){
	the_title();
}else if( is_single() ){
	printf( $query->get('title-post'), get_the_title() );
}else if( is_category() ){
	printf( $query->get('title-category'), single_cat_title('', false) );
}else if( is_tag() ){
	printf( $query->get('title-tag'), single_cat_title('', false) );
}else if( is_tax() ){
	echo single_term_title('', false);
}else if( is_author() ){
	if( ! in_the_loop() ){
		the_post();
		rewind_posts();
	}
	printf( $query->get('title-author'), get_the_author() );
}else if( is_search() ){
	printf( $query->get('title-search'), get_search_query() );
}else if( is_home() ){
	echo ff_wp_kses( $query->get('title-posts-page') );
}else if(is_date()){
	if( ! in_the_loop() ){
		the_post();
		rewind_posts();
	}
	if( is_day() ){
		printf( $query->get('title-day'), get_the_time( $query->get('title-day-format') ) );
	}else if( is_month() ){
		printf( $query->get('title-month'), get_the_time( $query->get('title-month-format') ) );
	}else if( is_year() ){
		printf( $query->get('title-year'), get_the_time( $query->get('title-year-format') ) );
	}
}
