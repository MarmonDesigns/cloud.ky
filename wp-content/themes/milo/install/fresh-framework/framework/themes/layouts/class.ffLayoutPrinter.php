<?php

/**
 * Class ffLayoutPrinter
 *
 * Load all known layouts and go through all of them. Evaluate with conditional logic, which layouts we want to print.
 * After filtering these layouts, we gonna print the layouts, and eventually call callbacks to find another default
 * layouts
 */
class ffLayoutPrinter extends  ffBasicObject {
    const DATA_SOURCE_NORMAL = 'normal';
    const DATA_SOURCE_DEFAULT = 'default';
    const DATA_SOURCE_EXTERNAL_CALLBACK = 'callback';

    const POSITION_HEADER = 'header';
    const POSITION_BEFORE_CONTENT = 'before-content';
    const POSITION_CONTENT = 'content';
    const POSITION_AFTER_CONTENT ='after-content';
    const POSITION_FOOTER = 'footer';

/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffLayoutsDataManager
     */
    private $_layoutsDataManager = null;

    /**
     * @var ffConditionalLogicEvaluator
     */
    private $_conditionalLogicEvaluator = null;

    /**
     * @var ffOptionsFactor
     */
    private $_optionsFactory = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_hasBeenInitialized = false;

    private $_layoutData = array();

    private $_layoutDefaultData = array();

    /**
     * @var callable
     */
    private $_emptyPositionCallback = null;

    /**
     * @var callable
     */
    private $_printSectionCallback = null;

