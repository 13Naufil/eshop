<?php get_head();
$ci = &get_instance();
$url_ext = get_option('url_ext');

$_home_link = (getUri(1) == 'blog' ? 'blog' : '');
$_logo = (getUri(1) == 'blog' ? get_option('blog_logo') : get_option('logo'));
?>
<style>
    .usermob a:before{
        display:none!important;
    }
</style>
<div class="mobile-nav">
    <nav>
        <ul class="unstyled mainnav pbpx-15">
            <?php
            $menu_config = array(
                'parent_li_start' => '<li id="menu-{id}" class="menu-item-{id}  menu-type-{menu_type} {active_class}"><a href="javascript:void(0)">{title} <span class="xicon icon-angle-down"></span></a>',
                'child_ul_start' => '<ul class="firstlevel unstyled" id="sub-menu-menu">',
            );
            echo get_nav(1, $menu_config); ?>
                 <li id="menu-4439" class="menu-item-4439  menu-type-custom usermob"><a href="<?php echo site_url('customer/account');?>"><i class="fa fa-user"></i> User</a>
</li>
<!--     <li id="menu-4439" class="menu-item-4439  menu-type-custom" style="padding-left:2%;padding-top:4%">-->
<!--     <form action="<?php base_url()?>/search" method="get" class="input-group" role="search">-->
<!--                                        <input type="hidden" name="type" value="product">-->
<!--                                        <input type="text" name="q" value="" style=" width:300px;margin-left:2%;border-radius:50px;" placeholder="Search Here" class="input-group-field front-search">-->
<!--                                        <span class="input-group-btn" style="right:50px!important;">-->
<!--                                                <button type="submit" class="btn front-searchbtn" style=""><i class="fa fa-search"></i></button>-->
<!--                                                </span>-->
<!--                                    </form>-->
<!--</li>-->
        </ul>
    </nav>
