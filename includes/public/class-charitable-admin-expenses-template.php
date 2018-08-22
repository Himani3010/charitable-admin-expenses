<?php
/**
 * Charitable Extension Boilerplate template
 *
 * @version     1.0.0
 * @package     Charitable Extension Boilerplate/Classes/Charitable_admin_expenses_Template
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Charitable_admin_expenses_Template' ) ) :

	/**
	 * Charitable_admin_expenses_Template
	 *
	 * @since       1.0.0
	 */
	class Charitable_admin_expenses_Template extends Charitable_Template {

		/**
		 * Set theme template path.
		 *
		 * @since   1.0.0
		 *
		 * @return  string
		 */
		public function get_theme_template_path() {
			return trailingslashit( apply_filters( 'charitable_admin_expenses_theme_template_path', 'charitable/charitable-extension-boilerplate' ) );
		}

		/**
		 * Return the base template path.
		 *
		 * @since   1.0.0
		 *
		 * @return  string
		 */
		public function get_base_template_path() {
			return charitable_admin_expenses()->get_path( 'templates' );
		}
	}

endif;
