<?php
/**
 * The class responsible for adding & saving extra settings in the Charitable admin.
 *
 * @package     Charitable Admin Expenses/Classes/Charitable_admin_expenses_Admin
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Charitable_Admin_Expenses_Admin' ) ) :

	/**
	 * Charitable_Admin_Expenses_Admin
	 *
	 * @since       1.0.0
	 */
	class Charitable_Admin_Expenses_Admin {

		/**
		 * The single static class instance.
		 *
		 * @since   1.0.0
		 *
		 * @var     Charitable_admin_expenses_Admin
		 */
		private static $instance = null;

		/**
		 * Create class object. Private constructor.
		 *
		 * @since   1.0.0
		 *
		 */
		private function __construct() {
			require_once( 'upgrades/class-charitable-admin-expenses-upgrade.php' );
			require_once( 'upgrades/charitable-admin-expenses-upgrade-hooks.php' );
		}

		/**
		 * Create and return the class object.
		 *
		 * @since   1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new Charitable_admin_expenses_Admin();
			}

			return self::$instance;
		}
		
		public function init_thickbox() {
	 	add_thickbox();
	 	}

		/**
		 * Add custom links to the plugin actions.
		 *
		 * @since   1.0.0
		 *
		 * @param   string[] $links Links to be added to plugin actions row.
		 * @return  string[]
		 */
		public function add_plugin_action_links( $links ) {
			$links[] = '<a href="' . admin_url( 'admin.php?page=charitable-settings&tab=extensions' ) . '">' . __( 'Settings', 'charitable-newsletter-connect' ) . '</a>';
			return $links;
		}

		/**
		 * Add settings to the Extensions settings tab.
		 *
		 * @since   1.0.0
		 *
		 * @param   array[] $fields Settings to display in tab.
		 * @return  array[]
		 */
		public function add_admin_expenses_settings( $fields = array() ) {
			if ( ! charitable_is_settings_view( 'extensions' ) ) {
				return $fields;
			}

			$custom_fields = array(
				'section_admin_expenses' => array(
					'title'             => __( 'Admin Expenses', 'charitable-admin-expenses' ),
					'type'              => 'heading',
					'priority'          => 50,
				),
				'admin_expenses_setting_text' => array(
					'title'             => __( 'Text Field Setting', 'charitable-admin-expenses' ),
					'type'              => 'text',
					'priority'          => 50.2,
					'default'           => __( '', 'charitable-admin-expenses' ),
				),
				'admin_expenses_setting_checkbox' => array(
					'title'             => __( 'Checkbox Setting', 'charitable-admin-expenses' ),
					'type'              => 'checkbox',
					'priority'          => 50.6,
					'default'           => false,
					'help'              => __( '', 'charitable-admin-expenses' ),
				),
			);

			$fields = array_merge( $fields, $custom_fields );

			return $fields;
		}
	
		/**
		* Add sub menu item Add Expenses into Charitable Menu
		*/
		public function add_admin_expenses_submenu_item() {
			$menu_capability = apply_filters( 'charitable_admin_menu_capability', 'view_charitable_sensitive_data' );
			add_submenu_page( 'charitable', __( 'Expenses', 'charitable-admin-expenses'), __( 'Expenses', 'charitable-admin-expenses'), $menu_capability, 'expenses', array($this, 'show_admin_expenses_template'));
			
		}
		
		public function show_admin_expenses_template() {
			$get_campaigns_list 	= get_charitable_campaigns_title_id();
			$view_args['campaigns'] = $get_campaigns_list;
			$view_args['base_path'] = charitable_admin_expenses()->get_path( 'includes' ) . 'admin/views/';
			$view_args['cae_nonce']		= wp_create_nonce( "cae_add_user_meta_form_nonce" ); 
			charitable_admin_view('expenses/add-expense', $view_args);
		}
		
		
		/**
		* Enqueue required scripts
		* 
		* @return
		*/
		public function enqueue_admin_scripts() {
			wp_enqueue_script('jquery-ui-datepicker');
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script('charitable-admin-expenses', charitable_admin_expenses()->get_path( 'includes', FALSE ) . 'admin/assets/charitable-admin-expenses.js', array('jquery-ui-dialog'), time(), true);
			wp_localize_script( 'charitable-admin-expenses', 'cae', array('ajaxurl' => admin_url( 'admin-ajax.php' )));
			wp_enqueue_media();
		}
		
		/**
		* Enqueue required styles
		*/
		public function enqueue_admin_styles() {
			wp_enqueue_style('jquery-ui-datepicker');
            wp_enqueue_style (  'wp-jquery-ui-dialog');
			wp_enqueue_style('thickbox');
			wp_enqueue_style('charitable-admin-expenses', charitable_admin_expenses()->get_path( 'includes', FALSE ) . 'admin/assets/charitable-admin-expenses.css', false, time());
		}
		
		/**
		* Save Expense Details
		* 
		* @return
		*/
		public function save_charitable_admin_expense() {
		if( isset( $_POST['cae_add_user_meta_nonce'] ) && wp_verify_nonce( $_POST['cae_add_user_meta_nonce'], 'cae_add_user_meta_form_nonce') ) {
			$data = $_POST['expense'];
			charitable_admin_expenses_get_table( 'campaign_admin_expenses' )->insert( $data, '' );
			wp_safe_redirect(admin_url('admin.php?page=expenses'));
			exit;
		
		}
		}
		
		/**
		* Remove Expense from Exoense Data Table
		* 
		* @return
		*/
		public function remove_expense() {
			$return = array('error' => FALSE);
			if( !isset($_POST['expense_id']) || empty($_POST['expense_id']) ){
			$return['error'] = TRUE;
			} else {
			$data = $_POST['expense_id'];
			$is_removed = charitable_admin_expenses_get_table( 'campaign_admin_expenses' )->delete($data, '' );
			if(!$is_removed) {
			$return['error'] = TRUE;	
			}
		}
		echo json_encode($return);
		wp_die();
		}
		
public static function charitable_admin_expenses_by_campaign($atts) {
write_log("under shortcode function");
			ob_start();
			echo '<h5>Hello World</h5>';
			return ob_get_clean();
		}
	
	
		/**
		* 
		* 
		* @return
		*/
		function media_selector_print_scripts() {

	$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );

	?><script type='text/javascript'>

		jQuery( document ).ready( function( $ ) {

			// Uploading files
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this

			jQuery('#upload_image_button').on('click', function( event ){

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}

				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});

				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();

					// Do something with attachment.id and/or attachment.url here
					$( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					$( '#image_attachment_id' ).val( attachment.id );

					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});

					// Finally, open the modal
					file_frame.open();
			});

			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		});

	</script><?php

	}
	}

endif;
