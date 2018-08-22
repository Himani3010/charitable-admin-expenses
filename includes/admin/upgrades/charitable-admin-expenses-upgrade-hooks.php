<?php
/**
 * Charitable Admin Expenses Upgrade Hooks.
 *
 * Action/filter hooks used for Charitable Admin Expenses Upgrades.
 *
 * @package     Charitable Admin Expenses/Functions/Upgrades
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Check if there is an upgrade that needs to happen and if so, display a notice to begin upgrading.
 *
 * @see     Charitable_admin_expenses_Upgrade::add_upgrade_notice()
 */
add_action( 'admin_notices', array( Charitable_admin_expenses_Upgrade::get_instance(), 'add_upgrade_notice' ) );
