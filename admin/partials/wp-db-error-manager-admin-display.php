<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.codevigor.com
 * @since      1.0.0
 *
 * @package    Wp_Db_Error_Manager
 * @subpackage Wp_Db_Error_Manager/admin/partials
 */
?>

<?php

	$arrayData = Wp_Db_Error_Manager_Template_Utility::get_settings();
	$imageUrl = $arrayData["imageUrl"];
	$title = $arrayData["title"];
	$description = $arrayData["description"];

?>

<div class="wrap bootstrap-wrapper">

    <h2><?php echo Wp_Db_Error_Manager_Configuration::$PLUGIN_DISPLAY_NAME; ?></h2>

	<div class="hide">
		<input type="hidden" id="redirect_tab" value="<?php echo $_GET["tab"]; ?>">
	</div>    

    <div>

	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist" id="main-tabs">
	    <li role="presentation" class="active"><a href="#choose-design" aria-controls="choose-design" role="tab" data-toggle="tab">Choose your background image</a></li>
	    <li role="presentation"><a id="a-customise-message" href="#customise-message" aria-controls="profile" role="tab" data-toggle="tab">Customise Message</a></li>
	    <li role="presentation"><a id="a-premium" href="#premium" aria-controls="premium" role="tab" data-toggle="tab">PREMIUM FEATURES</a></li>
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">
	    <div role="tabpanel" class="tab-pane active" id="choose-design">
	    	<h4 class='wp-db-error-settings-header'>Choose your background image</h4>
	    	<div class="row wp-db-error-screenshot-container">

	    		<div class="col-sm-12 wp-db-error-custom-image-url">
	    			<div class="col-sm-12 add-margin">
	    				<input type="text" id="txt_custom_image_url" class="form-control" placeholder="Enter a custom image url here" value="<?php echo $imageUrl; ?>" style="margin-left: auto;margin-right: auto;" />
	    			</div>
	    			<div class="col-sm-12 add-margin">
	    				<button class='btn btn-primary' id="cmd-retrieve-custom-image">Retrieve Image</button>
	    			</div>
	    			<div class="col-sm-12 add-margin">

	    			<?php

	    				if($imageUrl != "") {
	    					echo "<img src='$imageUrl' id='img_custom_image_url' class='wp-db-error-screenshot-individual-container' />";
	    				} else {
	    					echo "<img src='' id='img_custom_image_url' class='wp-db-error-screenshot-individual-container hide' />";
	    				}

	    			?>

	    			</div>
	    			
	    			<div class="col-sm-12 add-margin">OR choose a generic image below</div>
	    		</div>
    	
		    	<?php

		    		$templateList = Wp_Db_Error_Manager_Template_Utility::get_template_list();

		    		for($i=0;$i<count($templateList);$i++)
		    		{
		    			$templatePath = get_site_url().$templateList[$i]["image"];
		    			$templateImage = $templateList[$i]["image"];
		    			$templateId = $templateList[$i]["id"];

		    			echo "<div class='col-sm-3 wp-db-error-screenshot-individual-container choose-design' style=\"background-image: url('$templatePath');background-size: cover;\"  data-template-id='$templateId' data-template-image='$templatePath'>";
		    			echo "<a class='choose-design' href='#' data-template-id='$templateId' data-template-image='$templatePath'>";
			    		// echo "<img src='$templatePath' class='wp-db-error-screenshot' />";
			    		echo "</a>";
			    		echo "</div>";
		    		}

		    	?>

		    </div>
	    </div>
	    <div role="tabpanel" class="tab-pane" id="customise-message">
	    	<h4 class='wp-db-error-settings-header'>Customise your message</h4>
	    	<div class="row">
	    		<div class="col-sm-6">
	    			<form>
					  <div class="form-group">
					    <label for="exampleInputEmail1">Title</label>
					    <input type="text" class="form-control update-preview" placeholder="Title" name="title" id="txt_message_title" value="<?php echo $title; ?>">
					  </div>

					  <div class="form-group">
					    <label for="exampleInputEmail1">Description</label>
					    <p class="help-block">(HTML tags are accepted)</p>
					    <textarea class="form-control update-preview wpde-textarea" placeholder="Description" name="description" id="txt_message_description"><?php echo $description; ?></textarea>
					  </div>

					  <div class="form-group">
					  	<div class="bg-danger hide wpde-error-container"></div>
					  </div>

					  <a href="javascript:void(0);" class="btn btn-info" id="btn-generate-preview">Generate Preview</a>
					  <a href="" target="_blank" class="btn btn-link hide" id="preview-link">Click here to preview</a>
					  <button type="button" class="btn btn-primary" id="btn-save-changes">Save Changes</button>
					</form>
	    		</div>
	    		<div class="col-sm-6">
	    			<img src="<?php echo $imageUrl; ?>" class="img-responsive wp-db-error-screenshot-inactive" id="img-choose-message" data-template-id="" />
	    		</div>
	    		<div class="col-sm-12 well wpde-generated_file_content_container hide">
	    			<p>You can follow the following steps to replace or create your custom db error page:</p>
	    			<ol>
	    				<li>Using FTP, connect to your website.</li>
	    				<li>Navigate to your /wp-content/ directory</li>
	    				<li>If the file does not already exist, create a new file called 'db-error.php'</li>
	    				<li>Paste and replace the contents of the file with the following html code in that file:</li>
	    			</ol>
	    			<textarea id="txt_generated_file_contents" class="form-control wpde-textarea"></textarea>
	    		</div>
	    	</div>
	    </div>
	    <div role="tabpanel" class="tab-pane" id="premium">
	    	<h4 class='wp-db-error-settings-header'>PREMIUM SETTINGS</h4>
	    	
	    	<?php

	    		if(Wp_Db_Error_Manager_Auth::isLoggedIn()) {
	    			include_once(Wp_Db_Error_Manager_Configuration::get_admin_partials_folder()."/wp-db-error-manager-premium-display.php");

	    			echo "<input type='hidden' id='get_premium_plan' value='yes'>";

	    		} else {
	    			include_once(Wp_Db_Error_Manager_Configuration::get_admin_partials_folder()."/wp-db-error-manager-login-display.php");
	    		}

	    	?>

	    </div>
	  </div>

	</div>




	<!-- Modal Container -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Modal title</h4>
	      </div>
	      <div class="modal-body">
	        <p>One fine body&hellip;</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary">Save changes</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
    

</div>


