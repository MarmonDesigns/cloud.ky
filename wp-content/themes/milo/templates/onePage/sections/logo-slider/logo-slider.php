<div class="row">
	<div class="col-sm-12">
		<ul class="logos clearfix">
			<?php foreach ($query->get('logos') as $logo) { ?>
				<?php if( $logo->getImage('picture') ) { ?>
					<li><img src="<?php echo esc_url( $logo->getImage('picture')->url ); ?>" alt=""></li>
				<?php } ?>
			<?php } ?>
		</ul>
	</div>
</div>