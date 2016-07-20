<?php

class ffComponent_Theme_MetaboxPortfolio_SingleView extends ffOptionsHolder {
	public function getOptions() {
		$s = $this->_getOnestructurefactory()->createOneStructure( 'aaa');

		$s->startSection('general');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Front Image');
					$s->startSection('image');
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'fullwidth', 'Front image is fulwidth (overlays sidebar)', 0);
						$s->addElement(ffOneElement::TYPE_NEW_LINE );
					$s->endSection();
				$s->addElement(ffOneElement::TYPE_TABLE_DATA_END );

				$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Sidebar');
					$s->startSection('sidebar');
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show', 'Show sidebar', 1);
						$s->addElement(ffOneElement::TYPE_NEW_LINE );


						$s->startSection( 'items', ffOneSection::TYPE_REPEATABLE_VARIABLE );
							$s->startSection('about', ffOneSection::TYPE_REPEATABLE_VARIATION)->addParam('section-name', 'About');
								$s->addOption( ffOneOption::TYPE_TEXT, 'title', 'Title', 'About Project');
								$s->addElement(ffOneElement::TYPE_NEW_LINE );
								$text = '<p>Culpa eu et pariatur tempor est aliquip qui anim enim culpa magna laboris sint aliqua ad excepteur mollit.</p>';
								$s->addOption( ffOneOption::TYPE_TEXTAREA, 'text', 'Text', $text);
							$s->endSection();

							$s->startSection('tools', ffOneSection::TYPE_REPEATABLE_VARIATION)->addParam('section-name', 'Tools');
								$s->addOption( ffOneOption::TYPE_TEXT, 'title', 'Title', 'Tools Used');
								$s->addElement(ffOneElement::TYPE_NEW_LINE );

								$s->startSection( 'skills', ffOneSection::TYPE_REPEATABLE_VARIABLE );
									$s->startSection('one-skill', ffOneSection::TYPE_REPEATABLE_VARIATION )->addParam('section-name', 'One Skill');
										$s->addOption( ffOneOption::TYPE_TEXT, 'title', 'Title', 'Photoshop');
										$s->addElement(ffOneElement::TYPE_NEW_LINE);
										$s->addOption( ffOneOption::TYPE_TEXT, 'percentage', 'Percentage', '75');
									$s->endSection();
								$s->endSection();
							$s->endSection();

							 $s->startSection('details', ffOneSection::TYPE_REPEATABLE_VARIATION)->addParam('section-name', 'Project Details');
								$s->addOption( ffOneOption::TYPE_TEXT, 'title', 'Title', 'Project Details');
								$s->addElement(ffOneElement::TYPE_NEW_LINE );

								$s->startSection( 'details', ffOneSection::TYPE_REPEATABLE_VARIABLE );
									$s->startSection('one-detail', ffOneSection::TYPE_REPEATABLE_VARIATION )->addParam('section-name', 'One Detail');
										$s->addOption( ffOneOption::TYPE_ICON, 'icon', 'Icon', '');
										$s->addElement(ffOneElement::TYPE_NEW_LINE);
										$s->addOption( ffOneOption::TYPE_TEXT, 'type', 'Type', 'Client');
										$s->addElement(ffOneElement::TYPE_NEW_LINE);
										$s->addOption( ffOneOption::TYPE_TEXT, 'value', 'Value', 'Google, Inc');
									$s->endSection();
								$s->endSection();

								ff_load_section_options( 'buttons-block', $s);

							$s->endSection();

						$s->endSection();
					$s->endSection();
				$s->addElement(ffOneElement::TYPE_TABLE_DATA_END );

				$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Related Projects');
					$s->startSection('related-projects');
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show', 'Show Related Projects', 1);
						$s->addElement(ffOneElement::TYPE_NEW_LINE );
					$s->endSection();
				$s->addElement(ffOneElement::TYPE_TABLE_DATA_END );

			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$s->endSection();
		return $s;
	}
}

