<?php
/*
Plugin Name: WP GDPR Cookie Consent
Description: The Most Light-Weight, Simple and Complete GDPR Cookie Consent WP Plugin.
Version: 1.0.0
Author: WPManageNinja
Author URI: https://wpmanageninja.com
Plugin URI: https://github.com/WPManageNinja/wp-gdpr-cookie-consent
License: GPLv2 or later
Text Domain: wp_gdpr
Domain Path: /languages
*/

defined("ABSPATH") or die;

include "load.php";

define("WP_GDPR_PLUGIN_DIR_URL", plugin_dir_url(__FILE__));
define("WP_GDPR_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
define("WP_GDPR_PLUGIN_DIR_VERSION", '1.0.0');


class WPGDPRCookieConsent
{
	public function boot()
	{
		$this->adminHooks();
		$this->publicHooks();
		$this->loadTextDomain();
	}
	
	public function adminHooks()
	{
		add_action('admin_menu', array('WP_GDPR\Classes\Menu','addAdminMenuPages'));
		add_action('wp_ajax_ninja_gdpr_ajax_actions', array('WP_GDPR\Classes\GdprHandler','handleAjaxCalls'));

		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), function ($links) {
			$links[] = '<a href="'. esc_url( get_admin_url(null, 'tools.php?page=ninja-wp-gdpr') ) .'">Settings</a>';
			$links[] = '<a href="https://wpmanageninja.com/downloads/category/wordpress-plugins/?utm_source=plugin&utm_medium=wpgdpr&utm_campaign=plugin-menu" target="_blank">More plugins by WPManageNinja</a>';
			return $links;
		} );
		
	}
	
	public function publicHooks()
	{
		add_action('init', array('WP_GDPR\Classes\GdprHandler', 'addGDPRNotice'));
		add_filter('wp_gdpr_is_accepted', array('WP_GDPR\Classes\GdprHandler', 'filterCookieStatus'));
	}

	public function loadTextDomain()
	{
		// ...
	}
}

if(!function_exists('wp_gdpr_is_accepted')) {
	function wp_gdpr_is_accepted() {
		$currentState = \WP_GDPR\Classes\ArrayHelper::get($_COOKIE, 'wp_gdpr_permission', false);
		$status = false;
		if($currentState == 'accepted') {
			$status = true;
		}
		return apply_filters('wp_gdpr_is_accepted', $status);
	}
}

if(!function_exists('wp_gdpr_is_denied')) {
	function wp_gdpr_is_denied() {
		$currentState = \WP_GDPR\Classes\ArrayHelper::get($_COOKIE, 'wp_gdpr_permission', false);
		$status = false;
		if($currentState == 'denied') {
			$status = true;
		}
		return apply_filters('wp_gdpr_is_denied', $status);
	}
}

add_action('plugins_loaded', function() {
	$ninjaWpGDPR = new WPGDPRCookieConsent();
	$ninjaWpGDPR->boot(); 
});
