<?php

class ffCustomTaxonomy extends ffBasicObject {

	protected $_slug;

	protected $_args;
	protected $_conected_post_types = array() ;
	protected $_labels;


	function getArgs(){   return $this->_args; }
	function getConnectedPostTypes(){ return $this->_conected_post_types; }
	function getLabels(){ return $this->_labels; }


	function setArgs($val){   return $this->_args = $val; }
	function connectToPostType( $post_type ){ $this->_conected_post_types[] = $post_type; }
	function setLabels($val){ return $this->_labels = $val; }


	function __construct( $_slug ){
		$this->_slug = $_slug;
	}
	
	function getBuildArgs(){
		$_args = $this->_args->getArray();
		$_args['labels'] = $this->_labels->getArray();

		return $_args;
	}

	function setSlug( $user_slug ){
		$this->getArgs()->set( 'rewrite', array('slug' => $user_slug ) );
	}

	public function setCategoryBehaviour(){
		$_args = $this->_args->set('hierarchical',true);	
	}
}

?>