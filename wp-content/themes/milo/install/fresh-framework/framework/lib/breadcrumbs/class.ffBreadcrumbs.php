<?php

/**
 * Class ffBreadcrumbs
 * Computes breadcrumbs based on currently viewed URL. Then create a breadcrumbs collection and return this collection
 */

class ffBreadcrumbs extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffBreadcrumbsCollection
     */
    private $_breadcrumbsCollection = null;

    /**
     * @var ffOneBreadcrumbFactory
     */
    private $_oneBreadcrumbFactory = null;

    /**
     * @var ffFrontendQueryIdentificator
     */
    private $_queryIdentificator = null;

    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    /**
     * @var ffCustomTaxonomyIdentificator
     */
    private $_customTaxonomyIdentificator = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

    /**
     * @var string
     * current query type (home, singular, tax, etc)
     */
    private $_currentType = null;

    /**
     * @var stdClass
     * current query information (post type, tax type, id and other)
     */
    private $_currentInfo = null;

    /**
     * @var bool
     * add homepage breadcrumb at the beginning of breadcrumbs
     */
    private $_addHomepageBreadcrumb = true;


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffBreadcrumbsCollection $breadcrumbsCollection, ffOneBreadcrumbFactory $oneBreadcrumbFactory, ffWPLayer $WPLayer, ffFrontendQueryIdentificator $queryIdentificator, ffCustomTaxonomyIdentificator $customTaxonomyIdentificator ) {
        $this->_setBreadcrumbsCollection( $breadcrumbsCollection );
        $this->_setOneBreadcrumbFactory( $oneBreadcrumbFactory );
        $this->_setWPLayer( $WPLayer );
        $this->_setQueryIdentificator( $queryIdentificator );
        $this->_setCustomTaxonomyIdentificator( $customTaxonomyIdentificator );
    }

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
    public function setPropertyAddHomepageBreadcrumb( $value ) {
        $this->_setAddHomepageBreadcrumb( $value );
    }

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

    /**
     * Generate breadcrumbs and return collection filled with the breadcrumbs
     * @return ffBreadcrumbsCollection
     */
    public function generateBreadcrumbs() {
        $currentType = $this->_getQueryIdentificator()->getQueryType();

        $this->_setCurrentType( $currentType );
        $this->_setCurrentInfo( $this->_getQueryIdentificator()->getQueryInformations() );
        switch( $currentType ) {
            case ffConstQuery::SINGULAR:
                $this->_generateBreadcrumbsForSingular();
                break;

            case ffConstQuery::TAXONOMY:
                $this->_generateBreadcrumbsForTaxonomy();
                break;

            case ffConstQuery::SEARCH:
                $this->_generateBreadcrumbsForSearch();
                break;

            case ffConstQuery::DATE:
                $this->_generateBreadcrumbsForDate();
                break;

            case ffConstQuery::AUTHOR:
                $this->_generateBreadcrumbsForAuthor();
                break;

            case ffConstQuery::NOT_FOUND_404:
                $this->_generateBreadcrumbsFor404();
                break;

        }

        if( $this->_getAddHomepageBreadcrumb() == true ) {
            $this->_generateBreadcrumbsForHome();
        }

        $this->_getBreadcrumbsCollection()->getLastItem()->isSelected = true;

        return $this->_getBreadcrumbsCollection();
    }
