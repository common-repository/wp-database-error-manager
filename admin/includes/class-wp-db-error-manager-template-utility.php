<?php


class Wp_Db_Error_Manager_Template_Utility {

	public static function get_template_list() {
		$imageUrlPath = Wp_Db_Error_Manager_Configuration::get_design_path();

		$array = array();
		array_push($array, array("id" => 1, "image" => $imageUrlPath."/design-1.jpg"));
		array_push($array, array("id" => 2, "image" => $imageUrlPath."/design-2.jpg"));
		array_push($array, array("id" => 3, "image" => $imageUrlPath."/design-3.png"));
		array_push($array, array("id" => 4, "image" => $imageUrlPath."/design-4.jpg"));
		array_push($array, array("id" => 5, "image" => $imageUrlPath."/design-5.jpg"));
		array_push($array, array("id" => 6, "image" => $imageUrlPath."/design-6.jpg"));
		array_push($array, array("id" => 7, "image" => $imageUrlPath."/design-7.jpg"));
		array_push($array, array("id" => 8, "image" => $imageUrlPath."/design-8.jpg"));
		array_push($array, array("id" => 9, "image" => $imageUrlPath."/design-9.png"));
		array_push($array, array("id" => 10, "image" => $imageUrlPath."/design-10.jpg"));

		return $array;
	}

	private static function get_template_from_id($templateId) {
		$templateList = Wp_Db_Error_Manager_Template_Utility::get_template_list();

		for($i=0;$i<count($templateList);$i++) {
			if($templateList[$i]["id"] == $templateId) {
				return $templateList[$i];
			}
		}

		return $templateList[0];//if template id is invalid, return the first template
	}

	private static function get_generated_file_contents($dataArray) {
		return Wp_Db_Error_Manager_Template_Utility::replace_file_contents_with_data($dataArray);
	}

	private static function replace_file_contents_with_data($array) {
		$baseFile = Wp_Db_Error_Manager_Configuration::get_sample_file_physical_path();
		$baseFileContents = file_get_contents($baseFile);
		$formattedDescription = str_replace("\n", "<br />", $array["description"]);

		$newFileContents = str_replace("{{PAGE_TITLE}}", $array["title"], $baseFileContents);
		$newFileContents = str_replace("{{CONTENT_TITLE}}", $array["title"], $newFileContents);
		$newFileContents = str_replace("{{CONTENT_DESCRIPTION}}", $array["description"], $newFileContents);
		$newFileContents = str_replace("{{BACKGROUND_URL}}", $array["imageUrl"], $newFileContents);

		return stripslashes($newFileContents);
	}

	public static function generate_preview() {
		Wp_Db_Error_Manager_Template_Utility::save_preview_settings();
		Wp_Db_Error_Manager_Response::ok(array("file_path" => Wp_Db_Error_Manager_Configuration::get_preview_file_web_path()), true);
	}

	public static function generate_file() {
		$newFileContents = Wp_Db_Error_Manager_Template_Utility::get_generated_file_contents($_POST['data']);
		$newFileContentPath = Wp_Db_Error_Manager_Configuration::get_db_folder_physical_path();

		Wp_Db_Error_Manager_Template_Utility::save_settings();

		if(is_writable($newFileContentPath)) {
			$file = fopen($newFileContentPath, "w");
			fwrite($file, $newFileContents);
			fclose($file);

			Wp_Db_Error_Manager_Response::ok(array("file_path" => Wp_Db_Error_Manager_Configuration::get_preview_file_web_path()), true);
		} else {
			Wp_Db_Error_Manager_Response::error("Cannot generate the file.<br />The file ($newFileContentPath) is not writable.", true, array("file_contents" => $newFileContents));
		}
	}

	private static function save_settings() {
		global $wpdb;
		$myrows = $wpdb->get_results( "SELECT option_name FROM wp_options WHERE option_name = '".Wp_Db_Error_Manager_Configuration::$PLUGIN_NAME."'" );

		if(count($myrows) > 0) {
			//record exists
			$wpdb->update("wp_options",
				array("option_value" => json_encode($_POST['data'])),
				array("option_name" => Wp_Db_Error_Manager_Configuration::$PLUGIN_NAME),
				array("%s"));
		} else {
			$wpdb->insert("wp_options",
				array("option_name" => Wp_Db_Error_Manager_Configuration::$PLUGIN_NAME,
					"option_value" => json_encode($_POST['data'])),
				array("%s", "%s"));
		}
	}

	private static function save_preview_settings() {
		$optionName = Wp_Db_Error_Manager_Template_Utility::getPreviewSettingsOptionName();
		global $wpdb;
		$myrows = $wpdb->get_results( "SELECT option_name FROM wp_options WHERE option_name = '$optionName'" );

		if(count($myrows) > 0) {
			//record exists
			$wpdb->update("wp_options",
				array("option_value" => json_encode($_POST['data'])),
				array("option_name" => $optionName),
				array("%s"));
		} else {
			$wpdb->insert("wp_options",
				array("option_name" => $optionName,
					"option_value" => json_encode($_POST['data'])),
				array("%s", "%s"));
		}
	}

	private static function getPreviewSettingsOptionName() {
		return Wp_Db_Error_Manager_Configuration::$PLUGIN_NAME."-preview";
	}

	public static function get_settings()
	{
		global $wpdb;
		$myrows = $wpdb->get_results( "SELECT option_value FROM wp_options WHERE option_name='".Wp_Db_Error_Manager_Configuration::$PLUGIN_NAME."'" );

		$arrayData = array("imageUrl" => "", "title" => "", "description" => "");

		if(count($myrows) > 0) {

			$optionValue = json_decode($myrows[0]->option_value);

			$arrayData["imageUrl"] = $optionValue->imageUrl;
			$arrayData["title"] = $optionValue->title;
			$arrayData["description"] = stripslashes($optionValue->description);
		}

		return $arrayData;
	}

	public static function get_preview_settings() {
		global $wpdb;
		$myrows = $wpdb->get_results( "SELECT option_value FROM wp_options WHERE option_name='".Wp_Db_Error_Manager_Template_Utility::getPreviewSettingsOptionName()."'" );

		$arrayData = array("imageUrl" => "", "title" => "", "description" => "");

		if(count($myrows) > 0) {

			$optionValue = json_decode($myrows[0]->option_value);

			$arrayData["imageUrl"] = $optionValue->imageUrl;
			$arrayData["title"] = $optionValue->title;
			$arrayData["description"] = stripslashes($optionValue->description);
		}

		return $arrayData;
	}

	public static function get_preview_contents() {
		$dataArray = Wp_Db_Error_Manager_Template_Utility::get_preview_settings();

		return Wp_Db_Error_Manager_Template_Utility::replace_file_contents_with_data($dataArray);
	}
}