<?php

class ffMetaBoxLayoutPlacementView extends ffMetaBoxView {

	protected function _requireAssets() {
		ffContainer::getInstance()->getScriptEnqueuer()->getFrameworkScriptLoader()->requireFfAdmin();

	}

	public function requireModalWindows() {

		ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryColor();
		ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryIcon();
		return;
	}

	protected function _render( $post ) {
        $layoutsDataManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutsDataManager();

        $collection = $layoutsDataManager->getLayoutCollection();

        $item = $collection->getLayoutById( $post->ID );

        $fwc = ffContainer::getInstance();

        $fwc->getWPLayer()->add_action('admin_footer', array($this,'requireModalWindows'), 1);
		$s = $fwc->getOptionsFactory()->createOptionsHolder('ffOptionsHolder_Layout_Placement')->getOptions();//createStructure('portfolio');

		$value = $item->getPlacement(); //$fwc->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade(ffThemeContainer::THEME_NAME_LOW.'-layouts', true)->getOptionCoded('placements');


		$printer = $fwc->getOptionsFactory()->createOptionsPrinterBoxed( $value, $s );
		$printer->setNameprefix('placement');
		$printer->walk();



	}


	protected function _save( $postId ) {





        return;
	}
}