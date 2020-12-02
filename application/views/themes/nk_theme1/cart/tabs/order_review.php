<?php
/**
 * Developed by Naufil khan.
 * Email: developer.systech@gmail.com
 * Autour: Naufil khan
 * Date: 8/8/2019
 * Time: 12:57 AM
 */

?>
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
