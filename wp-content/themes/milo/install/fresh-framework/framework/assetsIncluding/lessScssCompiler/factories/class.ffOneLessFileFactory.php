<?php

class ffOneLessFileFactory extends ffFactoryAbstract {
	public function createOneLessFile() {
		$this->_getClassloader()->loadClass('ffOneLessFile');
		$oneLessFile = new ffOneLessFile();
		
		return $oneLessFile;
	}
}