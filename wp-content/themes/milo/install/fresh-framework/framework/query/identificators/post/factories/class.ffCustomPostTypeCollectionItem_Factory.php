<?php

class ffCustomPostTypeCollectionItem_Factory extends ffFactoryAbstract {
	public function createCustomPostTypeCollectionItem( $id = null, $label = null, $labelSingular = null ) {
		$this->_getClassloader()->loadClass('ffCustomPostTypeCollectionItem');
		return new ffCustomPostTypeCollectionItem($id, $label, $labelSingular);
	}
}