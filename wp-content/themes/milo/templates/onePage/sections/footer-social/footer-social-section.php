<?php
/** @var $s ffOneStructure */
################################################################################
# FOOTER SOCIAL START
################################################################################
$s->startSection('footer-social', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Footer social medias')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Footer')
    ->addParam('advanced-picker-menu-id', 'footer')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('footer-social'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('footer-social').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        ff_load_section_options( 'section-settings-block', $s );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Social medias')
            ->addParam('section-name', 'Social medias');
            $s->addOption(ffOneOption::TYPE_TEXTAREA, 'social-links', 'Social links', '');
        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# FOOTER SOCIAL END
################################################################################


