<?php
/** @var ffOneStructure $s */

$s->startSection('comments-form');


        $s->addElement(ffOneElement::TYPE_HEADING,'','General Comment Form Options');

        $s->addOption( ffOneOption::TYPE_TEXT, 'heading', 'Form Heading', 'Leave a Reply');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'name', 'Name', 'Name');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'email', 'Email', 'Email');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'website', 'Website', 'Url');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'comment-form', 'Comment Form', 'Message');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'submit-button', 'Submit Button', 'Send');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'logged-in', 'Logged in text', 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>');

        $s->addElement(ffOneElement::TYPE_NEW_LINE );

$s->endSection();