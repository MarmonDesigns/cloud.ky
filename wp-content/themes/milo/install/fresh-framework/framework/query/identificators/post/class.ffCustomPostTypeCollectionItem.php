<?php

class ffCustomPostTypeCollectionItem extends ffBasicObject {
	public function __construct( $id, $label, $labelSingular) {
		$this->id = $id;
		$this->label = $label;
		$this->labelSingular;
	}
	
	public $id = null;
	public $label = null;
	public $labelSingular = null;
}