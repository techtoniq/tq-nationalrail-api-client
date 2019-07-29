<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.techtoniq.com
 * @since      1.0.0
 *
 * @package    Tq_Nationalrail_Api_Client
 * @subpackage Tq_Nationalrail_Api_Client/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Tq_Nationalrail_Api_Client
 * @subpackage Tq_Nationalrail_Api_Client/includes
 * @author     Matt Daniels <matt@techtoniq.com>
 */
class Tq_Nationalrail_Api_Client_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'tq-nationalrail-api-client',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
