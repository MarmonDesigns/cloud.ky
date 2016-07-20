<?php

class ffFrontendQueryIdentificator extends ffBasicObject {

/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

    /**
     * @var WP_Query
     */
    private $_query = null;

    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

    private $_currentType = null;

    private $_currentInfo = null;

    private $_queryHasBeenParsed = false;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffWPLayer $WPLayer ) {
        $this->_setWPLayer( $WPLayer );

        if( $this->_getWPLayer()->action_been_executed('wp') ) {
            $this->actionWP();
        } else {
            $this->_getWPLayer()->add_action('wp',array($this, 'actWp'));
        }
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

    public function getQueryType() {
        $this->_validateQueryCall();

        return $this->_getCurrentType();
    }

    public function getQueryInformations() {
        $this->_validateQueryCall();

        return $this->_getCurrentInfo();
    }

    public function actionWP() {
        $this->parseQuery();
    }

    public function parseQuery() {
        $query = $this->_getQueryToParse();

        if( $query->is_home() ) {

            $this->_identifyHome();

        } else if( $query->is_singular() ) {

            $this->_identifySingular();

        } else if( $query->is_category() || $query->is_tag() || $query-> is_tax() ) {

            $this->_identifyTaxonomy();

        } else if( $query->is_search() ) {

            $this->_identifySearch();

        } else if( $query->is_date() || is_time() ) {

            $this->_identifyDate();

        } else if( $query->is_author() ) {

            $this->_identifyAuthor();

        } else if( $query->is_404() ) {
            $this->_identify404();
        }

    }

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _validateQueryCall() {
        if( $this->_getWPLayer()->action_been_executed('wp') == false ) {
            throw new ffException('Bad Order Call - called ffFrontendQueryIdentificator before the action WP!');
        }
    }

    private function _identify404() {
        $this->_setCurrentType(ffConstQuery::NOT_FOUND_404 );

        $currentInfo = $this->_getCurrentInfo();

        $currentInfo->name = '404';
        $currentInfo->type = '404';
        $currentInfo->query = '404';

        $this->_setCurrentInfo( $currentInfo );
    }

    /**
     * It's homepage, so fill it with blog name and site url
     */
    private function _identifyHome() {
        $this->_setCurrentType(ffConstQuery::HOME);

        $currentInfo = $this->_getCurrentInfo();

        $currentInfo->name = $this->_getWPLayer()->get_blog_name();
        $currentInfo->url = $this->_getWPLayer()->get_site_url();
        $currentInfo->type = 'Home';
        $currentInfo->query = ffConstQuery::HOME;

        $this->_setCurrentInfo( $currentInfo );
    }

    /**
     * Identify singular post
     */
    private function _identifySingular() {
        $currentInfo = $this->_getCurrentInfo();
        $currentPost = $this->_getWPLayer()->get_current_post();

        $this->_setCurrentType( ffConstQuery::SINGULAR );

        $currentInfo->name = $currentPost->post_title;
        $currentInfo->id = $currentPost->ID;
        $currentInfo->post_type = $currentPost->post_type;
        $currentInfo->query = ffConstQuery::SINGULAR;
    }

    /**
     * Identify Taxonomy
     */
    private function _identifyTaxonomy() {
        $this->_setCurrentType( ffConstQuery::TAXONOMY );
        $currentInfo = $this->_getCurrentInfo();
        $query = $this->_getQueryToParse();

        if( $query->is_category() ) {

            $currentInfo->name = $query->query_vars['category_name'];
            $currentInfo->id = $query->query_vars['cat'];
            $currentInfo->taxonomy_type = 'category';

        } else if( $query->is_tag) {

            $currentInfo->name = $query->query_vars['tag'];
            $currentInfo->id = $query->query_vars['tag_id'];
            $currentInfo->taxonomy_type = 'post_tag';

        } else if( $query->is_tax ) {

            $currentInfo->name = $query->query_vars['term'];
            $currentInfo->id = $this->_getWPLayer()->get_queried_object_id();
            $currentInfo->taxonomy_type = $query->query_vars['taxonomy'];

        }

        $currentInfo->query = ffConstQuery::TAXONOMY;

    }

    private function _identifySearch() {
        $this->_setCurrentType( ffConstQuery::SEARCH );
        $currentInfo = $this->_getCurrentInfo();

        $currentInfo->name = $this->_getWPLayer()->get_search_query();
        $currentInfo->id = null;
        $currentInfo->query = ffConstQuery::SEARCH;
    }

    private function _identifyDate() {
        $this->_setCurrentType( ffConstQuery::DATE );
        $currentInfo = $this->_getCurrentInfo();
        $query = $this->_getQueryToParse();

        if( $query->is_year() ) {
            $currentInfo->name = $this->_getWPLayer()->get_the_date('Y');
            $currentInfo->id = null;
            $currentInfo->date_type = ffConstQuery::DATE_YEAR;
        } else if( $query->is_month() ) {
            $currentInfo->name = $this->_getWPLayer()->get_the_date('m');
            $currentInfo->id = null;
            $currentInfo->date_type = ffConstQuery::DATE_MONTH;
        } else if( $query->is_day() ) {
            $currentInfo->name = $this->_getWPLayer()->get_the_date('d');
            $currentInfo->id = null;
            $currentInfo->date_type = ffConstQuery::DATE_DAY;
        } else if( $query->is_time() ) {
            $currentInfo->name = $this->_getWPLayer()->get_the_date('G i s');
            $currentInfo->id = null;
            $currentInfo->date_type = ffConstQuery::DATE_TIME;
        }
        // TODO TIME
        $currentInfo->query = ffConstQuery::DATE;

    }

    private function _identifyAuthor() {
        $this->_setCurrentType( ffConstQuery::AUTHOR );
        $currentInfo = $this->_getCurrentInfo();

        $authorData = $this->_getWPLayer()->get_author_data();

        $currentInfo->name = $this->_getWPLayer()->get_the_author();
        $currentInfo->id = $authorData->ID;
        $currentInfo->type = 'author';
        $currentInfo->query = ffConstQuery::AUTHOR;

    }


    /**
     * If there is set query from outer space, use it, otherwise use WP_Query
     * @return WP_Query
     */
    private function _getQueryToParse() {
        return $this->_getWPLayer()->get_wp_query();
    }

/**********************************************************************************************************************/
/* GETTERS & SETTERS
/**********************************************************************************************************************/
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
     * @return null
     */
    private function _getCurrentInfo()
    {
        if( $this->_currentInfo == null ) {
            $this->_currentInfo = new stdClass();
        }
        return $this->_currentInfo;
    }

    /**
     * @param null $currentInfo
     */
    private function _setCurrentInfo($currentInfo)
    {
        $this->_currentInfo = $currentInfo;
    }

    /**
     * @return null
     */
    private function _getCurrentType()
    {
        return $this->_currentType;
    }

    /**
     * @param null $currentType
     */
    private function _setCurrentType($currentType)
    {
        $this->_currentType = $currentType;
    }

    /**
     * @return boolean
     */
    private function _isQueryHasBeenParsed()
    {
        return $this->_queryHasBeenParsed;
    }

    /**
     * @param boolean $queryHasBeenParsed
     */
    private function _setQueryHasBeenParsed($queryHasBeenParsed)
    {
        $this->_queryHasBeenParsed = $queryHasBeenParsed;
    }


}