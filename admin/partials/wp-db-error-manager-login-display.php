<div class="row">
    <div class="col-sm-12">
        <p class="alert alert-info">
            
            <?php

                $email = "";

                if(isset($_GET["activation"]) && $_GET["activation"] == "done") {
                    echo "You have successfully registered. Please login to proceed.";
                } else {
                    echo "You need to register or login to be able to use the PREMIUM FEATURES.";
                }

                if(isset($_GET["email"])) {
                    $email = $_GET["email"];
                }

            ?>
        </p>
    </div>
    <div class="col-sm-6 wpde-login-container">
        <h3>Login</h3>
        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="text" class="form-control" placeholder="Email" name="email" id="txt_email" value="<?php echo $email; ?>">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Password</label>
                <input type="password" class="form-control" placeholder="Password" name="password" id="txt_password" value="">
            </div>

            <div class="form-group">
                <div class="hide result-container-login"></div>
            </div>

            <div id="login_container">
                <button type="button" class="btn btn-primary" id="cmd_login">Login</button>
                <!-- <a href="javascript:void(0);" class="btn btn-link" id="">Forgot Password?</a> -->
            </div>
        </form>
    </div>
    <div class="col-sm-6 wpde-login-container">
        <h3>Register</h3>
        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="text" class="form-control" placeholder="Email" name="email" id="txt_email_reg" value="">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Password</label>
                <input type="password" class="form-control" placeholder="Password" name="password" id="txt_password_reg" value="">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Confirm Password</label>
                <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="txt_confirm_password_reg" value="">
            </div>

            <div class="form-group">
                <div class="hide result-container-register"></div>
            </div>

            <button type="button" class="btn btn-primary" id="cmd_register">Register</button>
        </form>
    </div>
</div>