<?php

class ffPostMetaGetter extends ffBasicObject {
	
	private $_WPLayer = null;
	
	private $_postId = null;
	
	
	public function __construct( ffWPLayer $WPLayer ) {
		$this->_WPLayer = $WPLayer;
		if( ! $WPLayer->in_the_loop() ){
			$WPLayer->the_post();
			$WPLayer->rewind_posts();
		}
	}
	
	public function setPostId( $postId ) {
		$this->_postId = $postId;
	}
	
	public function removePostId() {
		$this->_postId = null;
	}
	

    public function getPostAuthorImage( $size = 32, $cssClasses = '') {
        $authorImage = get_avatar( get_the_author_meta( 'ID' ) , $size );
        if( !empty( $cssClasses ) ) {
            $authorImage = str_replace('\'avatar ', '\'avatar '.$cssClasses.' ', $authorImage);
        }
        return $authorImage;
    }

	public function getPostAuthorName() {
		if( $this->_postId == null ) {
			$author = $this->_getWPLayer()->get_the_author();
			
			return $author;
		} else {

        }
	}
	
	public function getPostCategoriesArray() {
		//get_the_category_list();

		
		$categories = $this->_getWPLayer()->get_the_category();
		
		foreach( $categories as $oneCategory ) {
			$categoryUrlUnescaped = $this->_getWPLayer()->get_category_link( $oneCategory->term_id );
			$categoryUrlEscaped = $this->_getWPLayer()->esc_url( $categoryUrlUnescaped );
			$oneCategory->computed_url = $categoryUrlEscaped;
		}
		
		return $categories;
	}
	
	public function getPostCategoriesHtml( $separator = ',', $linkClass = '', $separatorClass = '') {
		$categories = $this->getPostCategoriesArray();
		
		$output = '';
		$lastElement = end( $categories );
		foreach( $categories as $key => $oneCategory ) {
			$newClass = $linkClass . ' '.ffConstHTMLClasses::POST_META_CATEGORIES_LINK.' '.ffConstHTMLClasses::POST_META_CATEGORIES_LINK_SPECIFIC.$oneCategory->slug;
			
			$newLine = '';
			if( $key != 0  ) {
				$newLine .= '<span class="'.ffConstHTMLClasses::POST_META_CATEGORIES_LINK_SEPARATOR.' '.ffConstHTMLClasses::POST_META_CATEGORIES_LINK_SEPARATOR_SPECIFIC.$oneCategory->slug.' '.$separatorClass.'">, </span>';
			}
			
			$newLine .= '<a class="'.$newClass.'" href="'.$oneCategory->computed_url.'">';
			$newLine .= $oneCategory->name;
			$newLine .= '</a>';
			
			$output .= $newLine;
		}
		return $output;
	}
	
	public function getPostTagsArray() {
		$tags = $this->_getWPLayer()->get_the_tags();
		if( empty( $tags ) ) {
			return array();
		}
		foreach( $tags as $oneTag ) {
			$oneTag->computed_url = $this->_getWPLayer()->get_tag_link( $oneTag->term_id );
		}
		
		return $tags;
	}
	
	public function getPostTagsHtml() {
		$tags = $this->getPostTagsArray();

		$outputArray = array();
		foreach( $tags as $oneTag ) {
			
			$newLine = '';
			$newLine .= '<a href="'.$oneTag->computed_url.'">';
			$newLine .= $oneTag->name;
			$newLine .= '</a>';
			$outputArray[] = $newLine;
		}
		$output = implode(', ', $outputArray );
		
		return $output;
	}
	
	public function getPostCommentsText( $zero, $one, $more) {
		$commentsNumber = $this->_getWPLayer()->get_comments_number();
		
		if( $commentsNumber == 0 ) {
			return $zero;
		} else if( $commentsNumber == 1 ) {
			return $one;
		} else if( $commentsNumber > 1 ) {
			return str_replace('%s', $commentsNumber, $more );
		}
	}

    public function getPostCommentsId() {
        return 'comment-'.$this->_getWPLayer()->get_comment_ID();;
    }

    public function getPostCommentsNumber() {
        return $this->_getWPLayer()->get_comments_number();
    }

    public function getPostCommentsLink() {
        return $this->_getWPLayer()->get_comments_link();
    }
	
	public function getPostCommentsArray( $zero, $one, $more ) {
		echo 'NOT READY';
		die();
	}
	
	public function getPostCommentsLinkText( $zero, $one, $more ) {
		$text = $this->getPostCommentsText( $zero, $one, $more );
		$link = $this->_getWPLayer()->get_comments_link();
		
		$toReturn = '<a href="'.$link.'">'.$text.'</a>';
		
		return $toReturn;
	}
	
	public function getPostDate( $format = '' ) {
		return $this->_getWPLayer()->get_the_date($format);
	}
	
	public function getPostAuthorUrl() {
		$authorId = $this->_getWPLayer()->get_the_author_meta('ID');
		$url = $this->_getWPLayer()->get_author_posts_url( $authorId );
		return $url;
	}

    public function getPostAuthorDescription() {
        $meta = $this->_getWPLayer()->get_the_author_meta('description');

        return $meta;
    }

/**********************************************************************************************************************/
/* COMMENTS META SECTION
/**********************************************************************************************************************/
	public function getCommentAuthorName( $comment_ID = 0 ) {
        return $this->_getWPLayer()->get_comment_author( $comment_ID );
    }

    public function getCommentAuthorUrl( $comment_ID = 0 ) {
        return $this->_getWPLayer()->get_comment_author_url( $comment_ID );
    }

    public function getCommentDate( $format = '', $comment_ID = 0) {
        return $this->_getWPLayer()->get_comment_date( $format, $comment_ID );
    }

    public function getCommentAuthorImage( $size = '96', $id_or_email = null,  $default = '', $alt = false, $cssClass = '' ) {
        if( $id_or_email == null ) {
            $id_or_email = $this->_getWPLayer()->get_comment_author_email();
        }

        $args = array();
        if( !empty( $cssClass ) ) {
            $args['class'] = $cssClass;
        }

        return $this->_getWPLayer()->get_avatar( $id_or_email, $size, $default , $alt, $args );
    }

    public function getCommentReplyLink( $replyText, $args, $depth ) {
        $mergedArgs =  array_merge( $args, array('reply_text' => $replyText, 'depth' => $depth, 'max_depth' => $args['max_depth']));
        $result =  $this->_getWPLayer()->get_comment_reply_link( $mergedArgs );

        return $result;
    }
	
	private function _getWPLayer() {
		return $this->_WPLayer;
	}
	
}