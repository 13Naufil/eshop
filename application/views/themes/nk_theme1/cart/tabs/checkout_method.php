<div class="row">
    <div class="col-sm-5 col-xs-12">
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <h2 class="text-uppercase text-center">Guest Checkout</h2>
        <div class="row">
            <div class="text-center">
                <input type="button" name="btn_1" id="button" class="btn btn-space btn-guest-continue" value="Continue">
                <!--<form id="" name="form1" method="post" action="<?/*= site_url('customer/login'); */?>" class="validate">
                    <input type="hidden" name="redirect" id="redirect" value="<?php /*echo current_url();*/?>"/>
                    <input type="hidden" name="checkout" id="checkout" value="1"/>
                    <div class="form-group">
                        <label for="l_email">Email address</label>
                        <input name="billing_email" type="email" class="form-control " required id="copy-billing_email" value="" placeholder="Email"/>
                    </div>
                    <div class="form-group">
                        <label for="l_pass">Password</label>
                        <input name="billing_password" type="password" placeholder="Password" required class="form-control required" id="copy-billing_password" value=""/>
                    </div>
                    <div class="form-group text-center">
                        <input type="button" name="btn_1" id="button" class="btn btn-space btn-continue" value="Continue">
                    </div>

                </form>-->
            </div>
        </div>
    </div>
    <div class="col-sm-2 hidden-xs">
        <div class="or-spacer-vertical right">
            <div class="mask"></div>
            <span><strong><i>or</i></strong></span>
        </div>
    </div>
    <div class="col-sm-5 col-xs-12">
        <h2 class="text-uppercase text-center">Existing customer</h2>
        <h5 class="text-uppercase text-center">Enter your account details to continue</h5>
        <p>&nbsp;</p>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <form id="" name="form1" method="post" action="<?= site_url('customer/login'); ?>" class="validate">
                    <input type="hidden" name="redirect" id="redirect" value="<?php echo current_url();?>"/>
                    <input type="hidden" name="checkout" id="checkout" value="1"/>
                    <div class="form-group">
                        <label for="l_email">Email address</label>
                        <input name="email" type="text" class="form-control " id="l_email" value="" placeholder="Email"/>
                    </div>
                    <div class="form-group">
                        <label for="l_pass">Password</label>
                        <input name="password" type="password" placeholder="Password" class="form-control " id="l_pass" value=""/>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" name="submit" id="submit" class="btn btn-space" value="Login">
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>