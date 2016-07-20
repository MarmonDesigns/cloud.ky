<?php

global $accordions_index;
if( empty($accordions_index) ){
	$accordions_index = 0;
}
$accordions_index ++;
$index = 0;

?>
<h2 class="accordion-section-title"><?php $query->printText('title'); ?></h2>

<div class="panel-group" id="accordion_<?php echo  $accordions_index; ?>">
	<?php
	$index = 0;
	foreach ($query->get('accordion') as $oneAccordion){
		$index++;
	?>
		<div class="panel">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse"
						data-parent="#accordion_<?php echo  $accordions_index; ?>"
						href="#collapse_<?php echo  $accordions_index; ?>__<?php echo  $index; ?>"
						aria-expanded="false"
						class="collapsed"
					><?php $oneAccordion->printText('title'); ?></a>
				</h4>
			</div>
			<div id="collapse_<?php echo  $accordions_index; ?>__<?php echo  $index; ?>" class="panel-collapse collapse">
				<div class="panel-body">
					<p><?php $oneAccordion->printText('description'); ?></p>
				</div>
			</div>
		</div>
	<?php } ?>
</div>
