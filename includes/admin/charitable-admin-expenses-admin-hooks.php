<?php
/**
 * Charitable Admin Expenses admin hooks.
 *
 * @package     Charitable Admin Expenses/Functions/Admin
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', array( Charitable_Admin_Expenses_Admin::get_instance(), 'init_thickbox' ) );

/**
 * Add a direct link to the Extensions settings page from the plugin row.
 *
 * @see     Charitable_Admin_Expenses_Admin::add_plugin_action_links()
 */
add_filter( 'plugin_action_links_' . plugin_basename( charitable_admin_expenses()->get_path() ), array( Charitable_Admin_Expenses_Admin::get_instance(), 'add_plugin_action_links' ) );

/**
 * Add a "Admin Expenses" section to the Extensions settings area of Charitable.
 *
 * @see Charitable_Admin_Expenses_Admin::add_admin_expenses_settings()
 */
add_filter( 'charitable_settings_tab_fields_extensions', array( Charitable_Admin_Expenses_Admin::get_instance(), 'add_admin_expenses_settings' ), 6 );

/**
* Add a sub menu item to the Charitable Main Menu
* 
* @see     Charitable_Admin_Expenses_Admin::add_admin_expenses_submenu_item()
*/
add_action( 'admin_menu', array( Charitable_Admin_Expenses_Admin::get_instance(), 'add_admin_expenses_submenu_item'), 11);

/**
* Enqueue Admin Scripts
* 
* @see     Charitable_Admin_Expenses_Admin::enqueue_admin_scripts()
*/
add_action( 'admin_enqueue_scripts', array( Charitable_Admin_Expenses_Admin::get_instance(), 'enqueue_admin_scripts'), 11 );

/**
* Enqueue Admin Styles
* 
* @see     Charitable_Admin_Expenses_Admin::enqueue_admin_styles()
*/
add_action( 'admin_enqueue_scripts', array( Charitable_Admin_Expenses_Admin::get_instance(), 'enqueue_admin_styles'), 13 );

/**
* Enqueue scripts in footer
*/
add_action( 'admin_footer', array( Charitable_Admin_Expenses_Admin::get_instance(), 'media_selector_print_scripts'), 13 );

/**
* Handle Expense Form Response
*/
add_action( 'admin_post_expense_form_save_response', array( Charitable_Admin_Expenses_Admin::get_instance(), 'save_charitable_admin_expense') );

add_action('wp_ajax_remove_expense', array( Charitable_Admin_Expenses_Admin::get_instance(),'remove_expense') );

add_shortcode( 'charitable_admin_expenses_by_campaign', array( Charitable_Admin_Expenses_Admin::get_instance(), 'charitable_admin_expenses_by_campaign' ));