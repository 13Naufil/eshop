<?php
/**
 * Developed by Naufil khan.
 * Email: developer.systech@gmail.com
 * Autour: Naufil khan
 * Date: 8/8/2019
 * Time: 12:56 AM
 */
if(is_array($shipping)){
    $shipping = array2object($shipping);
}
if(empty($shipping->email)){
    $shipping->email = $billing->email;
}
?>
<div class="form-group">
    <div class="col-sm-6">
        <label for="first_name">First Name <span class="mandatory">*</span></label>
        <input type="text" name="shipping[first_name]" id="shipping_first_name" class="form-control " required value="<?php echo $shipping->first_name;?>">
    </div>
    <div class="col-sm-6">
        <label for="last_name">Last Name <span class="mandatory">*</span></label>
        <input type="text" name="shipping[last_name]" id="shipping_last_name" class="form-control " required value="<?php echo $shipping->last_name;?>">
    </div>
</div>
<div class="form-group clearfix">
    <div class="col-sm-6">
        <label for="phone">Phone <span class="mandatory">*</span></label>
        <input type="text" name="shipping[phone]" id="shipping_phone" class="form-control " required value="<?php echo $shipping->phone;?>">
    </div>
    <div class="col-sm-6">
        <label for="email">Email <span class="mandatory">*</span></label>
        <input type="text" name="shipping[email]" id="shipping_email" class="form-control" readonly required value="<?php echo $shipping->email;?>">
    </div>
</div>
<div class="form-group clearfix">
    <div class="col-sm-6">
        <label for="address">Address <span class="mandatory">*</span></label>
        <textarea name="shipping[address]" id="shipping_address" class="form-control " required cols="30" rows="3"><?php echo $shipping->address;?></textarea>
    </div>
    
     <div class="col-sm-6">
        <label for="address">City <span class="mandatory">*</span></label>
       
         <input type="text" name="shipping[city]" id="shipping_city" class="form-control" required>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <input type="button" name="btn_1" id="button" class="btn btn-space btn-continue" value="Continue">
    </div>
</div>
