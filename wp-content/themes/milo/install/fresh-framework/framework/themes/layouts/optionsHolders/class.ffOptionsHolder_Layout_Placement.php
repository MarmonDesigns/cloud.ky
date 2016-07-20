<?php

class ffOptionsHolder_Layout_Placement extends ffOptionsHolder {
	public function getOptions() {
		
		$s = $this->_getOnestructurefactory()->createOneStructure('layout');
		
		$s->startSection('placement');
		    $s->addElement( ffOneElement::TYPE_HTML,'', '<div id="post-formats-select" class="ff-custom-code-placement">');

                $s->addOption(ffOneOption::TYPE_CHECKBOX, 'active', 'Layout is Active', 1);

                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption(ffOneOption::TYPE_RADIO, 'placement', '', 'content')
                    ->addParam('break-line-at-end', true)
                    ->addSelectValue('Header', 'header')
                    ->addSelectValue('Before Content', 'before-content')
                    ->addSelectValue('Content', 'content')
                    ->addSelectValue('After Content', 'after-content')
                    ->addSelectValue('Footer', 'footer');
		
		        $s->addOption(ffOneOption::TYPE_SELECT, 'priority', 'Priority ', '5')
                    ->addSelectValue('1 (highest)', '1')
                    ->addSelectValue('2', '2')
                    ->addSelectValue('3', '3')
                    ->addSelectValue('4', '4')
                    ->addSelectValue('5 (default)', '5')
                    ->addSelectValue('6', '6')
                    ->addSelectValue('7', '7')
                    ->addSelectValue('8', '8')
                    ->addSelectValue('9', '9')
                    ->addSelectValue('10 (lowest)', '10');

		        $s->addElement( ffOneElement::TYPE_NEW_LINE );

		        $s->addOption( ffOneOption::TYPE_CHECKBOX, 'default', 'Default (show when nothing else found AND the conditional logic passes)', 0);


			$s->addElement( ffOneElement::TYPE_HTML,'', '</div>');
		$s->endSection();
		
		return $s;
	}
}