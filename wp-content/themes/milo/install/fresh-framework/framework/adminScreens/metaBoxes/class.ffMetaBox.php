<?php

/*
 *   add_meta_box( $id, $title, $callback, $post_type, $context,
         $priority, $callback_args );
 */
abstract class ffMetaBox extends ffBasicObject {
	const CONTEXT_NORMAL = 'normal';
	const CONTEXT_SIDE = 'side';
	const CONTEXT_ADVANCED = 'advanced';
	
	const PRIORITY_HIGH = 'high';
	const PRIORITY_CORE = 'core';
	const PRIORITY_DEFAULT = 'default';
	const PRIORITY_LOW = 'low';
	
	const VISIBILITY_PAGE_TEMPLATE = 'visibility_page_template';
	
	const PARAM_NORMALIZE_OPTIONS = 'param_normalize_options';
	
	private $_id = null;
	private $_title = null;
	private $_context = null;
	private $_priority = null;
	private $_postType = null;
	
	private $_visibility = array();
	
	private $_params = array();
	/**
	 * 
	 * @var ffMetaBoxView
	 */
	private $_view = null;
	
	/**
	 * 
	 * @var ffMetaBoxViewFactory
	 */
	private $_metaBoxViewFactory = null;
	
	public function __construct( ffMetaBoxViewFactory $metaBoxViewFactory ) {
		$this->_setMetaBoxViewFactory($metaBoxViewFactory);
		
		$this->_setContext( ffMetaBox::CONTEXT_ADVANCED );
		$this->_setPriority( ffMetaBox::PRIORITY_DEFAULT);
		$this->_initMetabox();
	}
	
	protected function _addVisibility( $param, $value ) {
		if( !isset( $this->_visibility[ $param ] ) ) {
			$this->_visibility[ $param ] = array();
		}
		
		$this->_visibility[ $param ][] = $value;
	}
	
	
	protected function _setParam( $name, $value ) {
		$this->_params[ $name ] = $value;
	}
	
	protected function _getParam( $name, $default = null ) {
		if( isset( $this->_params[ $name ] ) ) {
			return $this->_params[ $name ];
		} else {
			return $default;
		}
	} 
	
	public function getTitle() { return $this->_title; }
	public function getId() {
		if( $this->_id != null ) {
			return $this->_id;
		} else {
			return preg_replace("/[^a-zA-Z0-9]+/", "", $this->_title);
		}
	}
	
	public function getContext() { return $this->_context; }
	public function getPriority() { return $this->_priority; }
	public function getPostType() { return $this->_postType; }
	
	public function render( $postId ) {
		$this->_getView()->setVisibility( $this->_visibility );
		$this->_getView()->setParams( $this->_params );
		$this->_getView()->render( $postId );
	}
	
	public function ajaxRequest( ffAjaxRequest $ajaxRequest ) {
		$this->_getView()->ajaxRequest( $ajaxRequest );
	}
	
	public function save( $postId ) {
		$this->_getView()->setVisibility( $this->_visibility );
		$this->_getView()->setParams( $this->_params );
		$this->_getView()->save( $postId );
	}
	
	protected function _setTitle( $title ) {
		$this->_title = $title;
	}
	
	protected function _addPostType( $postType ) {
		if( $this->_postType == null ) {
			$this->_postType = array();
		}
		
		$this->_postType[] = $postType;
	}
	
	protected function _setPriority( $priority ) {
		$this->_priority = $priority;
	}
	
	protected function _setContext( $context ) {
		$this->_context = $context;
	}
	
	protected abstract function _initMetabox();
	
	/**
	 * @return ffMetaBoxView
	 */
	private function _getView() {
		if( $this->_view == null ) {
			$this->_view = $this->_getMetaBoxViewFactory()->createMetaBoxView( get_class( $this ) );
		}
		
		return $this->_view;
	}
	
	/**
	 *
	 * @return ffMetaBoxViewFactory
	 */
	protected function _getMetaBoxViewFactory() {
		return $this->_metaBoxViewFactory;
	}
	
	/**
	 *
	 * @param ffMetaBoxViewFactory $metaBoxViewFactory        	
	 */
	protected function _setMetaBoxViewFactory(ffMetaBoxViewFactory $metaBoxViewFactory) {
		$this->_metaBoxViewFactory = $metaBoxViewFactory;
		return $this;
	}
	
}