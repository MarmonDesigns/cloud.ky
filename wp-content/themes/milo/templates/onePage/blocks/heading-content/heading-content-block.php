<?php
/** @var ffOneStructure $s */

$s->startSection('heading-content-block');

$s->startSection('content', ffOneSection::TYPE_REPEATABLE_VARIABLE);
/**********************************************************************************************************************/
/* One Line (heading or paragraph)
/**********************************************************************************************************************/
    $s->startSection('one-line', ffOneSection::TYPE_REPEATABLE_VARIATION)
        ->addParam('section-name', 'One Line');
            $s->addOption(ffOneOption::TYPE_TEXTAREA, 'text', 'Text', 'The project for you');
            $s->addElement(ffOneElement::TYPE_NEW_LINE);
            $s->addOption(ffOneOption::TYPE_SELECT, 'type', 'Type', 'h1')
                ->addSelectValue('H1', 'h1')
                ->addSelectValue('H2', 'h2')
                ->addSelectValue('H3', 'h3')
                ->addSelectValue('H4', 'h4')
                ->addSelectValue('H5', 'h5')
                ->addSelectValue('H6', 'h6')
                ->addSelectValue('BR (new line)', 'br')
                ->addSelectValue('Paragraph', 'p')
                ;
         ff_load_section_options( 'animation-block', $s );
    $s->endSection();

/**********************************************************************************************************************/
/* BUTTON
/**********************************************************************************************************************/
    $s->startSection('one-button', ffOneSection::TYPE_REPEATABLE_VARIATION)
        ->addParam('section-name', 'One Button');

         ff_load_section_options( 'button-block', $s );
         ff_load_section_options( 'animation-block', $s );

    $s->endSection();

/**********************************************************************************************************************/
/* HTML
/**********************************************************************************************************************/
    $s->startSection('one-html', ffOneSection::TYPE_REPEATABLE_VARIATION)
        ->addParam('section-name', 'HTML');

            $s->addOption(ffOneOption::TYPE_TEXTAREA, 'html', 'HTML');

    $s->endSection();


/**********************************************************************************************************************/
/* ICON
/**********************************************************************************************************************/
    $s->startSection('one-icon', ffOneSection::TYPE_REPEATABLE_VARIATION)
        ->addParam('section-name', 'Icon');

            $s->addOption(ffOneOption::TYPE_ICON, 'icon', 'Icon');

    $s->endSection();



$s->endSection();

$s->endSection('/heading-content');
