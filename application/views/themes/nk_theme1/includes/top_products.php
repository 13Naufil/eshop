<div class="col-sm-6 border">
    <div class="row bg-silver top-search">
        <div class="col-sm-8 col-xs-12 nopadding" data-eq-height="top-cus-srh">
            <a href="<?php echo site_url($product_url); ?>">
                <img src="<?php echo _img('assets/front/products/' . $product->thumb); ?>" alt="<?php echo $product->name; ?>" class="img-responsive">
            </a>
        </div>
        <div class="col-sm-4 col-xs-12 text-right" data-eq-height="top-cus-srh">
            <img src="<?php echo _img('assets/admin/img/' . $product->brand_logo);?>" alt="<?php echo $product->name; ?>" class="img-responsive">

            <div class="bottom" style="width: auto;">
                <a href="<?php echo site_url($product_url); ?>">
                    <h3> <?php echo $product->name; ?> </h3>
                </a>
                <i class=""><?php include "price.temp.php"; ?></i>
                <p><?php echo get_product_rating($product->id, false); ?></p>
            </div>
        </div>
    </div>
    <div class="">
        <?php
        if (count($attributes) > 0) {
            echo '<ul class="highlights-list">';
            foreach ($attributes as $listing_attr) {
                if($listing_attr->used_in_product_listing != 'Yes') continue;
                ?>
                <li class="">
                    <div class="text-center">
                        <img src="<?php echo asset_url('admin/img/' . $listing_attr->attribute_img);?>" alt="<?php echo $listing_attr->attr_label;?>">
                    </div>
                    <div class="bottom">
                        <h4><?php echo $listing_attr->attr_value;?></h4>
                        <div><?php echo $listing_attr->attr_label;?></div>
                    </div>
                </li>
                <?
            }
            echo '</ul>';
        }
        ?>
    </div>
    <a href="<?php echo site_url($product_url); ?>" class="btn col-sm-12 btn-app">Buy Now</a>
</div>