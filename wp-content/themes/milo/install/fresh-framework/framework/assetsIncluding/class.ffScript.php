<?php

class ffScript extends ffBasicObject {
	const TYPE_FW = 'type_fw';
	const TYPE_THIRD = 'type_third';
	const TYPE_PLUG = 'type_plug';
	const TYPE_WIDGET = 'type_widget';
	const TYPE_SCODE = 'type_scode';
	const TYPE_THEME = 'type_theme';

	public function __construct( $handle = null, $source = null, $dependencies = null, $version = null, $inFooter = null, $type = null, $additionalInfo = null ) {
		$this->handle = $handle;
		$this->source = $source;
		$this->dependencies = $dependencies;
		$this->inFooter = $inFooter;
		$this->version = $version;
		$this->type = $type;
		$this->additionalInfo = $additionalInfo;
	}

    public function addData( $key, $value ) {
        if( $this->data == null ) {
            $this->data = array();
        }

        $this->data[ $key ] = $value;
    }
	
	public $handle = null;
	public $source = null;
	public $dependencies = null;
	public $version = null;
	public $inFooter = null;
	public $type = null;
	public $additionalInfo = false;
    public $data = null;
}