/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS - GENERATING BREADCRUMBS - 404
/**********************************************************************************************************************/

    private function _generateBreadcrumbsFor404() {
        $breadcrumbItem = $this->_getBreadcrumbItem();

        $breadcrumbItem->name = '404';
        $breadcrumbItem->type = '404';
        $breadcrumbItem->url = $this->_getWPLayer()->get_site_url();
        $breadcrumbItem->queryType = ffConstQuery::NOT_FOUND_404;

        $this->_breadcrumbsCollection->addItem( $breadcrumbItem );
    }

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS - GENERATING BREADCRUMBS - AUTHOR
/**********************************************************************************************************************/

    private function _generateBreadcrumbsForAuthor() {
        $currentInfo = $this->_getCurrentInfo();
        $breadcrumbItem = $this->_getBreadcrumbItem();

        $breadcrumbItem->name = $currentInfo->name;
        $breadcrumbItem->type = $currentInfo->type;
        $breadcrumbItem->url = $this->_WPLayer->get_author_posts_url( $currentInfo->id );
        $breadcrumbItem->queryType = ffConstQuery::AUTHOR;


        $this->_breadcrumbsCollection->addItem( $breadcrumbItem );
    }

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS - GENERATING BREADCRUMBS - DATE
/**********************************************************************************************************************/


    private function _generateBreadcrumbForYear( $year ) {
        $breadcrumbItem = $this->_getBreadcrumbItem();
        $link = $this->_getWPLayer()->get_year_link( $year );

        $breadcrumbItem->name = 'year';
        $breadcrumbItem->type = 'date';
        $breadcrumbItem->url = $link;
        $breadcrumbItem->queryType = ffConstQuery::DATE_YEAR;

        $this->_getBreadcrumbsCollection()->addItemAtStart( $breadcrumbItem );
    }

    private function _generateBreadcrumbForMonth( $year, $month ) {
        $breadcrumbItem = $this->_getBreadcrumbItem();
        $link = $this->_getWPLayer()->get_month_link( $year, $month );

        $breadcrumbItem->name = 'month';
        $breadcrumbItem->type = 'date';
        $breadcrumbItem->url = $link;
        $breadcrumbItem->queryType = ffConstQuery::DATE_MONTH;

        $this->_getBreadcrumbsCollection()->addItemAtStart( $breadcrumbItem );
    }

    private function _generateBreadcrumbForDay( $year, $month, $day ) {
        $breadcrumbItem = $this->_getBreadcrumbItem();
        $link = $this->_getWPLayer()->get_day_link( $year, $month, $day );

        $breadcrumbItem->name = 'day';
        $breadcrumbItem->type = 'date';
        $breadcrumbItem->url = $link;
        $breadcrumbItem->queryType = ffConstQuery::DATE_DAY;


        $this->_getBreadcrumbsCollection()->addItemAtStart( $breadcrumbItem );
    }

    private function _generateBreadcrumbsForDate() {
        $currentInfo = $this->_getCurrentInfo();


        $day = null;
        $month = null;
        $year = null;

        switch( $currentInfo->date_type ) {
            case ffConstQuery::DATE_TIME:
            case ffConstQuery::DATE_DAY:
                $day = $this->_getWPLayer()->get_the_date('d');
            case ffConstQuery::DATE_MONTH:
                $month = $this->_getWPLayer()->get_the_date('n');
            case ffConstQuery::DATE_YEAR:
                $year = $this->_getWPLayer()->get_the_date('Y');

                break;
        }

        switch( $currentInfo->date_type ) {
            case ffConstQuery::DATE_TIME:
            case ffConstQuery::DATE_DAY:
                $this->_generateBreadcrumbForDay( $year, $month, $day);

            case ffConstQuery::DATE_MONTH:
                $this->_generateBreadcrumbForMonth( $year, $month );

            case ffConstQuery::DATE_YEAR:
                $this->_generateBreadcrumbForYear( $year );

                break;
        }
    }


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS - GENERATING BREADCRUMBS - SEARCH
/**********************************************************************************************************************/

    private function _generateBreadcrumbsForSearch() {
        $currentInfo = $this->_getCurrentInfo();

        $breadcrumbItem = $this->_getBreadcrumbItem();

        $breadcrumbItem->type = 'search';
        $breadcrumbItem->name = $currentInfo->name;
        $breadcrumbItem->url = $this->_getWPLayer()->get_search_link( $currentInfo->name );
        $breadcrumbItem->queryType = ffConstQuery::SEARCH;

        $this->_getBreadcrumbsCollection()->addItem( $breadcrumbItem );
    }

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS - GENERATING BREADCRUMBS - TAXONOMY
/**********************************************************************************************************************/
    /**
     * generate breadcrumbs for taxonomy and all its parents
     */
    private function _generateBreadcrumbsForTaxonomy() {
        $currentInfo = $this->_getCurrentInfo();

        $taxonomyName = $currentInfo->taxonomy_type;
        $termId = $currentInfo->id;

        $this->_generateBreadcrumbForTermsAndItsParents( $termId, $taxonomyName );

    }

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS - GENERATING BREADCRUMBS - SINGULAR
/**********************************************************************************************************************/
    private function _createBreadcrumbFromPost( $post ) {
        $breadcrumbItem = $this->_getBreadcrumbItem();

        $breadcrumbItem->name = $post->post_title;
        $breadcrumbItem->type = $post->post_type;
        $breadcrumbItem->url = $this->_getWPLayer()->get_permalink( $post->ID );
        $breadcrumbItem->queryType = ffConstQuery::SINGULAR;

        return $breadcrumbItem;
    }

    private function _generateBreadcrumbsForPostAndAllParents( $postId ) {
        $post = $this->_getWPLayer()->get_post( $postId );

        $breadcrumbItem = $this->_createBreadcrumbFromPost( $post );

        $this->_getBreadcrumbsCollection()->addItemAtStart( $breadcrumbItem );

        if( $post->post_parent != 0 ) {
            $this->_generateBreadcrumbsForPostAndAllParents( $post->post_parent );
        }
    }

    private function _generateBreadcrumbsForSingular() {
        $currentInfo = $this->_getCurrentInfo();
        $postId = $currentInfo->id;
        $postType = $currentInfo->post_type;

        // if its hierarchical, we have to find all post parents
        // if its not hierarchical, we have to find all taxonomies, which are hierarchical
        if( $this->_getWPLayer()->is_post_type_hierarchical( $postType ) ) {
            $post = $this->_getWPLayer()->get_current_post();
            $this->_generateBreadcrumbsForPostAndAllParents( $post->ID );
        } else {
            $taxonomies = $this->_getCustomTaxonomyIdentificator()->getActiveTaxonomyCollection();

            if( !empty( $taxonomies ) ) {
                $taxonomyName = null;
                foreach( $taxonomies as $oneTaxonomy ) {
                    if( in_array( $postType, $oneTaxonomy->appliedToObjects ) && $oneTaxonomy->hierarchical ) {
                        $taxonomyName = $oneTaxonomy->id;
                    }
                }

                if( $taxonomyName != null ) {
                    $this->_generateBreadcrumbTermsForSingular( $postId, $taxonomyName );
                }
            }

            $post = $this->_getWPLayer()->get_current_post();
            $lastBreadcrumb = $this->_createBreadcrumbFromPost( $post );
            $this->_getBreadcrumbsCollection()->addItem($lastBreadcrumb );
        }


    }



    private function _generateBreadcrumbForTermsAndItsParents( $termId, $taxonomyName ) {
        $newTerm = $this->_getWPLayer()->get_term( $termId, $taxonomyName );

        $breadcrumbItem = $this->_createBreadcrumbFromTerm( $newTerm );
        $this->_getBreadcrumbsCollection()->addItemAtStart( $breadcrumbItem );

        if( $newTerm->parent != 0 ) {
            $this->_generateBreadcrumbForTermsAndItsParents( $newTerm->parent, $newTerm->taxonomy );
        }
    }

    private function _generateBreadcrumbTermsForSingular( $postId, $taxonomyName ) {
        $allTerms = $this->_getWPLayer()->get_the_terms( $postId, $taxonomyName );

        if( empty( $allTerms ) ) {
            return false;
        }
        $firstTerm = reset( $allTerms );
        $breadcrumbItem = $this->_createBreadcrumbFromTerm( $firstTerm );
        $this->_getBreadcrumbsCollection()->addItem( $breadcrumbItem );

        if( $firstTerm->parent != 0 ) {
            $this->_generateBreadcrumbForTermsAndItsParents( $firstTerm->parent, $firstTerm->taxonomy );
        }

    }


    private function _generateBreadcrumbsForHome() {
        $breadcrumb = $this->_getBreadcrumbItem();

        $breadcrumb->name = $this->_getWPLayer()->get_blog_name();
        $breadcrumb->type = 'home';
        $breadcrumb->url = $this->_getWPLayer()->get_site_url();
        $breadcrumb->queryType = ffConstQuery::HOME;

        $this->_getBreadcrumbsCollection()->addItemAtStart( $breadcrumb );
    }

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS - BREADCRUMB ITEMS
/**********************************************************************************************************************/
    private function _createBreadcrumbFromTerm( $term ) {
        $breadcrumbItem = $this->_getBreadcrumbItem();

        $breadcrumbItem->name = $term->name;
        $breadcrumbItem->type = $term->taxonomy;
        $breadcrumbItem->url = $this->_getWPLayer()->get_term_link( $term->term_id, $term->taxonomy );
        $breadcrumbItem->queryType = ffConstQuery::TAXONOMY;

        return $breadcrumbItem;
    }
    /**
     * @param string $name
     * @param string $url
     * @param string $type
     * @return ffOneBreadcrumb
     */
    private function _getBreadcrumbItem( $name = null, $url = null, $type = null ) {
        $newBreadcrumb = $this->_getOneBreadcrumbFactory()->createOneBreadcrumb();

        if( $name != null ) {
            $newBreadcrumb->name = $name;
        }
        if( $url != null ) {
            $newBreadcrumb->url = $url;
        }
        if( $type != null ) {
            $newBreadcrumb->type = $type;
        }

        return $newBreadcrumb;
    }


