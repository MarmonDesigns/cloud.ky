<?php
/** @var ffOneStructure $s  */

$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Featured Area');
    $s->startSection('blog-meta');
        $s->startSection('featured-image');
            $s->addOption( ffOneOption::TYPE_CHECKBOX,'show', 'Show Featured Image',1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE);

            $s->addOption( ffOneOption::TYPE_CHECKBOX,'resize', 'Resize Featured image',1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE);

            $s->addElement(ffOneElement::TYPE_DESCRIPTION, '','Please note, that original dimensions are: 848x334 - blog classic, and 360x325 for blog columns');
            $s->addElement( ffOneElement::TYPE_NEW_LINE);

            $s->addOption( ffOneOption::TYPE_TEXT,'width', 'Featured Image width',0);
            $s->addElement( ffOneElement::TYPE_NEW_LINE);

            $s->addOption( ffOneOption::TYPE_TEXT,'height', 'Featured Image height',0);
            $s->addElement( ffOneElement::TYPE_NEW_LINE);

            $s->addOption( ffOneOption::TYPE_CHECKBOX,'lightbox', 'Enable Ligthbox',1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE);
        $s->endSection();

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Title and Meta');

        $s->addOption( ffOneOption::TYPE_SELECT, 'size', 'Size ', '')
            ->addSelectValue('Normal', '')
            ->addSelectValue('Small', 'small');
        $s->addElement( ffOneElement::TYPE_NEW_LINE);

        $s->startSection('date');
            $s->addOption( ffOneOption::TYPE_CHECKBOX,'show', 'Show date &nbsp;',1);
            $s->addOption( ffOneOption::TYPE_TEXT,'format', 'in format','j F Y');
            $s->addElement( ffOneElement::TYPE_NEW_LINE);
        $s->endSection();

        $s->startSection('author');
            $s->addOption( ffOneOption::TYPE_CHECKBOX,'show', 'Show author',1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE);
        $s->endSection();

        $s->startSection('categories');
            $s->addOption( ffOneOption::TYPE_CHECKBOX,'show', 'Show Categories',1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE);
        $s->endSection();

        $s->startSection('tags');
            $s->addOption( ffOneOption::TYPE_CHECKBOX,'show', 'Show Tags',1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE);
        $s->endSection();

        $s->startSection('comments');
            $s->addOption( ffOneOption::TYPE_CHECKBOX,'show', 'Show Comments',1);
            $s->addElement( ffOneElement::TYPE_NEW_LINE);
        $s->endSection();
    $s->endSection();
$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
