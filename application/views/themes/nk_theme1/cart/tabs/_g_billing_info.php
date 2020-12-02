<?php
/**
 * Developed by Naufil khan.
 * Email: developer.systech@gmail.com
 * Autour: Naufil khan
 * Date: 8/8/2019
 * Time: 12:56 AM
 */

if(is_array($billing)){
    $billing = array2object($billing);
}
?>
<input type="hidden" name="customer_type" id="customer_type" value="guest"/>
<input type="hidden" name="checkout_method" id="checkout_method" value="guest"/>
<input type="hidden" name="billing[password]" id="billing_password" value=""/>

<div class="form-group">
    <div class="col-sm-6">
        <label for="first_name">First Name <span class="mandatory">*</span></label>
        <input type="text" name="billing[first_name]" id="billing_first_name" class="form-control " required value="<?php echo $billing->first_name;?>">
    </div>
    <div class="col-sm-6">
        <label for="last_name">Last Name <span class="mandatory">*</span></label>
        <input type="text" name="billing[last_name]" id="billing_last_name" class="form-control " required value="<?php echo $billing->last_name;?>">
    </div>
</div>
<div class="form-group clearfix">
    <div class="col-sm-6">
        <label for="phone">Phone <span class="mandatory">*</span></label>
        <input type="text" name="billing[phone]" id="billing_phone" class="form-control " required value="<?php echo $billing->phone;?>">
    </div>
    <div class="col-sm-6">
        <label for="email">Email <span class="mandatory">*</span></label>
        <input type="text" name="billing[email]" id="billing_email" class="form-control " required value="<?php echo $billing->email;?>">
    </div>
</div>
<div class="form-group clearfix">
    <div class="col-sm-6">
        <label for="address">Address <span class="mandatory">*</span></label>
        <textarea name="billing[address]" id="billing_address" class="form-control " required cols="30" rows="3"><?php echo $billing->address;?></textarea>
    </div>
    <div class="col-sm-6">
        <label for="city">City <span class="mandatory">*</span></label>
        <br>
        <select name="billing[city]" id="billing_city" class="select-search " required>
            <?php echo get_cities($billing->city); ?>
        </select>
    </div>
</div>
<div class="clearfix"></div>
<?php if(isset($checkout_tabs['shipping_info'])) { ?>
<div class="form-group">
    <div class="col-sm-12">
        <div class="radio">
            <label>
                <input type="radio" name="use_for_shipping" id="use_for_shipping_yes" <?php echo _radiobox($use_for_shipping, '1') . ' ' . (!isset($use_for_shipping) ? 'checked' : '');?> value="1"> Ship to this address
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="use_for_shipping" id="use_for_shipping_no" <?php echo _radiobox($use_for_shipping, '0');?> value="0"> Ship to different address
            </label>
        </div>
    </div>
</div>
<?php } ?>
<div class="form-group">
    <div class="col-sm-6">
        <input type="button" name="btn_1" id="button" class="btn btn-space btn-continue" value="Continue">
    </div>
</div>
