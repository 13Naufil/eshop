<?php
/**
 * Developed by Naufil khan.
 * Email: developer.systech@gmail.com
 * Autour: Naufil khan
 * Date: 8/8/2019
 * Time: 12:57 AM
 */

?>

<div class="row">
    <div class="col-sm-12">
        <div class="text-center">
            <h3><?php echo $shipping_dtl['title'];?></h3>
            <p>Shipping Cahrges: <?php echo number_format($shipping_dtl['amount']);?></p>
            <input type="hidden" name="payment_method" id="payment_method" value="COD"/>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-6">
        <input type="button" name="btn_1" id="button" class="btn btn-success btn-continue" value="Continue">
    </div>
</div>