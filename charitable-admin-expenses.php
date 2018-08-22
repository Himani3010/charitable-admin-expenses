<?php
/**
 * Plugin Name: 		Charitable - Admin Expenses
 * Plugin URI:
 * Description:
 * Version: 			1.0.0
 * Author: 				Himani Lotia
 * Author URI: 			https://www.wpcharitable.com
 * Requires at least: 	4.2
 * Tested up to: 		4.8
 *
 * Text Domain: 		charitable-admin-expenses
 * Domain Path: 		/languages/
 *
 * @package 			Charitable Admin Expenses
 * @category 			Core
 * @author 				Himani Lotia
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Load plugin class, but only if Charitable is found and activated.
 *
 * @return 	false|Charitable_admin_expenses Whether the class was loaded.
 */
function charitable_admin_expenses_load() {
	require_once( 'includes/class-charitable-admin-expenses.php' );

	$loaded = false;

	/* Check for Charitable */
	if ( ! class_exists( 'Charitable' ) ) {

		if ( ! class_exists( 'Charitable_Extension_Activation' ) ) {

			require_once 'includes/admin/class-charitable-extension-activation.php';

		}

		$activation = new Charitable_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation = $activation->run();

	} else {

		$loaded = new Charitable_admin_expenses( __FILE__ );

	}

	return $loaded;
}

add_action( 'plugins_loaded', 'charitable_admin_expenses_load', 1 );
