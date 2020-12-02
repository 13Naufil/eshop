<?php echo get_header() ?>
<div id="main">
    <div class="bg-container page-padding">
    <div class="container page-content">
        <div class="row">
            <div class="col-sm-3">
                <?php
                include "account_nav.php";
                ?>
            </div>
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">EDIT ACCOUNT INFORMATION</h3>
                    </div>
                    <div class="panel-body">
                        <form id="valid_form" name="form1" method="post"
                              action="<?= site_url('customer/registration'); ?>"
                              class="validate form-horizontal">
                            <input type="hidden" name="edit" id="edit" value="1"/>
                            <input type="hidden" name="redirect" id="redirect" value="<?php echo current_url();?>"/>
                            <?php
                            echo show_validation_errors();
                            if (!empty($captcha_error)) {
                                echo '<div class="alert alert-error ">' . $captcha_error . '</div>';
                            }
                            ?>
                            <fieldset>
                                <legend>Personal Information</legend>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="first_name">First Name <span class="mandatory">*</span></label>
                                        <input type="text" name="first_name" id="first_name"
                                               class="form-control validate[required]"
                                               value="<?php echo $row->first_name; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="last_name">Last Name <span class="mandatory">*</span></label>
                                        <input type="text" name="last_name" id="last_name"
                                               class="form-control validate[required]"
                                               value="<?php echo $row->last_name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="company">Company</label>
                                        <input type="text" name="company" id="company" class="form-control"
                                               value="<?php echo $row->company; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email">Email <span class="mandatory">*</span></label>
                                        <input type="text" name="email" id="email" disabled
                                               class="form-control validate[required,custom[email]]"
                                               value="<?php echo $row->email; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="address">Address <span class="mandatory">*</span></label>
                                        <input type="text" name="address" id="address"
                                               class="form-control validate[required]"
                                               value="<?php echo $row->address; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="city">City <span class="mandatory">*</span></label>
                                        <select name="city" id="city" class="select-search " required>
                                            <option value="Karachi">Karachi</option>
                                            <option value="Lahore">Lahore</option>
                                            <option value="Islamabad">Islamabad</option>
                                            <option value="Rawalpindi">Rawalpindi</option>
                                            <option disabled="">-----</option>
                                            <?php
                                            $billing->city = (!empty($billing->city) ? $billing->city : 'Karachi');
                                            echo selectBox('SELECT city, city AS city_name FROM cities ORDER BY `city`', $row->city);?>
                                        </select>

                                    </div>
                                    <div class="col-sm-6">
                                        <label for="state">State/Province </label>
                                        <input type="text" name="state" id="state" class="form-control" value="<?php echo $row->state; ?>">
                                        <!--<select name="state" id="state" class="form-control validate[required]">
                                            <option value="">Please select region, state or province</option>
                                        </select>-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="zip">Zip/Postal Code </label>
                                        <input type="text" name="zip" id="zip" class="form-control"
                                               value="<?php echo $row->zip; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="country">Country </label>
                                        <select name="country" id="country" class=" select-search">
                                            <option value="">Please select region, state or province</option>
                                            <?php
                                            $billing->country = (!empty($billing->country) ? $billing->country : 'Pakistan');
                                            echo selectBox("SELECT countryName, countryName AS country FROM `countries`", $billing->country); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="phone">Telephone <span class="mandatory">*</span></label>
                                        <input type="text" name="phone" id="phone"
                                               class="form-control validate[required]"
                                               value="<?php echo $row->phone; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="fax">Fax</label>
                                        <input type="text" name="fax" id="fax" class="form-control"
                                               value="<?php echo $row->fax; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-success">Submit</button>
                            <span class="pull-right mandatory">
                                * Required Fields
                            </span>
                                </div>

                            </fieldset>

                            <fieldset>
                                <legend><input type="checkbox" name="change_pass" id="change_pass" value="1" class="">
                                    Change
                                    Password
                                </legend>

                                <div class="hide pass-change">
                                    <!--<div class="form-group">
                                <div class="col-sm-6">
                                    <label for="current_password">Current Password <span class="mandatory">*</span></label>
                                    <input type="password" name="current_password" id="current_password" class="form-control validate[required,min[6],max[12]]" value="<?php /*//echo $row->password;*/ ?>">
                                </div>
                            </div>-->

                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label for="password">Password <span class="mandatory">*</span></label>
                                            <input type="password" name="password" id="password"
                                                   class="form-control validate[required,minSize[6],maxSize[12]]"
                                                   value="<?php //echo $row->password;?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="confirm_password">Confirm Password <span
                                                    class="mandatory">*</span></label>
                                            <input type="password" name="confirm_password" id="confirm_password"
                                                   class="form-control validate[required,equals[password]]"
                                                   value="<?php echo $row->confirm_password; ?>">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <p>&nbsp;</p>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <script>
        (function ($) {
            $(document).ready(function () {
                $('#current_password,#password, #confirm_password').attr('disabled', true);

                $(document).on('change', '#change_pass', function () {
                    if ($(this).is(':checked')) {
                        $('.pass-change').removeClass('hide');
                        $('#current_password,#password, #confirm_password').attr('disabled', false);
                    } else {
                        $('.pass-change').addClass('hide');
                        $('#current_password,#password, #confirm_password').attr('disabled', true);
                    }
                });
            });
        })(jQuery)
    </script>

<?php echo get_footer() ?>