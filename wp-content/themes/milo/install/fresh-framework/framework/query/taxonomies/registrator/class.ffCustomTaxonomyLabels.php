<?php
  
class ffCustomTaxonomyLabels extends ffBasicObject {

	protected $l = array(
					  'name', 'singular_name', 'search_items', 'popular_items',
					  'all_items', 'parent_item', 'parent_item_colon', 'edit_item',
					  'update_item', 'add_new_item', 'new_item_name',
					  'separate_items_with_commas', 'add_or_remove_items',
					  'choose_from_most_used', 'not_found', 'menu_name',
					);

	protected $name                        = '%NAME%s';
	protected $singular_name               = '%NAME%' ;
	protected $search_items                = 'Search %NAME%s';
	protected $popular_items               = 'Popular %NAME%s';
	protected $all_items                   = 'All %NAME%s';
	protected $parent_item                 = 'Parent %NAME%';
	protected $parent_item_colon           = 'Parent %NAME%:';
	protected $edit_item                   = 'Edit %NAME%';
	protected $update_item                 = 'Update %NAME%';
	protected $add_new_item                = 'Add New %NAME%';
	protected $new_item_name               = 'New %NAME% Name';
	protected $separate_items_with_commas  = 'Separate %LOW-NAME%s with commas';
	protected $add_or_remove_items         = 'Add or remove %LOW-NAME%s';
	protected $choose_from_most_used       = 'Choose from the most used %LOW-NAME%s';
	protected $not_found                   = 'No %LOW-NAME%s found.';
	protected $menu_name                   = '%NAME%s';

	function __construct( $name, $singular_name ){
		$this->name = $name;
		if( empty( $singular_name ) ){
			if( 's' == substr($name, -1) ){
				$this->singular_name = substr($name, 0, -1);
			}else{
				$this->singular_name = $name;
			}
		}else{
			$this->singular_name = $singular_name;
		}
		$this->generateLabels( $this->singular_name, $this->name );
	}

	protected function generateLabels($name, $name_s){

		$low_name = strtolower($name);
		$low_name_s = strtolower($name_s);

		foreach ($this->l as $key) {
			$this->$key = str_replace( "%NAME%s",     $name_s,     $this->$key);
			$this->$key = str_replace( "%NAME%",      $name,       $this->$key);
			$this->$key = str_replace( "%LOW-NAME%s", $low_name_s, $this->$key);
			$this->$key = str_replace( "%LOW-NAME%",  $low_name,   $this->$key);
		}

	}
	
	public function getArray(){
		$ret = array();
		foreach ($this->l as $key) {
			$ret[ $key ] = $this->$key;
		}
		return $ret;
	}

}
  
?>