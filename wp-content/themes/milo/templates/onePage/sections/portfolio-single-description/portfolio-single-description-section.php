<?php

/** @var $s ffOneStructure */
################################################################################
# PORTFOLIO START
################################################################################
$s->startSection('portfolio-single-description', ffOneSection::TYPE_REPEATABLE_VARIATION)
    ->addParam('section-name', 'Portfolio Single Description')
    ->addParam('hide-default', true)
    ->addParam('advanced-picker-menu-title', 'Common')
    ->addParam('advanced-picker-menu-id', 'common')
    ->addParam('advanced-picker-section-image', ff_get_section_preview_image_url('portfolio-single-description'));

    $s->addElement( ffOneElement::TYPE_TABLE_START );

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Preview');
        $s->addElement(ffOneElement::TYPE_HTML,'','<img src="'.ff_get_section_preview_image_url('portfolio-single-description').'" width="250">');
    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    ff_load_section_options('section-settings-block', $s);

    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'General');

        $s->startSection('boxes', ffOneSection::TYPE_REPEATABLE_VARIABLE );

            $s->startSection('detail-box', ffOneSection::TYPE_REPEATABLE_VARIATION)->addParam('section-name', 'Detail box');

                ff_load_section_options('bootstrap-columns-block', $s, array('sm' => 4));

                $s->startSection('details', ffOneSection::TYPE_REPEATABLE_VARIABLE);
                    $s->startSection('one-detail', ffOneSection::TYPE_REPEATABLE_VARIATION)
                        ->addParam('section-name', 'One detail');

                        $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Detail title', 'Client:');
                        $s->addElement(ffOneElement::TYPE_NEW_LINE);
                        $s->addOption(ffOneOption::TYPE_TEXT, 'content', 'Detail content', 'Soft easy company');
                        $s->addElement(ffOneElement::TYPE_NEW_LINE);

                    $s->endSection();
                $s->endSection();

            $s->endSection();

            $s->startSection('text-box', ffOneSection::TYPE_REPEATABLE_VARIATION)->addParam('section-name', 'Text box');

                ff_load_section_options('bootstrap-columns-block', $s, array('sm' => 4));

                $s->addOption(ffOneOption::TYPE_CHECKBOX, 'show-title', 'Show title', 1);
                $s->addElement(ffOneElement::TYPE_NEW_LINE);
                $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Detail title', 'Sed ut omis elit unde om nis iste natus volupta.');
                $s->addElement(ffOneElement::TYPE_NEW_LINE);

                $description = 'Eaque ipsa quae ab illo inventore veritatis et quasi archit ecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit as.';
                $s->addOption(ffOneOption::TYPE_TEXTAREA, 'description-text', 'Text', $description);

            $s->endSection();

        $s->endSection();

//        $s->addOption(ffOneOption::TYPE_CHECKBOX, 'details-checkbox', 'Show company details', 1);
//        $s->startSection('details', ffOneSection::TYPE_REPEATABLE_VARIABLE);
//            $s->startSection('one-detail', ffOneSection::TYPE_REPEATABLE_VARIATION)
//                ->addParam('section-name', 'One detail');
//            $s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Detail title', 'Client');
//            $s->addElement(ffOneElement::TYPE_NEW_LINE);
//            $s->addOption(ffOneOption::TYPE_TEXT, 'content', 'Detail content', 'Soft easy company');
//            $s->addElement(ffOneElement::TYPE_NEW_LINE);
//            $s->addOption(ffOneOption::TYPE_TEXT, 'link', 'Detail link', '');
//            $s->addElement(ffOneElement::TYPE_NEW_LINE);
//            $s->endSection();
//        $s->endSection();
//    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
//
//    $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Texts')
//        ->addParam('section-name', 'Texts');
//        $s->addOption(ffOneOption::TYPE_CHECKBOX, 'description-checkbox', 'Show company description', 1);
//        $s->addElement(ffOneElement::TYPE_NEW_LINE);
//        $s->addOption(ffOneOption::TYPE_TEXT, 'description-title', 'Title', 'Sed ut omis elit unde om nis iste natus volupta.');
//        $s->addElement(ffOneElement::TYPE_NEW_LINE);
//        $s->addOption(ffOneOption::TYPE_TEXTAREA, 'description-text', 'Text', 'Eaque ipsa quae ab illo inventore veritatis et quasi archit ecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit as.');
//        $s->addElement(ffOneElement::TYPE_NEW_LINE);
//        $s->addOption(ffOneOption::TYPE_TEXTAREA, 'additional-text', 'Additional text', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt dolor sit amet.');
//    $s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

    $s->addElement( ffOneElement::TYPE_TABLE_END );
$s->endSection();

################################################################################
# PORTFOLIO END
################################################################################