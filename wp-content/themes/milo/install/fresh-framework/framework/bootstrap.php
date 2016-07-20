<?php

function ff_initFramework() {
	remove_action('admin_notices', 'ff_plugin_fresh_framework_notification');

	$configuration = array(
		'less_and_scss_compilation' => true,
		'style_minification' => false,
		'script_minification' => false,
		'minificator' => array(
								'cache_files_max_old' => 60*60*24*7*2, // 14 days
								'cache_check_interval' => 60*60*24*3, // 3 days
							),

		'freshface-server-upgrading-url' => 'http://files.freshcdn.net/get-info.php',
		'freshface-server-theme-upgrading-url' => 'http://files.freshcdn.net/get-info-theme.php',

		// 'freshface-server-upgrading-url' => 'http://127.0.0.1:8888/wp/sandbox/wp-content/plugins/d-fresh-updater/get-info.php',
		// 'freshface-server-theme-upgrading-url' => 'http://127.0.0.1:8888/wp/sandbox/wp-content/plugins/d-fresh-updater/get-info-theme.php',
	);
	require_once FF_FRAMEWORK_DIR . '/framework/developingTools.php';
	require_once FF_FRAMEWORK_DIR . '/framework/fileSystem/class.ffClassLoader.php';


	$classLoader = new ffClassLoader();

	$classLoader->loadClass('ffBasicObject');
	
	$classLoader->loadConstants();
	
	$classLoader->loadClass('ffContainer');
	$classLoader->loadClass('ffFactoryAbstract');
	$classLoader->loadClass('ffFactoryCenterAbstract');
	$classLoader->loadClass('ffPluginAbstract');
	$classLoader->loadClass('ffPluginContainerAbstract');
	$classLoader->loadClass('ffException');
	



	$container = ffContainer::getInstance();

	$container->setConfiguration($configuration);
	$container->setClassloader($classLoader);

	do_action('ff_framework_initalized');

	// preventing to running framework when only making updates
	if( FF_FRAMEWORK_IS_INSTALLED ) {
		$container->getFramework()->run();
	}

	if( ('plugins.php' == basename($_SERVER['SCRIPT_NAME']) ) or ( 'update.php' == basename($_SERVER['SCRIPT_NAME']) ) ){
		ffContainer::getInstance()->getScriptEnqueuer()->addScriptFramework('ff-update-hide', '/framework/adminScreens/assets/js/update.js');
	}

}

ff_initFramework();

function ffContainer() {
	return ffContainer::getInstance();
}

