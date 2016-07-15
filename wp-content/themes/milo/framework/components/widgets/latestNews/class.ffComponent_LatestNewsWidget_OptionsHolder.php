<?php

class ffComponent_LatestNewsWidget_OptionsHolder extends ffOptionsHolder {
	public function getOptions() {
		$s = $this->_getOnestructurefactory()->createOneStructure( 'latest-news-structure' );
		$s->startSection('latest-news', 'Latest News');

			$s->addElement( ffOneElement::TYPE_HTML, '', '<p>' );
				$s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Latest News');
			$s->addElement( ffOneElement::TYPE_HTML, '', '</p>' );


			$s->addElement( ffOneElement::TYPE_HTML, '', '<p>' );
				$s->addElement( ffOneElement::TYPE_HTML,'','Categories');
				$s->addOption( ffOneOption::TYPE_TAXONOMY, 'categories', 'Categories', 'all')
					->addParam('tax_type', 'category')
					->addParam('type', 'multiple')
					;
			$s->addElement( ffOneElement::TYPE_HTML, '', '</p>' );


			$s->addElement( ffOneElement::TYPE_HTML, '', '<p>' );
				$s->addOption(ffOneOption::TYPE_TEXT, 'number-of-posts', 'Number of Posts', '3');

			$s->addElement( ffOneElement::TYPE_HTML, '', '<p>' );
				$s->addOption(ffOneOption::TYPE_SELECT, 'style', 'Style', '')
					->addSelectValue('Normal', '')
					->addSelectValue('Alternative', 'alt')
				;
			$s->addElement( ffOneElement::TYPE_HTML, '', '</p>' );

		$s->endSection();
		return $s;
	}
}

