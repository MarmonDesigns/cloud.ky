<?php

class ffPostTypeRegistratorManager extends ffBasicObject {

	/**
	 *
	 * @var array[ffPostTypeRegistrator]
	 */
	protected $_post_types = array();

	public function __construct( ffWPLayer $WPLayer, ffPostTypeRegistrator_Factory $PostTypeRegistrator_Factory  ) {
		$this->_setWPLayer($WPLayer);
		$this->_setPostTypeRegistratorFactory($PostTypeRegistrator_Factory);
		$WPLayer->add_action( 'init', array($this, 'actRegisterPostTypes' ) );
	}

	/**
	 *
	 * @param unknown $slug_id
	 * @param unknown $name
	 * @param string $singular_name
	 * @param string $is_hidden
	 * @return ffPostTypeRegistrator
	 */
	public function addPostTypeRegistrator( $slug_id, $name, $singular_name = null, $is_hidden = false ){
		$this->_post_types[ $slug_id ] = $this->_getPostTypeRegistratorFactory()
			// NORMAL
			->createNormalPostTypeRegistrator(
					$slug_id,
					$name,
					$singular_name
			);
		$this->_getWPLayer()->add_filter( 'post_updated_messages', array($this->_post_types[ $slug_id ], 'actionFilterPostUpdatedMessages' ) );
		return $this->_post_types[ $slug_id ];
	}

	public function addHiddenPostTypeRegistrator( $slug_id, $name, $singular_name = null ){
		$this->_post_types[ $slug_id ] = $this->_getPostTypeRegistratorFactory()
			// HIDDEN
			->createHiddenPostTypeRegistrator(
					$slug_id,
					$name,
					$singular_name
			);

		$this->_getWPLayer()->add_filter(
			'post_updated_messages',
			array(
				$this->_post_types[ $slug_id ],
				'actionFilterPostUpdatedMessages'
			)
		);

		$this->_getWPLayer()->add_filter(
			'post_row_actions',
			array(
				$this->_post_types[ $slug_id ],
				'actionFilterPostRowInlineEditAction'
			)
		);

		$this->_getWPLayer()->add_filter(
			'post_row_actions',
			array(
				$this->_post_types[ $slug_id ],
				'actionFilterPostRowViewAction'
			)
		);

		return $this->_post_types[ $slug_id ];
	}

	public function actRegisterPostTypes(){
		if( empty( $this->_post_types ) ){
			return;
		}

		foreach ($this->_post_types as $slug => $instance ) {
			$this->_getWPLayer()->register_post_type( $slug, $instance->getBuildArgs() );
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
	 * @var ffPostTypeRegistrator_Factory
	 */
	private $_PostTypeRegistrator_Factory = null;

	/**
	 * @return ffPostTypeRegistrator_Factory
	 */
	protected function _getPostTypeRegistratorFactory() {
		return $this->_PostTypeRegistrator_Factory;
	}

	/**
	 * @param ffPostTypeRegistrator_Factory $PostTypeRegistrator_Factory
	 */
	protected function _setPostTypeRegistratorFactory(ffPostTypeRegistrator_Factory $PostTypeRegistrator_Factory) {
		$this->_PostTypeRegistrator_Factory = $PostTypeRegistrator_Factory;
		return $this;
	}

}