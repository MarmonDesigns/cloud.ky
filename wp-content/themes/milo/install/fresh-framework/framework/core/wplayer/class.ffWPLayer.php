<?php

class ffWPLayer extends ffBasicObject {
	/**
	 * 
	 * @var ffHookManager
	 */
	private $_hookManager = null;
	
	private $_WPMLBridge = null;
	
	/**
	 * 
	 * @var ffAssetsSourceHolder
	 */
	private $_assetsSourceHolder = null;
	
	private $_frameworkUrl = null;
	
	private $_cached = array();
	
	public function setAssetsSourceHolder( ffAssetsSourceHolder $assetsSourceHolder ) {
		$this->_assetsSourceHolder = $assetsSourceHolder;
	}
	
	public function getAssetsSourceHolder() {
		return $this->_assetsSourceHolder;
	}
	
	public function get_absolute_path() {
		return ABSPATH;
	}
	
	public function current_user_can( $capability ) {
		return current_user_can($capability);
	}

	public function getGlobal($name){
		switch( $name ){
			// case 'some-variable':
			// 	global $some_other_variable;
			// 	return $some_other_variable;
			default:
				global $$name;
				return $$name;
		}
	}

	public function setGlobal($name, $value){
		switch( $name ){
			// case 'some-variable':
			// 	global $some_other_variable;
			// 	return $some_other_variable = $value;
			default:
				global $$name;
				return $$name = $value;
		}
	}

	public function sanitize_title( $title, $fallback_title = '', $context = 'save' ) {
		return sanitize_title($title, $fallback_title, $context);
	}

	public function wp_is_mobile() {
		return wp_is_mobile();
	}

	public function get_is_iphone (){ global $is_iphone ; return $is_iphone ; }
	public function get_is_chrome (){ global $is_chrome ; return $is_chrome ; }
	public function get_is_safari (){ global $is_safari ; return $is_safari ; }
	public function get_is_NS4    (){ global $is_NS4    ; return $is_NS4    ; }
	public function get_is_opera  (){ global $is_opera  ; return $is_opera  ; }
	public function get_is_macIE  (){ global $is_macIE  ; return $is_macIE  ; }
	public function get_is_winIE  (){ global $is_winIE  ; return $is_winIE  ; }
	public function get_is_gecko  (){ global $is_gecko  ; return $is_gecko  ; }
	public function get_is_lynx   (){ global $is_lynx   ; return $is_lynx   ; }
	public function get_is_IE     (){ global $is_IE     ; return $is_IE     ; }

    public function get_comment_author_email( $comment_ID = 0 ) {
        return get_comment_author_email( $comment_ID );
    }

    public function get_comment_ID() {
        return get_comment_ID();
    }


    public function get_comment_reply_link( $args = array(), $comment = null, $post = null ) {
        return get_comment_reply_link( $args, $comment, $post );
    }

    public function get_comment_date( $d = '', $comment_ID = 0  ) {
        return get_comment_date( $d, $comment_ID );
    }

    public function get_avatar( $id_or_email, $size = '96', $default = '', $alt = false, $args = null ) {
        return get_avatar( $id_or_email, $size, $default, $alt, $args );
    }

    public function get_comment_author_url( $comment_ID = 0 ) {
        return get_comment_author_url( $comment_ID );
    }

    public function get_comment_author( $comment_ID = 0) {
        return get_comment_author( $comment_ID );
    }

	public function get_freshface_demo_url() {
		return 'http://demo.freshface.net';
	}
	
	public function is_ajax() {
		return defined('DOING_AJAX') && DOING_AJAX;
	}

	public function is_admin_screen( $name ){
		if( ! $this->is_admin() ){
			return false;
		}
		return basename( $_SERVER['SCRIPT_NAME'] ) == $name;
	}

	public function plugin_basename( $file ) {
		return plugin_basename( $file );
	}
	
	public function plugins_url($path = '', $plugin = '') {
		return plugins_url($path, $plugin);
	}
	
	public function getFrameworkUrl() {
		return $this->_frameworkUrl;
	}
	
	public function getFrameworkDir() {
		return FF_FRAMEWORK_DIR;
	}
	
	public function remove_menu_page( $menu_slug ) {
		return remove_menu_page( $menu_slug );
	}
	
