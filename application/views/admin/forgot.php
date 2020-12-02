<?php
include dirname(__FILE__) . "/includes/head.php";

?>

<body class="full-width page-condensed">

<!-- Login wrapper -->
<div class="login-wrapper">
    <?php echo show_validation_errors(); ?>
    <br/>
    <form role="form" action="<?php echo admin_url('login/forgot'); ?>" method="post" class="validate">

        <div class="popup-header">
            <span class="text-semibold">Recover Your Password</span>
        </div>

        <div class="well">
            <p>Please enter your email address. You will receive a link to create a new password via email.</p>
            <div class="form-group has-feedback">
                <label>Enter registered email.</label>
                <input class="form-control validate[required,custom[email]]" type="text" name="email" placeholder="Email address" id="email" value="<?php echo set_value('email'); ?>"/>
                <i class="icon-mail-send form-control-feedback"></i>
            </div>
            <br/>
            <div class="row form-actions">
                <div class="col-xs-12 text-center">
                    <button type="submit" name="recover" class="btn btn-danger"><i class="icon-key2"></i> Get New Password</button>
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
        $('#email').focus();
        $("#validate").validationEngine('attach', { binded: false });
    })
</script>
