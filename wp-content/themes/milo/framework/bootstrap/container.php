<?php

class ffThemeContainer extends ffThemeContainerAbstract {

	const OPTIONS_HOLDER    = 'ffThemeOptionsHolder';
	const OPTIONS_PREFIX    = 'ff_options';
	const OPTIONS_NAMESPACE = 'theme_milo';
	const OPTIONS_NAME      = 'theme_options';
	const THEME_NAME_LOW = 'milo';


	/**
	 * @var ffThemeContainer
	 */
	private static $_instance = null;

	/**
	 * @param ffContainer $container
	 * @param string $pluginDir
	 * @return ffThemeContainer
	 */
	public static function getInstance( ffContainer $container = null, $pluginDir = null ) {
		if( self::$_instance == null ) {
			self::$_instance = new ffThemeContainer($container, $pluginDir);
		}
		return self::$_instance;
	}

	protected function _registerFiles() {

		$this->_registerThemeFile('ffAdminScreenThemeOptions', '/framework/adminScreens/ThemeOptions/class.ffAdminScreenThemeOptions.php');
		$this->_registerThemeFile('ffAdminScreenThemeOptionsViewDefault', '/framework/adminScreens/ThemeOptions/class.ffAdminScreenThemeOptionsViewDefault.php');

		$this->_registerThemeFile('ffThemeOptionsHolder', '/framework/core/class.ffThemeOptionsHolder.php');
		$this->_registerThemeFile('ffThemeOptions', '/framework/core/class.ffThemeOptions.php');


		$this->_registerThemeFile('ffComponent_Theme_OnePageOptions', '/framework/components/class.ffComponent_Theme_OnePageOptions.php');





		$this->_registerThemeFile('ffMetaBoxPortfolio', '/framework/adminScreens/metaBoxes/metaBoxPortfolio/class.ffMetaBoxPortfolio.php');
		$this->_registerThemeFile('ffMetaBoxPortfolioView', '/framework/adminScreens/metaBoxes/metaBoxPortfolio/class.ffMetaBoxPortfolioView.php');
		$this->_registerThemeFile('ffComponent_Theme_MetaboxPortfolio_CategoryView', '/framework/components/class.ffComponent_Theme_MetaboxPortfolio_CategoryView.php');

		$this->_registerThemeFile('ffMetaBoxPortfolioTitle', '/framework/adminScreens/metaBoxes/metaBoxPortfolioTitle/class.ffMetaBoxPortfolioTitle.php');
		$this->_registerThemeFile('ffMetaBoxPortfolioTitleView', '/framework/adminScreens/metaBoxes/metaBoxPortfolioTitle/class.ffMetaBoxPortfolioTitleView.php');
		$this->_registerThemeFile('ffComponent_Theme_MetaboxPortfolio_TitleView', '/framework/components/class.ffComponent_Theme_MetaboxPortfolio_TitleView.php');

		$this->_registerThemeFile('ffMetaBoxPortfolioSingle', '/framework/adminScreens/metaBoxes/metaBoxPortfolioSingle/class.ffMetaBoxPortfolioSingle.php');
		$this->_registerThemeFile('ffMetaBoxPortfolioSingleView', '/framework/adminScreens/metaBoxes/metaBoxPortfolioSingle/class.ffMetaBoxPortfolioSingleView.php');
		$this->_registerThemeFile('ffComponent_Theme_MetaboxPortfolio_SingleView', '/framework/components/class.ffComponent_Theme_MetaboxPortfolio_SingleView.php');

		$this->_registerThemeFile('ffMetaBoxPostSingle', '/framework/adminScreens/metaBoxes/metaBoxPostSingle/class.ffMetaBoxPostSingle.php');
		$this->_registerThemeFile('ffMetaBoxPostSingleView', '/framework/adminScreens/metaBoxes/metaBoxPostSingle/class.ffMetaBoxPostSingleView.php');
		$this->_registerThemeFile('ffComponent_Theme_SinglePost', '/framework/components/class.ffComponent_Theme_SinglePost.php');

        $this->_registerThemeFile('ffMetaBoxOnePage', '/framework/adminScreens/metaBoxes/metaBoxOnePage/class.ffMetaBoxOnePage.php');
        $this->_registerThemeFile('ffMetaBoxOnePageView', '/framework/adminScreens/metaBoxes/metaBoxOnePage/class.ffMetaBoxOnePageView.php');


        $this->_registerThemeFile('ffComponent_Theme_MetaboxPage_TitleView', '/framework/components/class.ffComponent_Theme_MetaboxPage_TitleView.php');
        $this->_registerThemeFile('ffMetaBoxPageTitle', '/framework/adminScreens/metaBoxes/metaBoxPageTitle/class.ffMetaBoxPageTitle.php');
        $this->_registerThemeFile('ffMetaBoxPageTitleView', '/framework/adminScreens/metaBoxes/metaBoxPageTitle/class.ffMetaBoxPageTitleView.php');



        $this->_registerThemeFile('ffComponent_Theme_LayoutOptions', '/framework/components/class.ffComponent_Theme_LayoutOptions.php');
        $this->_registerThemeFile('ffComponent_Theme_DefaultOptions', '/framework/components/class.ffComponent_Theme_DefaultOptions.php');




		$this->_registerThemeFile('ffThemeOptionsHolder', '/framework/core/class.ffThemeOptionsHolder.php');


		$this->_registerThemeFile('ffThemeOptions', '/framework/core/class.ffThemeOptions.php');

		$this->_registerThemeFile('ffThemeLayoutPreparator', '/framework/core/class.ffThemeLayoutPreparator.php');
		$this->getFrameworkContainer()->getClassLoader()->loadClass( 'ffThemeOptions' );


		$this->_registerThemeFile( 'ffWidgetLatestPosts', '/framework/components/widgets/latestPosts/class.ffWidgetLatestPosts.php');
		$this->_registerThemeFile( 'ffComponent_LatestPosts_OptionsHolder', '/framework/components/widgets/latestPosts/class.ffComponent_LatestPosts_OptionsHolder.php');
		$this->_registerThemeFile( 'ffComponent_LatestPosts_Printer', '/framework/components/widgets/latestPosts/class.ffComponent_LatestPosts_Printer.php');


        $this->_registerThemeFile( 'ffWidgetLatestPortfolio', '/framework/components/widgets/latestPortfolio/class.ffWidgetLatestPortfolio.php');
		$this->_registerThemeFile( 'ffComponent_LatestPortfolioWidget_OptionsHolder', '/framework/components/widgets/latestPortfolio/class.ffComponent_LatestPortfolioWidget_OptionsHolder.php');
		$this->_registerThemeFile( 'ffComponent_LatestPortfolioWidget_Printer', '/framework/components/widgets/latestPortfolio/class.ffComponent_LatestPortfolioWidget_Printer.php');



		$this->_registerThemeFile('freshizer', '/framework/core/freshizer.php');
		$this->getFrameworkContainer()->getClassLoader()->loadClass( 'freshizer' );


		$this->_registerThemeFile('ffWidgetLatestPosts', '/framework/widgets/class.ffWidgetLatestPosts.php');

		$this->_registerThemeFile('ffComponent_LatestPosts_OptionsHolder', '/framework/components/class.ffComponent_LatestPosts_OptionsHolder.php');
		$this->_registerThemeFile('ffComponent_OxygenLatestPosts_Printer', '/framework/components/class.ffComponent_OxygenLatestPosts_Printer.php');

		$this->_registerThemeFile('ffThemeAssetsIncluder', '/framework/theme/class.ffThemeAssetsIncluder.php');


        $this->_registerThemeFile('ffComponent_TwitterWidget_OptionsHolder', '/framework/components/widgets/twitter/class.ffComponent_TwitterWidget_OptionsHolder.php');
        $this->_registerThemeFile('ffComponent_TwitterWidget_Printer', '/framework/components/widgets/twitter/class.ffComponent_TwitterWidget_Printer.php');
        $this->_registerThemeFile('ffWidgetTwitter', '/framework/components/widgets/twitter/class.ffWidgetTwitter.php');

/**********************************************************************************************************************/
/* WIDGET - contact us
/**********************************************************************************************************************/
        $this->_registerThemeFile('ffComponent_ContactUsWidget_OptionsHolder', '/framework/components/widgets/contactUs/class.ffComponent_ContactUsWidget_OptionsHolder.php');
        $this->_registerThemeFile('ffComponent_ContactUsWidget_Printer', '/framework/components/widgets/contactUs/class.ffComponent_ContactUsWidget_Printer.php');
        $this->_registerThemeFile('ffWidgetContactUs', '/framework/components/widgets/contactUs/class.ffWidgetContactUs.php');

/**********************************************************************************************************************/
/* WIDGET - latest news
/**********************************************************************************************************************/
        $this->_registerThemeFile('ffComponent_LatestNewsWidget_OptionsHolder', '/framework/components/widgets/latestNews/class.ffComponent_LatestNewsWidget_OptionsHolder.php');
        $this->_registerThemeFile('ffComponent_LatestNewsWidget_Printer', '/framework/components/widgets/latestNews/class.ffComponent_LatestNewsWidget_Printer.php');
        $this->_registerThemeFile('ffWidgetLatestNews', '/framework/components/widgets/latestNews/class.ffWidgetLatestNews.php');


	}

	private $_themeLayoutPreparator = null;

	public function getThemeLayoutPreparator() {
		if( $this->_themeLayoutPreparator == null ) {
			$this->getFrameworkContainer()->getClassLoader()->loadClass('ffThemeLayoutPreparator');
			$this->_themeLayoutPreparator = new ffThemeLayoutPreparator( $this->getFrameworkContainer()->getWPLayer() );
		}

		return $this->_themeLayoutPreparator;
	}

}