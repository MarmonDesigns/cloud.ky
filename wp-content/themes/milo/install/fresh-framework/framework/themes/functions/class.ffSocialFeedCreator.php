<?php

class ffSocialFeedCreator {

	private $_items;

	protected $_possible_social_links = array(

			'blogger'     => array( 'title' => 'blogger',     'url_substr' => 'blogger'     ),
			'blogspot'    => array( 'title' => 'zocial-blogger',     'url_substr' => 'blogspot'    ),
			'delicious'   => array( 'title' => 'delicious',   'url_substr' => 'delicious'   ),
			'digg'        => array( 'title' => 'digg',        'url_substr' => 'digg'        ),
			'dribbble'    => array( 'title' => 'dribbble',    'url_substr' => 'dribbble'    ),
			'facebook'    => array( 'title' => 'facebook',    'url_substr' => 'facebook'    ),
			'flickr'      => array( 'title' => 'flickr',      'url_substr' => 'flickr'      ),
			'forrst'      => array( 'title' => 'forrst',      'url_substr' => 'forrst'      ),
			'google-plus' => array( 'title' => 'google-plus', 'url_substr' => 'google'      ),
			'lastfm'      => array( 'title' => 'lastfm',      'url_substr' => 'last'        ),
			'instagram'   => array( 'title' => 'instagram',   'url_substr' => 'instagram'   ),
			'linkedin'    => array( 'title' => 'linkedin',    'url_substr' => 'linkedin'    ),
			'myspace'     => array( 'title' => 'myspace',     'url_substr' => 'myspace'     ),
			'pinterest'   => array( 'title' => 'pinterest',   'url_substr' => 'pinterest'   ),
			'reddit'      => array( 'title' => 'reddit',      'url_substr' => 'reddit'      ),
			'rss'         => array( 'title' => 'rss',         'url_substr' => 'rss'         ),
			'skype'       => array( 'title' => 'skype',       'url_substr' => 'skype'       ),
			'stumbleupon' => array( 'title' => 'stumbleupon', 'url_substr' => 'stumbleupon' ),
			'tumblr'      => array( 'title' => 'tumblr',      'url_substr' => 'tumblr'      ),
			'twitter'     => array( 'title' => 'twitter',     'url_substr' => 'twitter'     ),
			'yahoo'       => array( 'title' => 'yahoo',       'url_substr' => 'yahoo'       ),
			'yelp'        => array( 'title' => 'yelp',        'url_substr' => 'yelp'        ),
			'youtube'     => array( 'title' => 'youtube',     'url_substr' => 'youtube'     ),
			'vimeo'       => array( 'title' => 'vimeo',       'url_substr' => 'vimeo'       ),
			'wordpress'   => array( 'title' => 'wordpress',   'url_substr' => 'wordpress'   ),
			'vk'          => array( 'title' => 'vk',          'url_substr' => 'vk'          ),
            'vine'          => array( 'title' => 'vine',          'url_substr' => 'vine'          ),
            'behance'          => array( 'title' => 'behance',          'url_substr' => 'behance'          ),


			'homeicon'    => array( 'title' => 'Home', 'url_substr' => 'homeicon' ),
			'phone'       => array( 'title' => 'Phone', 'url_substr' => 'phone' ),
			'email'       => array( 'title' => 'Email', 'url_substr' => 'email' ),
			'mailto'       => array( 'title' => 'Mailto', 'url_substr' => 'mailto' ),

	);


	function __construct( $links = null, $possibleSocials = null ){
		if( !empty($possibleSocials) ){
			$this->setPossibleSocials( $possibleSocials );
		}
		if( $links != null ) {
			$this->_translateTextToLinks( $links );
		}
	}
	
	public function getFeedFromLinks( $links ) {
		$this->_translateTextToLinks( $links );
		$items = $this->_items;
		$this->_items = null;
		return $items;
	}

	public function setPossibleSocials( $possibleSocials ){
		if( ! is_array($possibleSocials) ){
			return;
		}

		foreach($this->_possible_social_links as $key=>$value) {
			$key = strtolower($key);
			if( ! in_array( $key, $possibleSocials ) ){
				unset( $this->_possible_social_links[$key] );
			}
		}
	}

	protected function _translateTextToLinks( $links ){
		$links = explode("\n", $links);

		$this->links = array();

		foreach($links as $lIndex=>$lValue) {
			$l = $this->_translateLinkStringIntoInnerFormat($lValue);
			if( !empty( $l ) ){
				$this->_items[] = $l;
			}
		}
	}

	protected function _translateLinkStringIntoInnerFormat($linkString){
		$linkString = trim( $linkString );
		$linkString = strip_tags( $linkString );

		if( empty($linkString) ){
			return null;
		}

		if( '#' == substr($linkString, 0, 1) ){
			return null;
		}

		if ( ffContainer()->getWPLayer()->is_email( $linkString) ) {
			return (object) array(
				'type' => 'envelope',
				'link' => 'mailto:'.$linkString,
				'title' => 'E-mail',
			);
		}

		if( 'http' != substr($linkString, 0, 4) ){
			if( FALSE !== strpos($linkString,":") ){
				$e = explode(":", $linkString, 2);
				$sType = trim( $e[0] );
				$link = trim( $e[1] );
				return (object) array(
						'type' => $sType,
						'link' => $link,
						'title' => $this->_possible_social_links[ $sType ]['title'],
				);
			}
		}

		$socType = null;
		$socLink = null;

		$socProtocol = null;

		if( 'https://' == substr($linkString, 0, 8) ){
			$linkString = substr($linkString, 8);
			$socProtocol = 'https://';
		}else if( 'http://' == substr($linkString, 0, 7) ){
			$linkString = substr($linkString, 7);
			$socProtocol = 'http://';
		}else{
			$socProtocol = 'http://';
		}

		$slashPosition = strpos( $linkString, '/' );

		$domain = substr($linkString, 0, $slashPosition);

		foreach ($this->_possible_social_links as $sType=>$sDefinitions) {
			if( FALSE !== strpos( $domain, $sDefinitions['url_substr'] . '.' ) ){
				return (object) array(
						'type' => $sType,
						'link' => $socProtocol . $linkString,
						'title' => $this->_possible_social_links[ $sType ]['title'],
				);
			}
		}

		return null;

	}
}