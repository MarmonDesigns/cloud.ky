<?php

class ffMetaBoxOnePageView extends ffMetaBoxView {

	protected function _requireAssets() {
		ffContainer::getInstance()->getScriptEnqueuer()->getFrameworkScriptLoader()->requireFfAdmin()->requireFrsLibOptions();

		ffContainer::getInstance()->getScriptEnqueuer()->addScriptTheme('ff-onepage', '/framework/adminScreens/metaBoxes/metaBoxOnePage/onePage.js');

	/*	$pluginUrl = ffPluginFreshCustomCodeContainer::getInstance()->getPluginUrl();
		ffContainer::getInstance()->getScriptEnqueuer()->addScript('ff-custom-code-metabox-helper', $pluginUrl.'/assets/js/customCodeMetaboxHelper.js');
		ffContainer::getInstance()->getStyleEnqueuer()->addStyle('ff-custom-code-less', $pluginUrl.'/assets/css/customCode.less');*/
	}

	public function requireModalWindows() {
		ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryColor();
		ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryIcon();

	}


	public function ajaxRequest( ffAjaxRequest $ajaxRequest ) {

        if( isset($ajaxRequest->data['action']) && $ajaxRequest->data['action'] == 'getOptions' ) {
            $this->_renderOptionsAjax( $ajaxRequest->data['postId'] );
        } else if( isset($ajaxRequest->data['action']) && $ajaxRequest->data['action'] == 'setRevision' ) {


            $postId = $ajaxRequest->data['postId'];

            $revisionNumber = $ajaxRequest->data['revisionNumber'];


            $revisionManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getOnePageRevisionManager();
            $revisionManager->setPostId( $postId );
            $revisionManager->setRevisionAsContent( $revisionNumber);

            $this->_renderOptionsAjax( $ajaxRequest->data['postId'] );

        } else {

            $params = array();
            $postId = $ajaxRequest->data['postId'];
            parse_str( $ajaxRequest->data['serialised'], $params);
            if( !isset($params['has-been-normalized']) ) {
                return false;
            }

            $fwc = ffContainer::getInstance();
            $saver = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade( $postId );

            $postReader = $fwc->getOptionsFactory()->createOptionsPostReader();
            $s = $fwc->getOptionsFactory()->createOptionsHolder('ffComponent_Theme_OnePageOptions')->getOptions();

            $postReader->setOptionsStructure($s);
            $value = $postReader->getDataFromArray( $params );

            $value = $value['onepage'];
            $value = stripslashes_deep( $value );

            $valueNew = base64_encode(( serialize( $value ) ) );

            $saver->setOption( 'onepage' , $valueNew );

            $revisionManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getOnePageRevisionManager();
            $revisionManager->setPostId( $postId );
            $revisionManager->addNewRevision( $valueNew );

            $this->_printRevisionList( $postId );

        }
	}

    protected function _render( $post ) {
		ffContainer::getInstance()->getWPLayer()->add_action('admin_footer', array($this,'requireModalWindows'), 1);

		$fwc = ffContainer::getInstance();

		$s = $fwc->getOptionsFactory()->createOptionsHolder('ffComponent_Theme_DefaultOptions')->getOptions();//createStructure('portfolio');

//		$value = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade(  $post->ID )->getOption('onepage');
//		$value = unserialize( base64_decode( $value ));
		$printer = $fwc->getOptionsFactory()->createOptionsPrinterJavascriptConvertor( null, $s );
		$printer->setNameprefix('onepage');

        $printer->walk();

        echo '<div class="ff-post-id-holder" style="display:none;">'.  $post->ID.'</div>';

//        $revisionManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getOnePageRevisionManager();
//        $revisionManager->setPostId( $post->ID );
//        $revisionManager->setRevisionAsContent(1);
    }

	protected function _renderOptionsAjax( $postId  ) {
		ffContainer::getInstance()->getWPLayer()->add_action('admin_footer', array($this,'requireModalWindows'), 1);

		$fwc = ffContainer::getInstance();

		$s = $fwc->getOptionsFactory()->createOptionsHolder('ffComponent_Theme_OnePageOptions')->getOptions();//createStructure('portfolio');

		$value = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade(  $postId )->getOption('onepage');
		$value = unserialize( base64_decode( $value ));
		$printer = $fwc->getOptionsFactory()->createOptionsPrinterJavascriptConvertor( $value, $s );
		$printer->setNameprefix('onepage');
        echo '<br>';
		echo  $printer->walk();
        echo '<br>';
		echo '<input type="submit" style="display:none;" class="ff-onepage-save-ajax button-primary" value="Save All Sections">';
		echo '<div class="ff-post-id" style="display:none;">'.  $postId .'</div>';

		echo "\n\n".'<script>jQuery(window).load(function(){ jQuery(".ff-default-wp-color-picker").wpColorPicker();});</script>';

        echo '<div class="ff-post-id-holder" style="display:none;">'.  $postId.'</div>';

        echo '<div class="ff-revision-list-content">';
            $this->_printRevisionList( $postId );
        echo '</div>';

    }

    protected function _printRevisionList( $postId ) {

        $revisionManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getOnePageRevisionManager();
        $revisionManager->setPostId( $postId );

        $currentRevisionNumber = $revisionManager->getCurrentRevisionNumber();
        echo '<div class="ff-revision-list">';
            echo '<h4 style="margin-bottom:0;">Revisions</h4>';
            echo '<ul style="margin-top:4px">';

                foreach( $revisionManager->getListOfRevisionsForCurrentPost() as $revisionNumber => $oneRevision ) {

                    $revisionNumberText = $revisionNumber;
                    if( $revisionNumber == $currentRevisionNumber ) {
                        $revisionNumberText = 'current';
                    }


                    echo '<li>';
                        echo 'Revision ' . $oneRevision['number'] . ' (' . $oneRevision['human_time'].') ';


                        if( $revisionNumber == $currentRevisionNumber ) {
                            echo 'Current';
                        } else {
                            echo '<a href="" class="ff-revision-switch" data-revision-number="'.$revisionNumberText.'">';
                                echo 'Rollback';
                            echo '</a>';
                        }
                    echo '</li>';
                }

            echo '</ul>';

        echo '</div>';
    }


	protected function _save( $postId ) {

		if( !isset($_POST['has-been-normalized']) ) {
			return false;
		}

		$fwc = ffContainer::getInstance();
		$saver = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade( $postId );
		$s = $fwc->getOptionsFactory()->createOptionsHolder('ffComponent_Theme_OnePageOptions')->getOptions();//createStructure('portfolio');

		$postReader = $fwc->getOptionsFactory()->createOptionsPostReader();
		$postReader->setOptionsStructure($s);
		$value = $fwc->getOptionsFactory()->createOptionsPostReader()->getData( 'onepage');

		$valueNew = base64_encode(( serialize( $value ) ) );

		$saver->setOption( 'onepage' , $valueNew );

        $revisionManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getOnePageRevisionManager();
        $revisionManager->setPostId( $postId );
        $revisionManager->addNewRevision( $valueNew );

	}
}