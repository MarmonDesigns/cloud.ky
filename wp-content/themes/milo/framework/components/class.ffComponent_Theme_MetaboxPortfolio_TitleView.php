<?php

class ffComponent_Theme_MetaboxPortfolio_TitleView extends ffOptionsHolder {
	public function getOptions() {
		$s = $this->_getOnestructurefactory()->createOneStructure( 'aaa');



		$s->startSection('general');
			$s->addElement( ffOneElement::TYPE_TABLE_START );

				ff_load_section_options( 'section-settings-block', $s);

				ff_load_section_options( 'section-background-block', $s);


				$s->startSection('page-title');
					$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Heading Title');
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-title', 'Show Title ', 1);
						$s->addElement( ffOneElement::TYPE_NEW_LINE );
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'is-custom-title', 'Use custom &nbsp; ', 0);
						$s->addOption( ffOneOption::TYPE_TEXT, 'title', '', 'Custom Page Title');
						$s->addElement( ffOneElement::TYPE_NEW_LINE );
					$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


					$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
					$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Subheading');

						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-description', 'Show Description', 1);
						$s->addElement( ffOneElement::TYPE_NEW_LINE );
						$s->addOption( ffOneOption::TYPE_SELECT, 'description-style', 'Description style', 'lead')
								->addSelectValue('Smaller', '')
								->addSelectValue('Bigger', 'lead');
						$s->addElement( ffOneElement::TYPE_NEW_LINE );
						$s->addOption( ffOneOption::TYPE_TEXTAREA, 'description', '', 'This is a sub-title placeholder, you can put your page description here.');

					$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
				$s->endSection();

				$s->startSection('breadcrumbs');
					$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Breadcrumbs');
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show', 'Show', 1);
						$s->addElement( ffOneElement::TYPE_NEW_LINE );
						$s->addOption( ffOneOption::TYPE_TEXT, 'before', 'Text before', 'You are here: ');
					$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
				$s->endSection();

			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$s->endSection();
		return $s;
	}
}

