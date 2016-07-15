<?php

class ffMetaBoxPortfolioTitleView extends ffMetaBoxView {

    protected function _requireAssets() {
        ffContainer::getInstance()->getScriptEnqueuer()->getFrameworkScriptLoader()->requireFfAdmin();
    }

    public function requireModalWindows() {
        ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryColor();
        ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryIcon();
    }

    protected function _render( $post ) {
        $fwc = ffContainer::getInstance();

        $s = $fwc->getOptionsFactory()->createOptionsHolder('ffComponent_Theme_MetaboxPortfolio_TitleView')->getOptions();

        $value = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade(  $post->ID )->getOption('portfolio_title_options');

        $printer = $fwc->getOptionsFactory()->createOptionsPrinterBoxed( $value, $s );
        $printer->setNameprefix('portfolio_title_options');
        $printer->walk();


    }


    protected function _save( $postId ) {
        if( !isset($_POST['has-been-normalized']) ) {
            return false;
        }

        $fwc = ffContainer::getInstance();
        $saver = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade( $postId );

        $value = $fwc->getOptionsFactory()->createOptionsPostReader()->getData( 'portfolio_title_options');

        $saver->setOption( 'portfolio_title_options' , $value );

    }
}