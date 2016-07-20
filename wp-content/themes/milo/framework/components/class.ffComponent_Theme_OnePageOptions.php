<?php

class ffComponent_Theme_OnePageOptions extends ffOptionsHolder {
	public function getOptions() {
		$s = $this->_getOnestructurefactory()->createOneStructure( 'data' );
		
		
		$s->startSection('sections', ffOneSection::TYPE_REPEATABLE_VARIABLE)
			->addParam('section-picker', 'advanced')
		;
		
			ff_load_nonstandard_section_options( '/framework/components/sectionIncluding.php', $s);
		
		$s->endSection();

		return $s;
	}
}