<?php
$product = $_products[0];
$product_url = get_product_url($product);
//echo '<pre>';print_r($parent_url);echo '</pre>';
?>
<div class="col-sm-8 border nopadding" data-eq-height="t-a">
    <div class="-bg-silver">
    <div class=" text-center with-padding relative ">
        <div class="pull-right">
            <img src="<?php echo _img('assets/admin/img/' . $product->brand_logo,150,66);?>" width="150" height="66" alt="<?php echo $product->name; ?>" class="img-responsive">
        </div>
        <div class="clearfix"></div>
        <a title="<?php echo $product->name; ?>" href="<?php echo site_url($product_url); ?>">
            <img src="<?php echo _img('assets/front/products/' . $product->thumb, 330); ?>" width="330" height="330" alt="<?php echo $product->name; ?>" class="img-responsive">
        </a>
    </div>
    </div>
    <div class="bg-silver bottom">
    <div class="with-padding first-accessories">
        <div class="row">
            <div class="col-xs-8">
                <a title="<?php echo $product->name; ?>" href="<?php echo site_url($product_url); ?>">
                    <h3> <?php echo $product->name; ?> </h3>
                </a>

                <p><?php echo get_product_rating($product->id, false); ?></p>
                <br>
                <p><?php echo substr(strip_tags($product->short_description), 0, 150); ?> ...</p>
            </div>
            <div class="col-xs-4 text-center">
                <br>
                <i><?php include "price.temp.php"; ?></i>
                <br>
                <a title="<?php echo $product->name; ?>" href="<?php echo site_url($product_url); ?>" class="btn btn-app">Buy Now</a>
            </div>
        </div>
    </div>
    </div>
    <br>
</div>


<div class="col-sm-4 border" data-eq-height="t-a">
    <div data-eq-height="t-a-2" style="position: relative;">
        <?php
        if(isset($_products[1])){
        $product = $_products[1];
        $product_url = get_product_url($product);
        ?>
        <div class="text-center with-padding relative">
            <div class="left brand-logo">
                <img src="<?php echo _img('assets/admin/img/' . $product->brand_logo, 88); ?>"
                    width="88" alt="<?php echo $product->name; ?>" class="img-responsive">
            </div>
            <a href="<?php echo site_url($product_url); ?>">
                <img src="<?php echo _img('assets/front/products/' . $product->thumb, 180, 180); ?>"
                    width="180" height="180" alt="<?php echo $product->name; ?>" class="img-responsive">
            </a>

        </div>

        <div class="row">
            <div class="col-xs-6">
                <a href="<?php echo site_url($product_url); ?>">
                    <h6> <?php echo $product->name; ?> </h6>
                </a>

                <p><?php echo get_product_rating($product->id, false); ?></p>
            </div>
            <div class="col-xs-6 text-center">
                <i><?php include "price.temp.php"; ?></i>
                <a href="<?php echo site_url($product_url); ?>"
                   class="btn btn-app">Buy Now</a>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>
    <hr class="sm">
    <div data-eq-height="t-a-2" style="position: relative;">
        <?php
        }
        if(isset($_products[2])){
    $product = $_products[2];
    $product_url = get_product_url($product);
    ?>
    <div class="text-center with-padding relative">
        <div class="left brand-logo">
            <img src="<?php echo _img('assets/admin/img/' . $product->brand_logo,88);?>" width="88" alt="<?php echo $product->name; ?>" class="img-responsive">
        </div>
        <a href="<?php echo site_url($product_url); ?>">
            <img src="<?php echo _img('assets/front/products/' . $product->thumb, 180, 180); ?>" width="180" height="180" alt="<?php echo $product->name; ?>" class="img-responsive">
        </a>

    </div>


    <div class="row">
        <div class="col-xs-6">
            <a title="<?php echo $product->name; ?>" href="<?php echo site_url($product_url); ?>">
                <h6> <?php echo $product->name; ?> </h6>
            </a>

            <p><?php echo get_product_rating($product->id, false); ?></p>
        </div>
        <div class="col-xs-6 text-center">
            <i><?php include "price.temp.php"; ?></i>
            <a href="<?php echo site_url($product_url); ?>" class="btn btn-app">Buy Now</a>
        </div>
    </div>

    <?php } ?>
</div>
    <br>
</div>
