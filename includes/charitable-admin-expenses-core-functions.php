<?php
/**
 * Charitable Extension Boilerplate Core Functions.
 *
 * General core functions.
 *
 * @author      Studio164a
 * @category    Core
 * @package     Charitable Extension Boilerplate
 * @subpackage  Functions
 * @version     1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * This returns the original Charitable_admin_expenses object.
 *
 * Use this whenever you want to get an instance of the class. There is no
 * reason to instantiate a new object, though you can do so if you're stubborn :)
 *
 * @since   1.0.0
 *
 * @return  Charitable_admin_expenses
 */
function charitable_admin_expenses() {
	return Charitable_admin_expenses::get_instance();
}

/**
 * Displays a template.
 *
 * @since   1.0.0
 *
 * @param   string|array $template_name A single template name or an ordered array of template.
 * @param   array        $args          Optional array of arguments to pass to the view.
 * @return  Charitable_admin_expenses_Template
 */
function charitable_admin_expenses_template( $template_name, array $args = array() ) {
	if ( empty( $args ) ) {
		$template = new Charitable_admin_expenses_Template( $template_name );
	} else {
		$template = new Charitable_admin_expenses_Template( $template_name, false );
		$template->set_view_args( $args );
		$template->render();
	}

	return $template;
}

/**
* Fetches a list of Campaigns  
* 
* @since 1.0.0
* 
* @return Charitable Campaigns list title and id
*/
function get_charitable_campaigns_title_id() {
	$args = array( 'post_type' => 'campaign');
	$loop = new WP_Query( $args );
	
	$campaigns = array();
	$count=0;
	
	while ( $loop->have_posts() ) : $loop->the_post();
		$campaigns[$count]['id'] = get_the_id();
		$campaigns[$count]['title'] = get_the_title();
		$count++;
	endwhile;


	return $campaigns;
}

/**
 * Return the database table helper object.
 *
 * @since  1.0.0
 *
 * @param  string $table The table key.
 * @return mixed|null A child class of Charitable_DB if table exists. null otherwise.
 */
function charitable_admin_expenses_get_table( $table ) {
	return charitable_admin_expenses()->get_db_table( $table );
}

/**
* Get all Admin Expenses
*/
function get_admin_expenses() {
	$results = charitable_admin_expenses_get_table( 'campaign_admin_expenses' )->get_expenses();
	return $results;
}