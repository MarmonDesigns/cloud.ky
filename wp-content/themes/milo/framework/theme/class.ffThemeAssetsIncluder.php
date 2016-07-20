<?php

########################################################################################################################
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
# READ ME PLEASE
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
#
# wp_enqueue_style - HERE
# wp_enqeueu_Script - HERE
#
# Here is done the whole magic about including styles and scripts. These functions are mainly wrappers above the
# wp_enqueue_style and wp_enqueue_script WP functions. Please feel free to inherit this file at your child theme
# and change every thing you want:
#
# public function addStyleTheme( $handle = null, $source = null, $dependencies = null, $version = null, $media = null, $type = null, $additionalInfo = null )
#
#
# public function addScriptTheme( $handle = null, $source = null, $dependencies = null, $version = null, $inFooter = null, $type = null, $additionalInfo = true )
#
########################################################################################################################

class ffThemeAssetsIncluder extends ffThemeAssetsIncluderAbstract {

    private $_printedSections = array();

	public function addPrintedSection( $name ) {}

	public function addPrintedSectionMiloAssets( $name ) {
		$this->_printedSections[ $name ] = true;
	}

	public function isAdmin() {
		$styleEnqueuer = $this->_getStyleEnqueuer();
		$scriptEnqueuer = $this->_getScriptEnqueuer();

		$styleEnqueuer->addStyleTheme( 'wp-color-picker' );
		$scriptEnqueuer->addScript( 'wp-color-picker');
	}

	private function _includeGoogleFont( $font_name ){
		if( FALSE !== strpos($font_name, ',') ){
			// THIS IS NOT GOOGLE FONT
			return;
		}

		$font_name = str_replace("'", "", $font_name);

		$fontIdValue = str_replace(' ', '-', $font_name );
		$fontIdValue = strtolower( $fontIdValue );

		$src = '//fonts.googleapis.com/css?family='.esc_attr($font_name).':300,400,600,700,300italic,400italic,600italic,700italic&subset=latin,latin-ext';
		$this->_getStyleEnqueuer()->addStyle( 'google-font-' . esc_attr( $fontIdValue ), $src);
	}


	private function _includeCss() {
		$styleEnqueuer = $this->_getStyleEnqueuer();

        $styleEnqueuer->addStyle('ff-google-font','http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic');

        $styleEnqueuer->addStyleTheme('ff-bootstrap','/assets/css/bootstrap.min.css');

        $styleEnqueuer->addStyleTheme('ff-fancybox','/assets/js/fancybox/jquery.fancybox.css');
        $styleEnqueuer->addStyleTheme('ff-revolution-slider','/assets/js/revolutionslider/css/settings.css');
        $styleEnqueuer->addStyleTheme('ff-bx-slider','/assets/js/bxslider/jquery.bxslider.css');
        $styleEnqueuer->addStyleTheme('ff-youtube-player','/assets/js/ytplayer/css/YTPlayer.css');
        $styleEnqueuer->addStyleTheme('ff-animations','/assets/js/animations/animate.min.css');
        $styleEnqueuer->addStyleTheme('ff-custom','/assets/css/custom.css');
        $styleEnqueuer->addStyleTheme('ff-custom-page','/assets/css/pages-style.css');

        $accent = ffThemeOptions::getQuery('layout accent' );
        if( 'default' != $accent ){
            $styleEnqueuer->addStyleTheme('ff-accent','/assets/css/alternative-styles/'.esc_attr($accent).'.css');
        }

        // CUSTOM FONT STYLE

        $fontQuery = ffThemeOptions::getQuery('font');
        // Has to be same as in class.ffThemeOptionsHolder.php
        $this->_includeGoogleFont( $fontQuery->get('body'    ) );
        $this->_includeGoogleFont( $fontQuery->get('headers' ) );
        $this->_includeGoogleFont( $fontQuery->get('inputs'  ) );
        $this->_includeGoogleFont( $fontQuery->get('code'    ) );

        ffContainer::getInstance()->getWPLayer()->wp_add_inline_style('ff-custom-page',
            ff_get_font_selectors('body')
            . '{font-family: '
            .  $fontQuery->get('body')
            . ', Helvetica, Arial, sans-serif; }'
            . "\n"
            .ff_get_font_selectors('headers')
            . '{font-family: '
            .  $fontQuery->get('headers')
            . ', Helvetica, Arial, sans-serif; }'
            . "\n"
            .ff_get_font_selectors('inputs')
            . '{font-family: '
            .  $fontQuery->get('inputs')
            . ', Helvetica, Arial, sans-serif; }'
            . "\n"
            .ff_get_font_selectors('code')
            . '{font-family: '
            .  $fontQuery->get('code')
            . ', monospace; }'
            . "\n"
        );

        $styleEnqueuer->addStyleTheme('ff-font-awesome','/assets/fontawesome/css/font-awesome.min.css');
        $styleEnqueuer->addStyleFramework( 'ff-font-awesome4','/framework/extern/iconfonts/ff-font-awesome4/ff-font-awesome4.css');
        $styleEnqueuer->addStyleTheme('ff-miu-icon-font','/assets/miuiconfont/miuiconfont.css');
        $styleEnqueuer->addStyleFramework( 'ff-font-miu', '/framework/extern/iconfonts/ff-font-miu/ff-font-miu.css' );

        $iconfont_types = array(
//            'bootstrap glyphicons' => '/framework/extern/iconfonts/glyphicon/glyphicon.css',
            'brandico'    => '/framework/extern/iconfonts/ff-font-brandico/ff-font-brandico.css',
            'elusive'     => '/framework/extern/iconfonts/ff-font-elusive/ff-font-elusive.css',
            'entypo'      => '/framework/extern/iconfonts/ff-font-entypo/ff-font-entypo.css',
            'fontelico'   => '/framework/extern/iconfonts/ff-font-fontelico/ff-font-fontelico.css',
            'iconic'      => '/framework/extern/iconfonts/ff-font-iconic/ff-font-iconic.css',
            'linecons'    => '/framework/extern/iconfonts/ff-font-linecons/ff-font-linecons.css',
            'maki'        => '/framework/extern/iconfonts/ff-font-maki/ff-font-maki.css',
            'meteocons'   => '/framework/extern/iconfonts/ff-font-meteocons/ff-font-meteocons.css',
            'mfglabs'     => '/framework/extern/iconfonts/ff-font-mfglabs/ff-font-mfglabs.css',
            'modernpics'  => '/framework/extern/iconfonts/ff-font-modernpics/ff-font-modernpics.css',
            'typicons'    => '/framework/extern/iconfonts/ff-font-typicons/ff-font-typicons.css',
            'simple line icons' => '/framework/extern/iconfonts/ff-font-simple-line-icons/ff-font-simple-line-icons.css',
            'weathercons' => '/framework/extern/iconfonts/ff-font-weathercons/ff-font-weathercons.css',
            'websymbols'  => '/framework/extern/iconfonts/ff-font-websymbols/ff-font-websymbols.css',
            'zocial'      => '/framework/extern/iconfonts/ff-font-zocial/ff-font-zocial.css',
        );

        $iconfontQuery = ffThemeOptions::getQuery('iconfont');
        foreach ($iconfont_types as $name => $path) {
            if( $iconfontQuery->get( str_replace(' ', '_', $name) ) ){
                $styleEnqueuer->addStyleFramework( 'icon-option-font-' . str_replace(' ', '_', $name), $path);
            }
        }
	}

