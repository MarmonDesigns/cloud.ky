<?php if( $query->get('show-whole' ) ) { ?>

	<header class="content-header <?php
		if( $query->get('show-points') ){
			echo 'section-header ';
		}
		echo esc_attr( $query->get('text-align') );
		?>">

		<?php if( $query->get('show-title') ) { ?>
			<h2><?php $query->printText('title'); ?></h2>
		<?php } ?>

		<?php if( $query->get('show-description') ) { ?>
			<p class="<?php echo esc_attr( $query->get('description-style') ); ?>"><?php $query->printText('description'); ?></p>
		<?php } ?>

	</header>

<?php } ?>