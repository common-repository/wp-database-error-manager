<?php

/**
 * The plugin bootstrap file
 *
 * WP DB Error Manager allows you to properly handle and manage the errors by allowing you to create custom database error pages and get notifications when your website is down.
 *
 * @link              www.codevigor.com
 * @since             1.0.0
 * @package           Wp_Db_Error_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       WP Database Error Manager
 * Plugin URI:        www.codevigor.com/blog/wp-database-error-manager/
 * Description:       WP DB Error Manager allows you to properly handle and manage the errors by allowing you create custom database error pages and get notifications when your website is down.
 * Version:           2.1.6
 * Author:            Codevigor Ltd
 * Author URI:        www.codevigor.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-db-error-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-db-error-manager-activator.php
 */
function activate_wp_db_error_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-db-error-manager-activator.php';
	Wp_Db_Error_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-db-error-manager-deactivator.php
 */
function deactivate_wp_db_error_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-db-error-manager-deactivator.php';
	Wp_Db_Error_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_db_error_manager' );
register_deactivation_hook( __FILE__, 'deactivate_wp_db_error_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-db-error-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_db_error_manager() {

	$plugin = new Wp_Db_Error_Manager();
	$plugin->run();

}

// function addajaxurl() {
//     wp_localize_script( 'frontend-ajax', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
// }
	
run_wp_db_error_manager();
