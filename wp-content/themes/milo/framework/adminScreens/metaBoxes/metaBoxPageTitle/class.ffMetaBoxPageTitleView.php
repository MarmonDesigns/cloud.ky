<?php

class ffMetaBoxPageTitleView extends ffMetaBoxView {


    protected function _requireAssets() {
        ffContainer::getInstance()->getScriptEnqueuer()->getFrameworkScriptLoader()->requireFfAdmin();
    }


    public function requireModalWindows() {
    }


    protected function _render( $post ) {

        ffContainer::getInstance()->getWPLayer()->add_action('admin_footer', array($this,'requireModalWindows'), 1);

        $fwc = ffContainer::getInstance();

        $s = $fwc->getOptionsFactory()->createOptionsHolder('ffComponent_Theme_MetaboxPage_TitleView')->getOptions();


        $value = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade(  $post->ID )->getOption('page_title');
        $value = unserialize( base64_decode( $value ));

        $printer = $fwc->getOptionsFactory()->createOptionsPrinterBoxed( $value, $s );
        $printer->setNameprefix('page_title');
        $printer->walk();


    }


    protected function _save( $postId ) {


        $fwc = ffContainer::getInstance();
        $saver = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade( $postId );

        $s = $fwc->getOptionsFactory()->createOptionsHolder('ffComponent_Theme_MetaboxPage_TitleView')->getOptions();
        $postReader = $fwc->getOptionsFactory()->createOptionsPostReader($s);
        $value = $postReader->getData('page_title');

        $valueNew = base64_encode(( serialize( $value ) ) );

        $saver->setOption( 'page_title' , $valueNew );
    }
}

