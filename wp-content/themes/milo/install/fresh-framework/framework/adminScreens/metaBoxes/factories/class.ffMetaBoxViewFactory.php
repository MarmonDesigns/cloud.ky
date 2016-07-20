<?php

class ffMetaBoxViewFactory extends ffFactoryAbstract {
	public function createMetaBoxView( $metaboxName ) {
		$fullClassName = $metaboxName . 'View';
		$this->_getClassloader()->loadClass('ffMetaBoxView');
		$this->_getClassloader()->loadClass( $fullClassName );
		
		$metaBoxView = new $fullClassName();
		
		return $metaBoxView;
	}
}