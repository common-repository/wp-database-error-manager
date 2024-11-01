<?php


class Wp_Db_Error_Manager_Configuration {

	public static $PLUGIN_NAME = "wp-database-error-manager";
	public static $PLUGIN_DISPLAY_NAME = "WP Database Error Manager";

	//FOLDERS
	public static $PLUGIN_FOLDER = "wp-database-error-manager";
	public static $ASSETS_FOLDER = "assets";
	public static $PREVIEW_FOLDER = "preview";
	public static $TEMPLATE_DESIGN_FOLDER = "template-designs";
	public static $BASE_FILE_NAME = "base-file.html";
	public static $PREVIEW_FILE_NAME = "preview-file.php";

	//API
	// public static $API_URL = "http://localhost:1337/";
	public static $API_URL = "http://138.68.136.189/";
	// public static $SUBSCRIBE_URL = "http://localhost:1337/premium/subscribe";
	public static $SUBSCRIBE_URL = "http://wperrorapp.codevigor.com/premium/subscribe";
	public static $STATS_URL = "http://wperrorapp.codevigor.com/premium/automated-check-list";

	public static function get_screenshots_folder() {
		return plugin_dir_path(dirname(__FILE__)).Wp_Db_Error_Manager_Configuration::$ASSETS_FOLDER;
	}

	public static function get_admin_partials_folder() {
		return plugin_dir_path(dirname(__FILE__))."partials";
	}

	public static function get_design_path() {
		return "/wp-content/plugins/".Wp_Db_Error_Manager_Configuration::$PLUGIN_FOLDER."/".Wp_Db_Error_Manager_Configuration::$ASSETS_FOLDER."/".Wp_Db_Error_Manager_Configuration::$TEMPLATE_DESIGN_FOLDER;
	}

	public static function get_sample_file_physical_path() {
		return Wp_Db_Error_Manager_Configuration::get_preview_folder_physical_path().DIRECTORY_SEPARATOR.Wp_Db_Error_Manager_Configuration::$BASE_FILE_NAME;
	}

	public static function get_preview_file_physical_path() {
		return Wp_Db_Error_Manager_Configuration::get_preview_folder_physical_path().DIRECTORY_SEPARATOR.Wp_Db_Error_Manager_Configuration::$PREVIEW_FILE_NAME;
	}

	public static function get_preview_file_web_path() {
		return site_url()."/wp-content/plugins/".Wp_Db_Error_Manager_Configuration::$PLUGIN_FOLDER."/admin/".Wp_Db_Error_Manager_Configuration::$PREVIEW_FOLDER."/".Wp_Db_Error_Manager_Configuration::$PREVIEW_FILE_NAME;

		return Wp_Db_Error_Manager_Configuration::get_preview_folder_physical_path().DIRECTORY_SEPARATOR.Wp_Db_Error_Manager_Configuration::$PREVIEW_FILE_NAME;
	}

	public static function get_preview_folder_physical_path() {
		return plugin_dir_path(dirname(__FILE__)).Wp_Db_Error_Manager_Configuration::$PREVIEW_FOLDER;
	}

	public static function get_db_folder_physical_path() {
		return get_home_path()."wp-content/db-error.php";
	}

	public static function get_premium_plan_url() {
		return Wp_Db_Error_Manager_Configuration::$SUBSCRIBE_URL;
	}
}