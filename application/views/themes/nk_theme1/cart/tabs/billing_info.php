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

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
<input type="hidden" name="customer_type" id="customer_type" value="customer"/>
<input type="hidden" name="checkout_method" id="checkout_method" value="customer"/>
<input type="hidden" name="billing[password]" id="billing_password" value=""/>

<div class="form-group clearfix">
    <div class="col-sm-12">
        <label for="first_name">Name <span class="mandatory">*</span></label>
        <input type="text" name="billing[first_name]" id="billing_first_name" class="form-control " required value="<?php echo $billing->first_name;?>">
        <input type="hidden" name="billing[last_name]" id="billing_last_name" class="form-control " required value="<?php echo $billing->last_name;?>.">
    </div>
   
</div>
<div class="form-group clearfix">
    <div class="col-sm-6">
        <label for="email">Email <span class="mandatory">*</span></label>
        <input type="text" name="billing[email]" id="billing_email" class="form-control " required value="<?php echo $billing->email;?>">
    </div>
    <div class="col-sm-6">
        <label for="phone">Password <span class="mandatory">*</span></label>
        <input type="password" name="billing[password]" id="billing_password" class="form-control " required value="<?php echo $billing->password;?>">
    </div>
</div>
<div class="form-group clearfix">
    <div class="col-sm-6">
        <label for="phone">Phone <span class="mandatory">*</span></label>
        <input type="text" name="billing[phone]" id="billing_phone" class="form-control " required value="<?php echo $billing->phone;?>">
    </div>
      <div class="col-sm-6">
        <label for="address">City <span class="mandatory">*</span></label>
       
         <input type="text" name="shipping[city]" id="shipping_city" class="form-control" required>
    </div>
</div>


<div class="form-group clearfix">
    <div class="col-sm-12">
        <label for="address">Address <span class="mandatory">*</span></label>
        <textarea name="billing[address]" id="billing_address" class="form-control " required cols="30" rows="3"><?php echo $billing->address;?></textarea>
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
</div>
    <div class="col-lg-6 col-md-6 col-sm-12">
<div class="col-sm-12">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-cart">
            <thead>
            <tr>
                <th>PRODUCT NAME</th>
                <th width="120">UNIT PRICE</th>
                <th width="100">QUANTITY</th>
                <th width="120">TOTAL</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $total = 0;
                foreach ($products as $product) {
                    $total += ($product->price * $product->qty);
                    ?>
                    <tr>
                        <td class="">
                            <h6><?= $product->title . ' - SKU: ' . $product->sku; ?></h6>
                            <small><?php echo $product->attributes;?></small>
                        </td>
                        <td class="text-center"><strong class="price"><?php echo CURRENCY . number_format($product->price, CURRENCY_DECIMALS); ?></strong></td>
                        <td class="text-center"><?php echo number_format($product->qty);?></td>
                        <td class="text-center"><strong class="price"><?php echo CURRENCY . number_format(($product->price * $product->qty), CURRENCY_DECIMALS); ?></strong></td>
                    </tr>
                    <?
                }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Delivery Charges: &nbsp;</strong></td>
                <td class="text-center">
                    <strong>
                        <?php
                        if($shipping_amount == 0){
                            echo 'Free Delivery';
                        }else{
                            echo CURRENCY . number_format($shipping_amount, CURRENCY_DECIMALS);
                        }
                        ?>
                    </strong>
                </td>
            </tr>
            <?php if($discount > 0) { ?>
            <tr>
                <td colspan="3" class="text-right"><strong>Discount: &nbsp;</strong></td>
                <td class="text-center">
                    <strong>-<?php echo CURRENCY . number_format($discount, CURRENCY_DECIMALS); ?></strong>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="3" class="text-right"><strong>Total: &nbsp;</strong></td>
                <td class="text-center">
                    <strong style="color: red;"><?php echo CURRENCY . number_format(($total + $shipping_amount - $discount), CURRENCY_DECIMALS); ?></strong>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>


<!--<div class="col-sm-offset-8 col-sm-4 text-right">
    <select name="payment_method" id="payment_method" class="form-control pull-right">
        <?php
/*        $_payment_method = array('CASH ON DELIVERY');
        echo selectBox(array_combine($_payment_method,$_payment_method), '');
        */?>
    </select>
</div>-->
<p>&nbsp;</p>

<div class="form-group">
    <div class="col-sm-12 text-right">
        <button type="submit" name="submit" id="button" class="btn btn-space"><span>CONFIRM ORDER</span></button>
    </div>
</div>
</div>
</div>