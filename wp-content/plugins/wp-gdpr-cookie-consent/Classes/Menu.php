<?php

namespace WP_GDPR\Classes;

class Menu {
	
	public static function addAdminMenuPages() {
		add_submenu_page(
			'tools.php',
			__( 'WP GDPR', 'wp_gdpr' ),
			__( 'WP GDRP Consent', 'wp_gdpr' ),
			static::managePermission(),
			'ninja-wp-gdpr',
			array( static::class, 'renderGDPR' )
		);
	}
	
	public static function managePermission() {
		return apply_filters( 'ninja_wp_gdpr_menu_manager_permission', 'manage_options' );
	}
	
	public static function renderGDPR() {
		wp_enqueue_style( 'ninja_wp_gdpr_css', WP_GDPR_PLUGIN_DIR_URL . '/public/css/styles.css' );

		wp_enqueue_script(
			'ninja_wp_gdpr_js',
			WP_GDPR_PLUGIN_DIR_URL . 'public/js/ninja_wp_gdpr.js',
			array( 'jquery' ),
			WP_GDPR_PLUGIN_DIR_VERSION,
			true
		);
		
		wp_localize_script('ninja_wp_gdpr_js', 'ninja_wp_gdpr', array(
			'preview_url' => site_url().'?wp_gdpr_preview=1'	
		));
		
		include WP_GDPR_PLUGIN_DIR_PATH . 'views/admin_view.php';
	}
	
}
