<?php
/**
 * The main Charitable Admin Expenses class.
 *
 * The responsibility of this class is to load all the plugin's functionality.
 *
 * @package     Charitable Admin Expenses
 * @copyright   Copyright (c) 2017, Eric Daams
 * @license     http://opensource.org/licenses/gpl-1.0.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Charitable_Admin_Expenses' ) ) :

	/**
	 * Charitable_Admin_Expenses
	 *
	 * @since   1.0.0
	 */
	class Charitable_Admin_Expenses {

		/**
		 * Plugin version.
		 *
		 * @since   1.0.0
		 *
		 * @var string
		 */
		const VERSION = '1.0.0';

		/**
		 * Database version. A date in the format: YYYYMMDD
		 *
		 * @since   1.0.0
		 *
		 * @var string
		 */
		const DB_VERSION = '20151021';

		/**
		 * The product name.
		 *
		 * @since   1.0.0
		 *
		 * @var string
		 */
		const NAME = 'Charitable Admin Expenses';

		/**
		 * The product author.
		 *
		 * @since   1.0.0
		 *
		 * @var string
		 */
		const AUTHOR = 'Himani Lotia';

		/**
		 * Single static instance of this class.
		 *
		 * @since   1.0.0
		 *
	     * @var 	Charitable_Admin_Expenses
	     */
		private static $instance = null;

		/**
		 * The root file of the plugin.
		 *
		 * @since   1.0.0
		 *
		 * @var     string
		 */
		private $plugin_file;

		/**
		 * The root directory of the plugin.
		 *
		 * @since   1.0.0
		 *
		 * @var     string
		 */
		private $directory_path;

		/**
		 * The root directory of the plugin as a URL.
		 *
		 * @since   1.0.0
		 *
		 * @var     string
		 */
		private $directory_url;

		/**
		 * Create class instance.
		 *
		 * @since   1.0.0
		 *
		 * @param 	string $plugin_file Absolute path to the main plugin file.
		 */
		public function __construct( $plugin_file ) {
			$this->plugin_file      = $plugin_file;
			$this->directory_path   = plugin_dir_path( $plugin_file );
			$this->directory_url    = plugin_dir_url( $plugin_file );

			add_action( 'charitable_start', array( $this, 'start' ), 6 );
		}

		/**
		 * Returns the original instance of this class.
		 *
		 * @since   1.0.0
		 *
		 * @return  Charitable
		 */
		public static function get_instance() {
			return self::$instance;
		}

		/**
		 * Run the startup sequence on the charitable_start hook.
		 *
		 * This is only ever executed once.
		 *
		 * @since   1.0.0
		 *
		 * @return  void
		 */
		public function start() {
			// If we've already started (i.e. run this function once before), do not pass go.
			if ( $this->started() ) {
				return;
			}

			// Set static instance.
			self::$instance = $this;

			$this->load_dependencies();

			$this->maybe_start_admin();

			$this->maybe_start_public();

			$this->setup_licensing();

			$this->setup_i18n();
			
			$this->create_tables();

			// Hook in here to do something when the plugin is first loaded.
			do_action( 'charitable_admin_expenses_start', $this );
		}

		/**
		 * Include necessary files.
		 *
		 * @since   1.0.0
		 *
		 * @return  void
		 */
		private function load_dependencies() {
			$includes_path = $this->get_path( 'includes' );
			require_once(  $includes_path . 'charitable-admin-expenses-core-functions.php' );
			require_once( $includes_path . 'shortcodes/charitable-admin-expenses-shortcodes-hooks.php' );
		}

		/**
		 * Load the admin-only functionality.
		 *
		 * @since   1.0.0
		 *
		 * @return  void
		 */
		private function maybe_start_admin() {
			if ( ! is_admin() ) {
				return;
			}

			require_once( $this->get_path( 'includes' ) . 'admin/class-charitable-admin-expenses-admin.php' );
			require_once( $this->get_path( 'includes' ) . 'admin/charitable-admin-expenses-admin-hooks.php' );
			require_once( $this->get_path( 'includes' ) . 'db/class-charitable-admin-expenses-db.php' );
		}

		/**
		 * Load the public-only functionality.
		 *
		 * @since   1.0.0
		 *
		 * @return 	void
		 */
		private function maybe_start_public() {
			require_once( $this->get_path( 'includes' ) . 'public/class-charitable-admin-expenses-template.php' );
		}

		/**
		 * Set up licensing for the extension.
		 *
		 * @since   1.0.0
		 *
		 * @return  void
		 */
		private function setup_licensing() {
			charitable_get_helper( 'licenses' )->register_licensed_product(
				Charitable_Admin_Expenses::NAME,
				Charitable_Admin_Expenses::AUTHOR,
				Charitable_Admin_Expenses::VERSION,
				$this->plugin_file
			);
		}

		/**
		 * Set up the internationalisation for the plugin.
		 *
		 * @since   1.0.0
		 *
		 * @return  void
		 */
		private function setup_i18n() {
			if ( class_exists( 'Charitable_i18n' ) ) {

				require_once( $this->get_path( 'includes' ) . 'i18n/class-charitable-admin-expenses-i18n.php' );

				Charitable_Admin_Expenses_i18n::get_instance();
			}
		}

		/**
		 * Returns whether we are currently in the start phase of the plugin.
		 *
		 * @since   1.0.0
		 *
		 * @return  bool
		 */
		public function is_start() {
			return current_filter() == 'charitable_admin_expenses_start';
		}

		/**
		 * Returns whether the plugin has already started.
		 *
		 * @since   1.0.0
		 *
		 * @return  bool
		 */
		public function started() {
			return did_action( 'charitable_admin_expenses_start' ) || current_filter() == 'charitable_admin_expenses_start';
		}

		/**
		 * Returns the plugin's version number.
		 *
		 * @since   1.0.0
		 *
		 * @return  string
		 */
		public function get_version() {
			return self::VERSION;
		}

		/**
		 * Returns plugin paths.
		 *
		 * @since   1.0.0
		 *
		 * @param   string  $type          If empty, returns the path to the plugin.
		 * @param   boolean $absolute_path If true, returns the file system path. If false, returns it as a URL.
		 * @return  string
		 */
		public function get_path( $type = '', $absolute_path = true ) {
			$base = $absolute_path ? $this->directory_path : $this->directory_url;

			switch ( $type ) {
				case 'includes' :
					$path = $base . 'includes/';
					break;

				case 'templates' :
					$path = $base . 'templates/';
					break;

				case 'directory' :
					$path = $base;
					break;
					
				case 'admin' : 
					$path = $base . 'includes/admin/';	

				default :
					$path = $this->plugin_file;
			}

			return $path;
		}

		/**
		 * Throw error on object clone.
		 *
		 * This class is specifically designed to be instantiated once. You can retrieve the instance using charitable()
		 *
		 * @since   1.0.0
		 *
		 * @return  void
		 */
		public function __clone() {
			charitable_get_deprecated()->doing_it_wrong(
				__FUNCTION__,
				__( 'Cheatin&#8217; huh?', 'charitable-admin-expenses' ),
				'1.0.0'
			);
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since   1.0.0
		 *
		 * @return  void
		 */
		public function __wakeup() {
			charitable_get_deprecated()->doing_it_wrong(
				__FUNCTION__,
				__( 'Cheatin&#8217; huh?', 'charitable-admin-expenses' ),
				'1.0.0'
			);
		}
		
		/**
		 * Returns the model for one of Charitable's Admin Expenses database tables.
		 *
		 * @since  1.0.0
		 *
		 * @param  string $table The database table to retrieve.
		 * @return Charitable_DB
		 */
		public function get_db_table( $table ) {
			$tables = $this->get_tables();

			if ( ! isset( $tables[ $table ] ) ) {
				charitable_get_deprecated()->doing_it_wrong(
					__METHOD__,
					sprintf( 'Invalid table %s passed', $table ),
					'1.0.0'
				);
				return null;
			}
			
			$object = new $tables[$table];

			return $object;
		}
		
		/**
		 * Return the filtered list of registered tables.
		 *
		 * @since  1.0.0
		 *
		 * @return string[]
		 */
		private function get_tables() {
			/**
			 * Filter the array of available Charitable table classes.
			 *
			 * @since 1.0.0
			 *
			 * @param array $tables List of tables as a key=>value array.
			 */
			return apply_filters( 'charitable_admin_expenses_db_tables', array(
				'campaign_admin_expenses' => 'Charitable_Admin_Expenses_DB',
			) );
		}
		
		/**
	* 
	*/
	protected function create_tables() {
		require_once( charitable()->get_path( 'includes' ).'abstracts/abstract-class-charitable-db.php' );
		$tables = array($this->get_path( 'includes' ) . 'db/class-charitable-admin-expenses-db.php'    => 'Charitable_Admin_Expenses_DB',
			);
		foreach ( $tables as $file => $class ) {
				require_once( $file );
				$table = new $class;
				$table->create_table();
			}
		
	}
	}

endif;
