<?php

class ffPostAdminColumnManager extends ffBasicObject{

	protected $columns = array();

	/**
	 * Class ffPostAdminColumnManager Constructor
	 * @param ffWPLayer                 $WPLayer
	 * @param ffDataStorage_WPPostMetas $dataStorage_WPPostMetas
	 */
	function __construct(ffWPLayer $WPLayer, ffDataStorage_WPPostMetas $dataStorage_WPPostMetas ){
		$this->_setWPLayer($WPLayer);
		$this->_setDataStorage_WPPostMetas($dataStorage_WPPostMetas);

		$WPLayer->add_filter('manage_posts_columns', array( $this, 'manage_posts_columns' ), 1);
		$WPLayer->add_action('manage_posts_custom_column', array( $this, 'manage_posts_custom_column' ), 1, 2);
	}

	/**
	 * Add column into post list in WP admin
	 * @param string $post_type
	 * @param string $after_column
	 * @param string $title
	 * @param string $meta_key
	 * @return ffPostAdminColumnManager actual class
	 */
	public function addColumnMeta( $post_type, $after_column, $title, $meta_key ){
		if( empty( $this->columns[$post_type] ) ){
			$this->columns[$post_type] = array();
		}
		$this->columns[ $post_type ][ $meta_key ] = array(
			'type'   => 'meta',
			'after'  => $after_column,
			'title'  => $title,
			'action' => $meta_key,
		);

		return $this;
	}

	/**
	 * Add column into post list in WP admin
	 * @param string $post_type
	 * @param string $after_column
	 * @param string $title
	 * @param string $column_slug
	 * @return ffPostAdminColumnManager actual class
	 */
	public function addColumnCallback( $post_type, $after_column, $title, $column_slug, $callback ){
		if( empty( $this->columns[$post_type] ) ){
			$this->columns[$post_type] = array();
		}
		$this->columns[ $post_type ][ $column_slug ] = array(
			'type'   => 'callback',
			'after'  => $after_column,
			'title'  => $title,
			'action' => $callback,
		);

		return $this;
	}

	/**
	 * Add column with image into post list in WP admin
	 * @param string $post_type
	 * @param string $after_column
	 * @param string $title
	 * @param string $column_slug
	 * @return ffPostAdminColumnManager actual class
	 */
	public function addColumnImageID( $post_type, $after_column, $title, $column_slug ){
		if( empty( $this->columns[$post_type] ) ){
			$this->columns[$post_type] = array();
		}
		$this->columns[ $post_type ][ $column_slug ] = array(
			'type'   => 'meta-image-ID',
			'after'  => $after_column,
			'title'  => $title,
			'action' => $column_slug,
		);

		return $this;
	}

	/**
	 * Add column with HTML (links) into post list in WP admin - any [POST_ID] will be replaced with post ID
	 * @param string $post_type
	 * @param string $after_column
	 * @param string $title
	 * @param string $column_slug
	 * @param string $html
	 * @return ffPostAdminColumnManager actual class
	 */
	public function addColumnHTML( $post_type, $after_column, $title, $column_slug, $html ){
		if( empty( $this->columns[$post_type] ) ){
			$this->columns[$post_type] = array();
		}
		$this->columns[ $post_type ][ $column_slug ] = array(
			'type'   => 'HTML',
			'after'  => $after_column,
			'title'  => $title,
			'action' => $column_slug,
			'html'   => $html,
		);

		return $this;
	}

	/**
	 * return post type slug
	 * @return string
	 */
	protected function getActualPostType(){
		global $_GET;

		if( empty($_GET['post_type'])){
			return null;
		}

		if( empty( $this->columns[ $_GET['post_type'] ] ) ){
			return null;
		}

		return $_GET['post_type'];
	}

	/**
	 * Function for WP Hooks
	 * @param  array $defaults
	 * @return array
	 */
	public function manage_posts_columns($defaults){
		
		$post_type = $this->getActualPostType();

		// Is there hook for this post type ?
		
		if( null == $post_type ){
			return $defaults;
		}

		// Insert title

		$ret = array();
		foreach ($defaults as $titile_key=>$title_value) {

			$ret[$titile_key] = $title_value;

			foreach ($this->columns[ $post_type ] as $column_key => $column_values) {
				if( $titile_key == $column_values['after'] ){
					$ret[ $column_key ] = $column_values['title'];
				}

			}
		}

		return $defaults = $ret;
	}

	/**
	 * Function for WP Hooks
	 * @param  string $column_name
	 * @param  int $id
	 */
	public function manage_posts_custom_column($column_name, $id){

		$post_type = $this->getActualPostType();

		// Is there hook for this post type ?
		
		if( null == $post_type ){
			return;
		}

		if( empty( $this->columns[ $post_type ][ $column_name ] ) ){
			return;
		}

		$do = $this->columns[ $post_type ][ $column_name ];

		switch ( $do['type'] ) {
			case 'meta':
				echo $this->_getDataStorage_WPPostMetas()->getOption( $id, $column_name );
				break;

			case 'callback':
				echo call_user_func( $do['action'], $id );
				break;

			case 'meta-image-ID':
				$url = $this->_getWPLayer()->wp_get_attachment_url( $this->_getDataStorage_WPPostMetas()->getOption( $id, $column_name ) );
				echo "<a href='".$url."' title='Show' target='_blank' >";
				echo "<img src='";
				echo $url;
				echo "' height=80 /></a>";
				break;

			case 'HTML':
				$html = $do['html'];
				$html = str_replace('[POST_ID]', $id, $html);
				echo $html;
				break;

			default:
				# code...
				break;
		}
	}
	////////////////////////////////////////////////////////////////////////
	//
	//   getters / setters
	//
	////////////////////////////////////////////////////////////////////////


	/**
	 *
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
	}



	/**
	 * 
	 * @var ffDataStorage_WPPostMetas
	 */
	private $dataStorage_WPPostMetas = null;

	/**
	 * @return ffDataStorage_WPPostMetas
	 */
	protected function _getDataStorage_WPPostMetas() {
		return $this->dataStorage_WPPostMetas;
	}
	
	/**
	 * @param ffDataStorage_WPPostMetas $dataStorage_WPPostMetas
	 */
	protected function _setDataStorage_WPPostMetas(ffDataStorage_WPPostMetas $dataStorage_WPPostMetas) {
		$this->dataStorage_WPPostMetas = $dataStorage_WPPostMetas;
		return $this;
	}

}