	public function __construct( $frameworkUrl ) {
		$this->_frameworkUrl = $frameworkUrl;
	}
	
	public function wp_mkdir_p($path) {
		return wp_mkdir_p($path);
	}
	
	public function get_plugins( $plugin_folder = '' ) {
		return get_plugins( $plugin_folder );
	}
	
	public function wp_get_theme() {
		return wp_get_theme();
	}

	public function wp_get_themes( $args = array() ) {
		return wp_get_themes( $args );
	}
	
	public function setHookManager( ffHookManager $hookManager ) {
		$this->_hookManager = $hookManager;
	}
	
	public function setWPMLBridge( ffWPMLBridge $wpmlBridge ) {
		$this->_WPMLBridge = $wpmlBridge;
	}
	
	public function get_users($args = array() ) {
		return get_users( $args );
	}

    public function get_user_by( $field, $value ) {
        return get_user_by( $field, $value );
    }

    public function wp_create_user($username, $password, $email = '') {
        return wp_create_user( $username, $password, $email );
    }

    public function wp_clear_auth_cookie() {
        return wp_clear_auth_cookie();
    }

    public function wp_set_current_user( $id, $name = '' ) {
        return wp_set_current_user( $id, $name);
    }

    public function wp_set_auth_cookie( $user_id, $remember = false, $secure = '' ) {
        return wp_set_auth_cookie( $user_id , $remember, $secure );
    }

    public function wp_safe_redirect( $location, $status = 302 ) {
        return wp_safe_redirect($location, $status);
    }
	
	public function getWPMLBridge() {
		return $this->_WPMLBridge;
	}
	
	public function wp_remote_get( $url, $arguments = array() ) {
		return wp_remote_get($url, $arguments);
	}
	
	public function copy_dir( $from, $to, $skip_list = array() ) {
		return copy_dir( $from, $to, $skip_list );
	}
	
	public function download_url( $url, $timeout = 300 ) {
		return download_url($url, $timeout);
	}
	
	public function get_plugin_data( $plugin_file, $markup = true, $translate = true ) {
		require_once ABSPATH . '/wp-admin/includes/plugin.php';
		return get_plugin_data( $plugin_file, $markup, $translate );
	}
	
	public function get_file_data( $file, $default_headers, $context = '' ) {
		if( file_exists( $file ) ) {
			return get_file_data( $file, $default_headers, $context);
		} else {
			return null;
		}
	}

    public function trailingslashit( $string ) {
        return trailingslashit( $string );
    }

    public function untrailingslashit( $string ) {
        return untrailingslashit( $string );
    }
	
	public function deactivate_plugins( $plugins, $silent = false, $network_wide = null ) {
		return deactivate_plugins( $plugins, $silent, $network_wide);
	}
	
	public function activate_plugin( $plugin, $redirect = '', $network_wide = false, $silent = false ) {
		return activate_plugin( $plugin, $redirect, $network_wide, $silent);
	}
	
	public function get_wp_scripts() {
		global $wp_scripts;
		
		if( $wp_scripts == null ) {
			$wp_scripts = new WP_Scripts();
			wp_default_scripts($wp_scripts);
		}
		
		return $wp_scripts;
	}
	
	public function get_wp_styles() {
		global $wp_styles;
		return $wp_styles;
	}
	
	public function get_wp_admin_css_colors() {
		global $_wp_admin_css_colors;
		return $_wp_admin_css_colors;
	}
	
	public function set_wp_scripts($wp_scripts_new) {
		global $wp_scripts;
		$wp_scripts = $wp_scripts_new;
	}
	
	public function set_wp_styles( $wp_styles_new ) {
		global $wp_styles;
		$wp_styles = $wp_styles_new;
	}
	
	public function get_site_url( $blog_id = null, $path = '', $scheme = null ) {
		return get_site_url($blog_id, $path, $scheme );
	}
	
	/**
	 * 
	 * @return ffHookManager
	 */
	public function getHookManager() {
		return $this->_hookManager;
	}
	
	public function is_login_page() {
		return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
	}
	
	public function get_wp_query() {
		global $wp_query;
		return $wp_query;
	}
	
	public function get_paged() {
		global $paged;
		
		if ( empty( $paged ) ) {
			$wpQuery = $this->get_wp_query();
			$paged = $wpQuery->get('paged');
			
			if( $paged == 0 ) {
				$paged = 1;
			}
		}
		return $paged;
	}
	
