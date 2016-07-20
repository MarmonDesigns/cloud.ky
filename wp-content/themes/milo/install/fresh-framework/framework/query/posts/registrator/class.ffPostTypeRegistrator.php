<?php

class ffPostTypeRegistrator extends ffBasicObject {

	protected $_slug;

	protected $_args;
	protected $_supports;
	protected $_labels;
	protected $_messages;

	function getArgs(){     return $this->_args; }
	function getSupports(){ return $this->_supports; }
	function getLabels(){   return $this->_labels; }
	function getMessages(){ return $this->_messages; }

	function setArgs($val){     return $this->_args     = $val; }
	function setSupports($val){ return $this->_supports = $val; }
	function setLabels($val){   return $this->_labels   = $val; }
	function setMessages($val){ return $this->_messages = $val; }

	function __construct( $_slug ){
		$this->_slug = $_slug;
	}

	function getBuildArgs(){
		$_args = $this->_args->getArray();
		$_args['labels'] = $this->_labels->getArray();
		$_args['supports'] = $this->_supports->getArray();
		return $_args;
	}

	function setSlug( $user_slug ){
		$this->getArgs()->set( 'rewrite', array('slug' => $user_slug ) );
	}

	function actionFilterPostUpdatedMessages( $messages ){
		$messages[ $this->_slug ] = $this->_messages->getMessages();
		return $messages;
	}

	function actionFilterPostRowViewAction( $actions ) {
		global $post;
		if ( $this->_slug == $post->post_type && isset( $actions['view'] ) ){
			unset( $actions['view'] );
		}
		return $actions;
	}

	function actionFilterPostRowInlineEditAction( $actions ) {
		global $post;
		if ( $this->_slug == $post->post_type && isset( $actions['inline hide-if-no-js'] ) ){
			unset( $actions['inline hide-if-no-js'] );
		}
		return $actions;
	}
}