    private $_currentDataSource = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct(
        ffLayoutsDataManager $layoutsDataManager,
        ffConditionalLogicEvaluator $conditionalLogicEvaluator,
        ffOptions_Factory $optionsFactory
    ) {
        $this->_setLayoutsDataManager( $layoutsDataManager );
        $this->_setConditionalLogicEvaluator( $conditionalLogicEvaluator);
        $this->_setOptionsFactory( $optionsFactory);
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function printLayoutHeader() {
        $this->_printLayout( self::POSITION_HEADER );
        return $this;
    }

    public function printLayoutBeforeContent() {
        $this->_printLayout( self::POSITION_BEFORE_CONTENT );
        return $this;
    }

    public function printLayoutContent() {
        $this->_printLayout( self::POSITION_CONTENT );
        return $this;
    }

    public function printLayoutAfterContent() {
        $this->_printLayout( self::POSITION_AFTER_CONTENT );
        return $this;
    }

    public function printLayoutFooter() {
        $this->_printLayout( self::POSITION_FOOTER );
        return $this;
    }

    public function setPrintSectionCallback( $callback ) {
        $this->_printSectionCallback = $callback;
    }

    public function setCallbackForEmptyPosition( $callback ) {
        $this->_setEmptyPositionCallback( $callback );
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    public function filterLayoutsCallback( $item ) {
        /** @var ffLayoutCollectionItem $item */

        $conditions = $item->getConditional();
        $conditionQuery = $this->_getOptionsFactory()->createQuery( $conditions,'ffOptionsHolder_Layout_Conditions');
        $evaluator = $this->_getConditionalLogicEvaluator();

        $conditionQuerySelected = $conditionQuery->get('conditions show-where');

        if( !is_object( $conditionQuerySelected ) || get_class($conditionQuerySelected) != 'ffOptionsQuery' ) {
            return false;
        }

        if( !$item->getActive() || $item->getTrashed() ) {
            return false;
        }

        if( $evaluator->evaluate( $conditionQuery->get('conditions show-where') ) ) {
            return true;
        }

        return false;
    }

    private function _initialize() {
        if( $this->_hasBeenInitialized ) {
            return true;
        }
        $this->_hasBeenInitialized = true;

        $layoutCollection = $this->_getLayoutsDataManager()->getLayoutCollection();
        $layoutCollection->filter(array( $this, 'filterLayoutsCallback'));

        /** @var ffLayoutCollectionItem $oneItem */
        foreach( $layoutCollection as $oneItem ) {
            $placementQuery = $this->_getOptionsFactory()->createQuery( $oneItem->getPlacement(),'ffOptionsHolder_Layout_Placement');

            $placement = $placementQuery->get('placement placement');
            $priority = $placementQuery->get('placement priority' );
            $default = $placementQuery->get('placement default');

            if( $default ) {
               $this->_addDefaultLayout($placement, $priority, $oneItem);
            } else {
                $this->_addNormalLayout($placement, $priority, $oneItem);
            }
        }
    }

    private function _addDefaultLayout( $placement, $priority, $item ) {
        $this->_layoutDefaultData[ $placement ][ $priority ][] = $item;
    }

    private function _addNormalLayout( $placement, $priority, $item ) {
        $this->_layoutData[ $placement ][ $priority ][] = $item;
    }

    private function _printLayout( $type ) {
        $this->_initialize();


        $data = $this->_getDataForLayout( $type );

        if( empty( $data ) ) {
            return false;
        }

        if( $this->_getCurrentDataSource() != self::DATA_SOURCE_EXTERNAL_CALLBACK ) {
            foreach( $data as $priority => $onePriorityContent ) {
                foreach( $onePriorityContent as $oneItem ) {
                    /** @var ffLayoutCollectionItem $oneItem */

                    $oneSection = ( $oneItem->getData() );

                    $postQuery = $this->_getOptionsFactory()->createQuery( $oneSection,'ffComponent_Theme_LayoutOptions');

                    foreach( $postQuery->get('sections') as $oneSection ) {
                        $variationType = $oneSection->getVariationType();

                        $callback = $this->_getPrintSectionCallback();

                        $callback( $oneSection, $variationType );
                    }

                }
            }
        } else {
            $postQuery = $this->_getOptionsFactory()->createQuery( $data,'ffComponent_Theme_LayoutOptions');

            foreach( $postQuery->get('sections') as $oneSection ) {
                $variationType = $oneSection->getVariationType();

                if( $this->_printSectionCallback != null ) {
                    $callback = $this->_printSectionCallback;
                    $callback( $oneSection, $variationType );
                }
            }
        }
    }

    private function _getDataForLayout( $placement ) {

        if( isset( $this->_layoutData[ $placement ] ) ) {
            ksort( $this->_layoutData[ $placement ] );
            $this->_setCurrentDataSource( self::DATA_SOURCE_NORMAL );
            return $this->_layoutData[ $placement ];
        } else if( isset( $this->_layoutDefaultData[ $placement ] ) ) {
            ksort( $this->_layoutDefaultData[ $placement ] );
            $this->_setCurrentDataSource( self::DATA_SOURCE_DEFAULT );
            return $this->_layoutDefaultData[ $placement ];
        } else if ( $this->_getEmptyPositionCallback() != null ) {
            $callback = $this->_getEmptyPositionCallback();
            $returnValue = $callback( $placement );

            $this->_setCurrentDataSource( self::DATA_SOURCE_EXTERNAL_CALLBACK );

            return $returnValue;
        }
        return null;
    }



/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return callable
     */
    private function _getPrintSectionCallback()
    {
        if( $this->_printSectionCallback == null ) {
            throw new ffException('Layout Printer -> No callback has been set (this is theme domain)');
        }
        return $this->_printSectionCallback;
    }

    /**
     * @param callable $printSectionCallback
     */
    private function _setPrintSectionCallback($printSectionCallback)
    {
        $this->_printSectionCallback = $printSectionCallback;
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
     * @return ffConditionalLogicEvaluator
     */
    private function _getConditionalLogicEvaluator()
    {
        return $this->_conditionalLogicEvaluator;
    }

    /**
     * @param ffConditionalLogicEvaluator $conditionalLogicEvaluator
     */
    private function _setConditionalLogicEvaluator($conditionalLogicEvaluator)
    {
        $this->_conditionalLogicEvaluator = $conditionalLogicEvaluator;
    }

    /**
     * @return ffOptionsFactor
     */
    private function _getOptionsFactory()
    {
        return $this->_optionsFactory;
    }

    /**
     * @param ffOptionsFactor $optionsFactory
     */
    private function _setOptionsFactory($optionsFactory)
    {
        $this->_optionsFactory = $optionsFactory;
    }

    /**
     * @return null
     */
    private function _getCurrentDataSource()
    {
        return $this->_currentDataSource;
    }/**
     * @param null $currentDataSource
     */
    private function _setCurrentDataSource($currentDataSource)
    {
        $this->_currentDataSource = $currentDataSource;
    }

    /**
     * @return callable
     */
    private function _getEmptyPositionCallback()
    {
        return $this->_emptyPositionCallback;
    }

    /**
     * @param array $emptyPositionCallback
     */
    private function _setEmptyPositionCallback($emptyPositionCallback)
    {
        $this->_emptyPositionCallback = $emptyPositionCallback;
    }
}