<?php echo get_header() ?>
<div id="main">
    <div class="container">
        <div class="row page-customer-reset page-padding">
            <?php echo show_validation_errors();?>

            <div class="col-sm-6 col-sm-offset-3">

                <div class="panel panel-default">
                    <div class="panel-heading text-uppercase">Reset Password</div>

                    <div class="panel-body">
                        <form id="" name="form1" method="post" action="" class="col-sm-12">
                            <div class="text-body">
                                <?php echo $this->cms->get_block('customer-reset');?>

                                <div class="form-group">
                                    <label for="newpass">New Password</label>
                                    <input name="newpass" type="password" class="form-control validation[required]" id="newpass" value="" placeholder="New Password"/>
                                </div>
                                <div class="form-group">
                                    <label for="confpass">Confirm Password</label>
                                    <input name="confpass" type="password" class="form-control validation[required]" id="confpass" value="" placeholder="Confirm Password"/>
                                </div>

                            </div>
                            <div class="footer">
                                <input type="submit" class="btn btn-app2" value="Submit" name="reset">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<?php echo get_footer() ?>