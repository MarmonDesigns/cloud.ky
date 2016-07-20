<?php

class ffComponent_Theme_SinglePost extends ffOptionsHolder {
	public function getOptions() {

		$s = $this->_getOnestructurefactory()->createOneStructure('layout');

		$s->startSection('general');

			$s->addElement( ffOneElement::TYPE_TABLE_START );

				$s->startSection('blogpost-header');

					$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Blogpost Header' );

						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show', 'Show', 1);
						$s->addElement( ffOneElement::TYPE_NEW_LINE );
						$s->addOption(ffOneOption::TYPE_TEXT, 'title', 'Title', 'Here is the big headline for your blog post');
						$s->addElement( ffOneElement::TYPE_NEW_LINE );
						$descriptionDefault = 'Morbi lacus massa, euismod ut turpis molestie, tristique sodales est. Integer sit amet mi id sapien tempor molestie in nec massa. Fusce non ante sed lorem rutrum feugiat.';
						$s->addOption(ffOneOption::TYPE_TEXTAREA, 'description', 'Description', $descriptionDefault );

					$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

				$s->endSection();

			$s->addElement( ffOneElement::TYPE_TABLE_END );

		$s->endSection();

		return $s;
	}
}