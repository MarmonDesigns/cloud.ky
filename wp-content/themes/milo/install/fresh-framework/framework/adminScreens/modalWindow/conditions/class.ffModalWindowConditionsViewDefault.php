<?php

class ffModalWindowConditionsViewDefault extends ffModalWindowView {
	protected function _initialize() {
		$this->_setViewName('Default');
	}

	protected  function _requireAssets() {
		//$this->_getStyleEnqueuer()->addStyleFramework('select2', '/framework/extern/select2/jquery.select2.css');
		//$this->_getScriptEnqueuer()->addScriptFramework('select2', '/framework/extern/select2/jquery.select2.min.js');
		//$this->_getScriptEnqueuer()->addScriptFramework('select2-tools', '/framework/extern/select2/select2-tools.js');
		$this->_getScriptEnqueuer()->getFrameworkScriptLoader()->requireSelect2()->requireFrsLib()->requireFrsLibOptions()->requireFrsLibModal()->requireFfAdmin();


	}

	protected function _render() {
		$l = $this->_printForm();
	}
	
	public function printToolbar() {

		echo '<div class="media-frame-toolbar">';
			echo '<div class="media-toolbar">';
				echo '<div class="media-toolbar-primary">';
					echo '<input type="submit" class="ff-conditional-submit button media-button button-primary button-large" value="Save Changes">';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}

	public function proceedAjax( ffAjaxRequest $request ) {
		$params = array();
		parse_str($request->data, $params);
		
		if( isset( $params['a'] ) ) {
			$this->_printForm( $params['a']);
		} else {
			$this->_printForm();
		}
		//var_dump( $params);
		//var_dump(parse_str $request );
	}


	private function _printForm( $data = array() ) {

		$l = ffContainer::getInstance()->getOptionsFactory()->createOptionsHolder('ffOptionsHolderConditionalLogic')->getOptions();
		
		$printer2 = ffContainer::getInstance()->getOptionsFactory()->createOptionsPrinterLogic($data, $l );

		echo '<form class="fftestform ff-modal-logic" method="POST">';
		$printer2->setNameprefix('a');
		$printer2->walk();
		echo '</br>';
		echo '</form>';
	}
}