<?php

header('HTTP/1.1 503 Service Unavailable');
header('wp_db_error_manager: active');

define( 'SHORTINIT', true );

require("../includes/class-wp-db-error-manager-template-utility.php");
require("../includes/class-wp-db-error-manager-configuration.php");
require("../includes/class-wp-db-error-manager-response.php");
require("../../../../../wp-config.php");
require("../../../../../wp-includes/pluggable.php");
require("../../../../../wp-includes/formatting.php");
require("../../../../../wp-load.php");

echo Wp_Db_Error_Manager_Template_Utility::get_preview_contents();

?>