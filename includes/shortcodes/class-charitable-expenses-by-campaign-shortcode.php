<?php
/**
 * Admin Expenses by Campaign shortcode class.
 *
 * @package   Charitable Admin Expenses/Shortcodes/Admin Expenses
 * @author    Eric Daams
 * @copyright Copyright (c) 2018, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */
 
 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Charitable_Expenses_by_Campaign_Shortcode' ) ) :

	/**
	* Charitable_Expenses_by_Campaign_Shortcode class
	* 
	* @since 1.0.0
	*/
	class Charitable_Expenses_by_Campaign_Shortcode {
		
		/**
		* Display the shortcode output. This is the callback @method for the Expenses shortcode
		* @since   1.0.0
		*
		* @param  array $atts The user-defined shortcode attributes.
		* @return string
		*/
		public static function charitable_admin_expenses_by_campaign($atts) {
write_log("under shortcode function");
			ob_start();
			echo '<h5>Hello World</h5>';
			return ob_get_clean();
		}
	}
endif;
 