<?php

class ffVideoIncluder extends ffBasicObject {
	public function getIframeHtmlFromVideoLink( $videoLink ) {
		
		$iframeHtml = '';
		if( strpos( $videoLink, 'youtube.com') !== false ) {
			$iframeHtml = $this->_getIframeHtmlFromYoutube( $videoLink );
		} else if ( strpos( $videoLink, 'vimeo.com') !== false ) {
			$iframeHtml = $this->_getIframeHtmlFromVimeo( $videoLink );
		}
		
		return $iframeHtml;
	}
	
	
	protected function _getIframeHtmlFromYoutube( $videoLink ) {
		$code = str_replace( array('http://', 'https://' ), '', $videoLink );
		$code = str_replace( 'www.', '', $code);
		$code = str_replace( 'youtube.com/','', $code );
		$code = str_replace( 'watch?v=','', $code );

		return '<iframe width="1000" height="563" src="https://www.youtube.com/embed/'.esc_attr($code).'?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';
	}
	
	protected function _getIframeHtmlFromVimeo( $videoLink ) {
		
		$videoLinkWithoutProtocol = str_replace( array('http://', 'https://' ), '', $videoLink );
		$videoLinkWithoutWWW = str_replace( array('www.'), '', $videoLinkWithoutProtocol);
		$videoLinkWithoutVimeo = str_replace( array('vimeo.com/'),'', $videoLinkWithoutWWW );
		
		$iframe = '';
		$iframe .= '<iframe src="http://player.vimeo.com/video/'.$videoLinkWithoutVimeo.'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="1000" height="563" allowfullscreen>';
		$iframe .= '</iframe>';
		
		return $iframe;
	}
}