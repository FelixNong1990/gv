<?php
/*
Plugin Name: Usernoise Pro
Plugin URI: mailto: karev.n@gmail.com
Description: Usernoise Pro is an extension of Usernoise feedback plugin providing additional features.
Version: 3.7.11
Author: Nikolay Karev
Author URI: http://karevn.com
*/

define('UNPRO_USE_ADVANCED_DEBUG', 'unpro_use_advanced_debug');
define('UNPRO_HIDE_FEEDBACK_BUTTON', 'unpro_hide_feedback_button');
define('UNPRO_SHOW_FEEDBACK_BUTTON', 'unpro_show_feedback_button');
define('UNPRO_ADMIN_NOTIFICATION_EMAIL', 'unpro_admin_notification_email');
define('UNPRO_ENABLE_DISCUSSIONS', 'unpro_enable_discussions');
define('UNPRO_CUSTOM_BUTTON_ID', 'unpro_custom_button_id');
define('UNPRO_CUSTOM_BUTTON_CSS', 'unpro_custom_button_css');
define('UNPRO_ENABLE_FEEDS', 'unpro_enable_feeds');
define('UNPRO_FORM_CSS', 'unpro_form_css');
define('UNPRO_EXTERNAL_CODE', 'unpro_external_code');
define('UNPRO_DISABLE_BUTTON_ON_LOGIN', 'unpro_disable_button_on_login');
define('UNPRO_NOTIFICATIONS_SITE', 'unpro_notifications_site');

define('UNPRO_VERSION', "3.7.11");
define('REQUIRED_UN_VERSION', '3.7.9');
define('USERNOISEPRO_MAIN', __FILE__);
define('USERNOISEPRO_DIR', dirname(plugin_basename(__FILE__)));
define('USERNOISEPRO_BASENAME', plugin_basename(__FILE__));
define('USERNOISEPRO_SLUG', 'usernoise-pro');
if (!defined('UN_ENABLED')){
	define('UN_ENABLED', 'un_enabled');
}
load_plugin_textdomain('usernoise-pro', false, 'usernoise-pro/languages');
require('inc/dependencies.php');
require('inc/updater.php');
require('inc/template.php');
require_once('inc/external-code.php');
require('admin/settings.php');
add_action('init', 'unpro_load', 0);
add_action('plugins_loaded', 'unpro_load_controller');


function unpro_load_controller(){
	if (usernoise_dependency_ok()){
		require_once('inc/model.php');
		if (((is_admin() && defined('DOING_AJAX')) || !is_admin()) && un_get_option(UN_ENABLED))
			require('inc/controller.php');
		if (is_admin()){
			require('admin/editor-page.php');
			require('admin/feedback-list.php');
			require('admin/feedback-types.php');
		}
	}
}

function unpro_load(){
	if (usernoise_dependency_ok()){
		require_once('inc/model.php');
		require_once('inc/widgets.php');
		require_once('inc/migrations.php');
		require_once('inc/shortcodes.php');
		if (un_get_option(UN_ENABLED)){
			require_once('inc/integration.php');
		}
	}

}

function unpro_get_default_options(){
	return array(
		UNPRO_ENABLE_DISCUSSIONS => true
	);
}
function unpro_activation_hook(){
	global $un_settings;
	flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'unpro_activation_hook');
