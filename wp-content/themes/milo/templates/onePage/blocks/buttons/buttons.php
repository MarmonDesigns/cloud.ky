<?php

$align = $query->get('text-align');

if( $align ){
	echo '<div class="'.esc_attr( $align ).'">';
}

$buttons = $query->get('buttons');

foreach( $buttons as $oneButton ) {
	ff_load_section_printer(
		'button'
		, $oneButton->get('button')
	);
}

if( $align ){
	echo '</div>';
}
