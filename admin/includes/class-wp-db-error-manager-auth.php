<?php

class Wp_Db_Error_Manager_Auth {

	private static $AUTH_OPTION_NAME = "";

	public static function isLoggedIn() {
		$authDetails = Wp_Db_Error_Manager_ORM::getData(Wp_Db_Error_Manager_ORM::getAuthOptionName());

		if(count($authDetails) > 0) {
			$authTokenData = json_decode($authDetails[0]->option_value, true);

			if(isset($authTokenData["auth_token"])) {
				return true;
			}
		}

		return false;
	}

	public static function login() {
		$email = $_POST["data"]["email"];
		$password = $_POST["data"]["password"];

		$result = Wp_Db_Error_Manager_API::call("user/login", array("email" => $email, "password" => $password));
		$resultData = json_decode($result, true);

		if(isset($resultData["data"]) && isset($resultData["data"]["auth_token"])) {
			$authToken = $resultData["data"]["auth_token"];
			Wp_Db_Error_Manager_ORM::saveData(Wp_Db_Error_Manager_ORM::getAuthOptionName(), array("auth_token" => $authToken));
			Wp_Db_Error_Manager_Response::ok(array("success" => true, "message" => "Login successful. You will be redirected in a few seconds"), true);
		} else {
			Wp_Db_Error_Manager_Response::ok($result);
		}

		return $result;
	}

	public static function logout() {
		$result = array("code" => "", "message" => "You have been successfully logged out");
		Wp_Db_Error_Manager_ORM::deleteData(Wp_Db_Error_Manager_ORM::getAuthOptionName());
		Wp_Db_Error_Manager_Response::ok($result, true);

		return $result;
	}

	public static function register() {
		$email = $_POST["data"]["email"];
		$password = $_POST["data"]["password"];

		$result = Wp_Db_Error_Manager_API::call("user/register", array("email" => $email, "password" => $password, "url" => site_url()));

		Wp_Db_Error_Manager_Response::ok($result);

		return $result;
	}

	public static function get_auth_token() {
		$authDetails = Wp_Db_Error_Manager_ORM::getData(Wp_Db_Error_Manager_ORM::getAuthOptionName());

		if(count($authDetails) > 0) {
			$authTokenData = json_decode($authDetails[0]->option_value, true);

			if(isset($authTokenData["auth_token"])) {
				return $authTokenData["auth_token"];
			}
		}

		return "";
	}
}