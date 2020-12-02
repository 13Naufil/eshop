<?php echo get_header(); ?>
<div class="main" style="padding-top: 60px;">
<div class="container page-padding">
    <div class="col-sm-12">
        <?php echo show_validation_errors();?>
        <br>
        <br>
        <h4>Your Bag</h4>
        <h4><?php echo number_format($this->catalog->total()->qty); ?> items in your bag</h4>
        <div class="minigap"></div>
        <?php if(count($products) == 0) {?>
        <div class="text-center">
            <h4 class="text-uppercase">Your cart is empty!</h4>
            <a class="btn btn-space" href="<?php echo site_url();?>">CONTINUE SHOPPING</a>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div>
        </div>
    </div>
        <?php }else{ ?>
       <div class="row">
            <div class="col-md-8">
        <form action="<?php echo site_url('cart/update_cart');?>" method="post" id="cart-form">
        <?php
        $total = 0;
        foreach ($products as $product) {
         
         
            $total += ($product->price * $product->qty);
           
           
            ?>
            
            <div class="cart_box">
                <div class="row">
                    <div class="col-sm-2"><img src="<?php echo _img('assets/front/products/' . $product->image, 70, 70); ?>" class="img-responsive" alt=""></div>
                    <div class="col-sm-6">
                        <div style="padding-top: 4px;"></div>
                        <h6><span><strong><?php echo $product->title . '</strong><br><span class="sku">  SKU: ' . $product->sku; ?></span></strong></h5>
                        <p><?php echo $product->short_description;?></p>
                        <small><?php echo $product->attributes;?></small>
                    </div>
                    <div class="col-sm-4">
                        <div style="padding-top: 4px;"></div>
                        <div class="row">
                            
                            <div class="col-sm-8">
                                <h5><?php
                          
          echo CURRENCY . number_format(($product->price * $product->qty), CURRENCY_DECIMALS);
        
        
                                ?></h5>
                            </div>
                            <div class="col-sm-4">
                                <a href="<?php echo site_url('cart/delete_cart/?did=' . $product->did); ?>"> <i style="font-size: 21px;"  class="fa fa-trash-o"></i> </a>
                            </div>
                            <div class="col-sm-12 text-right">
                                <div class="input-group" style="margin-top: -5%; margin-right: 19%;">
                                    <input type="hidden" name="did[<?php echo $product->product_id;?>]" value="<?php echo $product->did;?>">
                                    <input type="number" min="<?php echo $product->min_sale_qty;?>" max="<?php echo $product->max_sale_qty;?>" id="qty_<?php echo $product->product_id;?>" name="qty[<?php echo $product->product_id;?>][<?php echo $product->did;?>]" class="form-control qty" value="<?php echo $product->qty;?>" style="width: 47px; height: 30px;margin-left: 73%;margin-top:1px">
                                    <div class="input-group-addon" style="padding: 0;"><button class="btn" type="submit" style="height:30px;line-height:27px;"><i class="fa fa-refresh"></i></button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
        </form>
  </div>
            <div class="col-md-4" style="margin-top: -5%;">
<div class="gap"></div>
<div class="row">
    <div class="col-sm-12">
        <h4>Discount Codes</h4>
        <div class="minigap"></div>
        <?php
        if ($order->coupon_id > 0){ ?>
            <table class="table" style="border-style: dashed;">
                <tr>
                    <td class="text-center">
                        <br>
                        <a class="pull-right" href="<?php echo site_url('cart/remove_coupon');?>"><i class="fa fa-trash"></i></a>
                        <h1><?php echo $coupon->coupon_code;?></h1>
                    </td>
                </tr>
            </table>
        <?php }else { ?>
            <form id="discount-coupon-form" action="<?php echo site_url('cart/apply_coupon');?>" method="post" class="form-horizontal">
            <div class="-discount">
                <label for="" style="font-weight: normal;">Use Coupon:</label>
                <div class="discount-form">
                    <div class="input-group">
                        <input class="form-control" id="coupon_code" name="coupon_code" value="" placeholder="Enter your coupon code if you have one.">
                        <div class="input-group-addon">
                            <button type="submit" title="Apply Coupon" class="btn btn-default btn-sm" value="USE"> Use
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
     <?php } ?>
    </div>
    <div class="col-sm-12">
        <hr>
        <h4>Delivery Options</h4>
        <div class="minigap"></div>
        <div class="form-group">
            <label for="" style="font-weight: normal;">Delivery type:</label>
            <select name="payment_method" id="payment_method" class="form-control" style="height: 40px;">
                <?php
                $_payment_method = array('CASH ON DELIVERY');
                echo selectBox(array_combine($_payment_method,$_payment_method), '');
                ?>
            </select>
        </div>
        <!--<div class="gap"></div>
        <hr>
        <div class="gap"></div>
        <div class="spend">
            Spend an extra £15.50 to get Free UK Next Day Delivery.
        </div>-->
    </div>
</div>
<div class="gap"></div>
<div class="container total-container">
    <div class="col-md-12 row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6" style='padding:0px'><h4><strong>Subtotal</strong></h4></div>
                <div class="col-sm-6"><h4 class="pull-left"><strong><?php echo ($total == 0 ? ZERO_PRICE : CURRENCY . number_format($total, CURRENCY_DECIMALS)); ?></strong></h4></div>
            </div>
        </div>
    </div>
    <?php if($discount > 0) { ?>
    <div class="col-md-12 row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6"><h4><strong>Discount</strong></h4></div>
                <div class="col-sm-6"><h4 class="pull-left"><strong><?php echo CURRENCY . '-' . number_format($discount, CURRENCY_DECIMALS); ?></strong></h4></div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6"><h4><strong>Delivery Charges</strong></h4></div>
                <div class="col-sm-6"><h4 class="pull-left"><strong>
                            <?php
                            if($shipping_amount == 0){
                                echo 'Free Delivery';
                            }else{
                                echo CURRENCY . number_format($shipping_amount, CURRENCY_DECIMALS);
                            }
                            ?></strong></h4>
                </div>
            </div>
        </div>
    </div>

    <?php if ($shipping_amount != 0){ ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $this->cms->get_block('delivery-cart-message');?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6"><h4><strong>Grand Total</strong></h4></div>
                <div class="col-sm-6"><h4 class="pull-left"><strong><?php echo (($total + $shipping_amount - $discount) == 0 ? ZERO_PRICE : CURRENCY . number_format(($total + $shipping_amount - $discount), CURRENCY_DECIMALS)); ?></strong></h4></div>
            </div>
        </div>
    </div>

    <div class="minigap"></div>
    <div class="row checkoutBtn">
        <div class="col-sm-3 offset-md-3">
            <a href="<?php echo site_url('cart/checkout');?>" class="btn btn-lg fullbtn">Checkout Securely</a>
        </div>
    </div>
</div>

</div>
        </div> 

</div>
        </div> 

<hr>
<?php
}
?>
</div>

<?php echo get_footer(); ?>

<script>
    (function ($) {
        $(document).ready(function () {
            $(document).on('click', '.action-btn', function (e) {
                e.preventDefault();
                var href = $(this).data('href');
                $('#cart-form').attr('action', href);
                $('#cart-form').submit();
            });
        });
    })(jQuery)
</script>