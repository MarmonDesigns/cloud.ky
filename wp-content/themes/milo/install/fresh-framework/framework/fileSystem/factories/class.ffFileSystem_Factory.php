<?php

class ffFileSystem_Factory extends ffFactoryAbstract {
	/**
	 * 
	 * @param ffWPLayer $WPLayer
	 * @return ffFileSystem
	 */
	public function createFileSystem( ffWPLayer $WPLayer ) {
		$this->_getClassloader()->loadClass('ffFileSystem');
		
		$WPLayer->add_filter('filesystem_method', array( $this, 'fileSystemMethodDirect') );
		
		$WPLayer->WP_Filesystem();
		
		$WPFileSystem = $WPLayer->get_WP_filesystem();
		
		
		$WPLayer->remove_filter('filesystem_method', array( $this, 'fileSystemMethodDirect') );
		
		$fileSystem = new ffFileSystem( $WPLayer, $WPFileSystem);
		
		return $fileSystem;
	}
	
	public function fileSystemMethodDirect( $method ) {
		return 'direct';
	}
	
	

}