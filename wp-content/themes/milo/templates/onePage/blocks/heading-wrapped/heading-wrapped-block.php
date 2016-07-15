<?php
/** @var ffOneStructure $s */

$s->startSection('heading-wrapped-block');

    $s->addOption(ffOneOption::TYPE_SELECT, 'wrapper-type', 'Style', '3')
        ->addSelectValue('Type 1', 1 )
        ->addSelectValue('Type 2', 2 )
        ->addSelectValue('Type 3', 3 )
        ->addSelectValue('Type 4', 4 )
        ;


    ff_load_section_options( 'heading-content-block', $s);

$s->endSection('/heading-wrapped-block');
