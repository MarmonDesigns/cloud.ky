<?php

class ffCustomPostTypeIdentificator extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 *
	 * @var ffWPLayer
	 */
	protected  $_WPLayer = null;

	/**
	 *
	 * @var ffCustomPostTypeCollection_Factory
	 */
	protected $_customPostTypeCollectionFactory = null;

	protected  $_postTypeBlacklist = array();

    protected $_blacklistHasBeenReseted = false;
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/

	public function __construct( ffWPLayer $WPLayer, ffCustomPostTypeCollection_Factory $customPostTypeCollectionFactory ) {
		$this->_setWPLayer($WPLayer);
		$this->_setCustomPostTypeCollectionFactory($customPostTypeCollectionFactory);
	}

	public function getActivePostTypesCollection() {
		$activePostTypesArray = $this->_getWPLayer()->get_wp_post_types();
        if( !$this->_blacklistHasBeenReseted ) {
		    $activePostTypesAfterBlacklist = $this->_filterNotPublicPostTypes( $activePostTypesArray );
        } else {
            $activePostTypesAfterBlacklist = $activePostTypesArray;
        }
		return $this->_getCustomPostTypeCollectionFactory()->createCustomPostTypeCollection( $activePostTypesAfterBlacklist );
	}

    public function resetBlacklist() {
        $this->_blacklistHasBeenReseted = true;

        return $this;
    }

/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	private function _filterNotPublicPostTypes( $postTypes ) {

		foreach ($postTypes as $key => $type) {
			if( empty( $type->public ) ){
				unset( $postTypes[$key] );
			}
		}

		return $postTypes;
	}
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/


	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	/**
	 * @return ffCustomPostTypeCollection_Factory
	 */
	protected function _getCustomPostTypeCollectionFactory() {
		return $this->_customPostTypeCollectionFactory;
	}
	
	/**
	 * @param ffCustomPostTypeCollection_Factory $customPostTypeCollectionFactory
	 */
	protected function _setCustomPostTypeCollectionFactory(ffCustomPostTypeCollection_Factory $customPostTypeCollectionFactory) {
		$this->_customPostTypeCollectionFactory = $customPostTypeCollectionFactory;
		return $this;
	}
	
}