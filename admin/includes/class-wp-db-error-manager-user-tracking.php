<?php


class Wp_Db_Error_Manager_User_Tracking {

	private static $ACTIVATION_ACTION = "activation";
	private static $DEACTIVATION_ACTION = "deactivation";

	public static function recordActivation() {
		return Wp_Db_Error_Manager_User_Tracking::recordGeneric(Wp_Db_Error_Manager_User_Tracking::$ACTIVATION_ACTION);
	}

	public static function recordDeactivation() {
		return Wp_Db_Error_Manager_User_Tracking::recordGeneric(Wp_Db_Error_Manager_User_Tracking::$DEACTIVATION_ACTION);
	}

	public static function record_ui_action() {
		$action = $_POST["data"]["action"];
		$details = $_POST["data"]["details"];

		$details = json_encode($details);

		return Wp_Db_Error_Manager_User_Tracking::recordGeneric($action, $details);
	}

	private static function recordGeneric($action, $details = "") {
		$url = site_url();

		$result = Wp_Db_Error_Manager_API::call("user-tracking/record/generic", array("url" => $url, "action" => $action, "details" => $details), "POST", true);

        return $result;
	}
	
}