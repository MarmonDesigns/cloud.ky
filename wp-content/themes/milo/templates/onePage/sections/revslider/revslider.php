<div class="bannercontainer">
<?php

if( function_exists('putRevSlider') ){
	$revslider = $query->get('revslider');
	putRevSlider( $revslider->get('id') );
}else{
	?>
		<div class="container">
			<h4 class="title">We have a problem here</h4>
			<p>You used Revolution Slider section, but you have not installed this plugin: Function <code>putRevSlider()</code> does not work!</p>
		</div>
	<?php
}

?></div>