<?php

class ffPostCollectionItem extends ffBasicObject{
	
	protected $_WPPost;

    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

	public function __construct( WP_Post $_WPPost, ffWPLayer $WPLayer ){
		$this->_WPPost = $_WPPost;
        $this->_WPLayer = $WPLayer;
	}

	protected function get( $name ){
		if( isSet( $this->_WPPost->$name ) ){
			return $this->_WPPost->$name;
		}
		return NULL;
	}

	protected function set( $name, $value ){
		$this->_WPPost->$name = $value;
		return $this;
	}

    public function getFeaturedImage() {
        $featuredImageId = $this->_WPLayer->get_post_thumbnail_id( $this->getID() );
        $featuredImageUrl = $this->_WPLayer->wp_get_attachment_url( $featuredImageId );
        return $featuredImageUrl;
    }

	public function getWPPost(){
		return $this->_WPPost;
	}

	public function getID(                     ){ return $this->get( 'ID'                    ); }
	public function setID(              $value ){        $this->set( 'ID'                    , $value ); return $this; }	

	public function getAuthorID(               ){ return $this->get( 'post_author'           ); }
	public function setAuthorID(        $value ){        $this->set( 'post_author'           , $value ); return $this; }	

    public function getPermalink() {
        return $this->_WPLayer->get_permalink( $this->getID() );
    }

	public function getDate(                   ){ return $this->get( 'post_date'             ); }
	public function setDate(            $value ){        $this->set( 'post_date'             , $value ); return $this; }	

	public function getDateFormated( $format ) {
		$originalDate = $this->getDate();
		$timestamp = strtotime( $originalDate );
		return date( $format, $timestamp);
	}
	
	public function getDateGMT(                ){ return $this->get( 'post_date_gmt'         ); }
	public function setDateGMT(         $value ){        $this->set( 'post_date_gmt'         , $value ); return $this; }	

	public function getContent(                ){ return $this->get( 'post_content'          ); }
	public function setContent(         $value ){        $this->set( 'post_content'          , $value ); return $this; }	

	public function getTitle(                  ){ return $this->get( 'post_title'            ); }
	public function setTitle(           $value ){        $this->set( 'post_title'            , $value ); return $this; }	

	public function getExcerpt(                ){ return $this->get( 'post_excerpt'          ); }
	public function setExcerpt(         $value ){        $this->set( 'post_excerpt'          , $value ); return $this; }	

	public function getStatus(                 ){ return $this->get( 'post_status'           ); }
	public function setStatus(          $value ){        $this->set( 'post_status'           , $value ); return $this; }	

	public function getCommentStatus(          ){ return $this->get( 'comment_status'        ); }
	public function setCommentStatus(   $value ){        $this->set( 'comment_status'        , $value ); return $this; }	

	public function getPingStatus(             ){ return $this->get( 'ping_status'           ); }
	public function setPingStatus(      $value ){        $this->set( 'ping_status'           , $value ); return $this; }	

	public function getPassword(               ){ return $this->get( 'post_password'         ); }
	public function setPassword(        $value ){        $this->set( 'post_password'         , $value ); return $this; }	

	public function getSlugName(               ){ return $this->get( 'post_name'             ); }
	public function setSlugName(        $value ){        $this->set( 'post_name'             , $value ); return $this; }	

	public function getToPing(                 ){ return $this->get( 'to_ping'               ); }
	public function setToPing(          $value ){        $this->set( 'to_ping'               , $value ); return $this; }	

	public function getPinged(                 ){ return $this->get( 'pinged'                ); }
	public function setPinged(          $value ){        $this->set( 'pinged'                , $value ); return $this; }	

	public function getModified(               ){ return $this->get( 'post_modified'         ); }
	public function setModified(        $value ){        $this->set( 'post_modified'         , $value ); return $this; }	

	public function getModifiedGMT(            ){ return $this->get( 'post_modified_gmt'     ); }
	public function setModifiedGMT(     $value ){        $this->set( 'post_modified_gmt'     , $value ); return $this; }	

	public function getContentFiltered(        ){ return $this->get( 'post_content_filtered' ); }
	public function setContentFiltered( $value ){        $this->set( 'post_content_filtered' , $value ); return $this; }	

	public function getParent(                 ){ return $this->get( 'post_parent'           ); }
	public function setParent(          $value ){        $this->set( 'post_parent'           , $value ); return $this; }	

	public function getGuid(                   ){ return $this->get( 'guid'                  ); }
	public function setGuid(            $value ){        $this->set( 'guid'                  , $value ); return $this; }	

	public function getMenuOrder(              ){ return $this->get( 'menu_order'            ); }
	public function setMenuOrder(       $value ){        $this->set( 'menu_order'            , $value ); return $this; }	

	public function getPostType(               ){ return $this->get( 'post_type'             ); }
	public function setPostType(        $value ){        $this->set( 'post_type'             , $value ); return $this; }	

	public function getMimeType(               ){ return $this->get( 'post_mime_type'        ); }
	public function setMimeType(        $value ){        $this->set( 'post_mime_type'        , $value ); return $this; }	

	public function getCommentCount(           ){ return $this->get( 'comment_count'         ); }
	public function setCommentCount(    $value ){        $this->set( 'comment_count'         , $value ); return $this; }	

	public function getFilter(                 ){ return $this->get( 'filter'                ); }
	public function setFilter(         $value  ){        $this->set( 'filter'                , $value ); return $this; }



}





