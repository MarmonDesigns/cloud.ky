<?php

class ffCustomTaxonomyCollectionItem extends ffBasicObject {
	public function __construct( $id, $label, $labelSingular) {
		$this->id = $id;
		$this->label = $label;
		$this->labelSingular;
	}

    public function isAppliedToPostType( $postType ) {
        return in_array( $postType, $this->appliedToObjects );
    }
	
	public $id = null;
	public $label = null;
	public $labelSingular = null;
    public $appliedToObjects = null;
    public $hierarchical = null;
}