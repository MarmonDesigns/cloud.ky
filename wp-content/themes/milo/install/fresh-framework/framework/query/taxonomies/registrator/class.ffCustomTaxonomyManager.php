<?php

class ffCustomTaxonomyManager extends ffBasicObject {

	protected $_taxonomies = array();

	public function __construct( ffWPLayer $WPLayer, ffCustomTaxonomy_Factory $CustomTaxonomy_Factory  ) {
		$this->_setWPLayer($WPLayer);
		$this->_setCustomTaxonomyFactory($CustomTaxonomy_Factory);
		$WPLayer->add_action( 'init', array($this, 'actRegisterTaxonomies' ) );
	}

	/**
	 * 
	 * @param unknown $slug_id
	 * @param unknown $name
	 * @param string $singular_name
	 * @param string $is_hidden
	 * @return ffCustomTaxonomy:
	 */
	public function addCustomTaxonomy( $slug_id, $name, $singular_name = null, $is_hidden = false ){
		$this->_taxonomies[ $slug_id ] = $this->_getCustomTaxonomyFactory()
			// NORMAL
			->createNormalCustomTaxonomy( 
					$slug_id,
					$name,
					$singular_name
			);
		// $this->_getWPLayer()->add_filter( 'post_updated_messages', array($this->_taxonomies[ $slug_id ], 'actionFilterPostUpdatedMessages' ) );
		return $this->_taxonomies[ $slug_id ];
	}

	public function actRegisterTaxonomies(){
		if( empty( $this->_taxonomies ) ){
			return;
		}

		foreach ($this->_taxonomies as $slug => $instance ) {
			$this->_getWPLayer()->register_taxonomy( 
				$slug,
				$instance->getConnectedPostTypes(),
				$instance->getBuildArgs()
			);
		}
	}

	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

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
	 * 
	 * @var ffCustomTaxonomy_Factory
	 */
	private $_CustomTaxonomy_Factory = null;

	/**
	 * @return ffCustomTaxonomy_Factory
	 */
	protected function _getCustomTaxonomyFactory() {
		return $this->_CustomTaxonomy_Factory;
	}
	
	/**
	 * @param ffCustomTaxonomy_Factory $CustomTaxonomy_Factory
	 */
	protected function _setCustomTaxonomyFactory(ffCustomTaxonomy_Factory $CustomTaxonomy_Factory) {
		$this->_CustomTaxonomy_Factory = $CustomTaxonomy_Factory;
		return $this;
	}

}