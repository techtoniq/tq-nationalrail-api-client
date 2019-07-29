<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.techtoniq.com
 * @since             1.0.0
 * @package           Tq_Nationalrail_Api_Client
 *
 * @wordpress-plugin
 * Plugin Name:       National Rail API Client
 * Plugin URI:        https://github.com/techtoniq/tq-nationalrail-api-client
 * Description:       Shortcode to display real time train information from the National Rail API.
 * Version:           1.0.0
 * Author:            Matt Daniels
 * Author URI:        http://www.techtoniq.com
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       tq-nationalrail-api-client
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TQ_NATIONALRAIL_API_CLIENT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tq-nationalrail-api-client-activator.php
 */
function activate_tq_nationalrail_api_client() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tq-nationalrail-api-client-activator.php';
	Tq_Nationalrail_Api_Client_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tq-nationalrail-api-client-deactivator.php
 */
function deactivate_tq_nationalrail_api_client() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tq-nationalrail-api-client-deactivator.php';
	Tq_Nationalrail_Api_Client_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tq_nationalrail_api_client' );
register_deactivation_hook( __FILE__, 'deactivate_tq_nationalrail_api_client' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tq-nationalrail-api-client.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tq_nationalrail_api_client() {

	$plugin = new Tq_Nationalrail_Api_Client();
	$plugin->run();

}
run_tq_nationalrail_api_client();
