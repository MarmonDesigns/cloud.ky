<?php

class ffMetaBoxLayoutConditionsView extends ffMetaBoxView {
	
	protected function _requireAssets() {
		ffContainer::getInstance()->getScriptEnqueuer()->getFrameworkScriptLoader()->requireFfAdmin();
		
	/*	$pluginUrl = ffPluginFreshCustomCodeContainer::getInstance()->getPluginUrl();
		ffContainer::getInstance()->getScriptEnqueuer()->addScript('ff-custom-code-metabox-helper', $pluginUrl.'/assets/js/customCodeMetaboxHelper.js');
		ffContainer::getInstance()->getStyleEnqueuer()->addStyle('ff-custom-code-less', $pluginUrl.'/assets/css/customCode.less');*/
	}
	
	public function requireModalWindows() {
		ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryColor();
		ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryIcon();
		return;
	}
	
	protected function _render( $post ) {
        $fwc = ffContainer::getInstance();

        $fwc->getWPLayer()->add_action('admin_footer', array($this,'requireModalWindows'), 1);

        $options = $fwc->getOptionsFactory()->createOptionsHolder('ffOptionsHolder_Layout_Conditions')->getOptions();

        $layoutsDataManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutsDataManager();
        $collection = $layoutsDataManager->getLayoutCollection();
        $item = $collection->getLayoutById( $post->ID );
        $value = $item->getConditional();

		$printer = $fwc->getOptionsFactory()->createOptionsPrinterBoxed( $value, $options );
		$printer->setNameprefix('conditions');
		$printer->walk();
	}
 
	
	protected function _save( $postId ) {
        return;

        $fwc = ffContainer::getInstance();

        $layoutsDataManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutsDataManager();
        $collection = $layoutsDataManager->getLayoutCollection();
        $item = $collection->getLayoutById( $postId );

        $options = $fwc->getOptionsFactory()->createOptionsHolder('ffOptionsHolder_Layout_Conditions')->getOptions();
        $postReader = $fwc->getOptionsFactory()->createOptionsPostReader($options);

        $value = $postReader->getData('conditions');


        $item->setConditional( $value );

//        $layoutsDataManager->saveLayoutCollection();
	}
	
	
	
}