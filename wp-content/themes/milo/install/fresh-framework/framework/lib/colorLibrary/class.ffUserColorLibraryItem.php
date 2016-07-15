<?php


class ffUserColorLibraryItem extends ffBasicObject {

################################################################################
# CONSTANTS
################################################################################

################################################################################
# PRIVATE OBJECTS
################################################################################
	/**
	 * 
	 * @var ffColor
	 */
	private $_color = null;
	
	private $_id = null;
	
	private $_title = null;
	
	private $_tags = null;
	
	private $_timestamp = null;
	
	private $_group = null;

################################################################################
# PRIVATE VARIABLES	
################################################################################	

################################################################################
# CONSTRUCTOR
################################################################################	
	public function __construct( ffColor $color ) {
		$this->_setColor($color);
	}
################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	

################################################################################
# PRIVATE FUNCTIONS
################################################################################
	 
################################################################################
# GETTERS AND SETTERS
################################################################################	
	/**
	 *
	 * @return ffColor
	 */
	public function getColor() {
		return $this->_color;
	}
	
	/**
	 *
	 * @param ffColor $_color
	 */
	protected function _setColor(ffColor $color) {
		$this->_color = $color;
		return $this;
	}
	
	/**
	 *
	 * @return unknown_type
	 */
	public function getId( $withPrefix = true ) {
		
		$id = $this->_id;
		
		if( $withPrefix ) {
			$id = ffUserColorLibrary::LESS_COLOR_PREFIX . $id;
		}
		
		return $id;
	}
	
	/**
	 *
	 * @param unknown_type $_id        	
	 */
	public function setId($id) {
		$this->_id = $id;
		return $this;
	}
	
	/**
	 *
	 * @return unknown_type
	 */
	public function getTitle() {
		return $this->_title;
	}
	
	/**
	 *
	 * @param unknown_type $_title        	
	 */
	public function setTitle($title) {
		$this->_title = $title;
		return $this;
	}
	
	/**
	 *
	 * @return unknown_type
	 */
	public function getTags() {
		return $this->_tags;
	}
	
	/**
	 *
	 * @param unknown_type $_tags        	
	 */
	public function setTags($tags) {
		$this->_tags = $tags;
		return $this;
	}
	
	/**
	 *
	 * @return unknown_type
	 */
	public function getTimestamp() {
		return $this->_timestamp;
	}
	
	/**
	 *
	 * @param unknown_type $_date        	
	 */
	public function setTimestamp($timestamp) {
		$this->_timestamp = $timestamp;
		return $this;
	}
	
	public function setGroup( $group) {
		$this->_group = $group;
	}
	
	public function getGroup() {
		return $this->_group;
	}
	
	
}