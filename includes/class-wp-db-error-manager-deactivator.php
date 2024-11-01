<?php

/**
 * Fired during plugin deactivation
 *
 * @link       www.codevigor.com
 * @since      1.0.0
 *
 * @package    Wp_Db_Error_Manager
 * @subpackage Wp_Db_Error_Manager/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Db_Error_Manager
 * @subpackage Wp_Db_Error_Manager/includes
 * @author     Codevigor Ltd <suyash@codevigor.com>
 */
class Wp_Db_Error_Manager_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		Wp_Db_Error_Manager_User_Tracking::recordDeactivation();

	}

}
