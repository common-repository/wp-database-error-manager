<div class="row">
    <div class="col-sm-12" id="premium_settings_results">
    </div>
    <div class="col-sm-6 hide" id="premium_settings_warning">
        <p class="alert alert-warning">Currently, you do not have any active premium plan. Click on the button below to subscribe.</p>
        <a href="<?php echo Wp_Db_Error_Manager_Configuration::get_premium_plan_url(); ?>" class="btn btn-primary" target="_blank">Subscribe to Premium</a>
        <button class="btn btn-info" id="cmd_check_premium">Check again</button>

    </div>
    <div class="col-sm-12 hide" id="premium_settings_container">
        <div class="col-sm-6">
            <div class="checkbox wpde-checkbox">
                <label>
                    <input type="checkbox" id="ch_enable_automated_check" /> Enable automated check
                </label>
                <p class="help-block">Automated checks are done every 5 minutes to check if there is a database connection error. This is useful in order to get notifications of these errors before your users do.</p>
            </div>
            <div class="form-group">
                <div class="hide result-premium-settings"></div>
            </div>
            <button type="button" class="btn btn-primary" id="cmd_save_premium_settings">Save Changes</button>
            &nbsp;&nbsp;
            <button type="button" class="btn btn-danger" id="cmd_logout">LOG OUT</button>
        </div>
        <div class="col-sm-6">
            <div class="jumbotron">
                <p>Click here to consult the control panel and manage all your websites.</p>
                <p>
                    <a class="btn btn-info btn-lg" target="_blank" href="<?php echo Wp_Db_Error_Manager_Configuration::$STATS_URL; ?>" role="button">View Stats</a>
                </p>
            </div>
        </div>
    </div>
</div>