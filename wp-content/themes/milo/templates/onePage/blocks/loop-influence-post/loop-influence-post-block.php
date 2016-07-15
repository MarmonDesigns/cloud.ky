<?php
/** @var ffOneStructure $s */
$s->startSection('loop-influence-post-block');
    $s->addElement( ffOneElement::TYPE_HTML, '', '<strong style="color:red;">Please note, this option will be applied only if you are outside Blog Category archive</strong> Also please note that posts per page are inherited from WP Admin -> Settings -> Reading');

    $s->addOption( ffOneOption::TYPE_TAXONOMY, 'categories', 'Categories', 'all')
        ->addParam('tax_type', 'category')
        ->addParam('type', 'multiple')
    ;
$s->endSection();