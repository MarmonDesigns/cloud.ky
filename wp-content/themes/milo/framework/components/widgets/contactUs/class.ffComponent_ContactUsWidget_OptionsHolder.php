<?php

class ffComponent_ContactUsWidget_OptionsHolder extends ffOptionsHolder {
	public function getOptions() {
		$s = $this->_getOnestructurefactory()->createOneStructure( 'contact-us-structure' );
		$s->startSection('contact-us', 'Contact Us');

			$s->addElement( ffOneElement::TYPE_HTML, '', '<p>' );
				$s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Contact Us');
			$s->addElement( ffOneElement::TYPE_HTML, '', '</p>' );

            $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->startSection('description-boxes', ffOneSection::TYPE_REPEATABLE_VARIABLE );
                    $s->startSection('one-box', ffOneSection::TYPE_REPEATABLE_VARIATION)->addParam('section-name', 'One Box');

                        $s->startSection('lines', ffOneSection::TYPE_REPEATABLE_VARIABLE );
                            $s->startSection('one-heading', ffOneSection::TYPE_REPEATABLE_VARIATION )->addParam('section-name', 'One Heading');
                                $s->addOption( ffOneOption::TYPE_TEXT, 'text', 'Text', 'Address');
                            $s->endSection();

                            $s->startSection('one-line', ffOneSection::TYPE_REPEATABLE_VARIATION )->addParam('section-name', 'One Text Line');
                                $s->addOption( ffOneOption::TYPE_TEXT, 'text', 'Text', '1713 Hide A Way Road');
                            $s->endSection();

                            $s->startSection('one-email', ffOneSection::TYPE_REPEATABLE_VARIATION )->addParam('section-name', 'One Email');
                                $s->addOption( ffOneOption::TYPE_TEXT, 'text', 'Text', 'your@email.com');
                            $s->endSection();
                        $s->endSection();

                    $s->endSection();
                $s->endSection();

            $s->addElement( ffOneElement::TYPE_NEW_LINE );

		$s->endSection();
		return $s;
	}
}

