<?php

class ffPaginationWPLoop extends ffBasicObject {

	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffPaginationComputer
	 */
	private $_paginationComputer = null;
	
	private $_range = 3;
	
	public function __construct( ffWPLayer $WPLayer, ffPaginationComputer $paginationComputer ) {
		$this->_WPLayer = $WPLayer;
		$this->_paginationComputer = $paginationComputer;
	}
	
	public function setRange( $range ) {
		$this->_range = $range;
	}
	
	public function hasPrev() {
		$wpQuery = $this->_getWPLayer()->get_wp_query();
		$currentPage = $this->_getWPLayer()->get_paged();
		$numberOfPagesOverall = $wpQuery->max_num_pages;
		
		if( $currentPage < $numberOfPagesOverall ) {
			return true;
		} else {
			return false;
		}
		
		
	}
	
	public function getPrevLink() {
		$currentPage = $this->_getWPLayer()->get_paged();
		return get_pagenum_link( $currentPage + 1 );
	}
	
	public function hasNext() {
		$currentPage = $this->_getWPLayer()->get_paged();
		if( $currentPage > 1 ) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getNextLink() {
		$currentPage = $this->_getWPLayer()->get_paged();
		return get_pagenum_link( $currentPage - 1 );
	}

    public function computeTestPagination( $range, $numberOfPages, $currentPage ) {
        $paginationComputer = $this->_paginationComputer;


		$paginationComputer->setRange( $range );
		$paginationComputer->setNumberOfPages( $numberOfPages );
		$paginationComputer->setCurrentPage( $currentPage );

		//var_dump( $wpQuery );

		return $paginationComputer->getComputedPagination();
    }
	
	public function computePagination() {
		
		$paginationComputer = $this->_paginationComputer;
	
		$wpQuery = $this->_getWPLayer()->get_wp_query();
		$paged = $this->_getWPLayer()->get_paged();

		$paginationComputer->setRange(  $this->_range );
		$paginationComputer->setNumberOfPages( $wpQuery->max_num_pages );
		$paginationComputer->setCurrentPage( $paged );
		
		//var_dump( $wpQuery );
		
		return $paginationComputer->getComputedPagination();
	}
	
	/**
	 * 
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
}