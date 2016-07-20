<?php
/** @var $s ffOneStructure */
################################################################################
# PRICING tables START
################################################################################
$s->startSection('pricing-tables', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Pricing Tables')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('pricing-tables'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('pricing-tables').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        ff_load_section_options('section-settings-block', $s);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Pricing table');
            $s->startSection('tables', ffOneSection::TYPE_REPEATABLE_VARIABLE);
                $s->startSection('one-table', ffOneSection::TYPE_REPEATABLE_VARIATION)
                    ->addParam('section-name', 'One table');

                        $s->addElement( ffOneElement::TYPE_TABLE_START );
                            $s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Bootstrap Columns Options and animations' );

                                ff_load_section_options( 'bootstrap-columns-block', $s, array('sm'=>4));

                                ff_load_section_options('animation-block', $s );

                            $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

                            $s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Header' );

                                $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Starter');
                                $s->addElement(ffOneElement::TYPE_NEW_LINE);
                                $s->addOption(ffOneOption::TYPE_TEXT, 'price', 'Price', '25');
                                $s->addElement(ffOneElement::TYPE_NEW_LINE);
                                $s->addOption(ffOneOption::TYPE_TEXT, 'currency', 'Currency', '$');
                                $s->addElement(ffOneElement::TYPE_NEW_LINE);
                                $s->addOption(ffOneOption::TYPE_TEXT, 'time-period', 'Time period', 'per month');
                                $s->addElement(ffOneElement::TYPE_NEW_LINE);

                            $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

                            $s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Content' );
                                $s->startSection('rows', ffOneSection::TYPE_REPEATABLE_VARIABLE);
                                    $s->startSection('one-row', ffOneSection::TYPE_REPEATABLE_VARIATION)
                                        ->addParam('section-name', 'One row');
                                        $s->addOption(ffOneOption::TYPE_TEXT, 'item', 'Item', '2 Domain Names');
                                    $s->endSection();
                                $s->endSection();

                             $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


                            $s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Button' );

                                $s->addElement(ffOneElement::TYPE_NEW_LINE);
                                ff_load_section_options( 'button-block', $s );
                                $s->addElement(ffOneElement::TYPE_NEW_LINE);

                            $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

                        $s->addElement( ffOneElement::TYPE_TABLE_END );
                $s->endSection();
            $s->endSection();
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# PRICING tables END
################################################################################
