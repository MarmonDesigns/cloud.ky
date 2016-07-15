<?php
/** @var ffOneStructure $s */

$title = 'Section Options';

if( isset( $params['title'] ) ) {
    $title = $params['title'];
}

$s->startSection('section-settings');
$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', $title);
    $s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', $title);

        $s->addElement( ffOneElement::TYPE_TABLE_START );
/**********************************************************************************************************************/
/* GENERAL
/**********************************************************************************************************************/
            $s->startSection('general');
                $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'General');
                    $s->addOption( ffOneOption::TYPE_TEXT, 'id', 'Section ID ', '' );
                    $s->addElement( ffOneElement::TYPE_HTML, '', ' <span class="description">Option is used for linking. Leave blank for no ID.</span>');

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );
                    $s->addOption( ffOneOption::TYPE_SELECT, 'color-type', 'Color type', 'light')
                        ->addSelectValue('Light BG / Dark text', 'light')
                        ->addSelectValue('Dark BG / Light text', 'dark')
                        ;
                $s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
            $s->endSection();
/**********************************************************************************************************************/
/* FULLWIDTH
/**********************************************************************************************************************/
            $s->startSection('fullwidth');
                $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Fullwidth Wrapper');
                    $s->addOption( ffOneOption::TYPE_CHECKBOX, 'apply', 'Apply settings below', 'default');

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption( ffOneOption::TYPE_SELECT, 'margin-top', 'Margin top (px)', 'default')
                        ->addSelectValue('Default', 'default')
                        ->addSelectValue('0', '0')
                        ->addSelectNumberRange(5, 250, 5)
                        ;

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption( ffOneOption::TYPE_SELECT, 'margin-bottom', 'Margin bottom (px)', 'default')
                        ->addSelectValue('Default', 'default')
                        ->addSelectValue('0', '0')
                        ->addSelectNumberRange(5, 250, 5)
                        ;

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption( ffOneOption::TYPE_SELECT, 'padding-top', 'Padding top (px)', 'default')
                        ->addSelectValue('Default', 'default')
                        ->addSelectValue('0', '0')
                        ->addSelectNumberRange(5, 250, 5)
                        ;

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption( ffOneOption::TYPE_SELECT, 'padding-bottom', 'Padding bottom (px)', 'default')
                        ->addSelectValue('Default', 'default')
                        ->addSelectValue('0', '0')
                        ->addSelectNumberRange(5, 250, 5)
                        ;

                    $s->addElement(ffOneElement::TYPE_HEADING, '', 'Background');

                    $s->startSection('background');
                        ff_load_section_options( 'section-background-block', $s);
                    $s->endSection();

                $s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
            $s->endSection();
/**********************************************************************************************************************/
/* BOXED
/**********************************************************************************************************************/
            $s->startSection('boxed');
                $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Boxed Wrapper');
                    $s->addOption( ffOneOption::TYPE_CHECKBOX, 'apply', 'Apply settings below', 0);

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption( ffOneOption::TYPE_SELECT, 'width-type', 'Width Value', 'from-input')
                        ->addSelectValue('Fullwidth', 'fullwidth')
                        ->addSelectValue('Set Below', 'from-input')
                        ;

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption( ffOneOption::TYPE_TEXT, 'maxwidth', 'Max-width in px', '1170' );
                    $s->addElement( ffOneElement::TYPE_HTML, '', ' <span class="description">Max width of the boxed div, default is 1170</span>');

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption( ffOneOption::TYPE_SELECT, 'padding-top', 'Padding top (px)', 'default')
                        ->addSelectValue('Default', 'default')
                        ->addSelectValue('0', '0')
                        ->addSelectNumberRange(5, 250, 5)
                        ;

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption( ffOneOption::TYPE_SELECT, 'padding-bottom', 'Padding bottom (px)', 'default')
                        ->addSelectValue('Default', 'default')
                        ->addSelectValue('0', '0')
                        ->addSelectNumberRange(5, 250, 5)
                        ;

                    $s->addElement(ffOneElement::TYPE_HEADING, '', 'Background');

                    $s->startSection('background');
                        ff_load_section_options( 'section-background-block', $s);
                    $s->endSection();

                $s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
            $s->endSection();

           $s->startSection('container');
                $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Container Wrapper');
                    $s->addOption( ffOneOption::TYPE_CHECKBOX, 'apply', 'Apply settings below', 0);

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption( ffOneOption::TYPE_SELECT, 'type', 'Type', 'not')
                        ->addSelectValue('Container', 'not')
                        ->addSelectValue('Container Fluid', 'fluid')
                        ->addSelectValue('Container Fullwidth', 'fullwidth')
                        ;

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption( ffOneOption::TYPE_CHECKBOX, 'is-fulscreen', 'Is Fullscreen section', 0);

                $s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
            $s->endSection();

        $s->addElement( ffOneElement::TYPE_TABLE_END );

    $s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
$s->endSection();