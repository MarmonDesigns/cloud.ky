<form
	role="search"
	method="get"
	id="searchform"
	class="searchform"
	action="<?php echo esc_url( home_url( '/' ) ); ?>"
>
	<input
		name="s"
		id="s"
		type="text"
		placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder' ); ?>"
		value="<?php echo get_search_query(); ?>"
	/>
	<input
		class="btn btn-default"
		type="submit"
		value=""
	/>
</form>
