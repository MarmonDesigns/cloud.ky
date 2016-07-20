<?php

class ffOnePageRevisionManager extends ffBasicObject {

    CONST ONEPAGE_META_NAME = 'onepage';
    CONST REVISION_LIST_META_NAME = 'onepage_revision_list';
    CONST ONEPAGE_REVISION_META_NAME = 'onepage_revision_%';

/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffDataStorage_WPPostMetas_NamespaceFacade
     */
    private $_postMeta = null;


/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

    /**
     * Current post ID
     * @var int
     */
    private $_postId = null;

    /**
     * @var int
     */
    private $_allowedNumberOfRevisions = 5;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct() {
        $this->_setPostMeta( ffContainer()->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade() );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function addNewRevision( $revision ) {
        $newRevisionNumber = $this->_getNewRevisionNumber();
        $this->_insertNewRevision( $revision, $newRevisionNumber );
        $this->_deleteOldRevisions();
    }

    public function setRevisionAsContent( $revisionNumber ) {
        $revisionContent = $this->getRevisionContent( $revisionNumber );
        $this->_setMainContent( $revisionContent );

        $revisionList = $this->getRevisionList();
        $revisionList['current_revision'] = $revisionNumber;
        $this->_setRevisionList( $revisionList );
    }

    public function getRevisionContent( $revisionNumber ) {
        $postMetaName = $this->_getNewRevisionName( $revisionNumber );
        return $this->_getPostMeta()->getOption( $postMetaName );
    }


    public function getRevisionList() {
        $revisionListMetaName = ffOnePageRevisionManager::REVISION_LIST_META_NAME;

        $revisionList = $this->_getPostMeta()->getOption( $revisionListMetaName );

        if( empty( $revisionList ) ) {
            $revisionList = $this->_createRevisionList();
        }

        return $revisionList;
    }

    public function getCurrentRevisionNumber() {
        $revisionList = $this->getRevisionList();

        return $revisionList['current_revision'];
    }

    public function getListOfRevisionsForCurrentPost() {
        $revisionList = $this->getRevisionList();

        $revisionInfo = $revisionList['revision_info'];

        krsort( $revisionInfo );

        foreach( $revisionInfo as $revisionNumber => $data ) {
            $humanTime = date('M j,Y \a\t i:G:s', $data['timestamp']);
            $revisionInfo[ $revisionNumber ]['human_time'] = $humanTime;
        }

        return $revisionInfo;
    }


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
    public function setPostId( $postId ) {
        return $this->_setPostId( $postId );
    }


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _setMainContent( $content ) {
        $mainContentName = ffOnePageRevisionManager::ONEPAGE_META_NAME;
        $this->_getPostMeta()->setOption( $mainContentName, $content );
    }


    private function _deleteOldRevisions() {
        $revisionList = $this->getRevisionList();

        $lastRevisionNumber = $revisionList['last_revision_number'];
        $smallestRevisionNumber = $lastRevisionNumber - $this->_getAllowedNumberOfRevisions();

        foreach( $revisionList['revision_info'] as $revisionNumber => $info ) {
            if( $revisionNumber <= $smallestRevisionNumber ) {
                $this->_deleteRevisionByNumber( $revisionNumber );
                unset( $revisionList['revision_info'][ $revisionNumber ] );
            }
        }

        $this->_setRevisionList( $revisionList );
    }

    private function _deleteRevisionByNumber( $revisionNumber ) {
        $metaName = $this->_getNewRevisionName( $revisionNumber );
        $this->_getPostMeta()->deleteOption( $metaName );
    }


    private function _insertNewRevision( $revision, $revisionNumber ) {
        $postMetaName = $this->_getNewRevisionName( $revisionNumber );
        $this->_getPostMeta()->setOption( $postMetaName, $revision );

        $revisionList = $this->getRevisionList();

        $revisionList['last_revision_number'] = $revisionNumber;
        $revisionList['current_revision'] = $revisionNumber;

        $revisionInfo = array();
        $revisionInfo['number'] = $revisionNumber;
        $revisionInfo['timestamp'] = time();

        $revisionList['revision_info'][ $revisionNumber ] = $revisionInfo;


        $this->_setRevisionList( $revisionList );
    }

    private function _setRevisionList( $revisionList ) {
        $this->_getPostMeta()->setOption( ffOnePageRevisionManager::REVISION_LIST_META_NAME, $revisionList );
    }

    private function _getNewRevisionNumber() {
        $revisionList = $this->getRevisionList();
        $lastRevisionNumber = $revisionList['last_revision_number'];
        $newRevisionNumber = $lastRevisionNumber + 1;
        return $newRevisionNumber;
    }

    private function _createRevisionList() {
        $revisionList = array();
        $revisionList['last_revision_number'] = 0;
        $revisionList['current_revision'] = 0;
        $revisionList['revision_info'] = array();

        return $revisionList;
    }
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    private function _getNewRevisionName( $revisionNumber ) {
        return str_replace('%', $revisionNumber, ffOnePageRevisionManager::ONEPAGE_REVISION_META_NAME);
    }

    /**
     * @return int
     */
    private function _getPostId()
    {
        return $this->_postId;
    }

    /**
     * @param int $postId
     */
    private function _setPostId($postId)
    {
        $this->_postId = $postId;
        $this->_getPostMeta()->setNamespace( $postId );
    }


    /**
     * @return ffDataStorage_WPPostMetas_NamespaceFacade
     */
    private function _getPostMeta()
    {
        return $this->_postMeta;
    }

    /**
     * @param ffDataStorage_WPPostMetas_NamespaceFacade $postMeta
     */
    private function _setPostMeta($postMeta)
    {
        $this->_postMeta = $postMeta;
    }

    /**
     * @return int
     */
    private function _getAllowedNumberOfRevisions()
    {
        return $this->_allowedNumberOfRevisions;
    }

    /**
     * @param int $allowedNumberOfRevisions
     */
    private function _setAllowedNumberOfRevisions($allowedNumberOfRevisions)
    {
        $this->_allowedNumberOfRevisions = $allowedNumberOfRevisions;
    }


}