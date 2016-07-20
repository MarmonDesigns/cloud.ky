<?php
class ffAdminScreenBootstrapVariablesViewDefault extends ffAdminScreenView {

	public function ajaxRequest( ffAdminScreenAjax $ajax ) { }

	protected function _render() {
		$lessManager = ffContainer::getInstance()->getLessWPOptionsManager();

		$namespace = 'bootstrap';
		$options = $lessManager->getOptionsFromFrameworkBootstrap( $namespace );

		// $namespace = 'theme-variables';
		// $file = get_template_directory() . '/assets/less/variables.less';
		// $options = $lessManager->getOptionsFromFile( $namespace, $file );

		$data    = $lessManager->createWPOptionsData( $namespace );

		echo '<div class="wrap">';
		echo '<h2>Bootstrap LESS variables</h2>';
		echo '<form method="post">';
		echo '<button class="button button-primary hero">Save</button>';

		$printer = ffContainer::getInstance()->getOptionsFactory()->createOptionsPrinterBoxed( $data, $options );
		$printer->setNameprefix( $namespace );
		$printer->walk();

		echo '</form>';
		echo '</div>';
	}

	protected function _requireAssets() { }

	protected function _setDependencies() { }

}