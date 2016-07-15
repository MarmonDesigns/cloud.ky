<?php

class ffMetaBoxPortfolioView extends ffMetaBoxView {

	protected function _requireAssets() {
		ffContainer::getInstance()->getScriptEnqueuer()->getFrameworkScriptLoader()->requireFfAdmin();
	}

	public function requireModalWindows() {
		ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryIcon();
	}

	protected function _render( $post ) {
		$fwc = ffContainer::getInstance();

		ffContainer::getInstance()->getWPLayer()->add_action('admin_footer', array($this,'requireModalWindows'), 1);

		$s = $fwc->getOptionsFactory()->createOptionsHolder('ffComponent_Theme_MetaboxPortfolio_CategoryView')->getOptions();//createStructure('portfolio');

		$value = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade(  $post->ID )->getOption('portfolio_category_options');

		$printer = $fwc->getOptionsFactory()->createOptionsPrinterBoxed( $value, $s );
		$printer->setNameprefix('portfolio_category_options');
		$printer->walk();

	}


	protected function _save( $postId ) {
		if( !isset($_POST['has-been-normalized']) ) {
			return false;
		}

		$fwc = ffContainer::getInstance();
		$saver = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade( $postId );

		$value = $fwc->getOptionsFactory()->createOptionsPostReader()->getData( 'portfolio_category_options');

		$saver->setOption( 'portfolio_category_options' , $value );
	}
}