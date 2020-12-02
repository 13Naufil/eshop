<?php
include dirname(__FILE__) . "/includes/head.php";

?>


<body class="full-width page-condensed">

<!-- Login wrapper -->
<div class="login-wrapper" style="<?php echo ($remember_data) ? 'top: 38%;' : '';?>">
    <?php echo show_validation_errors(); ?>
    <br/>
    <div class="popup-header">
        <span class="text-semibold">Reset Your Password</span>
    </div>

    <div class="well">

        <form action="" method="post" class="row-fluid validate" id="validate">
            <div class="form-group  has-feedback">
                <label>Enter New Password</label>
                <input class="form-control validate[required,minSize[6],maxSize[12]]" type="password" name="newpass" placeholder="New Password" id="newpass"/>
                <i class="icon-lock form-control-feedback"></i>
            </div>

            <div class="form-group has-feedback">
                <label>Enter Confirm Password</label>
                <input class="form-control validate[required,equals[newpass]]" type="password" name="confpass" placeholder="Confirm password" id="confpass"/>
                <i class="icon-lock form-control-feedback"></i>
            </div>

            <div class="row form-actions">
                <div class="col-xs-12 text-center">
                    <input type="submit" name="reset" value="Reset Password" class="btn btn-danger btn-block"/>
                </div>
            </div>

        </form>
    </div>
</div>
<?php
include dirname(__FILE__) . "/includes/footer.php";
?>
<!-- /login block -->
<script type="text/javascript">
    $(function () {
        $('#newpass').focus();
        $("#validate").validationEngine('attach', { binded: false });
    })
</script>
