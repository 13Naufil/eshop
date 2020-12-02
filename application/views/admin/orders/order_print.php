<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
include dirname(__FILE__) . "/../includes/head.php";
?>

<style>
    .panel-body {
        padding-top: 0;
    }

    .invoice-header {
        padding-top: 15px;
    }
</style>
<!-- New invoice template -->
<div class="panel <?php echo($order->status == 'Paid' ? 'panel-success' : 'panel-default'); ?>">
    <div class="panel-heading">
        <h6 class=""><i class="icon-coin"></i> invoice #: <?php echo $order->order_number; ?>
            <a class="pull-right" style="" href="javascript: window.print();"><i class="btn icon-print2"></i> Print</a>
        </h6>

        <!--<div class="dropdown pull-right">
            <a href="#" class="dropdown-toggle panel-icon" data-toggle="dropdown"> <i class="icon-cog3"></i> <b class="caret"></b> </a>
            <ul class="dropdown-menu icons-right dropdown-menu-right">
                <li><a href="#"><i class="icon-print2"></i> Print invoice</a></li>
            </ul>
        </div>-->
    </div>
    <div class="panel-body">
        <div class="row invoice-header">
            <table width="100%">
                <tr>
                    <td width="50%">
                        <img src="<?php echo asset_url('admin/img/admin_logo.png'); ?>" alt="<?php echo get_option('site_tile'); ?>">
                    </td>
                    <td width="50%">
                        <ul class="invoice-details">
                            <li>Invoice # <strong class="text-danger"><?php echo $order->order_number; ?></strong></li>
                            <li>Date of Invoice: <strong><?php echo mysql2date($order->created); ?></strong></li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table width="100%">
                <tr>
                    <td width="64%">
                        <h6>Billing Info:</h6>
                        <ul>
                            <li><?php echo $billing->full_name; ?></li>
                            <li><a href="mailto:<?php echo $billing->email; ?>"><?php echo $billing->email; ?></a></li>
                            <?php
                            $address = explode(', ', $billing->full_address);
                            foreach ($address as $add) {
                                echo '<li>' . trim($add) . '</li>';
                            }
                            ?>
                            <li><a href="tel:<?php echo $billing->phone; ?>"><?php echo $billing->phone; ?></a></li>
                        </ul>
                    </td>
                    <td width="34%">
                        <h6>Shipping Info:</h6>
                        <ul>
                            <li><?php echo $shipping->full_name; ?></li>
                            <li><a href="mailto:<?php echo $shipping->email; ?>"><?php echo $shipping->email; ?></a></li>
                            <?php
                            $address = explode(', ', $shipping->full_address);
                            foreach ($address as $add) {
                                echo '<li>' . trim($add) . '</li>';
                            }
                            ?>
                            <li><a href="tel:<?php echo $shipping->phone; ?>"><?php echo $shipping->phone; ?></a></li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Item Image</th>
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
                $tax_amount += ((($ord->price * $ord->tax) / 100) * $ord->qty);
                ?>
                <tr>
                    <td style="width: 100px;">
                        <img src="<?php echo _img('assets/front/products/'.$ord->image,'100','150');?>" alt="<?php echo $ord->name; ?>">
                    </td>
                    <td>
                        <?php echo $ord->name; ?><br>
                        <small><?php echo $ord->attributes; ?></small>
                    </td>
                    <td><?php echo number_format($ord->price, 2); ?></td>
                    <td align="center"><?php echo number_format($ord->qty); ?></td>
                    <td align="center"><?php echo number_format($ord->price * $ord->qty, 2); ?></td>
                </tr>
                <?
            }
            $_total_amount = ($subtotal + $tax_amount);
            ?>

            </tbody>
        </table>
    </div>
    <div class="panel-body">
        <div class="row invoice-payment">
            <div class="col-sm-8">
                <!--<h6>Payment method:</h6>-->

            </div>
            <div class="col-sm-4">
                <table class="table">
                    <tbody>
                    <tr>
                        <th class="text-right">Subtotal:</th>
                        <td class="text-right" width="120"><?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                    <!--<tr>
                  <th>Tax:</th>
                  <td class="text-right"><?php /*echo number_format($tax_amount,2);*/ ?></td>
                </tr>-->
                    <tr>
                        <th class="text-right">Delivery Charges:</th>
                        <td align="right" class="text-right">
                                <?php
                                if ($order->shipping_amount == 0) {
                                    echo 'Free Delivery';
                                } else {
                                    echo number_format($order->shipping_amount, 2);
                                }
                                ?>
                            </td>
                    </tr>
                    <?php if ($order->discount > 0) { ?>
                        <tr>
                            <th class="text-right">Discount:</th>
                            <td align="right">-<?php echo number_format($order->discount, 2); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th class="text-right">Total:</th>
                        <td class="text-right text-danger"><h6><?php echo number_format($order->total_amount, 2); ?></h6></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <?php
        if (!empty($order->note)) {
            ?>
            <h6>Notes &amp; Information:</h6>
            <?php
            echo $order->note;
        }
        ?>
    </div>
</div>
<!-- /new invoice template -->
<script>
    window.print();
</script>