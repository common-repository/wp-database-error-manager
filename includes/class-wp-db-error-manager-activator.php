<?php

/**
 * Fired during plugin activation
 *
 * @link       www.codevigor.com
 * @since      1.0.0
 *
 * @package    Wp_Db_Error_Manager
 * @subpackage Wp_Db_Error_Manager/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Db_Error_Manager
 * @subpackage Wp_Db_Error_Manager/includes
 * @author     Codevigor Ltd <suyash@codevigor.com>
 */
class Wp_Db_Error_Manager_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		Wp_Db_Error_Manager_User_Tracking::recordActivation();
	}

}