</div>
<div id="fixed" class="wrapper-container">
    <style>
        .header_top_table p {
            width: 33.33%;
            float: left;
            margin: 0;
        }
      
      
        .front-search:hover{
            border:1px solid #ff8030;
        }
         .front-search:focus{
            border:1px solid #ff8030;
        }
        @media (max-width: 767px){
.logoMobile {
   
     width: 100%; 
    margin: 0 20px 0 20px;
    text-align: center;
}

#cartToggle{font-size: 24px;padding-top: 0%;padding-right: 10px;color:#ff8030;margin-top:0px;}
}
  @media (min-width: 767px){
#cartToggle{font-size: 24px;padding-top: 49%;padding-right: 10px;color:#ff8030;margin-top:10px}
    .front-searchbtn{
        font-size:18px;background-color:#ff8030;border-radius:50px;border-color:#ff8030;margin-top:6px;outline:none;
    }
     .front-searchbtn:hover{
        font-size:18px;background-color:#ff8030;border-radius:50px;border-color:#ff8030;margin-top:6px;outline:none;
    }
        .front-searchbtn:active{
        font-size:18px;background-color:#ff8030;border-radius:50px;border-color:#ff8030;margin-top:6px;outline:none;
    }
  }
    </style>

    <div class="mobile-nav-btn"> <span class="lines"></span> </div>
    <header class="site-header" role="banner"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <div class="topbar-text1">
            <p>Quality Product, Fast Service</p>
        </div>
        <div class="header-bottom on">
            <div class="header-mobile">
                <!-- end Navigation Mobile  -->
                <div class="logoMobile">
                    <a href="<?php echo site_url($_home_link)?>">
                        <img src="<?php echo asset_url('admin/img/' . $_logo); ?>" alt="<?php echo get_option('site_title');?>"/>
                    </a>
                   
                </div>
            </div>
            <div class="header-panel" style="line-height:70px">
                <div class="top-header-panel">
                    <div class="container">
                        <div class="header-panel-bottom">
                            <div class="topbar-text">
                                <a href="<?php echo site_url($_home_link)?>">
                        <img src="<?php echo asset_url('admin/img/' . $_logo); ?>" style="width:150px;height:60px;margin-top:1px;margin-left:40px" alt="<?php echo get_option('site_title');?>"/>
                    </a>
                            </div>
                             <div class="topbar-text" style="width:50%;padding:.4%">
                                <div class="nav-search on">
                                   
                                    <form action="<?php base_url()?>/search" method="get" class="input-group" role="search">
                                        <input type="hidden" name="type" value="product">
                                        <input type="text" name="q" value="" style=" width:450px;margin-left:50%;border-radius:50px;margin-top:20px;" placeholder="Search Here" class="input-group-field front-search">
                                        <span class="input-group-btn" style="right:-250px!important;">
                                                <button type="submit" class="btn front-searchbtn" style=""><i class="fa fa-search"></i></button>
                                                </span>
                                    </form>
                                </div>
                            </div>
                            <!--<div class="header-panel-top">-->
                            <!--    <div class="nav-search on">-->
                            <!--        <a class="icon-search" href="javascript:;">Search</a>-->
                            <!--        <form action="" method="get" class="input-group search-bar" role="search">-->
                            <!--            <input type="hidden" name="type" value="product">-->
                            <!--            <input type="text" name="q" value="" placeholder="search" class="input-group-field" aria-label="Search Site" autocomplete="off">-->
                            <!--            <span class="input-group-btn">-->
                            <!--                    <input type="submit" class="btn"  value="Search">-->
                            <!--                    </span>-->
                            <!--        </form>-->
                            <!--    </div>-->
                            <!--    <div class="currency"></div>-->
                            <!--</div>-->
                            <ul class="customer-links" style="margin-right: 1%;">
                                <li class="wishlist">
                                    <a href="<?php echo site_url('customer/wishlist');?>">
                                        <i class="fa fa-heart-o" style="color:#ff8030;" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a style="margin-left:10px;" href="<?php echo site_url('customer/account');?>">
                                        <i class="fa fa-user" style="font-size:24px;padding-top: 32%;color:#ff8030;margin-top:18px" aria-hidden="true"></i>
                                    </a>
                                </li>
                                 <li>
                                    <a style="margin-left:10px;" href="">
                                        <i class="fa fa-facebook-square" style="font-size:24px;padding-top: 32%;color:#ff8030;margin-top:18px" aria-hidden="true"></i>
                                    </a>
                                </li>
                                 <li>
                                    <a style="margin-left:10px;" href="">
                                        <i class="fa fa-instagram" style="font-size:24px;padding-top: 32%;color:#ff8030;margin-top:18px" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <!--  <li>-->
                                <!--    <a style="margin-left:10px;" href="https://wa.me/923000704252">-->
                                <!--        <i class="fa fa-whatsapp" style="font-size:24px;padding-top: 32%;color:#ff8030;margin-top:18px" aria-hidden="true"></i>-->
                                <!--    </a>-->
                                <!--</li>-->
                            </ul>
                            <div class="top-header">
                              
                                <div class="wrapper-top-cart">
                                    <p class="top-cart">
                                        <span class="icon">&nbsp;</span>
                                            <i class="fa fa-shopping-cart" id="cartToggle" aria-hidden="true"></i>
                                        <a href="javascript:;" id="cartToggle" style="display:none;">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                            <span id="cartCount"><?php echo number_format($this->catalog->total()->qty); ?></span>
                                        </a>
                                    </p>
                                    <div id="dropdown-cart" style="display:none">
                                        <div class="has-items">
                                            <?php
                                            $order_id = getSession('customer_order_id');
                                            if($order_id > 0) { ?>
                                            <ol class="mini-products-list" style="list-style: none;">
                                                <?php
                                                $products = $this->catalog->cart_detail($order_id);
                                                $total = 0;
                                                foreach ($products as $product) {
                                                $total += ($product->price * $product->qty);
                                                ?>
                                                    <li class="item">
                                                        <a href="<?php echo _img('assets/front/products/' . $product->image, 66, 100); ?>" title="<?php echo $product->name;?>" class="product-image">
                                                            <img src="<?php echo _img('assets/front/products/' . $product->image, 66, 100); ?>" alt="<?php echo $product->name;?>"></a>
                                                        <div class="product-details"><a href="<?php echo site_url('cart/delete_cart/?did=' . $product->did); ?>" title="Remove This Item" style="color: black;font-size: 12px;font-weight: 800;" class="btn-remove">X</a>
                                                            <p class="product-name"><a href="<?php echo _img('assets/front/products/' . $product->image, 66, 100); ?>"><?php echo $product->name;?></a></p>
                                                            <div class="cart-collateral"><?php echo number_format($product->qty); ?> x <span class="price"><span class="money"><?php echo CURRENCY . number_format($product->price, CURRENCY_DECIMALS); ?></span></span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <? } ?>
                                            </ol>
                                            <div class="summary">
                                                <p class="total">
                                                    <span class="label"><span >Total</span>:</span>
                                                    <span class="price"><span class=money><?php echo CURRENCY;?> <?php echo number_format($this->catalog->total()->amount, 2); ?> </span></span>
                                                </p>
                                            </div>
                                            <?php } ?>
                                            <div class="actions">
                                                <a href="<?php echo site_url('cart')?>" class="btn">Check Out & View Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Top Header -->
                        </div>
                    </div>
                </div>
                <div class="bottom-header-panel hidden-xs">
                    <div class="container">
                        <h1 class="header-logo">
                            <a href="<?php echo site_url($_home_link)?>" class=c-beautybay-logo>
                                <img src="<?php echo asset_url('admin/img/' . $_logo); ?>" alt="<?php echo get_option('site_title');?>"/>
                            </a>
                        </h1>
                    </div>
                </div>
            </div>
            <nav class="nav-bar" role="navigation">
             
                <div class="container-fluid">
                    <ul class="site-nav" id="_menuBar" style="margin-left:50px">
                        <?php
                        
                        $menu_config = array(
                            'parent_li_start' => '<li id="menu-{id}" class="menu-item-{id}  menu-type-{menu_type} {active_class} dropdown "><a class="dropdown-toggle" data-toggle="dropdown" href="{href}">{title} <span class="sr-only"></span></a>',
                            'child_ul_start' => '<ul class="site-nav-dropdown">',
                        );
                        echo get_nav(1, $menu_config); ?>
                   

                    </ul>
                </div>
            </nav>
        </div>
    </header>
</div>