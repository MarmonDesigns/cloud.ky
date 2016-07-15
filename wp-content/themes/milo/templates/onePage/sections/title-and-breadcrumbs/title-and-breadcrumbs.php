<div id="page-header"<?php
if( $query->get('background color-type') ){
	echo ' class="'.esc_attr( $query->get('background color-type') ).'"';
}
if( 'default' != $query->get('background margin-bottom') ){
    echo ' style="margin-bottom:'.absint( $query->get('background margin-bottom') ).'px"';
}
?>>
<?php
ff_load_section_printer(
    'section-background'
    , $query->get('background')
);
?>
	<div class="container">
		<div class="row">
			<?php if( $query->get('show-title') ) { ?>
				<div class="col-sm-6 pull-left">
					<h4><?php
						ff_load_section_printer(
							'page-title'
							, $query->get('translation')
						);
					?></h4>
				</div>
			<?php } ?>
			<?php
				if( $query->get('breadcrumbs show') ) {

					echo '<div class="col-sm-6 pull-right">';

						$breadcrumbsCollection = ffContainer()->getLibManager()->createBreadcrumbs()->generateBreadcrumbs();

						echo '<ol class="breadcrumb">';
							$breadcrumbsArray = array();
							$connector = '';
							foreach( $breadcrumbsCollection as $oneItem ) {
								$nextItem = '';

								if( $oneItem->queryType == ffConstQuery::HOME ) {
									$oneItem->name = $query->get('breadcrumbs homepage');
								}


								if( $oneItem->isSelected ) {
									$nextItem .= '<li class="active">';
										$nextItem .= ff_wp_kses( $oneItem->name );
									$nextItem .= '</li>';
								} else {
									$nextItem .= '<li><a href="'.esc_url( $oneItem->url ).'">';
										$nextItem .= ff_wp_kses( $oneItem->name );
									$nextItem .= '</a></li>';
								}


								$breadcrumbsArray[] = $nextItem;
							}

							echo implode( $connector, $breadcrumbsArray );

						echo '</ol>';
					echo '</div>';
				}
			?>
		</div>
	</div>
</div>
