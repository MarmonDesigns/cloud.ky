<?php

class ffPaginationComputer extends ffBasicObject {

	const TYPE_PREV = 'prev';
	const TYPE_NEXT = 'next';
	const TYPE_FIRST_NUMBER_BUTTON = 'first_number_button';
	const TYPE_LAST_NUMBER_BUTTON = 'last_number_button';
	const TYPE_DOTS_START = 'dots_start';
	const TYPE_DOTS_END = 'dots_end';
	const TYPE_STD_BUTTON = 'button';
	
	
	private $_range = 2;
	private $_numberOfPages = 1;
	private $_currentPage = null;
	
	
	public function setRange( $range ) {
		$this->_range = $range;
		
		return $this;
	}
	
	
	public function setNumberOfPages( $numberOfPages ) {
		$this->_numberOfPages = $numberOfPages;
		
		return $this;
	}
	
	public function setCurrentPage( $currentPage ) {
		$this->_currentPage = $currentPage;
		
		return $this;
	}
	
	public function getComputedPagination() {


        $range = $this->_range;
        $currentPage = $this->_currentPage;
        $numberOfPages = $this->_numberOfPages;

        $toReturn = array();

        if( $numberOfPages == 1 ) {
            return null;
        }


        //## PREVIOUS Button
        if ( $currentPage > 1 ) {
            $button = $this->_createNewButton( ffPaginationComputer::TYPE_PREV, $currentPage -1,  false);
			$toReturn[] = $button;
        }

        //## FIRST Button
        if( $currentPage - $range > 1 ) {
            $button = $this->_createNewButton( ffPaginationComputer::TYPE_FIRST_NUMBER_BUTTON, 1, false );
            $toReturn[] = $button;
        }


        //## DOTS START

        if( $currentPage - $range > 2 ) {
            $button = $this->_createNewButton( ffPaginationComputer::TYPE_DOTS_START, null, false );
            $toReturn[] = $button;
        }


        //## CONTENT BUTTONS
        $contentStart = $currentPage - $range;
        if( $contentStart < 1 ) {
            $contentStart = 1;
        }

        $contentEnd = $currentPage + $range;

        if( $contentEnd > $numberOfPages ) {
            $contentEnd = $numberOfPages;
        }


        for( $i = $contentStart; $i <= $contentEnd; $i++ ) {
            $button = $this->_createNewButton( ffPaginationComputer::TYPE_STD_BUTTON,  $i,  false);
            if( $currentPage == $i ) {
                $button->selected = true;
            }
            $toReturn[] = $button;
        }


        //## DOTS END

        if( $currentPage + $range < $numberOfPages - 1 ) {
            $button = $this->_createNewButton( ffPaginationComputer::TYPE_DOTS_END, null, false );
            $toReturn[] = $button;
        }

        //## LAST Button
        if( $currentPage + $range < $numberOfPages ) {
            $button = $this->_createNewButton( ffPaginationComputer::TYPE_LAST_NUMBER_BUTTON, $numberOfPages, false );
            $toReturn[] = $button;
        }

        //## NEXT Button
        if ( $currentPage < $numberOfPages ) {
            $button = $this->_createNewButton( ffPaginationComputer::TYPE_NEXT, $currentPage + 1,  false);
			$toReturn[] = $button;
        }


        return $toReturn;

	}
	
	
	private function _createNewButton( $type, $page, $selected ) {
			$button = new stdClass();
			$button->type = $type;
			$button->page = $page;
			$button->selected = $selected;
			
			return $button;
	}
}

/*
 * 
 * private $range = 11;				// how many buttons we want to show ?
	protected $_paged = 0;
	protected $_page_count = 0;
	
	abstract protected function _getItemLink( $i );
	
	
	
	protected function _setActualPage( $actualPage ) {
		$this->_paged = $actualPage;
	}
	
	protected function _setNumberOfPages( $numberOfPages ) {
		$this->_page_count = $numberOfPages;
	}

	/**
	 * Compute pagination and return array with paged buttons. The array output is array( page, selected, link )
	 *
	 * @return array array( array(page, selected, link ) )
	 
	public function compute() {
		// DEFINE IMPORTANT VARIABLES
		// paged = actual page selected
		// page_count = number of all pages
		/*global $paged, $wp_query;
		if(empty($paged)) $paged = 1;
		$page_count = $wp_query->max_num_pages;
		if(!$page_count) $page_count = 1; 
		$paged = $this->_paged;
		$page_count = $this->_page_count;

		// go to calculation
		if( $page_count == 1 ) return;		// there are no more pages than one, paginaiton is useless

		$buttons_from_selected = null;		// how many buttons you want to show from each side of button actual selected
		$buttons_from_selected = $this->range - 3;	// first, last, selected;

		if( $paged != 1 )	$buttons_from_selected--; // prev
		if( $paged != $page_count ) $buttons_from_selected--; // next

			
		$to_return = array();

		//## PREV BUTTON
		if( $paged != 1 ) {
			$btn = array( 'page'=>'prev', 'link'=> $this->_getItemLink( $paged - 1 ) , 'selected'=>false );
			$to_return['prev'] = $btn;
		}

        $to_return['items'] = array();

		//## FIRST NUMBER BUTTON
		$btn_first = array( 'page'=>1,'link'=>$this->_getItemLink(1), 'selected' => false );
		if( $paged == 1 ) $btn_first['selected'] = true;
		$to_return['items']['first'] = $btn_first;

		//## RANGE FOR LEFT AND RIGHT
		$range_from_selected = ceil($buttons_from_selected / 2);

		//## WHERE TO START
		$starting_range = $paged - $range_from_selected;
		if( $starting_range < 2 )	$starting_range = 2;

		//#WHERE TO END
		$ending_range = $paged + $range_from_selected;
		if( $ending_range > ($page_count-1) ) $ending_range = ($page_count - 1);

		for( $i = $starting_range; $i <= $ending_range; $i++ ) {
				
			// ## STARTING 3 DOTS ( ... )
			if( $i == $starting_range && $starting_range != 2  ) {
				$btn = array( 'page'=>'startdot', 'link'=> null , 'selected'=>false );
				$to_return['items'][] = $btn;
			}
			// ## ENDING 3 DOTS ( ... )
			else if ( $i == $ending_range && ( $ending_range != ($page_count - 1 ) ) ) {
				$btn = array( 'page'=>'enddot', 'link'=> null , 'selected'=>false );
				$to_return['items'][] = $btn;
			}
			// ## STD BUTTON
			else {
				$btn = null;
				$selected = false;
				if( $paged == $i ) $selected = true;
				$btn = array( 'page'=>$i, 'link'=> $this->_getItemLink( $i ) , 'selected'=>$selected );
				$to_return['items'][] = $btn;
			}
		}

		//## LAST NUMBER BUTTON
		$selected = false;
		if( $page_count == $paged ) $selected = true;
		$btn_last = array( 'page'=> $page_count, 'link' =>$this->_getItemLink( $page_count ), 'selected' =>$selected );
		$to_return['items']['last'] = $btn_last;

		//## NEXT BUTTON
		if( $paged != $page_count ) {
			$btn = array( 'page'=>'next', 'link'=> $this->_getItemLink( $paged + 1 ) , 'selected'=>false );
			$to_return['next'] = $btn;
		}

		return $to_return;
	}
 */