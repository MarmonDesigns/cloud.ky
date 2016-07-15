<?php
  
class ffPostTypeRegistratorLabels extends ffBasicObject {

	protected $_values = array(
		// 'name' => array( _x('Posts', 'post type general name'), _x('Pages', 'post type general name') ),
		// 'singular_name' => array( _x('Post', 'post type singular name'), _x('Page', 'post type singular name') ),
		// 'add_new' => array( _x('Add New', 'post'), _x('Add New', 'page') ),
		// 'add_new_item' => array( __('Add New Post'), __('Add New Page') ),
		// 'edit_item' => array( __('Edit Post'), __('Edit Page') ),
		// 'new_item' => array( __('New Post'), __('New Page') ),
		// 'view_item' => array( __('View Post'), __('View Page') ),
		// 'search_items' => array( __('Search Posts'), __('Search Pages') ),
		// 'not_found' => array( __('No posts found.'), __('No pages found.') ),
		// 'not_found_in_trash' => array( __('No posts found in Trash.'), __('No pages found in Trash.') ),
		// 'parent_item_colon' => array( null, __('Parent Page:') ),
		// 'all_items' => array( __( 'All Posts' ), __( 'All Pages' ) )

		'name'               => '---NAME---s',
		'singular_name'      => '---NAME---',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New ---NAME---',
		'edit_item'          => 'Edit ---NAME---',
		'new_item'           => 'New ---NAME---',
		'view_item'          => 'View ---NAME---',
		'search_items'       => 'Search ---NAME---s',
		'not_found'          => 'No ---LOW-NAME---s found.',
		'not_found_in_trash' => 'No ---LOW-NAME---s found in Trash.',
		//'parent_item_colon'  => 'Parent ---NAME---:',
		'parent_item_colon'  => '',
		'all_items'          => 'All ---NAME---s',
	);

	protected $_name = "HEK";
	protected $_singular_name = "WUT";

	function __construct( $name, $singular_name ){
		$this->_name = $name;
		if( empty( $singular_name ) ){
			if( 's' == substr($name, -1) ){
				$this->_singular_name = substr($name, 0, -1);
			}else{
				$this->_singular_name = $name;
			}
		}else{
			$this->_singular_name = $singular_name;
		}
	}

	public function set( $name, $value ){
		$this->_values[ $name ] = $value;
	}

	public function get( $name ){
		return $this->_values[ $name ];
	}	
	
	public function getArray(){
		
		$name = $this->_name;
		$singular_name = $this->_singular_name;

		$low_name = strtolower($singular_name);
		$low_name_s = strtolower($name);

		foreach ($this->_values as $key => $value) {
			$this->_values[ $key ] = str_replace( "---NAME---s",     $name,          $this->_values[ $key ] );
			$this->_values[ $key ] = str_replace( "---NAME---",      $singular_name, $this->_values[ $key ] );
			$this->_values[ $key ] = str_replace( "---LOW-NAME---s", $low_name_s,    $this->_values[ $key ] );
			$this->_values[ $key ] = str_replace( "---LOW-NAME---",  $low_name,      $this->_values[ $key ] );
		}

		return $this->_values;
	}

}
  
?>