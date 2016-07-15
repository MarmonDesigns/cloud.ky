<?php
/** @var ffOneStructure $s */

$s->startSection('comments-list');

    $s->startSection('heading');
        $s->addElement(ffOneElement::TYPE_HEADING,'','General Comments Options');
        $s->addOption(ffOneOption::TYPE_CHECKBOX, 'show', 'Show Heading', 1);
        $s->addElement(ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'trans-zero', 'No Comments', 'Comments (0)');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'trans-one', 'One Comment', 'Comments (1)');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'trans-more', '%s Comments', 'Comments (%s)');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );
    $s->endSection();

    $s->startSection('one-comment');
        $s->addElement(ffOneElement::TYPE_HEADING,'','One Comment Options');

        $s->addOption(ffOneOption::TYPE_CHECKBOX, 'show-date', 'Show Date', 1);
        $s->addElement(ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'date-format', 'Date Format', 'M d, Y, \a\t g:i A');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );


        $s->addOption( ffOneOption::TYPE_TEXT, 'trans-reply', 'Reply comment', 'reply');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );

        $s->addOption( ffOneOption::TYPE_TEXT, 'trans-moderation', 'Awaiting for moderation', 'Your comment is awaiting moderation.');
        $s->addElement(ffOneElement::TYPE_NEW_LINE );
    $s->endSection();

$s->endSection();