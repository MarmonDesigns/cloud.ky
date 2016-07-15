<?php
class ffNavMenuWalker extends Walker_Nav_Menu {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_parameters = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( $parameters = null ) {
        $this->_parameters = $parameters;
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    /*----------------------------------------------------------*/
    /* LEVEL
    /*----------------------------------------------------------*/
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $customDepthMethodName = '_start_lvl_depth_'.$depth;
        if( method_exists( $this, $customDepthMethodName) ) {
            call_user_func_array(array( $this, $customDepthMethodName ), array(&$output, $depth, $args) );
        } else if( method_exists( $this, '_start_lvl' ) ) {
            call_user_func_array(array( $this, '_start_lvl' ), array(&$output, $depth, $args) );
        } else {
            $this->_start_lvl_fallback( $output, $depth, $args );
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $customDepthMethodName = '_end_lvl_depth_'.$depth;
        if( method_exists( $this, $customDepthMethodName) ) {
            call_user_func_array(array( $this, $customDepthMethodName ), array(&$output, $depth, $args) );
        } else if( method_exists( $this, '_end_lvl' ) ) {
             call_user_func_array(array( $this, '_end_lvl' ), array(&$output, $depth, $args) );
        } else {
            $this->_end_lvl_fallback( $output, $depth, $args );
        }
	}

    /*----------------------------------------------------------*/
    /* ELEMENT
    /*----------------------------------------------------------*/
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $customDepthMethodName = '_start_el_depth_'.$depth;
        if( method_exists( $this, $customDepthMethodName) ) {
            call_user_func_array(array( $this, $customDepthMethodName ), array(&$output, $item, $depth, $args, $id) );
        } else if( method_exists( $this, '_start_el' ) ) {
             call_user_func_array(array( $this, '_start_el' ), array(&$output, $item, $depth, $args, $id) );
        } else {
            $this->_start_el_fallback( $output, $item, $depth, $args, $id );
        }
    }

    public function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $customDepthMethodName = '_end_el_depth_'.$depth;
        if( method_exists( $this, $customDepthMethodName) ) {
            call_user_func_array(array( $this, $customDepthMethodName ), array(&$output, $item, $depth, $args, $id) );
        } else if( method_exists( $this, '_end_el' ) ) {
             call_user_func_array(array( $this, '_end_el' ), array(&$output, $item, $depth, $args, $id) );
        } else {
            $this->_end_el_fallback( $output, $item, $depth, $args, $id );
        }
    }

    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element )
			return;

		$id_field = $this->db_fields['id'];

		// Display tfhis element.
		if ( is_object( $args[0] ) )
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    /*----------------------------------------------------------*/
    /* PRINTING FUNCTIONS
    /*----------------------------------------------------------*/
    protected function _start_lvl_fallback( &$output, $depth = 0, $args = array(), $additionalUlClasses = '' ) {
        $output .= '<ul class="sub-menu '.$additionalUlClasses.'">';
    }

    protected function _end_lvl_fallback( &$output, $depth = 0, $args = array() ) {
        $output .= '</ul>';
    }

    protected function _start_el_fallback( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $liClasses = $this->_getLiClassNames( $item, $depth, $args, $id );
        $liId = $this->_getLiId( $item, $depth, $args, $id );
        $linkAttributes = $this->_getLinkAttributes( $item, $depth, $args, $id );

        $output .= '<li id="'.$liId.'" class="'.$liClasses.'">';

        $item_output = $args->before;
		$item_output .= '<a'. $linkAttributes .'>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . $item->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $item->link_after . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    protected function _end_el_fallback( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $output .= "</li>\n";
    }

    protected function _getMenuItemQuery( $menuId, $itemId ) {
        return ffContainer()->getThemeFrameworkFactory()->getMenuOptionsManager()->getQueryForMenuItem( $menuId, $itemId );
    }

    protected function _getAttrHelper() {
        return ffContainer()->getAttrHelper();
    }

    /*----------------------------------------------------------*/
    /* PRINTING HELPERS
    /*----------------------------------------------------------*/
    protected function _getUlClassNames( $depth = 0, $args = array() ){
        $classes = $this->_getAttrHelper();

        $classes->addValue('sub-menu');

        if( isset( $args->ul_css_class ) ) {
            if( is_array( $args->ul_css_class ) ) {
                $classes->addValuesArray( $args->ul_css_class);
            }  else {
                $classes->addValue( $args->ul_css_class);
            }
        }

        $classesString = $classes->getValues();

        return $classesString;
    }

    protected function _getLiClassNames( $item, $depth = 0, $args = array(), $id = 0) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? esc_attr( $class_names ) : '';

        return $class_names;
    }

    protected function _getLiId( $item, $depth = 0, $args = array(), $id = 0) {
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? esc_attr( $id ) : '';

        return $id;
    }

    protected function _getLinkAttributes( $item, $depth = 0, $args = array(), $id = 0) {
        $atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        $atts['class']  = ! empty( $item->css_class_link ) ? $item->css_class_link : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

        return $attributes;
    }

    protected function _getParam( $name ) {
        if( isset( $this->_parameters[ $name ] ) ) {
            return $this->_parameters[ $name ];
        } else {
            return null;
        }
    }
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}