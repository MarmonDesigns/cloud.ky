<?php
	$backgroundImage = $query->getImage('image')->url;
	if( !empty($backgroundImage) ){
		$backgroundImageString = ' style="background-image: url(' . esc_url( $backgroundImage ) . ');"';
		$extra_class = ' parallax';
	}else{
		$backgroundImageString = '';
		$extra_class = '';
	}
?>

<div class="row">
	<div class="col-sm-12">

		<div class="info-box<?php echo esc_attr( $extra_class ); ?>"<?php echo   $backgroundImageString; ?>>
			<?php ff_load_section_printer('heading-content', $query->get('content')); ?>
		</div><!-- info-box -->

	</div><!-- col -->
</div><!-- row -->
