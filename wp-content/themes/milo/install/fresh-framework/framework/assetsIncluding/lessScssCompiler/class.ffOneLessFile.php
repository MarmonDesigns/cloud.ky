<?php

class ffOneLessFile extends ffBasicObject {
	const TYPE_BOOTSTRAP = 'bs';
	const TYPE_PLUGIN = 'plg';
	const TYPE_TEMPLATE = 'tmplt';
	const TYPE_USER = 'urs';
	const INFO_COLOR_LIBRARY_GROUP = 'inf_cl_lib_grp';
	const COLOR_LIBRARY_GROUP_USER = 'user_group';
	
	public $url = null;
	public $type = null;
	public $path = null;
	public $hash = null;
	public $content = null;
	public $priority = null;
	public $additionalInfo = null;
	
	public function getAdditionalInfo( $name ) {
		if( !isset( $this->additionalInfo[ $name ] ) ) {
			return null;
		} else {
			return $this->additionalInfo[ $name ];
		}
	}
	
	public function setAdditionalInfo( $name, $value ) {
		$this->additionalInfo[ $name ] = $value;
	}
	
}