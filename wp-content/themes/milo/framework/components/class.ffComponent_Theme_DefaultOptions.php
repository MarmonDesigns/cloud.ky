<?php

class ffComponent_Theme_DefaultOptions extends ffOptionsHolder {
	public function getOptions() {
		
		$s = $this->_getOnestructurefactory()->createOneStructure('layout');
		
		$s->startSection('sections', ffOneSection::TYPE_REPEATABLE_VARIABLE)
			->addParam('section-picker', 'advanced')
		;
 
		    $s->addOption(ffOneOption::TYPE_REVOLUTION_SLIDER, 'revo-slider', 'revo slider');
            $s->addOption( ffOneOption::TYPE_NAVIGATION_MENU_SELECTOR, 'menu-selector', 'menu-selector');
 
		$s->endSection();
		
		return $s;
	}
}