<?php
/** @var $s ffOneStructure */
################################################################################
# CONTACT FORM 1 START
################################################################################
$s->startSection('contact-form-2', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Contact Form 2')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('contact-form-2'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('contact-form-2').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        ff_load_section_options( 'section-settings-block', $s );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Contact Form');
            $s->startSection('contact-form');
                $s->addOption(ffOneOption::TYPE_TEXT, 'name', 'Name', 'name');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption(ffOneOption::TYPE_TEXT, 'email', 'Email', 'email');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption(ffOneOption::TYPE_TEXT, 'subject', 'Subject', 'subject');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption(ffOneOption::TYPE_TEXT, 'message', 'Message', 'message');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption(ffOneOption::TYPE_TEXT, 'button', 'Button', 'Submit');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );
            $s->endSection();
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Contact Form User Data');
            $s->startSection('contact-form-user-input');

                $s->addOption(ffOneOption::TYPE_TEXT, 'email', 'Your email address (where to receive emails)', 'your@email.com');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption(ffOneOption::TYPE_TEXT, 'subject', 'Subject of the emails received', 'Milo contact form');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->endSection();
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Contact Form Messages');
            $s->startSection('contact-form-messages');

                $s->addOption(ffOneOption::TYPE_TEXT, 'validation-name', 'Validation Name', 'Please enter your name!');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption(ffOneOption::TYPE_TEXT, 'validation-email', 'Validation Email (empty)', 'Please enter your email!');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption(ffOneOption::TYPE_TEXT, 'validation-email-format', 'Validation Email (format)', 'Please enter a valid email address');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );


                $s->addOption(ffOneOption::TYPE_TEXT, 'validation-subject', 'Validation subject', 'Please enter the subject!');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );


                $s->addOption(ffOneOption::TYPE_TEXT, 'validation-message', 'Validation Message (empty)', 'Please enter your message!');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption(ffOneOption::TYPE_TEXT, 'validation-message-minlength', 'Validation Message (minlength)', 'At least {0} characters required');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );


                $s->addOption(ffOneOption::TYPE_TEXT, 'message-send-ok', 'Message has been sent', 'Your message was successfully sent!');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->addOption(ffOneOption::TYPE_TEXT, 'message-send-wrong', 'Message has NOT been sent', 'There was an error sending the message!');
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

            $s->endSection();
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Description');
            $s->startSection('description');
                $s->addOption(ffOneOption::TYPE_CHECKBOX, 'show', 'Show', 1);
                $s->addElement( ffOneElement::TYPE_NEW_LINE );

                $s->startSection('description-boxes', ffOneSection::TYPE_REPEATABLE_VARIABLE );
                    $s->startSection('one-box', ffOneSection::TYPE_REPEATABLE_VARIATION)->addParam('section-name', 'One Box');

                        ff_load_section_options('bootstrap-columns-block', $s, array('sm'=>4) );

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

            $s->endSection();
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# CONTACT FORM 1 END
################################################################################
