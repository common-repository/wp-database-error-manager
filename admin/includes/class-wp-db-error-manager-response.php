<?php

class Wp_Db_Error_Manager_Response {

	public static function ok($data, $json = false) {
		if($json) {
			echo json_encode(array("data" => $data, "response" => "ok"));
		} else {
			if(is_array($data)) {
				echo json_encode($data);
			} else {
				echo $data;
			}
		}
	}

	public static function error($error, $json = false, $data = null) {
		if($json) {
			echo json_encode(array("error" => $error, "response" => "error", "data" => $data));
		} else {
			echo $error;
		}
	}
}