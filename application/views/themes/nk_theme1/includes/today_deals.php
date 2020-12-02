<?php
$where = " AND attributes.attribute_code='deals' AND attributes_option_values_rel.admin_value='Deal Today'";
$products = $this->catalog->get_products($where);
if (count($products) > 0) {
    ?>
  
    <p>&nbsp;</p>
    <div class="clearfix"></div>
    <div class="today-deal-container">
        <div class="today-deal-box">
            <h2>Today's Deals</h2>
        </div>
        <div class="deal-products">
            <?php


            echo '<div class="deal-slider">';
            foreach ($products as $k => $product) {

                $product_url = get_product_url($product);
                ?>
                <div class="rounded">
                    <div class="product-img  text-center">
                        <a title="<?php echo $product->name; ?>" href="<?php echo site_url($product_url); ?>">
                            <img src="<?php echo _img('assets/front/products/' . $product->thumb, 156); ?>" width="156" height="156"
                                 alt="<?php echo $product->name; ?>"/>
                        </a>
                    </div>
                    <?php include "price.temp.php"; ?>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <a title="<?php echo $product->name; ?>" href="<?php echo site_url($product_url); ?>">
                                <h2>
                                    <?php echo $product->brand_title; ?>
                                    <br>
                                    <?php echo $product->name; ?>
                                </h2>
                            </a>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <p>&nbsp;</p>
                            <p class="stars"><?php echo get_product_rating($product->id, false); ?></p>
                        </div>
                    </div>
                </div>
                <?
            }
            echo '</div>';

            ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php
}