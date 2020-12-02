<!--contact-block-->
<div class="row">
    <div class=" col-sm-6 col-sm-offset-3 col-xs-12">
    <?php echo $this->session->flashdata('contact_error'); ?>
    </div>
</div>
<p class="text-center">Please fulfil the required fields.</p>
<form action="<?php echo site_url('do_contact');?>" class="validate" method="post">
    <div class="row">
        <div class=" col-sm-3 col-sm-offset-3 col-xs-12">
            <input type="text" name="name" value="" placeholder="Name" class="form-control validate[required]"/>
        </div>
        <div class=" col-sm-3 col-xs-12">
            <input type="text" name="email" value="" placeholder="Email" class="form-control validate[required,custom[email]]"/>
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-6 col-sm-offset-3 col-xs-12">
            <input type="text" name="phone" value="" placeholder="Contact Number (optional)" class="form-control"/>
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-6 col-sm-offset-3 col-xs-12">
            <select name="country" id="country" class="select-search">
                <option value="">Select Your Country</option>
                <?php

                echo selectBox("SELECT currencyCode,countryName FROM countries", 'PKR');
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-6 col-sm-offset-3 col-xs-12">
            <input type="text" name="city" value="" placeholder="City" class="form-control validate[required]"/>
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-6 col-sm-offset-3 col-xs-12">
            <input type="text" name="subject" value="" placeholder="Subject" class="form-control validate[required]"/>
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-6 col-sm-offset-3 col-xs-12">
            <textarea name="message" id="message" cols="30" rows="10" placeholder="Type your message here" class="form-control validate[required]"></textarea>
        </div>
    </div>
    <div class="row">
        <div class=" col-sm-6 col-sm-offset-3 col-xs-12 text-center">
            <input type="submit" value="Submit" class="round-btn"/>
        </div>
    </div>
</form>

<!--contact-block-->