/**********************************************************************************************************************/
/* GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return ffBreadcrumbsCollection
     */
    private function _getBreadcrumbsCollection()
    {
        return $this->_breadcrumbsCollection;
    }

    /**
     * @param ffBreadcrumbsCollection $breadcrumbsCollection
     */
    private function _setBreadcrumbsCollection($breadcrumbsCollection)
    {
        $this->_breadcrumbsCollection = $breadcrumbsCollection;
    }

    /**
     * @return ffOneBreadcrumbFactory
     */
    private function _getOneBreadcrumbFactory()
    {
        return $this->_oneBreadcrumbFactory;
    }

    /**
     * @param ffOneBreadcrumbFactory $oneBreadcrumbFactory
     */
    private function _setOneBreadcrumbFactory($oneBreadcrumbFactory)
    {
        $this->_oneBreadcrumbFactory = $oneBreadcrumbFactory;
    }

    /**
     * @return ffFrontendQueryIdentificator
     */
    private function _getQueryIdentificator()
    {
        return $this->_queryIdentificator;
    }

    /**
     * @param ffFrontendQueryIdentificator $queryIdentificator
     */
    private function _setQueryIdentificator($queryIdentificator)
    {
        $this->_queryIdentificator = $queryIdentificator;
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
     * @return null
     */
    private function _getCurrentInfo()
    {
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
     * @return ffCustomTaxonomyIdentificator
     */
    private function _getCustomTaxonomyIdentificator()
    {
        return $this->_customTaxonomyIdentificator;
    }

    /**
     * @param ffCustomTaxonomyIdentificator $customTaxonomyIdentificator
     */
    private function _setCustomTaxonomyIdentificator($customTaxonomyIdentificator)
    {
        $this->_customTaxonomyIdentificator = $customTaxonomyIdentificator;
    }

    /**
     * @return boolean
     */
    private function _getAddHomepageBreadcrumb()
    {
        return $this->_addHomepageBreadcrumb;
    }

    /**
     * @param boolean $addHomepageBreadcrumb
     */
    private function _setAddHomepageBreadcrumb($addHomepageBreadcrumb)
    {
        $this->_addHomepageBreadcrumb = $addHomepageBreadcrumb;
    }

}