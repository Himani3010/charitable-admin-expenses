<?php
/**
 * Charitable Admin Expenses DB class.
 *
 * @package   Charitable Admin Expenses/Classes/Charitable_Admin_Expenses_DB
 * @author    Himani Lotia
 * @copyright Copyright (c) 2018, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Charitable_Admin_Expenses_DB' ) ) :
	/**
	* Charitable_Admin_Expenses_DB
	* @since 1.0.0
	*/
	class Charitable_Admin_Expenses_DB extends Charitable_DB {
		/**
		 * The version of our database table
		 *
		 * @since 1.0.0
		 *
		 * @var   string
		 */
		public $version = '1.0.0';
		
		/**
		 * The name of the primary column
		 *
		 * @since 1.0.0
		 *
		 * @var   string
		 */
		public $primary_key = 'expense_id';
		
		/**
		 * Set up the database table name.
		 *
		 * @since 1.0.0
		 *
		 * @global WPDB $wpdb
		 */
		public function __construct() {
			global $wpdb;

			$this->table_name = $wpdb->prefix . 'charitable_admin_expenses';
		}
		
		/**
		 * Create the table.
		 *
		 * @since 1.0.0
		 *
		 * @global WPDB $wpdb
		 */
		public function create_table() {
			global $wpdb;

			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE {$this->table_name} (
				expense_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				expense_title varchar(255) default NULL,
				expense_amount bigint(20) unsigned default NULL,
				expense_date datetime NOT NULL default '0000-00-00',
				expense_campaign_id bigint(20) unsigned default NULL,
				expense_receipt_id bigint(20) unsigned default NULL,
				PRIMARY KEY  (expense_id)
				) $charset_collate;";

			$this->_create_table( $sql );
		}
		
		/**
		 * Whitelist of columns.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_columns() {
			return array(
				'expense_id'          => '%d',
				'expense_title'       => '%s',
				'expense_amount'      => '%d',
				'expense_date'        => '%s',
				'expense_campaign_id' => '%d',
				'expense_receipt_id'  => '%d',
			);
		}
		
		/**
		 * Default column values.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_column_defaults() {
			return array(
				'expense_id'          => '',
				'expense_title'       => '',
				'expense_amount'      => '',
				'expense_date'        => date( 'Y-m-d' ),
				'expense_campaign_id' => '',
				'expense_receipt_id'  => '',
			);
		}
		
		/**
		 * Add a new expense.
		 *
		 * @since  1.0.0
		 *
		 * @param  array  $data Expenses data to insert.
		 * @param  string $type Should always be 'expenses'.
		 * @return int The ID of the inserted expense.
		 */
		public function insert( $data, $type = 'expenses' ) {

			$expense_id = parent::insert( $data, $type );

			//$this->maybe_log_consent( $data, $expense_id );

			return $expense_id;
		}
		
		/**
		* Get Expenses list
		*/
		public function get_expenses() {
			global $wpdb;
			return $wpdb->get_results("SELECT * FROM {$this->table_name};");
		}
		
		/**
		* Remove Expense
		*/
		public function remove_expense( $data, $type = 'expenses' ) {
			$is_removed = parent::delete($data);
			return $is_removed;
		}
	}
endif;