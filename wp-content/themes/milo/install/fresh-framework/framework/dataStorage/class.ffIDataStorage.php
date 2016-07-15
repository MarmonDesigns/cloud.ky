<?php

interface ffIDataStorage {
	public function setOption( $namespace, $name, $value );
	public function getOption( $namespace, $name, $default=null );
	public function deleteOption( $namespace, $name );
}