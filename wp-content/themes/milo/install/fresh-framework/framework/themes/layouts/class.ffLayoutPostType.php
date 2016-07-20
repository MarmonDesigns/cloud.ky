<?php

/**
 * Class ffLayoutPostType
 * a.) handle registration of this custom post type
 * b.) hooks action of trash, untrash, delete and then handle these actions
 * c.) handle admin columns (on / off, placement and other)
 */
class ffLayoutPostType extends ffBasicObject {
    const POST_NAME_SUFFIX = 'ff-layout-';
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffPostTypeRegistratorManager
     */
    private $_postTypeRegistratorManager = null;

    /**
     * @var ffMetaBoxManager
     */
    private $_metaBoxManager = null;

    /**
     * @var ffLayoutsDataManager
     */
    private $_layoutsDataManager = null;

    /**
     * @var ffLayoutsEmojiManager
     */
    private $_layoutsEmojiManager = null;

    /**
     * @var ffPostAdminColumnManager
     */
    private $_postAdminColumnManager = null;

    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    /**
     * @var ffRequest
     */
    private $_Request = null;

    /**
     * @var ffScriptEnqueuer
     */
    private $_scriptEnqueuer = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_themeName = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct(
        ffMetaBoxManager $metaBoxManager,
        ffPostTypeRegistratorManager $postTypeRegistratorManager,
        ffLayoutsDataManager $layoutsDataManager,
        ffPostAdminColumnManager $postAdminColumnManager,
        ffWPLayer $WPLayer,
        ffScriptEnqueuer $scriptEnqueuer,
        ffRequest $request
    ) {

        $this->_setMetaBoxManager( $metaBoxManager );
        $this->_setPostTypeRegistratorManager( $postTypeRegistratorManager );
        $this->_setLayoutsDataManager( $layoutsDataManager );
        $this->_setPostAdminColumnManager($postAdminColumnManager );
        $this->_setWPLayer( $WPLayer );
        $this->_setScriptEnqueuer( $scriptEnqueuer );
        $this->_setRequest( $request );

    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function ajaxLayoutListing( ffAjaxRequest $ajaxRequest ) {
        $data = $ajaxRequest->data;

        $postId = $data['post-id'];
        $newActiveStatus = filter_var($data['active-change-to'], FILTER_VALIDATE_BOOLEAN);;


        $item = $this->_getLayoutsDataManager()->getLayoutCollection()->getLayoutById( $postId );

        $item->setActive($newActiveStatus );


        $this->_getLayoutsDataManager()->saveLayoutCollection();
    }

    public function registerPostType() {
        $this->_registerLayoutPostType();
        $this->_registerMetaBoxes();
        $this->_registerAdminColumns();
        $this->_hookImportantPostActions();

    }

/**********************************************************************************************************************/
/* ADMIN COLUMNS
/**********************************************************************************************************************/
    public function cbAdminColumnPriority( $postId ) {
        $item = $this->_getLayoutsDataManager()->getLayoutCollection()->getLayoutById( $postId );
        $placement = $item->getPlacement();

        if( isset( $placement['placement'] ) && isset( $placement['placement']['priority'] ) ) {
            echo $placement['placement']['priority'];
        }
    }

    public function cbAdminColumnPlacement( $postId ) {
        $item = $this->_getLayoutsDataManager()->getLayoutCollection()->getLayoutById( $postId );
        $placement = $item->getPlacement();

        if( isset( $placement['placement'] ) && isset( $placement['placement']['placement'] ) ) {
            echo ucfirst( str_replace('-', ' ', $placement['placement']['placement'] ) );
        }
    }

    public function cbAdminColumnDefault( $postId ) {
        $item = $this->_getLayoutsDataManager()->getLayoutCollection()->getLayoutById( $postId );
        $placement = $item->getPlacement();

        if( isset( $placement['placement'] ) && isset( $placement['placement']['default'] ) ) {
            $value =  $placement['placement']['default'];

            if( $value ) {
                echo 'Yes';
            } else {
                echo 'No';
            }
        }
    }

    public function cbAdminColumnActive( $postId ) {
        $item = $this->_getLayoutsDataManager()->getLayoutCollection()->getLayoutById( $postId );
        $active = $item->getActive();
//        var_dump( $active );
        echo '<div class="ff-layout-active-container">';
            echo '<div class="ff-layout-active-info" style="display: none;">';
                echo '<div class="post-id">' . $postId . '</div>';
            echo '</div>';

            echo '<div class="ff-layout-active-button">';
                if( $active ) {
                    echo '<div class="switch switch--on"></div>';
                } else {
                    echo '<div class="switch switch--off"></div>';
                }
            echo '</div>';
        echo '</div>';
    }

/**********************************************************************************************************************/
/* HOOKING POST ACTIONS
/**********************************************************************************************************************/
    private function _hookImportantPostActions() {
        $WPLayer = $this->_getWPLayer();


        if( !$WPLayer->is_ajax() && $WPLayer->is_admin() &&  ($this->_getRequest()->get( 'post_type' ) != $this->_getPostTypeName()) &&  ($this->_getRequest()->post( 'post_type' ) != $this->_getPostTypeName())  ) {
            $this->_deleteGhostLayouts();

        }

        $WPLayer->add_action( 'wp_trash_post', array( $this, 'actTrashPost' ),1,1 );
        $WPLayer->add_action( 'before_delete_post', array( $this, 'actDeletePost' ),1,1 );
        $WPLayer->add_action( 'untrash_post', array( $this, 'actUntrashPost' ),1,1 );

        $WPLayer->getHookManager()->addAjaxRequestOwner('ff-layout-ajax', array( $this, 'ajaxLayoutListing' ) );

        if( $this->_getRequest()->get('post_type') == $this->_getPostTypeName() ) {
            $this->_getScriptEnqueuer()->addScriptFramework('ff-layout-columns', '/framework/themes/layouts/assets/layout-columns.js');
            $this->_getScriptEnqueuer()->getFrameworkScriptLoader()->requireFrsLib();
            $this->_getScriptEnqueuer()->getFrameworkScriptLoader()->requireFfAdmin();
        }
    }

    private $_existingLayoutsId = false;

    private function _deleteGhostLayouts() {

        if( !$this->_getLayoutsDataManager()->doesLayoutCollectionExists() ) {
            return false;
        }

        $layouts = $this->_getWPLayer()->get_posts(array('post_status'=>'publish,trash', 'post_type' =>$this->_getPostTypeName(), 'posts_per_page'=>-1));

        $layoutsId = array();

        foreach( $layouts as $oneLayout ) {
            $layoutsId[] = $oneLayout->ID;
        }

        $this->_existingLayoutsId = $layoutsId;

        $this->_getLayoutsDataManager()->getLayoutCollection()->remove(array($this,'deleteGhostLayoutsCallback'));
        $this->_getLayoutsDataManager()->saveLayoutCollection();
    }

    public function deleteGhostLayoutsCallback( ffLayoutCollectionItem $layoutCollectionItem ) {
        if( $this->_existingLayoutsId == false ) {
            return false;
        }

        $currentLayoutId = $layoutCollectionItem->getId();

        $layoutExist =  in_array( $currentLayoutId, $this->_existingLayoutsId );

        if( !$layoutExist ) {
            return true;
        }
    }

    public function actTrashPost( $postId ) {
        $post = $this->_getWPLayer()->get_post($postId, ARRAY_A);

        if(  isset( $post['post_type']) && $post['post_type'] == $this->_getPostTypeName() ) {
            $layout  = $this->_layoutsDataManager->getLayoutCollection()->getLayoutById( $postId );
            $layout->setTrashed( true );

            $this->_layoutsDataManager->saveLayoutCollection();
        }
    }

    public function actUntrashPost( $postId ) {
        $post = $this->_getWPLayer()->get_post($postId, ARRAY_A);

        if(  isset( $post['post_type']) && $post['post_type'] == $this->_getPostTypeName() ) {
            $layout  = $this->_layoutsDataManager->getLayoutCollection()->getLayoutById( $postId );
            $layout->setTrashed( false );

            $this->_layoutsDataManager->saveLayoutCollection();
        }
    }

    public function actDeletePost( $postId ) {
        $post = $this->_getWPLayer()->get_post($postId, ARRAY_A);

        if(  isset( $post['post_type']) && $post['post_type'] == $this->_getPostTypeName() ) {
            $this->_layoutsDataManager->getLayoutCollection()->deleteLayoutById( $postId );
            $this->_layoutsDataManager->saveLayoutCollection();
        }

    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
    public function setThemeName( $themeName ) {

        $this->_themeName = $themeName;
    }

    public function getPostTypeName() {
        return $this->_getPostTypeName();
    }
/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _getPostTypeName() {
        $postTypeName = ffLayoutPostType::POST_NAME_SUFFIX . $this->_getThemeName();

        return $postTypeName;
    }
    private function _registerLayoutPostType() {
        $postTypeLayout = $this->_getPostTypeRegistratorManager()->addHiddenPostTypeRegistrator( $this->_getPostTypeName(), 'Layout' );

        $postTypeLayout->getSupports()
            ->set('editor', false)
            ->set('excerpt', false)
//            ->set('thumbnail', false)
            ->set('author', false)
            ->set('revisions', false )
            ;

        $postTypeLayout->getArgs()
            ->set('show_in_menu' , true )
            ->set('show_in_admin_bar' , true )
            ;
    }

    private function _registerAdminColumns() {
        $postTypeName = $this->_getPostTypeName();

        $postAdminColumnManager = $this->_getPostAdminColumnManager();

        $postAdminColumnManager->addColumnCallback($postTypeName, 'title', 'Active', 'ff-layout-active', array($this, 'cbAdminColumnActive')) ;
        $postAdminColumnManager->addColumnCallback($postTypeName, 'title', 'Placement', 'ff-layout-placement', array($this, 'cbAdminColumnPlacement')) ;
        $postAdminColumnManager->addColumnCallback($postTypeName, 'title', 'Priority', 'ff-layout-priority', array($this, 'cbAdminColumnPriority')) ;
        $postAdminColumnManager->addColumnCallback($postTypeName, 'title', 'Default', 'ff-layout-default', array($this, 'cbAdminColumnDefault')) ;
    }

    private function _registerMetaBoxes() {
        $metaBoxManager= $this->_getMetaBoxManager();

        $metaBoxManager->addMetaBoxClassName('ffMetaBoxLayoutContent');
        $metaBoxManager->addMetaBoxClassName('ffMetaBoxLayoutPlacement');
        $metaBoxManager->addMetaBoxClassName('ffMetaBoxLayoutConditions');
    }


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return null
     * @throws ffException
     */
    private function _getThemeName()
    {
        if( $this->_themeName == null ) {
            throw new ffException('ffLayoutPostType - variable THEME NAME is empty and has been used');
        }
        return $this->_themeName;
    }

    /**
     * @return ffPostTypeRegistratorManager
     */
    private function _getPostTypeRegistratorManager()
    {
        return $this->_postTypeRegistratorManager;
    }

    /**
     * @param ffPostTypeRegistratorManager $postTypeRegistratorManager
     */
    private function _setPostTypeRegistratorManager($postTypeRegistratorManager)
    {
        $this->_postTypeRegistratorManager = $postTypeRegistratorManager;
    }

    /**
     * @return ffMetaBoxManager
     */
    private function _getMetaBoxManager()
    {
        return $this->_metaBoxManager;
    }

    /**
     * @param ffMetaBoxManager $metaBoxManager
     */
    private function _setMetaBoxManager($metaBoxManager)
    {
        $this->_metaBoxManager = $metaBoxManager;
    }

    /**
     * @return ffLayoutsDataManager
     */
    private function _getLayoutsDataManager()
    {
        return $this->_layoutsDataManager;
    }

    /**
     * @param ffLayoutsDataManager $layoutsDataManager
     */
    private function _setLayoutsDataManager($layoutsDataManager)
    {
        $this->_layoutsDataManager = $layoutsDataManager;
    }

    /**
     * @return ffPostAdminColumnManager
     */
    private function _getPostAdminColumnManager()
    {
        return $this->_postAdminColumnManager;
    }

    /**
     * @param ffPostAdminColumnManager $postAdminColumnManager
     */
    private function _setPostAdminColumnManager($postAdminColumnManager)
    {
        $this->_postAdminColumnManager = $postAdminColumnManager;
    }

    /**
     * @return ffWPLayer
     */
    private function _getWPLayer()
    {
        return $this->_WPLayer;
    }

    /**
     * @param ffWPLayer $WPLayer
     */
    private function _setWPLayer($WPLayer)
    {
        $this->_WPLayer = $WPLayer;
    }

    /**
     * @return ffScriptEnqueuer
     */
    private function _getScriptEnqueuer()
    {
        return $this->_scriptEnqueuer;
    }

    /**
     * @param ffScriptEnqueuer $scriptEnqueuer
     */
    private function _setScriptEnqueuer($scriptEnqueuer)
    {
        $this->_scriptEnqueuer = $scriptEnqueuer;
    }

    /**
     * @return ffRequest
     */
    private function _getRequest()
    {
        return $this->_Request;
    }

    /**
     * @param ffRequest $Request
     */
    private function _setRequest($Request)
    {
        $this->_Request = $Request;
    }

    /**
     * @return ffLayoutsEmojiManager
     */
    private function _getLayoutsEmojiManager()
    {
        return $this->_layoutsEmojiManager;
    }

    /**
     * @param ffLayoutsEmojiManager $layoutsEmojiManager
     */
    private function _setLayoutsEmojiManager($layoutsEmojiManager)
    {
        $this->_layoutsEmojiManager = $layoutsEmojiManager;
    }



}