<?php

function Walker_Nav_Menu_milo_fallback( $args ){
	?>
		<div>
			<p>No menu selected. Create menu in the <code>WP Admin menu &raquo; Appereance &raquo; Menu</code> and create it.</p>
		</div>
	<?php
}

class Walker_Nav_Menu_milo extends Walker_Nav_Menu {

	protected $_fresh_menu_state = array();
	protected $_last_img = '';

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "\n".str_repeat("\t", $depth);
		if( in_array( 'megamenu', $this->_fresh_menu_state ) ){
			if( 0 == $depth ){
				$output .= '<div class="megamenu-container"';
				$output .= ' style="background-image:url('.esc_attr( $this->_last_img ).')"';
				$output .= '>';
			}else{
				$output .= '<ul>';
			}
		}else{
			$output .= '<ul role="menu" class="">';
		}
		$output .= "\n";
	}


	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= str_repeat("\t", $depth);
		if( ( 0 == $depth ) and ( in_array( 'megamenu', $this->_fresh_menu_state ) ) ){
			$output .= "</div>";
		}else{
			$output .= "</ul>";
		}
		$output .= "\n";
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$LI_classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$LI_classes[] = 'menu-item-' .  $item->ID;

		if( ( 1 == $depth ) and ( in_array( 'megamenu', $this->_fresh_menu_state ) ) ){
			$LI_classes[] .= 'section';
		}else if ( !empty($args->has_children) ){
			if( ( 0 == $depth ) and ( ! in_array( 'megamenu', $LI_classes ) ) ){
				$LI_classes[] .= 'dropdown';
			}
		}

		if ( in_array( 'current-menu-item', $LI_classes ) ){
			$LI_classes[] = 'active';
		}

		$LI_classes = apply_filters( 'nav_menu_css_class', array_filter( $LI_classes ), $item, $args );
		if( 0 == $depth ){
			$this->_fresh_menu_state = $LI_classes;
		}
		$LI_classes = implode(' ', $LI_classes);

		$LI_id = 'menu-item-'.  $item->ID;
		$LI_id = apply_filters( 'nav_menu_item_id', $LI_id, $item, $args );

		$output .= ( $depth ) ? str_repeat( "\t", $depth ) : '';

		if( empty( $item->description ) and ('{"id":' != substr($item->description,0,5) ) ){
			$this->_last_img = '';
		}else{
			$this->_last_img = $item->description;
			$this->_last_img = str_replace( '&#8220;', '"', $this->_last_img );
			$this->_last_img = str_replace( '&#8221;', '"', $this->_last_img );
			$this->_last_img = json_decode( $this->_last_img );

			if( !empty( $this->_last_img->url ) ) {
				$this->_last_img = $this->_last_img->url;
			}else{
				$this->_last_img = '';
			}
		}

		$item_output  = '';

		if( ( 1 == $depth ) and ( in_array( 'megamenu', $this->_fresh_menu_state ) ) ){
			$output .= '<div id="' . esc_attr( $LI_id ) . '" class="' . esc_attr( $LI_classes ) . '">';
			if( ! empty( $this->_last_img ) and ( FALSE !== strpos( ' '.  $LI_classes.' ', ' show-image ' ) ) ){
				$output .= '<img class="hidden-xs hidden-sm" alt="" src="'.esc_url($this->_last_img).'">';
			}else {
				$output .= '<h5>';
			}
		}else{
			$output .= '<li id="' . esc_attr( $LI_id ) . '" class="' . esc_attr( $LI_classes ) . '">';
			$atts = array(
				'title'         => ! empty( $item->title  ) ? $item->title  : '' ,
				'target'        => ! empty( $item->target ) ? $item->target : '' ,
				'rel'           => ! empty( $item->xfn    ) ? $item->xfn    : '' ,
				'href'          => ! empty( $item->url    ) ? $item->url    : '' ,
				'class'         => '' ,
				'aria-haspopup' => 'true' ,
			);

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' .  $attr . '="' .  $value . '"';
				}
			}

			$item_output .= empty( $args->before ) ? '':$args->before;
			$item_output .= '<a'.  $attributes .'>';
		}

		if ( FALSE === strpos( ' '.  $LI_classes.' ', ' show-image ' ) ){
			$item_output .= empty( $args->link_before ) ? '' : $args->link_before;
			$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= empty( $args->link_after ) ? '' : $args->link_after;
		}

		if( ( 1 == $depth ) and ( in_array( 'megamenu', $this->_fresh_menu_state ) ) ){
			if ( FALSE === strpos( ' '.  $LI_classes.' ', ' show-image ' ) ){
				$item_output .= '</h5>';
			}
		}else if ( FALSE === strpos( ' '.  $LI_classes.' ', ' show-image ' ) ){
			$item_output .= '</a>';
		}

		$item_output .= empty( $args->after ) ? '' : $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if( ( 1 == $depth ) and ( in_array( 'megamenu', $this->_fresh_menu_state ) ) ){
			$output .= "</div>\n";
		}else{
			$output .= "</li>\n";
		}
	}

	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}

