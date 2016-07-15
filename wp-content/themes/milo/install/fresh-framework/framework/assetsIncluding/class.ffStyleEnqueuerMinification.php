<?php

class ffStyleEnqueuerMinification extends ffStyleEnqueuer {
	/**
	 *
	 * @var ffMinificator
	 */
	private $_minificator = null;
	
	public function __construct( ffWPLayer $WPLayer, ffStyle_Factory $styleFactory, ffMinificator $minificator ) {
		parent::__construct($WPLayer, $styleFactory);
		$this->_setMinificator( $minificator );
	}
	
	public function actionEnqueueStyles() {
		$this->_enqueueNonMinificableStyles();
		if( !empty($this->_styles) ) {
			$this->_getMinificator()->startBatchCss('styles');
				$this->_getMinificator()->addStyleArray( $this->_styles );
			$url = $this->_getMinificator()->proceedBatchCss();
			
			$this->_getWplayer()
				->wp_enqueue_style(
						'styles-min',
						$url,
						null,
						null,
						false
				);
		}
	}
	
	/**
	 * @return ffMinificator
	 */
	protected function _getMinificator() {
		return $this->_minificator;
	}
	
	/**
	 * @param ffMinificator $_minificator
	 */
	protected function _setMinificator(ffMinificator $minificator) {
		$this->_minificator = $minificator;
		return $this;
	}
}