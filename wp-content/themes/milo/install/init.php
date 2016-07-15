<?php

function ff_themeInstallFramework() {
	if( !file_exists( dirname(__FILE__).'/fresh-framework/freshplugin.php' ) ) {
		return false;
	}
	require_once  dirname(__FILE__).'/fresh-framework/freshplugin.php';
	
	$versionManager =  ffFrameworkVersionManager::getInstance();
	$versionManager->initFrameworkFromTemplate();

	$container = ffContainer::getInstance();
	
	
	$currentDir = dirname( __FILE__ );
	$infoFile = $currentDir .'/fresh-framework/info.php';
	require( $infoFile );

	$latestInstalledVersion = $versionManager->getLatestInstalledVersion();
 
	if(version_compare( $info['plugin-version'], $latestInstalledVersion, '>')) {
		if( $container->getPluginInstaller()->installPluginFromFolder( $currentDir .'/fresh-framework' ) ) {
			$container->getPluginInstaller()->activateInstalledPlugins();
			header("Refresh:0");
			die();
		}
	} else {
		return;
	}
}
ff_themeInstallFramework();