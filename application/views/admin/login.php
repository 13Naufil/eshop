<?php
include dirname(__FILE__) . "/includes/head.php";
?>

<body class="full-width page-condensed">


<!--<div class="admin-logo">
    <div class="thumbnail text-center">
        <img alt="" src="<?php /*echo base_url('assets/admin/img/admin-logo.png');*/?>">
    </div>
</div>-->


<!-- Login wrapper -->
<div class="login-wrapper" style="<?php echo ($remember_data) ? 'top: 38%;' : '';?>">
    <?php echo show_validation_errors(); ?>
    <br/>
    <form role="form" action="<?php echo admin_url('login/do_login'); ?>" method="post" class="validate">
        <input type="hidden" name="reffer" id="reffer" value="<?php echo $this->session->userdata('REFERER');?>"/>

        <div class="popup-header"><a href="#" class="pull-left"><i class="icon-user-plus"></i></a>
            <span class="text-semibold">User Login</span>
        </div>

        <div class="well">
            <?php
            if($remember_data) {
                ?>
                <div class="thumbnail">
                    <div class="thumb"><img alt="" src="<?php echo base_url('assets/admin/img/users/'. $remember_data->photo);?>"></div>
                    <div class="caption text-center">
                    <h6><?php echo $remember_data->first_name . ' ' . $remember_data->last_name;?></h6>
                    </div>
                </div>
                <input class="" type="hidden" name="user_name" id="user_name" value="<?php echo stripslashes($user_name); ?>"/>
            <?php } ?>
            <?php
            if(!$remember_data) {
            ?>
            <div class="form-group has-feedback">
                <label>Username</label>
                <input class="form-control" type="text" name="user_name" placeholder="Username" id="user_name" value="<?php echo stripslashes($user_name); ?>"/>
                <i class="icon-users form-control-feedback"></i>
            </div>
            <?php } ?>
            <div class="form-group has-feedback">
                <label>Password</label>
                <input class="form-control " type="password" name="password" placeholder="Password" value="<?php echo $password; ?>"/>
                <i class="icon-lock form-control-feedback"></i>
            </div>
            <div class="form-group text-center">
                <i class="icon-unlocked"></i>
                <a href="<?php echo admin_url('login/forgot');?>">Forgot password?</a>
            </div>
            <div class="row form-actions">
                <div class="col-xs-6">
                    <div class="checkbox checkbox-success">
                        <label>
                            <input type="checkbox" name="remember" class="styled" value="1" <?= ($remember) ? 'checked' : ''; ?>>
                            Remember me</label>
                    </div>
                </div>
                <div class="col-xs-6">
                    <button type="submit" name="login" class="btn btn-danger pull-right"><i class="icon-key2"></i> Sign in</button>
                </div>
            </div>
        </div>
  </form>
</div>
<!-- /login wrapper -->

<?php
include dirname(__FILE__) . "/includes/footer.php";
?>

<script type="text/javascript">
    $(function () {
        $('#user_name').focus();
    })
</script>