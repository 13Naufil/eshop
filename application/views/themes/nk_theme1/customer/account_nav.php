<?php
$c_nav = getUri(2);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">MY ACCOUNT</h3>
    </div>

    <div class="panel-body">
        <ul class="left-nav">
            <li class="<?php echo ($c_nav == 'account' ? 'current' : '');?>"><a href="<?php echo site_url('customer/account'); ?>">Account Information</a></li>
            <li class="<?php echo ($c_nav == 'orders' ? 'current' : '');?>"><a href="<?php echo site_url('customer/orders'); ?>">My Orders</a></li>
            <li class="<?php echo ($c_nav == 'wishlist' ? 'current' : '');?>"><a href="<?php echo site_url('customer/wishlist'); ?>">My Wishlist</a></li>
            <!--<li><a href="<?php /*echo site_url('customer/account/edit'); */?>">Account Information</a></li>
            <li><a href="<?php /*echo site_url('customer/address'); */?>">Address Book</a></li>
            <li><a href="<?php /*echo site_url('customer/reviews/product'); */?>">My Product Reviews</a></li>
            <li><a href="<?php /*echo site_url('customer/tags/product');*/?>">My Tags</a></li>
            <li><a href="<?php /*echo site_url('customer/subscription');*/?>">Newsletter Subscriptions</a></li>-->
        </ul>
    </div>
</div>