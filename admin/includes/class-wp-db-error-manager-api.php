<?php


class Wp_Db_Error_Manager_API {

	public static function call($action, $data = false, $method = "POST", $includeAuthToken = false)
	{
	    $curl = curl_init();
	    $url = Wp_Db_Error_Manager_Configuration::$API_URL.$action;

	    if($includeAuthToken) {
	    	$data["auth_token"] = Wp_Db_Error_Manager_Auth::get_auth_token();
	    }

	    $encodedData = $data;

	    switch ($method)
	    {
	        case "POST":
	            curl_setopt($curl, CURLOPT_POST, 1);

	            if($data) {
	                curl_setopt($curl, CURLOPT_POSTFIELDS, $encodedData);
	            }
	            break;
	        case "PUT":
	            curl_setopt($curl, CURLOPT_PUT, 1);
	            break;
	        default:
	            if($data) {
	                $url = sprintf("%s?%s", $url, http_build_query($data));
	            }
	    }

	    // Optional Authentication:
	    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	    $result = curl_exec($curl);

	    curl_close($curl);

	    return $result;
	}
	
}