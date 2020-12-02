<?php echo get_head(); ?>
<?php

$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
if(get_option('paypal_sandbox') == 1){
    $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
}
?>
<form name="form1" action="<?=$paypal_url;?>" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="<?=get_option('paypal_business_email') ; ?>">
    <input type="hidden" name="item_name" value="Shopping from <?=get_option('site_title') ; ?>">
    <input type="hidden" name="item_number" value="<?php echo $order_info->order_number ?>">
    <input type="hidden" name="amount" value="<?php echo $order_info->total_amount; ?>">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="invoice" value="<?php echo $invoice; ?>">
    <input type="hidden" name="custom" value="">
    <input type="hidden" name="currency_code" value="<?=get_option('paypal_currency_code') ; ?>">
    <input type="hidden" name="receiver_email" value="">
    <input type="hidden" name="option_name1" value="">
    <input type="hidden" name="option_selection1" value="">
    <input type="hidden" name="no_note" value="0">
    <input type="hidden" name="return" value="<?php echo site_url('cart/thanks'); ?>">
    <input type="hidden" name="cancel_return" value="<?php echo site_url('customer/logout'); ?>">
    <input type="hidden" name="notify_url" value="<?php echo site_url('cart/notify_url'); ?>">
</form>
</body>
</html>

<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $('form[name=form1]').submit();
        });
    })(jQuery)
</script>