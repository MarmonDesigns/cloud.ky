<?php

class ffColor extends ffBasicObject {

################################################################################
# CONSTANTS
################################################################################

################################################################################
# PRIVATE OBJECTS
################################################################################
	
################################################################################
# PRIVATE VARIABLES	
################################################################################	
	private $_hex = null;	
	
	private $_r = null;
	
	private $_g = null;
	
	private $_b = null;
	
	private $_alpha = null;
################################################################################
# CONSTRUCTOR
################################################################################	

################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	
	public function setHex( $hex, $alpha = 1 ) {
		$rgb = $this->_hex2rgb( $hex );
		$this->_setHex($hex, $alpha);
		$this->_setRGB( $rgb['r'], $rgb['g'], $rgb['b'], $alpha);
		
	}
	
	public function setRgb( $r, $g, $b, $alpha = 1 ) {
		$hex = $this->_rgb2hex($r, $g, $b);
		$this->_setRGB($r, $g, $b, $alpha);
		$this->_setHex($hex, $alpha);
	}
	
	public function getHex() {
		return $this->_hex;
	}
	
	public function getRgb() {
		return array('r' => $this->_r, 'g' => $this->_g, 'b' => $this->_b, 'a' => $this->_alpha );
	}
	
	public function getHTMLColor() {
		if( $this->_alpha == 1 ) {
			return $this->getHex();
		} else {
			$rgb = $this->getRgb();
			$toReturn = 'rgba('.  $rgb['r'] . ',' . $rgb['g'] .',' .$rgb['b'] . ',' . $this->_alpha.')';
			
			return $toReturn;
		}
	}
	
	public function getR() {
		return $this->_r;
	}
	
	public function getG() {
		return $this->_g;
	}
	
	public function getB() {
		return $this->_b;
	}
	
	public function getA() {
		return $this->_alpha;
	}
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	private function _setHex( $hex, $alpha = 1 ) {
		$this->_hex = $hex;
		$this->_alpha = $alpha;
	}
	
	private function _setRGB( $r, $g, $b, $alpha = 1) {
		$this->_r = $r;
		$this->_g = $g;
		$this->_b = $b;
		$this->_alpha = $alpha;
	}
	
	private function _rgb2hex($R, $G, $B){
		$R=dechex($R);
		If (strlen($R)<2)
		$R='0'.$R;
	
		$G=dechex($G);
		If (strlen($G)<2)
		$G='0'.$G;
	
		$B=dechex($B);
		If (strlen($B)<2)
		$B='0'.$B;
	
		return '#' . $R . $G . $B;
	}
	
	private function _hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);
	
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array('r'=>$r, 'g'=>$g, 'b'=>$b);
		//return implode(",", $rgb); // returns the rgb values separated by commas
		return $rgb; // returns an array with the rgb values
	}
################################################################################
# GETTERS AND SETTERS
################################################################################	
	
}