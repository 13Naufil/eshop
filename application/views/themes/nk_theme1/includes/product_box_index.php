<div class="box equal-h">
    <div class="row">
        <div class="col-xs-6 text-center">
            <a title="<?php echo $product->name; ?>" href="<?php echo site_url($product_url); ?>" class="img-anchor">
                <img class="img-responsive" src="<?php echo _img('assets/front/products/' . $product->thumb, 230); ?>" width="230" alt="<?php echo $product->name; ?>"/>
            </a>
        </div>
        <div class="col-xs-6">
            <a title="<?php echo $product->name; ?>" href="<?php echo site_url($parent_url); ?>" class="">
                <h3><?php echo $product->name; ?></h3>
            </a>

            <div class="rating-box"><?php echo get_product_rating($product->id); ?></div>

            <p><?php echo substr(strip_tags($product->short_description), 0, 75); ?>...</p>
            <a title="<?php echo $product->name; ?>" href="<?php echo site_url($product_url);?>" class="">Detail ></a>
            <br>
            <a title="<?php echo $product->name; ?>" href="<?php echo site_url($product_url);?>" class="btn btn-app">Buy Now</a>
        </div>
    </div>
</div>