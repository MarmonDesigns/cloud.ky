<?php

class ffCustomTaxonomyCollectionItem_Factory extends ffFactoryAbstract {
	
	public function createCustomTaxonomyCollectionItem( $id = null, $label = null, $labelSingular = null) {
		$this->_getClassloader()->loadClass('ffCustomTaxonomyCollectionItem');
		$customTaxonomyCollectionItem = new ffCustomTaxonomyCollectionItem($id, $label, $labelSingular);
		return $customTaxonomyCollectionItem;
	}	
}