<div class="project-slider-tabs">
	<?php ff_print_before_section( $query->get('section-settings-navigation section-settings')); ?>
	<div class="row">
		<div class="col-sm-12">
			<div id="project-slider-control">
				<?php
					foreach( $query->get('projects') as $key => $oneProject ) {
						$projectName = $oneProject->get('project-name');
						echo '<a data-slide-index="'.esc_attr( $key ).'" href="">'.ff_wp_kses( $projectName ).'</a>';
					}
				?>
			</div>
		</div>
	</div>
	<?php ff_print_after_section( $query->get('section-settings-navigation section-settings')); ?>
</div>

<?php $sliderHeight = $query->get('slider-height'); ?>

<div class="project-slider">
	<ul>
		<?php
			foreach( $query->get('projects') as $oneProject ) {
				$imageNonResized = $oneProject->getImage('project-image')->url;
				$imageUrlResized = fImg::resize( $imageNonResized, 1868, $sliderHeight, true);
				echo '<li>';
					echo '<img src="' . esc_url( $imageUrlResized ) . '" alt="">';
					echo '<div class="slide-description">';
						ff_load_section_printer('heading-content', $oneProject );
					echo '</div>';
				echo '</li>';
			}
		?>
	</ul>
</div>
