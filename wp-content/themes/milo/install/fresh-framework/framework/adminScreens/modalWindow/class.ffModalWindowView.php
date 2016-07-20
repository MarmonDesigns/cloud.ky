<?php

abstract class ffModalWindowView extends ffModalWindowBasicObject {

	private $_viewSlug = null;

	private $_viewName = null;

	private $_wrappedInnerContent = true;

	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	// Toolbar

	protected $_toolbarCancelText = "Cancel";
	protected $_toolbarOKText = "Use";
	protected $_toolbarHasSizeSlider = false;

	public function proceedAjax( ffAjaxRequest $request ) {

	}

	public function getSlug() {
		return $this->_viewSlug;
	}

	public function getName() {
		return $this->_viewName;
	}

	public function getWrappedInnerContent() {
		return $this->_wrappedInnerContent;
	}


	public function render() {
		$this->_requireAssets();
		$this->_render();
	}

	public function printToolbar() {
		echo '<div class="media-frame-toolbar">';
			echo '<div class="media-toolbar">';

				if( $this->_toolbarHasSizeSlider ){
					echo '<div class="media-toolbar-secondary">';
						echo '<div class="ff-modal-library-size-slider">';
							echo '<div class="ff-modal-library-size-slider-control-left"></div>';
							echo '<div class="ff-modal-library-size-slider-control-right"></div>';
						echo '</div>';
						echo '<input type="hidden" class="ff-modal-library-size-slider-value">';
					echo '</div>';
				}

				echo '<div class="media-toolbar-primary">';
					echo '<input type="submit" class="ff-cancel-library-button button media-button button-secondary button-large media-button-cancel"'
						.' value="'.$this->_toolbarCancelText.'">';
					echo '<input type="submit" class="ff-submit-library-button button media-button button-primary button-large media-button-select"'
						.' value="'.$this->_toolbarOKText.'">';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}

	protected function _requireAssets() {}
	abstract protected function _render();

	protected function _initialize() {

	}

	protected function _getViewSlug() {
		return $this->_viewSlug;
	}

	protected function _setWrappedInnerContent( $wrappedInnerContent ) {
		$this->_wrappedInnerContent = $wrappedInnerContent;
	}

	protected function _setViewSlug($viewSlug) {

		$this->_viewSlug = $this->_getWPLayer()->sanitize_title($viewSlug);
		return $this;
	}

	protected function _getViewName() {
		return $this->_viewName;
	}

	protected function _setViewName($viewName) {
		$this->_viewName = $viewName;
		$this->_setViewSlug( $viewName );
		return $this;
	}
}