	public function add_shortcode($tag, $func) {
		return add_shortcode($tag, $func);
	}

    public function get_bloginfo( $show = '', $filter = 'raw' ) {
        return get_bloginfo( $show, $filter );
    }

    public function get_blog_name() {
        return $this->get_bloginfo('name');
    }

    public function remove_action( $tag, $function_to_remove, $priority = 10  ) {
        return remove_action( $tag, $function_to_remove, $priority );
    }

    public function register_widget( $widget_class ) {
        return register_widget( $widget_class );
    }

	public function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
		return add_action( $tag, $function_to_add, $priority, $accepted_args );
	}
	
	public function remove_meta_box($id, $screen, $context) {
		return remove_meta_box($id, $screen, $context);
	}
	
	public function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		return add_filter($tag, $function_to_add, $priority, $accepted_args);
	}
	
	public function get_terms( $taxonomies, $args ) {
		return get_terms( $taxonomies, $args );
	}

    public function get_term( $term, $taxonomy, $output = OBJECT, $filter = 'raw' ) {
        return get_term( $term, $taxonomy, $output, $filter );
    }
	
	public function get_plugin_base_dir() {
		return WP_PLUGIN_DIR;
	}

    public function wp_parse_args( $args, $defaults = '' ) {
        return wp_parse_args($args, $defaults );
    }
	
	public function get_WP_filesystem() {
		global $wp_filesystem;
		return $wp_filesystem;
	}
	
	public function wp_upload_dir() {
		return wp_upload_dir();
	}
	
	public function get_home_url() {
		if( !isset( $this->_cached['get_home_url'] ) ) {
			$this->_cached['get_home_url'] = get_home_url(); 
		}
		return $this->_cached['get_home_url'];
	}
	
	public function get_home_path() {
		if( !isset( $this->_cached['get_home_path'] ) ) {
			$this->_cached['get_home_path'] = get_home_path();
		}
		return $this->_cached['get_home_path'];
	}
	
	public function is_main_query() {
		return is_main_query();
	}
	
	public function remove_filter( $tag, $function_to_remove, $priority = 10) {
		return remove_filter($tag, $function_to_remove, $priority );
	}
	
	public function WP_Filesystem() {
		require_once(ABSPATH .'/wp-admin/includes/file.php');
		return WP_Filesystem();
	}
	
	public function is_admin() {
		return is_admin();
	}
	
	public function is_child_theme() {
		return is_child_theme();
	}

    public function __( $text, $domain = 'default' ) {
        return __($text, $domain);
    }

    public function comment_form( $args = array(), $post_id = null ) {
        return comment_form( $args, $post_id );
    }

	private $_stylesheet_directory = null;
	public function get_stylesheet_directory() {
		if( $this->_stylesheet_directory == null ) {
			$this->_stylesheet_directory = get_stylesheet_directory();
		}
		
		return $this->_stylesheet_directory;

	}
	
	private $_stylesheet_directory_uri = null;
	public function get_stylesheet_directory_uri() {
		if( $this->_stylesheet_directory_uri == null ) {
			$this->_stylesheet_directory_uri = get_stylesheet_directory_uri();
		}
	
		return $this->_stylesheet_directory_uri;
	}
	
	
	private $_template_directory = null;
	public function get_template_directory() {
		if( $this->_template_directory == null ) {
			$this->_template_directory = get_template_directory();
		}
	
		return $this->_template_directory;
	
	}

    public function wp_get_post_terms( $post_id = 0, $taxonomy = 'post_tag', $args = array() ) {
        return wp_get_post_terms($post_id, $taxonomy, $args );
    }
	
	private $_template_directory_uri = null;
	public function get_template_directory_uri() {
		if( $this->_template_directory_uri == null ) {
			$this->_template_directory_uri = get_template_directory_uri();
		}
	
		return $this->_template_directory_uri;
	}
	
	//get_stylesheet_directory();
	//get_stylesheet_directory();
	//get_template_directory();
	
	public function action_enqueue_scripts_name() {
		if( $this->is_admin() ) {
			// return 'wp_print_scripts';
			return 'admin_enqueue_scripts';
		} else {
			return 'wp_enqueue_scripts';
		}
	}
	
	public function get_the_category( $id = false ) {
		return get_the_category( $id );
	}
	
	public function get_category_link( $category ) {
		return get_category_link( $category );
	}

    public function get_author_data() {
        global $authordata;
        return $authordata;
    }
	
	public function get_the_author() {
		return get_the_author();
	}

    public function get_the_terms( $post, $taxonomy ) {
        return get_the_terms( $post, $taxonomy );
    }

    public function get_term_link( $term, $taxonomy = '' ) {
        return get_term_link( $term, $taxonomy );
    }
	
	public function get_the_tags( $id = 0 ) {
		return get_the_tags( $id = 0 );
	}
	
	public function get_tag_link( $tag ) {
		return get_tag_link($tag);
	}
	
	public function esc_url( $url, $protocols = null, $_context = 'display' ) {
		return esc_url( $url, $protocols, $_context );
	}
	
	public function add_action_enque_scripts( $callback, $priority = 10 ) {
		if( $this->is_admin() ) {
			$this->add_action('admin_enqueue_scripts', $callback, $priority);
		} else {
			$this->add_action('wp_enqueue_scripts', $callback, $priority);
		}
	}

    public function get_edit_user_link( $user_id = null ) {
        return get_edit_user_link( $user_id );
    }

    public function wp_get_current_user() {
        return wp_get_current_user();
    }

    public function wp_logout_url( $redirect = '' ) {
        return wp_logout_url( $redirect );
    }

	public function wp_enqueue_script( $handle, $src = false, $deps = array(), $ver = null, $in_footer = false ) {
        if( $ver == null ) {
            $ver = false;
        }
		wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer);
	}
	
	private $_stylesToEnqeueueInFooter = array();
	
	public function wp_enqueue_style( $handle, $src = false, $deps = array(), $media = 'all', $in_footer = false )  {
		if( $in_footer && ( $this->action_been_executed('wp_enqueue_scripts') || $this->action_been_executed('admin_enqueue_scripts') ) ) {
		
			if( empty( $this->_stylesToEnqeueueInFooter) ) {
				$this->add_action('wp_footer', array( $this, 'enqueue_footer_styles'), 1);
			}
			
			$style = array();
			$style['handle'] = $handle;
			$style['src'] = $src;
			$style['deps'] = $deps;
			$style['media'] = $media;
			
			
			
			$this->_stylesToEnqeueueInFooter[] = $style;
		} else {
			wp_enqueue_style( $handle, $src, $deps, false, $media);
		}
	}

	public function wp_add_inline_style($handle, $data){
		wp_add_inline_style($handle, $data);
	}

	public function add_editor_style( $style ){
		add_editor_style( $style );
	}

	public function enqueue_footer_styles() {
		foreach( $this->_stylesToEnqeueueInFooter as $oneStyle ) {
			wp_enqueue_style( $oneStyle['handle'], $oneStyle['src'], $oneStyle['deps'], false, $oneStyle['media']);
		}
	}
	
	
	public function wp_enqueue_style_add_param( $handle, $key, $param ) {
		global $wp_styles;
		$wp_styles->add_data($handle, $key, $param);
	
	}
	
	public function add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null ) {
		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
	}
	
	public function add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '' ) {
		add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
	}
	
	public function do_action($tag, $arg='') {
		do_action($tag, $arg);
	}
	
	public function do_shortcode($content) {
		return do_shortcode($content);
	}
	
	public function apply_filters( $tag, $value){
		$args = func_get_args();

		return apply_filters($tag, $value, $args);
	}
	

    public function get_year_link( $year ) {
        return get_year_link( $year );
    }

    public function get_month_link( $year, $month) {
        return get_month_link( $year, $month );
    }

    public function get_day_link( $year, $month, $date ) {
        return get_day_link($year, $month, $date);
    }

	public function action_been_executed( $actionName ) {
		global $merged_filters, $wp_actions;
	
		if( isset( $merged_filters[ $actionName ] ) || isset( $wp_actions[ $actionName ])) {
			return true;
		} else {
			return false;
		}
	}
	
	public function get_the_date(  $d = '', $post = null  ) {
		return get_the_date($d, $post);
	}
	
	public function get_comments_number( $post_id = 0 ) {
		return get_comments_number( $post_id );
	}
	
	public function comments_link() {
		return comments_link();
	}

    public function comments_open( $post_id = null ) {
        return comments_open( $post_id );
    }

	public function get_comments_link( $post_id = null) {
		return $this->esc_url(get_comments_link( $post_id ));
	}

    public function get_comments( $args = '') {
        return get_comments( $args );
    }
	
	
	public function wp_enqueue_media( $args = array() ) {
		return wp_enqueue_media( $args );
	}
	
	public function get_queried_object_id() {
		return get_queried_object_id();
	}
	
	public function get_queried_object() {
		return get_queried_object();
	}
	
	public function update_option($name, $value ) {
		return update_option( $name, $value );
	}
	
	public function delete_option( $name ) {
		return delete_option( $name );
	}
	
	public function get_option( $name, $default = null ) {
		return get_option( $name, $default );
	}
	
	public function get_wp_plugin_dir() {
		return WP_PLUGIN_DIR;
	}
	
	public function get_wp_post_types() {
		global $wp_post_types;
		return $wp_post_types;
	}
	
	public function get_taxonomies(  $args = array(), $output = 'names', $operator = 'and' ) {
		return get_taxonomies( $args, $output, $operator );
	}
	
	public function get_taxonomy( $taxonomy ) {
		return get_taxonomy($taxonomy );
	}
	
	public function get_posts( $args ) {
		return get_posts( $args );
	}

	public function in_the_loop() {
		return in_the_loop();
	}

	public function the_post() {
		the_post();
	}

	public function rewind_posts() {
		rewind_posts();
	}

	public function get_post( $id, $output = OBJECT, $filter="raw" ){
		return get_post( $id, $output, $filter );
	}

    public function get_metadata($meta_type, $object_id, $meta_key = '', $single = false) {
        return get_metadata($meta_type, $object_id, $meta_key, $single);
    }

	public function get_post_format( $post_id ){
		return get_post_format( $post_id );
	}

	public function is_singular( $post_types = '' ) {
		return is_singular( $post_types );
	}

	public function is_page( $page = '' ){
		return is_page( $page );
	}

    public function is_posts_page() {
        if( !$this->is_front_page() && $this->is_home() ) {
            return true;
        } else {
            return false;
        }
    }

	public function is_home(){       return is_home(); }
	public function is_front_page(){ return is_front_page(); }
	public function is_404(){        return is_404(); }
	public function is_archive(){    return is_archive(); }
	public function is_author( $author = '' ){     return is_author( $author ); }
	public function is_search(){     return is_search(); }
	public function is_date(){       return is_date(); }
	public function is_day(){        return is_day(); }
	public function is_month(){      return is_month(); }
	public function is_year(){       return is_year(); }

	public function is_post_type_archive( $post_types = '' ){
		return is_post_type_archive( $post_types );
	}

    public function is_post_type_hierarchical( $post_type ) {
        return is_post_type_hierarchical( $post_type );
    }

	public function is_category( $category = '' ) {
		return is_category( $category );
	}

	public function is_tag( $tag = '' ) {
		return is_tag( $tag  );
	}

	public function is_tax( $taxonomy = '', $term = '' ) {
		return is_tax( $taxonomy, $term );
	}

	public function is_taxonomy() {
		return ( is_category() || is_tag() || is_tax() );
	}

	public function wp_get_object_terms($object_ids, $taxonomies, $args = array()){
		return wp_get_object_terms($object_ids, $taxonomies, $args);
	}

	/**
	 * @return string template of actual page
	 */
	public function get_page_template(){
		return get_page_template();
	}

	/**
	 * @return array array of possible theme page templates
	 */
	public function get_page_templates(){
		return get_page_templates();
	}

	public function wp_delete_post( $postid, $force_delete = false ){
		wp_delete_post( $postid, $force_delete );
	}

	public function wp_insert_post( $post, $wp_error = false ){
		return wp_insert_post( $post, $wp_error );
	}

	public function wp_update_post( $postarr = array(), $wp_error = false ) {
		return wp_update_post( $postarr, $wp_error);
	}

    public function wp_update_user( $userdata ) {
        return wp_update_user( $userdata );
    }

    public function get_search_query( $escaped = true ) {
        return get_search_query( $escaped );
    }

    public function get_search_link( $query = '' ) {
        return get_search_link( $query );
    }

	public function get_post_meta( $post_id, $key = '', $single = false ){
		return get_post_meta( $post_id, $key, $single );
	}

	public function update_post_meta($post_id, $meta_key, $meta_value, $prev_value = ''){
		return update_post_meta($post_id, $meta_key, $meta_value, $prev_value);
	}

    public function update_user_meta( $user_id, $meta_key, $meta_value, $prev_value = ''  ) {
        return update_user_meta($user_id, $meta_key, $meta_value, $prev_value);
    }

    public function get_user_meta( $user_id, $key = '', $single = false) {
        return get_user_meta( $user_id, $key, $single);
    }

    /**
     * @return wpdb
     */
    public function getWPDB() {
        global $wpdb;
        return $wpdb;
    }

	public function delete_post_meta($post_id, $meta_key, $meta_value = ''){
		return delete_post_meta($post_id, $meta_key, $meta_value);
	}

	public function wp_get_attachment_url( $att_ID ){
		return wp_get_attachment_url( $att_ID );
	}

	public function get_permalink( $id = 0, $leavename = false ){
		return get_permalink( $id, $leavename );
	}

	public function get_the_post_thumbnail( $post_id = null, $size = 'post-thumbnail', $attr = '' ){
		return get_the_post_thumbnail( $post_id, $size, $attr );
	}

    public function get_post_thumbnail_id( $postId = null ) {
        return get_post_thumbnail_id( $postId );
    }

	public function register_post_type( $post_type, $args ){
		return register_post_type( $post_type, $args );
	}

	public function get_post_type( $post = null ){
		return get_post_type( $post );
	}

	public function register_taxonomy( $taxonomy, $object_type, $args ){
		return register_taxonomy( $taxonomy, $object_type, $args );
	}

	public function get_wp_registered_sidebars() {
		global $wp_registered_sidebars;
		return $wp_registered_sidebars;
	}
	
	public function set_wp_registered_sidebars( $registeredSidebars ) {
		global $wp_registered_sidebars;
		$wp_registered_sidebars = $registeredSidebars;
	}

	public function register_sidebar($args = array()){
		return register_sidebar($args);
	}
	
	public function createWpDependency(  $handle = null, $src = null, $deps = null, $ver = null, $args = null ) {
		return new _WP_Dependency( $handle, $src, $deps, $ver, $args );
	}
	
	public function get_theme_support( $feature ) {
		return get_theme_support($feature);
	}

    public function get_wp_debug(){
        return WP_DEBUG;
    }

    public function get_ff_debug() {
        if( defined('FF_WP_DEBUG') ) {
            return FF_WP_DEBUG;
        } else {
            return false;
        }
    }
	
	public function add_meta_box( $id, $title, $callback, $screen = null, $context = 'advanced', $priority = 'default', $callback_args = null ) {
		return add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
	}

	public function get_current_user_id(){
		return get_current_user_id();
	}

    /**
     * @return WP_Post
     */
    public function get_current_post() {
        global $post;
        return $post;
    }

	public function get_current_screen() {
		return get_current_screen();
	}

	public function get_the_author_meta($field = '', $user_id = false  ){
		return get_the_author_meta( $field, $user_id );
	}
	
	public function get_author_posts_url($author_id, $author_nicename = '') {
		return get_author_posts_url( $author_id, $author_nicename );
	}
	
	public function sanitize_only_letters_and_numbers( $string ) {
		$res = preg_replace("/[^a-zA-Z0-9\s ]/", "", $string);
		$res = str_replace(' ', '-', $res);
		
		return $res;
	}
	
	public function getCurrentUrl() {
	 	$pageURL = 'http';
	         if (isset( $_SERVER['HTTPS'])&& $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	         $pageURL .= "://";
	         if ( isset( $_SERVER['SERVER_PORT'])&&$_SERVER["SERVER_PORT"] != "80") {
	         $pageURL .=          
	         $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	         } 
	         else {
	         $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	         }
	    return $pageURL;
	}
	
	public function get_all_navigation_menus() {
			return $this->get_terms( 'nav_menu', array( 'hide_empty' => true ) );
	}

	public function is_email( $string ){
		return is_email( $string );
	}
}







