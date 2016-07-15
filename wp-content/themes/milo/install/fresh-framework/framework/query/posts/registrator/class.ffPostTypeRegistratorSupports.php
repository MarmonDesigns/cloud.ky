<?php
  
class ffPostTypeRegistratorSupports extends ffBasicObject {

	protected $_values = array(
		'title'           => TRUE,
		'editor'          => TRUE,
		'author'          => TRUE,
		'thumbnail'       => TRUE,
		'excerpt'         => TRUE,
		'trackbacks'      => FALSE,
		'custom-fields'   => FALSE,
		'comments'        => FALSE,
		'revisions'       => FALSE,
		'page-attributes' => FALSE,
		'post-formats'    => FALSE,
	);

	public function set( $name, $value ){
		$this->_values[ $name ] = $value;
		return $this;
	}

	public function get( $name ){
		return $this->_values[ $name ];
	}

	public function getArray(){
		$ret = array();
		foreach ($this->_values as $feature => $add_it) {
			if( $add_it ) {
				$ret[] = $feature;
			}
		}
		return $ret;
	}

}
?>