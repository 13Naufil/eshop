<?php
/**
 * Developed by Naufil khan.
 * Email: developer.systech@gmail.com
 * Autour: Naufil khan
 * Date: 9/5/2019
 * Time: 9:33 PM
 */
 
?>
<style>
    .table {
      width: 100%;
      max-width: 100%;
      margin-bottom: 20px;
        font-size: 12px;;
    }
    .table-bordered {
      border: 1px solid #ddd;
    }
    .table-bordered > thead > tr > th,
    .table-bordered > tbody > tr > th,
    .table-bordered > tfoot > tr > th,
    .table-bordered > thead > tr > td,
    .table-bordered > tbody > tr > td,
    .table-bordered > tfoot > tr > td {
      border: 1px solid #ddd;
      padding: 5px;
    }
    .table-bordered > thead > tr > th,
    .table-bordered > thead > tr > td {
      border-bottom-width: 2px;
    }
    .table-striped > tbody > tr:nth-child(odd) > td,
    .table-striped > tbody > tr:nth-child(odd) > th {
      background-color: #f9f9f9;
    }
</style>
<div class="table-responsive">
    <table class="table table-striped table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th>Item name</th>
            <th width="120">Item Price</th>
            <th width="100">Quantity</th>
            <th width="120">Total</th>
        </tr>
        </thead>
        <tbody id="product-list">
        <?php
        $subtotal = $tax_amount = $_total_amount = 0;
        foreach ($order_detail as $ord) {

            $ord->qty = (!empty($ord->qty) ? $ord->qty : 1);
            $subtotal += ($ord->price * $ord->qty);
            //$tax_amount += ((($ord->price * $ord->tax) / 100) * $ord->qty);
            ?>
            <tr>
                <td><?php echo $ord->name; ?></td>
                <td><?php echo ($ord->price == 0 ? ZERO_PRICE : CURRENCY . number_format($ord->price, CURRENCY_DECIMALS)); ?></td>
                <td align="center"><?php echo number_format($ord->qty); ?></td>
                <td align="center"><?php echo ($ord->price * $ord->qty == 0 ? ZERO_PRICE : CURRENCY  . number_format($ord->price * $ord->qty, CURRENCY_DECIMALS)); ?></td>
            </tr>
            <?
        }
        $_total_amount = ($subtotal + $tax_amount);
        ?>

        </tbody>
    </table>
</div>
<div class="panel-body" style="float: right;">
    <table class="table" width="">
        <tbody>
        <!--<tr>
              <th>Tax:</th>
              <td class="text-right"><?php /*echo number_format($tax_amount,2);*/ ?></td>
            </tr>-->
        <tr>
            <td align="right"><h4>Delivery Charges:</h4></td>
            <td align="right" class="text-right text-danger"><h4>
                    <?php
                    if($shipping_amount == 0){
                        echo 'Free Delivery';
                    }else{
                        echo CURRENCY . number_format($shipping_amount, CURRENCY_DECIMALS);
                    }
                    ?>
                </h4></td>
        </tr>
        <?php if($discount > 0) { ?>
            <tr>
                <td align="right"><h4>Discount:</h4></td>
                <td align="right"><h4><?php echo CURRENCY . '-' . number_format($discount, CURRENCY_DECIMALS); ?></h4></td>
            </tr>
        <?php }  ?>
        <tr>
            <td align="right"><h4>Total:</h4></td>
            <td align="right" class="text-danger"><h4><?php echo ($total_amount == 0 ? ZERO_PRICE : CURRENCY . number_format($total_amount, CURRENCY_DECIMALS)); ?></h4></td>
        </tr>
        </tbody>
    </table>
</div>

