<?php

class ffComponent_LatestPortfolioWidget_OptionsHolder extends ffOptionsHolder {
	public function getOptions() {
		$s = $this->_getOnestructurefactory()->createOneStructure( 'latest-news-structursse' );
		$s->startSection('latest-portfolio', 'Latest Portfolio');

			$s->addElement( ffOneElement::TYPE_HTML, '', '<p>' );
				$s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Latest Portfolio');
			$s->addElement( ffOneElement::TYPE_HTML, '', '</p>' );


			$s->addElement( ffOneElement::TYPE_HTML, '', '<p>' );
				$s->addElement( ffOneElement::TYPE_HTML,'','Portfolio Categories');
				$s->addOption( ffOneOption::TYPE_TAXONOMY, 'categories', 'Portfolio Categories', 'all')
					->addParam('tax_type', 'ff-portfolio-category')
					->addParam('type', 'multiple')
					;
			$s->addElement( ffOneElement::TYPE_HTML, '', '</p>' );


			$s->addElement( ffOneElement::TYPE_HTML, '', '<p>' );

				$s->addOption(ffOneOption::TYPE_TEXT, 'number-of-posts', 'Number of Posts', '3');

			$s->addElement( ffOneElement::TYPE_HTML, '', '<p>' );

                $s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-description', 'Show description', 0);

			$s->addElement( ffOneElement::TYPE_HTML, '', '</p>' );

            $s->addElement( ffOneElement::TYPE_HTML, '', '<p>' );

                $description = 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt';
                $s->addOption( ffOneOption::TYPE_TEXTAREA, 'description', 'Description', $description);

			$s->addElement( ffOneElement::TYPE_HTML, '', '</p>' );

		$s->endSection();
		return $s;
	}
}

