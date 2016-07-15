<?php

class ffConditionalLogicConstants{

	// Page type

	const is_home            = 'is_home';
	const is_front_page      = 'is_front_page';
	const is_post_page       = 'is_not_front_page__and__is_home';
	const is_top_level_page  = 'is_top_level_page';
	const is_child_page      = 'is_child_page';
	const has_childs         = 'has_childs';
	const is_404             = 'is_404';

	// Page view

	const is_taxonomy        = 'is_taxonomy';
	const is_singular        = 'is_singular';
	const is_archive         = 'is_archive';

	// Page archive

	const is_author          = 'is_author';
	const is_search          = 'is_search';

	const is_date            = 'is_date';
	const is_day             = 'is_day';
	const is_month           = 'is_month';
	const is_year            = 'is_year';

	// System
	const min_IE_version    = 6;
	const max_IE_version    = 12;

}