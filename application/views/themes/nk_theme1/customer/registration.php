<?php echo get_header() ?>
<div id="main">
    <div class="container">
        <div class="page-padding">
        <div class="col-sm-6 col-sm-offset-3">
            <?php
            echo show_validation_errors();
            if (!empty($captcha_error)) {
                echo '<div class="alert alert-error ">' . $captcha_error . '</div>';
            }
            ?>

            <h1 class="text-center">Register an Account</h1>
            <hr class="sm">
            <div class="minigap"></div>
            <?php echo $this->cms->get_block('registration-header');?>
            <form id="registration" method="post" action="<?php echo site_url('customer/registration'); ?>" class="validate form-horizontal">
                <div class="form-group">
                    <label for="name">First Name:</label>
                    <input type="text" name="first_name" value="<?php echo $row->first_name;?>" class="form-control validate[required]">
                </div>

                <div class="form-group">
                    <label for="name">Last Name:</label>
                    <input type="text" name="last_name" value="<?php echo $row->last_name;?>" class="form-control validate[required]">
                </div>

                <!--<div class="form-group">
                    <label for="name">Country:</label><br>
                    <select class="select-search validate[required]" name="country" id="country">
                        <?php
/*                        if($row->country == '') $row->country = 'Pakistan';
                        echo selectBox("SELECT countryName, countryName AS country FROM countries", $row->country);*/?>
                    </select>
                </div>-->

                <div class="form-group">
                    <label for="name">City:</label><br>
                    <select class="select-search validate[required]" name="city" id="city">
                        <?php echo get_cities($row->city); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Zip Code:</label>
                    <input type="text" name="zip_code" class="form-control" value="<?php echo $row->zip_code;?>">
                </div>

                <div class="form-group">
                    <label for="name">Phone:</label>
                    <input type="text" name="phone" class="form-control validate[required]" value="<?php echo $row->phone;?>">
                </div>

                <div class="form-group">
                    <label for="name">Address:</label>
                    <input type="text" name="address" class="form-control validate[required]" value="<?php echo $row->address;?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" class="form-control validate[required,custom[email]]" value="<?php echo $row->email;?>">
                </div>

                <div class="form-group">
                    <label for="email">Password:</label>
                    <input type="password" id="password" name="password" class="form-control validate[required,minSize[6],maxSize[12]" value="<?php echo $row->password;?>">
                </div>

                <div class="form-group">
                    <label for="email">Confirm Password:</label>
                    <input type="confirm_password" name="confirm_password" class="form-control validate[required,confirm[password]]" value="<?php echo $row->confirm_password;?>">
                </div>

                <div class="form-group">
                    <label for="email">Gender:</label>
                    <select class="form-control" name="gender">
                        <?php
                        $_OP = array('Male', 'Female');
                        echo selectBox(array_combine($_OP, $_OP), $row->gender);?>
                    </select>
                </div>

                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="newsletter" value="1" <?php echo _checkbox($row->newsletter, 1);?>>
                        Signup for newsletter
                    </label>
                </div>

                <?php echo $this->cms->get_block('registration-footer');?>
                <div class="clearfix"></div>
                <div class="minigap"></div>
                <button type="submit" class="btn btn-success btn-lg text-center">Create Account</button>
            </form>
        </div>
        </div>
    </div>
</div>
<?php echo get_footer() ?>