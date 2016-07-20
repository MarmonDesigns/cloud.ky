<?php

class ffMetaBoxPostSingleView extends ffMetaBoxView {

    protected function _requireAssets() {

        ffContainer::getInstance()->getScriptEnqueuer()->getFrameworkScriptLoader()->requireFfAdmin();
    }

    public function requireModalWindows() {
        ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryIcon();
        return;
    }

    protected function _render( $post ) {

        ffContainer::getInstance()->getWPLayer()->add_action('admin_footer', array($this,'requireModalWindows'), 1);

        $fwc = ffContainer::getInstance();

        $s = $fwc->getOptionsFactory()->createOptionsHolder('ffComponent_Theme_SinglePost')->getOptions();//createStructure('portfolio');


        $value = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade(  $post->ID )->getOption('single-post');
        $value = unserialize( base64_decode( $value ));

        $printer = $fwc->getOptionsFactory()->createOptionsPrinterBoxed( $value, $s );
        $printer->setNameprefix('single-post');
        $printer->walk();


    }


    protected function _save( $postId ) {


        $fwc = ffContainer::getInstance();
        $saver = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade( $postId );

        $s = $fwc->getOptionsFactory()->createOptionsHolder('ffComponent_Theme_SinglePost')->getOptions();
        $postReader = $fwc->getOptionsFactory()->createOptionsPostReader($s);
        $value = $postReader->getData('single-post');//$fwc->getOptionsFactory()->createOptionsPostReader()->getData( 'onepage');


        $valueNew = base64_encode(( serialize( $value ) ) );



        $saver->setOption( 'single-post' , $valueNew );

    }
}