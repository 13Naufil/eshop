<?php
/**
 * Developed by Naufil khan.
 * Email: developer.systech@gmail.com
 * Autour: Naufil khan
 * Date: 8/8/2019
 * Time: 12:56 AM
 */
?>
<input type="hidden" name="<?=$address_type;?>[id]" id="<?=$address_type;?>_id" value=""/>
<div class="form-group">
    <div class="col-sm-6">
        <label for="first_name">First Name <span class="mandatory">*</span></label>
        <input type="text" name="<?=$address_type;?>[first_name]" id="<?=$address_type;?>_first_name" class="form-control validation[required]" value="<?php echo $address_type->first_name;?>">
    </div>
    <div class="col-sm-6">
        <label for="last_name">Last Name <span class="mandatory">*</span></label>
        <input type="text" name="<?=$address_type;?>[last_name]" id="<?=$address_type;?>_last_name" class="form-control validation[required]" value="<?php echo $address_type->last_name;?>">
    </div>
</div>
<!--<div class="form-group">-->
<!--    <div class="col-sm-6">-->
<!--        <label for="company">Company</label>-->
<!--        <input type="text" name="<?=$address_type;?>[company]" id="<?=$address_type;?>_company" class="form-control" value="<?php echo $address_type->company;?>">-->
<!--    </div>-->
<!--    <div class="col-sm-6">-->
        <!--<label for="email">Email <span class="mandatory">*</span></label>
        <input type="text" name="<?=$address_type;?>[email]" id="<?=$address_type;?>_email" class="form-control validation[required,custom[email]]" value="<?php /*echo $address_type->email;*/?>">-->
<!--    </div>-->
<!--</div>-->
<div class="form-group">
    <div class="col-sm-12">
        <label for="address">Address <span class="mandatory">*</span></label>
        <input type="text" name="<?=$address_type;?>[address]" id="<?=$address_type;?>_address" class="form-control validation[required]" value="<?php echo $address_type->address;?>">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="city">City <span class="mandatory">*</span></label>
        <input type="text" name="<?=$address_type;?>[city]" id="<?=$address_type;?>_city" class="form-control validation[required]" value="<?php echo $address_type->city;?>">
    </div>
    <div class="col-sm-6">
        <label for="state">State/Province <span class="mandatory">*</span></label>
        <input type="text" name="<?=$address_type;?>[state]" id="<?=$address_type;?>_state" class="form-control validation[required]" value="<?php echo $address_type->state;?>">
        <!--<select name="<?=$address_type;?>[state]" id="<?=$address_type;?>_state" class="form-control validation[required]">
            <option value="">Please select region, state or province</option>
        </select>-->
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="zip">Zip/Postal Code <span class="mandatory">*</span></label>
        <input type="text" name="<?=$address_type;?>[zip]" id="<?=$address_type;?>_zip" class="form-control validation[required]" value="<?php echo $address_type->zip;?>">
    </div>
    <div class="col-sm-6">
        <label for="country">Country <span class="mandatory">*</span></label>
        <select name="<?=$address_type;?>[country]" id="<?=$address_type;?>_country" class="validation[required] form-control">
            <option value="">- Select -</option>
            <?php echo selectBox("SELECT countryName, countryName AS country FROM `countries`", $address_type->country);?>
        </select>
    </div>
</div>
<div class="clearfix"></div>
<div class="form-group">
    <div class="col-sm-6">
        <label for="phone">Telephone <span class="mandatory">*</span></label>
        <input type="text" name="<?=$address_type;?>[phone]" id="<?=$address_type;?>_phone" class="form-control validation[required]" value="<?php echo $address_type->phone;?>">
    </div>
    <div class="col-sm-6">
        <label for="fax">Fax</label>
        <input type="text" name="<?=$address_type;?>[fax]" id="<?=$address_type;?>_fax" class="form-control" value="<?php echo $address_type->fax;?>">
    </div>
</div>
 <div class="form-actions text-right">
                                <input type="submit" value="Save" class="btn btn-success col-sm-12">
                            </div>
