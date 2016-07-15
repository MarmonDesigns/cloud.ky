<?php
/** @var ffOneStructure $s  */

$s->startSection('bootstrap-columns');
//$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Bootstrap Columns');
    $s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', 'Bootstrap Columns');

        $s->addElement( ffOneElement::TYPE_TABLE_START );
/**********************************************************************************************************************/
/* GENERAL
/**********************************************************************************************************************/
//            $s->startSection('columns');
                $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Columns');
// xs, sm. md. lg

                    $xs = $sm = $md = $lg = 'no';

                    if( isset( $params['xs'] ) ) {
                        $xs = $params['xs'];
                    }

                    if( isset( $params['sm'] ) ) {
                        $sm = $params['sm'];
                    }

                    if( isset( $params['md'] ) ) {
                        $md = $params['md'];
                    }

                    if( isset( $params['lg'] ) ) {
                        $lg = $params['lg'];
                    }

                    $s->addOption(  ffOneOption::TYPE_SELECT, 'xs', 'XS', $xs )
                        ->addSelectValue('Dont use', 'no')
                        ->addSelectNumberRange(1,12)
                        ;

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption(  ffOneOption::TYPE_SELECT, 'sm', 'SM', $sm )
                        ->addSelectValue('Dont use', 'no')
                        ->addSelectNumberRange(1,12)
                        ;

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption(  ffOneOption::TYPE_SELECT, 'md', 'MD', $md )
                        ->addSelectValue('Dont use', 'no')
                        ->addSelectNumberRange(1,12)
                        ;

                    $s->addElement( ffOneElement::TYPE_NEW_LINE );

                    $s->addOption(  ffOneOption::TYPE_SELECT, 'lg', 'LG', $lg )
                        ->addSelectValue('Dont use', 'no')
                        ->addSelectNumberRange(1,12)
                        ;

                $s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
//            $s->endSection();

        $s->addElement( ffOneElement::TYPE_TABLE_END );

    $s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
//$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
$s->endSection();