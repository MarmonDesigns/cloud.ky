<div class="icon <?php
	echo esc_attr( $query->get('shape') );
?> <?php
	echo esc_attr( $query->getIcon('icon-background') );
?> <?php
	echo esc_attr( $query->getIcon('icon-size') );
?>">
	<i class="<?php echo esc_attr( $query->getIcon('icon') ); ?>"></i>
</div>
<div class="iconbox-content">
	<?php $title_size = $query->get('title-size'); ?>
	<h<?php echo absint($title_size); ?> class="title"><?php $query->printText('title');?></h<?php echo absint($title_size); ?>>
	<p><?php $query->printText('description');?></p>
	<?php
		if( $query->get('show-button') ){
			ff_load_section_printer(
				'button'
				, $query->get('button')
			);
		}
	?>
</div>