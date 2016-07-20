<?php

class ffComponent_Theme_MetaboxPortfolio_CategoryView extends ffOptionsHolder {
	public function getOptions() {
		$s = $this->_getOnestructurefactory()->createOneStructure( 'category');

		$s->startSection('general');
			$s->addElement( ffOneElement::TYPE_TABLE_START );

                $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Date');
                    $s->startSection('date');
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'different', 'Use this date instead of date when portfolio has been created', 0);
						$s->addElement(ffOneElement::TYPE_NEW_LINE );
						$s->addOption( ffOneOption::TYPE_TEXT, 'date', 'Date', '05 March 2015');
                        $s->addElement(ffOneElement::TYPE_NEW_LINE );
					$s->endSection();
				$s->addElement(ffOneElement::TYPE_TABLE_DATA_END );


                $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Title');
                    $s->startSection('title');
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'different', 'Use this Title instead of portfolio title', 0);
						$s->addElement(ffOneElement::TYPE_NEW_LINE );
						$s->addOption( ffOneOption::TYPE_TEXT, 'title', 'Title', 'Conceptual industrial design');
                        $s->addElement(ffOneElement::TYPE_NEW_LINE );
					$s->endSection();
				$s->addElement(ffOneElement::TYPE_TABLE_DATA_END );

                $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Sub Title');
                    $s->startSection('subtitle');
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'different', 'Use this Sub Title instead of first portfolio tag', 0);
						$s->addElement(ffOneElement::TYPE_NEW_LINE );
						$s->addOption( ffOneOption::TYPE_TEXT, 'subtitle', 'Sub Title', 'Packaging design');
                        $s->addElement(ffOneElement::TYPE_NEW_LINE );
					$s->endSection();
				$s->addElement(ffOneElement::TYPE_TABLE_DATA_END );

                $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Description');
                    $s->startSection('description');
                        $default = 'Lorem ipsum dolor sit amet, consectetur enim ad minim elit, sed do eiusmod tempor omis unde ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.';
						$s->addOption( ffOneOption::TYPE_TEXTAREA, 'description', 'Description', $default);
                        $s->addElement(ffOneElement::TYPE_NEW_LINE );
					$s->endSection();
				$s->addElement(ffOneElement::TYPE_TABLE_DATA_END );

                $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Button (if presented)');
                    $s->startSection('button');
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'different-caption', 'Use this caption instead of settings from Portfolio Classic Arhcive', 0);
						$s->addElement(ffOneElement::TYPE_NEW_LINE );
                        $s->addOption( ffOneOption::TYPE_TEXT, 'caption', 'Caption', 'Caption');
                        $s->addElement(ffOneElement::TYPE_NEW_LINE );


                        $s->addOption( ffOneOption::TYPE_CHECKBOX, 'different-url', 'Use this URL for button instead of linking to Single Portfolio', 0);
						$s->addElement(ffOneElement::TYPE_NEW_LINE );
						$s->addOption( ffOneOption::TYPE_TEXT, 'url', 'Packaging design', 'http://www.yoururl.com/');
                        $s->addElement(ffOneElement::TYPE_NEW_LINE );
					$s->endSection();
				$s->addElement(ffOneElement::TYPE_TABLE_DATA_END );


				// $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Heading');
				// 	$s->startSection('text');
				// 		$s->addOption( ffOneOption::TYPE_TEXT, 'title', 'Title', 'Project Title');
				// 		$s->addElement(ffOneElement::TYPE_NEW_LINE );
				// 		$s->addOption( ffOneOption::TYPE_TEXT, 'subtitle', 'Subtitle', 'Website Design');
				// 	$s->endSection();
				// $s->addElement(ffOneElement::TYPE_TABLE_DATA_END );

			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$s->endSection();
		return $s;
	}
}

