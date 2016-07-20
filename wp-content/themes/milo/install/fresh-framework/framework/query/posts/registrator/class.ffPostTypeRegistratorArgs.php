<?php
  
class ffPostTypeRegistratorArgs extends ffBasicObject {

	protected $_values = array(
		// 'labels'               => array(),
		// 'description'          => '',
		// 'public'               => false,
		// 'hierarchical'         => false,
		// 'exclude_from_search'  => null,
		// 'publicly_queryable'   => null,
		// 'show_ui'              => null,
		// 'show_in_menu'         => null,
		// 'show_in_nav_menus'    => null,
		// 'show_in_admin_bar'    => null,
		// 'menu_position'        => null,
		// 'menu_icon'            => null,
		// 'capability_type'      => 'post',
		// 'capabilities'         => array(),
		// 'map_meta_cap'         => null,
		// 'supports'             => array(),
		// 'register_meta_box_cb' => null,
		// 'taxonomies'           => array(),
		// 'has_archive'          => false,
		// 'rewrite'              => true,
		// 'query_var'            => true,
		// 'can_export'           => true,
		// 'delete_with_user'     => null,
		// '_builtin'             => false,
		// '_edit_link'           => 'post.php?post=%d',

		// http://codex.wordpress.org/Function_Reference/register_post_type
		'exclude_from_search'  => false,
		'public'               => true,
		'has_archive'          => true,
		'show_ui'              => true,
		'menu_position'        => 5,     // After posts
		'show_in_menu'         => true,
	);

	public function set( $name, $value ){
		$this->_values[ $name ] = $value;
		return $this;
	}

	public function get( $name ){
		return $this->_values[ $name ];
	}	

	function getArray(){
		return $this->_values;
	}
	
}
  
?>