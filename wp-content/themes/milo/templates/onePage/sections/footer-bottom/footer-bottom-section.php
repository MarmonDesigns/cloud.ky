<?php
/** @var $s ffOneStructure */
################################################################################
# FOOTER SOCIAL START
################################################################################
$s->startSection('footer-bottom', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Footer Bottom')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Footer')
    ->addParam('advanced-picker-menu-id', 'footer')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('footer-bottom'));

	$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
			$s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('footer-bottom').'" width="250">');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');

            $textContent = '<p class="last text-center text-uppercase">&copy; All Rights Reserved <span class="text-primary">Milo</span><span class="text-lowercase"> template.</span></p>';
            $s->addOption(ffOneOption::TYPE_TEXTAREA, 'content', 'Social links', $textContent);

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	$s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# FOOTER SOCIAL END
################################################################################


