<?php
  
class ffCustomTaxonomyArgs extends ffBasicObject {

	protected $_values = array(
		// 'labels'                => array(),
		// 'description'           => '',
		// 'public'                => true,
		// 'hierarchical'          => false,
		// 'show_ui'               => null,
		// 'show_in_menu'          => null,
		// 'show_in_nav_menus'     => null,
		// 'show_tagcloud'         => null,
		// 'meta_box_cb'           => null,
		// 'capabilities'          => array(),
		// 'rewrite'               => true,
		// 'query_var'             => $taxonomy,
		// 'update_count_callback' => '',
		// '_builtin'              => false,
		'update_count_callback' => '_update_post_term_count', 
	);

	public function set( $name, $value ){
		$this->_values[ $name ] = $value;
	}
	
	function getArray(){
		return $this->_values;
	}
}
  
?>