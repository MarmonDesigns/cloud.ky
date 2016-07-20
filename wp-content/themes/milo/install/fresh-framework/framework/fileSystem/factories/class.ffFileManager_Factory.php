<?php
class ffFileManager_Factory extends ffFactoryAbstract {
	/**
	 * 
	 * @return ffFileManager
	 */
	public function createFileManager() {
		$this->_getClassloader()->loadClass('ffFileManager');
		return new ffFileManager();
	}
}