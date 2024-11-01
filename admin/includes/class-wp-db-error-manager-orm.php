<?php

class Wp_Db_Error_Manager_ORM {

	public static function getData($optionName) {
		global $wpdb;
		$myrows = $wpdb->get_results("SELECT option_value FROM wp_options WHERE option_name='$optionName'");

		return $myrows;
	}

	public static function saveData($optionName, $dataArray) {
		global $wpdb;
		$myrows = $wpdb->get_results( "SELECT option_name FROM wp_options WHERE option_name = '$optionName'" );

		if(count($myrows) > 0) { //record exists
			$wpdb->update("wp_options",
				array("option_value" => json_encode($dataArray)),
				array("option_name" => $optionName),
				array("%s"));
		} else {
			$wpdb->insert("wp_options",
				array("option_name" => $optionName,
					"option_value" => json_encode($dataArray)),
				array("%s", "%s"));
		}
	}

	public static function deleteData($optionName) {
		global $wpdb;
		$myrows = $wpdb->delete("wp_options", array("option_name" => $optionName));
	}

	public static function getAuthOptionName() {
		return Wp_Db_Error_Manager_Configuration::$PLUGIN_NAME."-auth";
	}
}