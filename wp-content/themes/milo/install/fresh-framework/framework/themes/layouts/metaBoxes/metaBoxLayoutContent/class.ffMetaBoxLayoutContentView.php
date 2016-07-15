<?php

class ffMetaBoxLayoutContentView extends ffMetaBoxView {
	
	protected function _requireAssets() {
        $fwc = ffContainer();

        $fwc->getScriptEnqueuer()->getFrameworkScriptLoader()->requireFfAdmin()->requireFrsLibOptions()->requireSelect2();
        $fwc->getScriptEnqueuer()->addScriptFramework('ff-layout-saving', '/framework/themes/layouts/metaBoxes/assets/ff-layout-saving-manager.js', null, '2');
	}

	public function requireModalWindows() {
		ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryColor();
		ffContainer::getInstance()->getModalWindowFactory()->printModalWindowManagerLibraryIcon();
		return;
	}

    protected function _render( $post ) {
        $fwc = ffContainer();

        $fwc->getWPLayer()->add_action('admin_footer', array($this,'requireModalWindows'), 1);
        $fwc->getOptionsFactory()->createOptionsPrinterDataboxGenerator()->printAll();

        echo '<div class="ff-repeatable-spinner"></div>';
        echo '<div class="ff-post-id-holder" style="display:none;">'.$post->ID.'</div>';
    }

