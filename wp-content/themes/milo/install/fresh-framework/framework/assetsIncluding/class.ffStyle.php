<?php

class ffStyle extends ffBasicObject {
	const TYPE_FW = 'type_fw';
	const TYPE_THIRD = 'type_third';
	const TYPE_PLUG = 'type_plug';
	const TYPE_WIDGET = 'type_widget';
	const TYPE_SCODE = 'type_scode';
	const TYPE_THEME = 'type_theme';
	
	const PARAM_ADDITIONAL_INFO = 'ff_additional_info';

	public function __construct( $handle = null, $source = null, $dependencies = null, $version = null, $media = null, $type = null, $additionalInfo = null ) {
		$this->handle = $handle;
		$this->source = $source;
		$this->dependencies = $dependencies;
		$this->media = $media;
		$this->version = $version;
		$this->type = $type;
		$this->additionalInfo = $additionalInfo;
	}
	
	public $handle = null;
	public $source = null;
	public $dependencies = null;
	public $version = null;
	public $media = null;
	public $type = null;
	public $additionalInfo = null;
}