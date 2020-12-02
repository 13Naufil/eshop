<?php echo get_header(); ?>
<div id="main">
    <div class="container">

        <div class="row page-padding">
            <?php echo show_validation_errors();?>
            <div class="col-sm-6">
                <div class="new-customer">
                    <div class="panel panel-default">
                        <div class="panel-heading text-uppercase">New Customers</div>

                        <div class="panel-body">
                            <div class="text-body">
                                <?php echo $this->cms->get_block('customer-new-login');?>
                            </div>

                            <div class="footer">
                                <a href="<?php echo site_url('customer/registration'); ?>" class="btn btn-space">CREATE AN ACCOUNT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="login_container">
                    <div class="panel panel-default">
                        <div class="panel-heading text-uppercase">Registered Customers</div>

                        <div class="panel-body">
                            <div class="text-body">
                                <form id="" name="form1" method="post" action="<?= site_url('customer/login'); ?>" class="col-sm-12">
                                    <input type="hidden" name="checkout" id="checkout" value="<?= $checkout; ?>"/>
                                    <?php
                                    if (!empty($login_error)) {
                                        echo '<p class="alert alert-danger">' . $login_error . '</p>';
                                    }
                                    ?>
                                    <?php echo $this->cms->get_block('customer-login');?>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input name="email" type="text" class="form-control validate[required]" id="l_email" value="" placeholder="Email"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input name="password" type="password" placeholder="Password" class="form-control  validate[required]" id="l_pass" value=""/>
                                    </div>

                                    <div class="footer">
                                        <input type="submit" class="btn btn-space" value="LOGIN">
                                        <span class="pull-right">
                                            <a href="#forget_password_container" id="forget_password_container">Forget password?</a>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="forget_password_container" style="display: none;">
                    <div class="panel panel-default">
                        <div class="panel-heading text-uppercase">Forget Password</div>

                        <div class="panel-body">
                            <form id="" name="form1" method="post" action="<?= site_url('customer/forget'); ?>" class="col-sm-12">
                                <div class="text-body">
                                    <?php echo $this->cms->get_block('customer-login');?>


                                    <input type="hidden" name="checkout" id="checkout" value="<?= $checkout; ?>"/>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input name="email" type="text" class="form-control validate[required]" id="l_email" value="" placeholder="Email"/>
                                    </div>
                                </div>
                                <div class="footer">
                                    <input type="submit" class="btn btn-space" value="Forget" name="forget">
                                    <span class="pull-right">
                                        <a href="#login_container" id="login_container">Login?</a>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

    <script type="text/javascript">
        (function ($) {
            $(document).ready(function () {
                $('#forget_password_container').on('click', function (e) {
                    e.preventDefault();
                    $('.login_container').hide();
                    $('.forget_password_container').show();
                });
                $('#login_container').on('click', function (e) {
                    e.preventDefault();
                    $('.forget_password_container').hide();
                    $('.login_container').show();
                });
            });
        })(jQuery)
    </script>

<?php echo get_footer() ?>