<?php

class ffCommentWalker extends Walker_Comment {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    /**
     * @var ffPostMetaGetter
     */
    private $_postMetaGetter = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $depth++;
//        $GLOBALS['comment_depth'] = $depth + 1;
        $customDepthMethodName = '_start_lvl_depth_'. $depth;
        if( method_exists( $this, $customDepthMethodName) ) {
            call_user_func_array(array( $this, $customDepthMethodName ), array(&$output, $depth, $args) );
        } else if( method_exists( $this, '_start_lvl' ) ) {
            call_user_func_array(array( $this, '_start_lvl' ), array(&$output, $depth, $args) );
        } else {
            $this->_start_lvl_fallback( $output, $depth, $args );
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $depth++;
//        $GLOBALS['comment_depth'] = $depth + 1;
        $customDepthMethodName = '_end_lvl_depth_'.$depth;
        if( method_exists( $this, $customDepthMethodName) ) {
            call_user_func_array(array( $this, $customDepthMethodName ), array(&$output, $depth, $args) );
        } else if( method_exists( $this, '_end_lvl' ) ) {
             call_user_func_array(array( $this, '_end_lvl' ), array(&$output, $depth, $args) );
        } else {
            $this->_end_lvl_fallback( $output, $depth, $args );
        }
	}

    public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
        $depth++;
        $GLOBALS['comment'] = $comment;
        $customDepthMethodName = '_start_el_depth_'.$depth;
        if( method_exists( $this, $customDepthMethodName) ) {
            call_user_func_array(array( $this, $customDepthMethodName ), array(&$output, $comment, $depth, $args, $id) );
        } else if( method_exists( $this, '_start_el' ) ) {
             call_user_func_array(array( $this, '_start_el' ), array(&$output, $comment, $depth, $args, $id) );
        } else {
            $this->_start_el_fallback( $output, $comment, $depth, $args, $id );
        }
    }

    public function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $depth++;
        $customDepthMethodName = '_end_el_depth_'.$depth;
        if( method_exists( $this, $customDepthMethodName) ) {
            call_user_func_array(array( $this, $customDepthMethodName ), array(&$output, $item, $depth, $args, $id) );
        } else if( method_exists( $this, '_end_el' ) ) {
             call_user_func_array(array( $this, '_end_el' ), array(&$output, $item, $depth, $args, $id) );
        } else {
            $this->_end_el_fallback( $output, $item, $depth, $args, $id );
        }
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    protected function _start_lvl_fallback( &$output, $depth = 0, $args = array() ) {

    }

    protected function _end_lvl_fallback( &$output, $depth = 0, $args = array() ) {

    }

    protected function _start_el_fallback( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    }

    protected function _end_el_fallback( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    }
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    protected function _getPostMetaGetter() {
        if( $this->_postMetaGetter == null ) {
            $this->_postMetaGetter =  ffContainer()->getThemeFrameworkFactory()->getPostMetaGetter();
        }

        return $this->_postMetaGetter;
    }
}