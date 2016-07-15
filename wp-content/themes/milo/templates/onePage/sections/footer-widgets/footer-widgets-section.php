<?php
/** @var $s ffOneStructure */
################################################################################
# FOOTER SOCIAL START
################################################################################
$s->startSection('footer-widgets', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Footer Widgets')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Footer')
    ->addParam('advanced-picker-menu-id', 'footer')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('footer-widgets'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('footer-widgets').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');

            for( $i = 1; $i <= 4; $i ++ ) {
                $s->addOption(ffOneOption::TYPE_SELECT, 'footer-sidebar-'.  $i, 'Footer Widgets #'.  $i.' sidebar size * 1/12', '3')
                        ->addSelectValue('Dont Show', 'dont-show')
                        ->addSelectNumberRange(1,12)
                        ;
                $s->addElement( ffOneElement::TYPE_NEW_LINE );
            }

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# FOOTER SOCIAL END
################################################################################


