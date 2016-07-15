<?php
	$query = $query->get('heading-wrapped-block');
	$styleClass = 'headline style-' . esc_attr( $query->get('wrapper-type') );
	if( 4 == $query->get('wrapper-type') ){
		$styleClass = 'text-center';
	}
?>
<div class="row">
	<div class="col-sm-12">
		<div class="<?php echo  $styleClass; ?>">
			<?php ff_load_section_printer( 'heading-content', $query ); ?>
		</div><!-- headline -->
	</div>
</div>