	private function _includeJs() {
        $scriptEnqueuer = $this->_getScriptEnqueuer();



		$scriptEnqueuer->addScript('jquery');

        $scriptEnqueuer->addScriptFramework(
			'ff-frslib',
			'/framework/frslib/src/frslib.js',
			array( 'jquery' ),
            null,
            true
		);

        $scriptEnqueuer->addScriptTheme('ff-bootstrap','/assets/js/bootstrap.min.js', null, null, true);

        $scriptEnqueuer->addScriptTheme('ff-viewport','/assets/js/viewport/jquery.viewport.js', null, null, true);

        $scriptEnqueuer->addScriptTheme('ff-hover-intent','/assets/js/menu/hoverIntent.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-superfish','/assets/js/menu/superfish.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-sticky','/assets/js/sticky/jquery.sticky.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-fancybox','/assets/js/fancybox/jquery.fancybox.pack.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-bx-slider','/assets/js/bxslider/jquery.bxslider.min.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-parallax','/assets/js/parallax/jquery.parallax-scroll.min.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-imagesloaded','/assets/js/isotope/imagesloaded.pkgd.min.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-isotope','/assets/js/isotope/isotope.pkgd.min.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-placeholder','/assets/js/placeholders/jquery.placeholder.min.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-validate','/assets/js/validate/jquery.validate.min.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-submit','/assets/js/submit/jquery.form.min.js', null, null, true);


//        $scriptEnqueuer->addScriptTheme('ff-chart','/assets/js/charts/chart.min.js', null, null, true);


        $scriptEnqueuer->addScriptTheme('ff-youtube','/assets/js/ytplayer/jquery.mb.YTPlayer.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-animations','/assets/js/animations/wow.min.js', null, null, true);
        $scriptEnqueuer->addScriptTheme('ff-custom','/assets/js/custom.js', null, null, true);

        if ( is_singular() && comments_open() && get_option('thread_comments') ){
            wp_enqueue_script( 'comment-reply' );
        }
	}

    private function _sectionHasBeenPrinted( $sectionName ) {
        return isset( $this->_printedSections[ $sectionName ] );
    }

	public function isNotAdmin() {
		$this->_includeCss();
		$this->_includeJs();
	}

    public function actionWPFooter() {

        $scriptEnqueuer = $this->_getScriptEnqueuer();

        if( $this->_sectionHasBeenPrinted('map') ) {
            $scriptEnqueuer->addScript('ff-google-maps-extern','http://maps.google.com/maps/api/js?sensor=false', null, null, true);
            $scriptEnqueuer->addScriptTheme('ff-google-maps','/assets/js/googlemaps/jquery.gmap.min.js', null, null, true);
        }

        if( $this->_sectionHasBeenPrinted('fun-facts-with-counters') ) {
            $scriptEnqueuer->addScriptTheme('ff-simple-counter','/assets/js/counter/jQuerySimpleCounter.js', null, null, true);
        }

        if( $this->_sectionHasBeenPrinted('fun-facts') ) {
            $scriptEnqueuer->addScriptTheme('ff-easy-pie-chart','/assets/js/charts/jquery.easypiechart.min.js', null, null, true);
        }

    }
}




