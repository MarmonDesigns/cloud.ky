<?php
########################################################################################################################
# Welcome to "Milo" theme!
#=======================================================================================================================
# thank you for purchasing. This is a functions.php file. Here you can find any
# theme specific functions ( for example ajax calls, custom post types and
# other things ). Most of the other functions are located in our plugin
# Fresh Framework, which has to be activated in order to run this template
# without any problems.
########################################################################################################################
#																			                                           #
#																			                                           #
#																			                                           #
########################################################################################################################
# Framework Initialisation
#=======================================================================================================================
# this code initialise our fresh framework plugin. If the plugin is not
# presented, we run automatic installation which will result in installing
# and activating the plugin. Please do not change the framework initialisation ( lines 22 - 43 ), its complex
# and there is nothing you can gain by changing this
########################################################################################################################
require 'install/init.php';

if ( !class_exists('ffFrameworkVersionManager') && !is_admin() ) {
	echo '<span style="color:red; font-size:50px;">';
		echo 'The Fresh Framework plugin must be installed and activated in order to use this theme.';
	echo '</span>';
	die();
} else if( !class_exists('ffFrameworkVersionManager') && is_admin() ) {
	if( !function_exists('ff_plugin_fresh_framework_notification') ) {
		function ff_plugin_fresh_framework_notification() {
			?>
		    <div class="error">
		    <p><strong><em>Fresh</strong></em> plugins require the <strong><em>'Fresh Framework'</em></strong> plugin to be activated first.</p>
		    </div>
		    <?php
		}
		add_action( 'admin_notices', 'ff_plugin_fresh_framework_notification' );
	}

	return;
}
require 'framework/init.php';

global $content_width;
if ( ! isset( $content_width ) ) $content_width = 1140;

########################################################################################################################
########################################################################################################################
########################################################################################################################
#
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
# WHERE TO FIND JavaScript and CSS files including?
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
# Its located in folder framework/theme/class.ffThemeAssetsIncluder.php
# you can change it directly here, or override it at your child theme, if you wish
#
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
# SEE THIS BEFORE CUSTOMIZATION
# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
#
# !!! Please note, that all options are cached. So if you change anything it the /templates/onePage structure, the
# changes will not appear, until you delete the wp-content/uploads/freshframework/cached_options folder. You can
# prevent caching by setting this constant in the "wp-config.php" file:
#
# define('FF_WP_DEBUG', true);
#
#
# We moved some of important functions out of the "functions.php" file, so you could easily override them in your child
# theme. For example different ajax requests, like sending contact form messages, ajax portfolio and other :-)
#
# Also all functions are wrapped by "function_exists", so when you use child theme, you can override these functions
# without getting errors. If you struggle with anything, just let us know please :)
#
#
########################################################################################################################


$ffFileSystem = ffContainer()->getFileSystem();

// TGM plugin installer
require_once "install/install-plugins-by-tgm.php";

// CUSTOMIZABLE THINGS
// ===================
// feel free to change these things in your child theme :-)

// ADD THEME SUPPORT AND OTHER STUFF
require $ffFileSystem->locateFileInChildTheme('/functions/customizable/theme-setup.php');

// CONTACT FORM ajax
require $ffFileSystem->locateFileInChildTheme('/functions/customizable/contact-form.php');

// SIDEBAR registration
require $ffFileSystem->locateFileInChildTheme('/functions/customizable/sidebar-registration.php');

// FONTS SELECTOR
require $ffFileSystem->locateFileInChildTheme('/functions/customizable/fonts.php');

// INTERNAL THINGS
// ===============
// please customize only if you are sure what are you doing :-)

// SECTIONS - internal
require $ffFileSystem->locateFileInChildTheme('/functions/internal/sections.php');

// LAYOUTS - internal
require $ffFileSystem->locateFileInChildTheme('/functions/internal/layouts.php');

// FONTS AND ICONS - internal
require $ffFileSystem->locateFileInChildTheme('/functions/internal/fonts-and-icons.php');

// JS CONSTANTS - internal
require $ffFileSystem->locateFileInChildTheme('/functions/internal/javascript-constants.php');

// THEME SPECIFIC FUNCTIONS
require $ffFileSystem->locateFileInChildTheme('/functions/internal/theme-specific.php');

// IMPORTANT FUNCTIONS WRAPPING WORDPRESS FUNCTIONS
require $ffFileSystem->locateFileInChildTheme('/functions/internal/wordpress-wrappers.php');

// COLOR ACCENT GENERATION
require $ffFileSystem->locateFileInChildTheme('/functions/internal/color-accent-generation.php');

// EXTERNAL PLUGINS COMMUNICATION
require $ffFileSystem->locateFileInChildTheme('/functions/internal/external-plugins.php');

################################################################################
# Framework Initialisation End
################################################################################




