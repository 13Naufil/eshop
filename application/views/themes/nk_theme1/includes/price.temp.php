<?php
$ci = & get_instance();
$product_price = ($ci->catalog->get_product_price($product->id, '', true));
$product_price->symbol = CURRENCY;
?>
        <?php if($product_price->special_price !== '0.00') { ?>
            <span>
                <span class=money>
                    <span class="special-price"><?php echo $product_price->symbol;?> <?php echo number_format($product_price->special_price, CURRENCY_DECIMALS);?> </span>
                    <span class="old-price"><?php echo $product_price->symbol;?> <?php echo number_format($product_price->price, CURRENCY_DECIMALS);?> </span>
                </span>
            </span>
        <?php } else{ ?>
            <span><span class=money><?php echo $product_price->symbol;?> <?php echo number_format($product_price->price, CURRENCY_DECIMALS);?></span></span>
        <?php } ?>