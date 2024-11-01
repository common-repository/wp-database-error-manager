<?php


class Wp_Db_Error_Manager_Premium {

    public static function save_premium_settings() {
        $automatedChecks = $_POST["data"]["automated_checks"];
        $automatedCheckUrl = site_url();

        $result = Wp_Db_Error_Manager_API::call("premium/save-premium-settings", array("automated_checks" => $automatedChecks, "automated_check_url" => $automatedCheckUrl, "auth_token" => Wp_Db_Error_Manager_Auth::get_auth_token()), "POST", true);

        Wp_Db_Error_Manager_Response::ok($result);

        return $result;
    }

    public static function load_premium_settings() {
    	$url = site_url();
    	$authToken = Wp_Db_Error_Manager_Auth::get_auth_token();

    	if($authToken != "") {
    		$result = Wp_Db_Error_Manager_API::call("premium/get-premium-settings", array("url" => $url, "auth_token" => Wp_Db_Error_Manager_Auth::get_auth_token()), "POST", true);
        	Wp_Db_Error_Manager_Response::ok($result);
    	} else {
    		Wp_Db_Error_Manager_Response::ok(array());
    	}

        return $result;
    }

    public static function get_active_plan() {
        $result = Wp_Db_Error_Manager_API::call("premium/get-active-plan", array("auth_token" => Wp_Db_Error_Manager_Auth::get_auth_token()), "POST", true);

        Wp_Db_Error_Manager_Response::ok($result);

        return $result;
    }

}