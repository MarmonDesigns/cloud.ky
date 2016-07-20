<?php

/******************************************************************************/
/* ANIMATION BLOCK
/******************************************************************************/

$s->startSection('animation');

	$s->addElement( ffOneElement::TYPE_NEW_LINE );

	$_opt_ = $s->addOption( ffOneOption::TYPE_SELECT, 'type', 'Animation Type', '')
		->addSelectValue( 'None', '')
	;

	$possible_opt_values = array(
		'bounce' ,
		'flash' ,
		'pulse' ,
		'rubberBand' ,
		'shake' ,
		'swing' ,
		'tada' ,
		'wobble' ,
		'bounceIn' ,
		'bounceInDown' ,
		'bounceInLeft' ,
		'bounceInRight' ,
		'bounceInUp' ,
		'bounceOut' ,
		'bounceOutDown' ,
		'bounceOutLeft' ,
		'bounceOutRight' ,
		'bounceOutUp' ,
		'fadeIn' ,
		'fadeInDown' ,
		'fadeInDownBig' ,
		'fadeInLeft' ,
		'fadeInLeftBig' ,
		'fadeInRight' ,
		'fadeInRightBig' ,
		'fadeInUp' ,
		'fadeInUpBig' ,
		'fadeOut' ,
		'fadeOutDown' ,
		'fadeOutDownBig' ,
		'fadeOutLeft' ,
		'fadeOutLeftBig' ,
		'fadeOutRight' ,
		'fadeOutRightBig' ,
		'fadeOutUp' ,
		'fadeOutUpBig' ,
		'animated.flip' ,
		'flipInX' ,
		'flipInY' ,
		'flipOutX' ,
		'flipOutY' ,
		'lightSpeedIn' ,
		'lightSpeedOut' ,
		'rotateIn' ,
		'rotateInDownLeft' ,
		'rotateInDownRight' ,
		'rotateInUpLeft' ,
		'rotateInUpRight' ,
		'rotateOut' ,
		'rotateOutDownLeft' ,
		'rotateOutDownRight' ,
		'rotateOutUpLeft' ,
		'rotateOutUpRight' ,
		'hinge' ,
		'rollIn' ,
		'rollOut' ,
		'zoomIn' ,
		'zoomInDown' ,
		'zoomInLeft' ,
		'zoomInRight' ,
		'zoomInUp' ,
		'zoomOut' ,
		'zoomOutDown' ,
		'zoomOutLeft' ,
		'zoomOutRight' ,
		'zoomOutUp' ,
		'slideInDown' ,
		'slideInLeft' ,
		'slideInRight' ,
		'slideInUp' ,
		'slideOutDown' ,
		'slideOutLeft' ,
		'slideOutRight' ,
		'slideOutUp' ,
	);

	foreach ($possible_opt_values as $possible_value) {
		$possible_value_title = str_replace('-', ' ', $possible_value);
		$possible_value_title = ucfirst( $possible_value_title );
		$_opt_->addSelectValue( $possible_value_title, $possible_value );
	}

$s->endSection();