	protected function _ajaxRender( $postId ) {
        $fwc = ffContainer();

        $layoutsDataManager = $fwc->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutsDataManager();
        $collection = $layoutsDataManager->getLayoutCollection();
        $item = $collection->getLayoutById( $postId);

        $layoutsOptionsHolderClassName = $fwc->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getThemeLayoutManager()->getLayoutsOptionsHolderClassName();

        $options = $fwc->getOptionsFactory()->createOptionsHolder( $layoutsOptionsHolderClassName )->getOptions();
        $value = $item->getData();

        $printer = $fwc->getOptionsFactory()->createOptionsPrinterJavascriptConvertor( $value, $options );
		$printer->setNameprefix('onepage');
		echo $printer->walk();

        echo '<div class="ff-revision-list-content">';
            $this->_printRevisionList( $postId );
        echo '</div>';
        echo '<div class="ff-post-id-holder" style="display:none;">'.$postId.'</div>';
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

//
//                    Revision 93 (2015-10-10 at 15:05:05) Current
//                    Revision 92 (2015-10-10 at 15:05:05) Rollback
//                    Revision 91 (2015-10-10 at 15:05:05) Rollback
//                    Revision 90 (2015-10-10 at 15:05:05) Rollback
//                    Revision 89 (2015-10-10 at 15:05:05) Rollback

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

    public function ajaxRequest( ffAjaxRequest $ajaxRequest ) {
        if( $ajaxRequest->data['action'] == 'save' ) {
            $this->_ajaxSave( $ajaxRequest );
        } else if ( $ajaxRequest->data['action'] == 'getOptions' ) {
            $this->_ajaxRender( $ajaxRequest->data['postId'] );
        } else if( $ajaxRequest->data['action'] == 'rollbackToRevision' ) {

            $postId = $ajaxRequest->data['postId'];
            $revisionNumber = $ajaxRequest->data['revisionNumber'];

            $revisionManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getOnePageRevisionManager();
            $revisionManager->setPostId( $postId );
            $revisionManager->setRevisionAsContent( $revisionNumber);

            $revision = $revisionManager->getRevisionContent( $revisionNumber );
            $revision = base64_decode( $revision );
            $revision = unserialize( $revision );

            $layoutsDataManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutsDataManager();
            $collection = $layoutsDataManager->getLayoutCollection();
            $item = $collection->getLayoutById( $postId );
            $item->setData( $revision);
            $layoutsDataManager->saveLayoutCollection();


            $this->_ajaxRender( $ajaxRequest->data['postId'] );

        }
	}

    protected function _ajaxSave( ffAjaxRequest $ajaxRequest ) {
         $contentFormParsed = null;
        $conditionsFormParsed = null;
        $placementFormParsed = null;

        $contentForm = $ajaxRequest->data['serialisedContent'];
        $conditionsForm = $ajaxRequest->data['serialisedConditions'];
        $placementForm = $ajaxRequest->data['serialisedPlacement'];
        $postId = $ajaxRequest->data['postId'];

        parse_str( $contentForm, $contentFormParsed);
        parse_str( $conditionsForm, $conditionsFormParsed);
        parse_str( $placementForm, $placementFormParsed);



        $fwc = ffContainer::getInstance();

        $layoutsOptionsHolderClassName = $fwc->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getThemeLayoutManager()->getLayoutsOptionsHolderClassName();


        $s = $fwc->getOptionsFactory()->createOptionsHolder($layoutsOptionsHolderClassName)->getOptions();
		$postReader = $fwc->getOptionsFactory()->createOptionsPostReader($s);
		$onepage = $postReader->getDataFromArray($contentFormParsed['onepage']); //$fwc->getOptionsFactory()->createOptionsPostReader()->getData( 'onepage');


        $revisionValue = $onepage;
        $revisionValue = stripslashes_deep( $revisionValue );

        $revisionValue = base64_encode(( serialize( $revisionValue ) ) );

        $revisionManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getOnePageRevisionManager();
        $revisionManager->setPostId( $postId );
        $revisionManager->addNewRevision( $revisionValue );

        $this->_printRevisionList( $postId );




        $layoutsDataManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutsDataManager();
        $collection = $layoutsDataManager->getLayoutCollection();
        $item = $collection->getLayoutById( $postId );



        $item->setData( $onepage );

		$s = $fwc->getOptionsFactory()->createOptionsHolder('ffOptionsHolder_Layout_Placement')->getOptions();
		$postReader = $fwc->getOptionsFactory()->createOptionsPostReader($s);
		$placement = $postReader->getDataFromArray($placementFormParsed['placement']);//$fwc->getOptionsFactory()->createOptionsPostReader()->getData( 'onepage');

        $item->setPlacement( $placement );



        $options = $fwc->getOptionsFactory()->createOptionsHolder('ffOptionsHolder_Layout_Conditions')->getOptions();
        $postReader = $fwc->getOptionsFactory()->createOptionsPostReader($options);

        $conditions = $postReader->getDataFromArray($conditionsFormParsed['conditions']);

        $item->setConditional( $conditions );


        $layoutsDataManager->saveLayoutCollection();
    }

	protected function _save( $postId ) {
        // test if the options has been processed via javascript
		if( !isset($_POST['has-been-normalized']) ) {
			return false;
		}

		$fwc = ffContainer::getInstance();

        $layoutsOptionsHolderClassName = $fwc->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getThemeLayoutManager()->getLayoutsOptionsHolderClassName();


		$s = $fwc->getOptionsFactory()->createOptionsHolder($layoutsOptionsHolderClassName)->getOptions();
		$postReader = $fwc->getOptionsFactory()->createOptionsPostReader($s);
		$value = $postReader->getData('onepage');//$fwc->getOptionsFactory()->createOptionsPostReader()->getData( 'onepage');

        $revisionValue = $value;
        $revisionValue = stripslashes_deep( $revisionValue );

        $revisionValue = base64_encode(( serialize( $revisionValue ) ) );

        $revisionManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getOnePageRevisionManager();
        $revisionManager->setPostId( $postId );
        $revisionManager->addNewRevision( $revisionValue );


        $layoutsDataManager = ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutsDataManager();
        $collection = $layoutsDataManager->getLayoutCollection();
        $item = $collection->getLayoutById( $postId );

        $item->setData( $value );

		$s = $fwc->getOptionsFactory()->createOptionsHolder('ffOptionsHolder_Layout_Placement')->getOptions();
		$postReader = $fwc->getOptionsFactory()->createOptionsPostReader($s);
		$value = $postReader->getData('placement');//$fwc->getOptionsFactory()->createOptionsPostReader()->getData( 'onepage');

        $item->setPlacement( $value );


        $options = $fwc->getOptionsFactory()->createOptionsHolder('ffOptionsHolder_Layout_Conditions')->getOptions();
        $postReader = $fwc->getOptionsFactory()->createOptionsPostReader($options);

        $value = $postReader->getData('conditions');

        $item->setConditional( $value );

        $layoutsDataManager->saveLayoutCollection();



	}
}