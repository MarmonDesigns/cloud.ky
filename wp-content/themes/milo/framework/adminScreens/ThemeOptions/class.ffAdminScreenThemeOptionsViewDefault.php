<?php

class ffAdminScreenThemeOptionsViewDefault extends ffAdminScreenView {

	public function actionSave( ffRequest $request ) {

		if( ! $request->postEmpty() ){
			flush_rewrite_rules( false );
		}

	}
	
	protected function _render() {

		ffContainer::getInstance()->getModalWindowFactory()->printModalWindowSectionPicker();

		if( ! ffContainer::getInstance()->getRequest()->postEmpty() ){
			echo '<iframe src="?page=ThemeOptions&flush-more=1" style="height:1px;width:1px;"></iframe>';
		}

		echo '<div class="wrap">';
		echo '<form method="post">';

		echo '<h2>Theme Options</h2>';

		echo '<h2 class="nav-tab-wrapper">';

		echo '<a href="#ff-theme-mix-admin-tab-layout" class="nav-tab nav-tab-active" data-for="ff-theme-mix-admin-tab-layout">Layout</a>';
        echo '<a href="#ff-theme-mix-admin-tab-translation" class="nav-tab nav-tab-active" data-for="ff-theme-mix-admin-tab-translation">Translation</a>';
		echo '<a href="#ff-theme-mix-admin-tab-fonts" class="nav-tab" data-for="ff-theme-mix-admin-tab-fonts">Fonts</a>';
		echo '<a href="#ff-theme-mix-admin-tab-iconfonts" class="nav-tab" data-for="ff-theme-mix-admin-tab-iconfonts">Icon Fonts</a>';
		echo '<a href="#ff-theme-mix-admin-tab-portfolio" class="nav-tab" data-for="ff-theme-mix-admin-tab-portfolio">Portfolio Slugs</a>';
		echo '</h2>';

		$this->_renderOptions(
			  ffThemeContainer::OPTIONS_HOLDER
			, ffThemeContainer::OPTIONS_PREFIX
			, ffThemeContainer::OPTIONS_NAMESPACE
			, ffThemeContainer::OPTIONS_NAME
		);

		echo '</form>';
		echo '</div>';

		?>
			<style type="text/css">
				.ff-theme-mix-admin-tab-iconfonts i{
					font-size: 20px;
					margin-right: 20px;
					width: 20px;
				}
			</style>
			<script>
			(function($){
				$(document).ready(function(){
					$(".ff-theme-layout-changer label").click(function(){
						$( this ).parents('fieldset').find('label').removeClass('selected');
						$( this ).addClass('selected');
					});

					$(".ff-theme-layout-changer label input[checked=checked]").each(function(){
						$(this).parents('label').click();
					});

				});

				$(document).ready(function(){
					$(".nav-tab").click(function(){
						$(".ff-theme-mix-admin-tab-content").hide();
						$("." + $(this).attr("data-for")).show();
						$(".nav-tab-active").removeClass("nav-tab-active");
						$(this).addClass("nav-tab-active");
					});
				});

				$(document).ready(function(){

					if( -1 == document.URL.indexOf('#') ){
						$(".nav-tab-active").click();
						return;
					}

					var _id;
					_id = document.URL.split('#');
					_id = "" + _id[1];
					if( _id.length < 1 ) {
						return null;
					}

					if( $( 'a[href=#' + _id + ']' ).size() < 1 ){
						$(".nav-tab-active").click();
						return;
					}

					$( 'a[href=#' + _id + ']' ).click();
				});

				$(window).load(function(){
					$(".ff-default-wp-color-picker").each(function(){
						var $this_parent = $(this).parent();
						var this_text = $this_parent.text();
						$(this).wpColorPicker();
						$this_parent.find('a').attr('title', this_text);
						console.log(this_text);
						$this_parent.contents().filter(function() {
							return this.nodeType == 3; //Node.TEXT_NODE
						}).remove();
					});
				});
			})(jQuery);
			</script>
		<?php

	}

	protected function _requireAssets() {
		$styleEnqueuer = $this->_getStyleEnqueuer();
		$scriptEnqueuer = $this->_getScriptEnqueuer();

		if( ffContainer::getInstance()->getRequest()->get('flush-more') ){
			flush_rewrite_rules( false );
			exit;
		}

		$styleEnqueuer->addStyleTheme( 'wp-color-picker' );
		$scriptEnqueuer->addScript( 'wp-color-picker');

		$iconfont_types = array(
			'bootstrap glyphicons'
			              => '/framework/extern/iconfonts/glyphicon/glyphicon.css',
			'brandico'    => '/framework/extern/iconfonts/ff-font-brandico/ff-font-brandico.css',
			'elusive'     => '/framework/extern/iconfonts/ff-font-elusive/ff-font-elusive.css',
			'entypo'      => '/framework/extern/iconfonts/ff-font-entypo/ff-font-entypo.css',
			'fontelico'   => '/framework/extern/iconfonts/ff-font-fontelico/ff-font-fontelico.css',
			'iconic'      => '/framework/extern/iconfonts/ff-font-iconic/ff-font-iconic.css',
			'linecons'    => '/framework/extern/iconfonts/ff-font-linecons/ff-font-linecons.css',
			'maki'        => '/framework/extern/iconfonts/ff-font-maki/ff-font-maki.css',
			'meteocons'   => '/framework/extern/iconfonts/ff-font-meteocons/ff-font-meteocons.css',
			'mfglabs'     => '/framework/extern/iconfonts/ff-font-mfglabs/ff-font-mfglabs.css',
			'miu'         => '/framework/extern/iconfonts/ff-font-miu/ff-font-miu.css',
			'modernpics'  => '/framework/extern/iconfonts/ff-font-modernpics/ff-font-modernpics.css',
			'typicons'    => '/framework/extern/iconfonts/ff-font-typicons/ff-font-typicons.css',
			'simple line icons'
			              => '/framework/extern/iconfonts/ff-font-simple-line-icons/ff-font-simple-line-icons.css',
			'weathercons' => '/framework/extern/iconfonts/ff-font-weathercons/ff-font-weathercons.css',
			'websymbols'  => '/framework/extern/iconfonts/ff-font-websymbols/ff-font-websymbols.css',
			'zocial'      => '/framework/extern/iconfonts/ff-font-zocial/ff-font-zocial.css',
		);

		foreach ($iconfont_types as $name => $path) {
			$styleEnqueuer->addStyleFramework( 'icon-option-font-' . str_replace(' ', '_', $name), $path);
		}


	}

	protected function _setDependencies() {

	}

	public function ajaxRequest( ffAdminScreenAjax $ajax ) {

	}
}