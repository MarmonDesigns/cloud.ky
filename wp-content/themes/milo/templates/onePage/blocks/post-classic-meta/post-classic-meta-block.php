<?php
                $s->startSection('post-classic-meta');
                    $s->startSection('featured-image');
                        $s->addOption( ffOneOption::TYPE_CHECKBOX,'show', 'Show Featured Image',1);
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);

                        $s->addOption( ffOneOption::TYPE_TEXT,'width', 'Featured Image width',780);
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);

                        $s->addOption( ffOneOption::TYPE_TEXT,'height', 'Featured Image height',0);
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);
                    $s->endSection();

                    $s->startSection('date');
                        $s->addOption( ffOneOption::TYPE_CHECKBOX,'show', 'Show date',1);
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);

                        $s->addOption( ffOneOption::TYPE_TEXT,'format', 'Date format','F j, Y');
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);
                    $s->endSection();

                    $s->startSection('author');
                        $s->addOption( ffOneOption::TYPE_CHECKBOX,'show', 'Show author',1);
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);

                        $s->addOption( ffOneOption::TYPE_TEXT,'text-before', 'Text before','Posted by');
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);
                    $s->endSection();

                    $s->startSection('categories');
                        $s->addOption( ffOneOption::TYPE_CHECKBOX,'show', 'Show Categories',1);
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);

                        $s->addOption( ffOneOption::TYPE_TEXT,'text-before', 'Text before','in');
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);
                    $s->endSection();

                    $s->startSection('comments');
                        $s->addOption( ffOneOption::TYPE_CHECKBOX,'show', 'Show Comments',1);
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);

                        $s->addOption( ffOneOption::TYPE_TEXT,'zero', '0 Comments','0 Comments');
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);
                        $s->addOption( ffOneOption::TYPE_TEXT,'one', '1 Comment','1 Comment');
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);
                        $s->addOption( ffOneOption::TYPE_TEXT,'more', 'X Comments','%s Comments');
                        $s->addElement( ffOneElement::TYPE_NEW_LINE);
                    $s->endSection();
                $s->endSection();