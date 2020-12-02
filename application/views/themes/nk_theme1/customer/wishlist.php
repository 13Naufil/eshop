<?php echo get_header(); ?>
<div id="main">
    <div class="bg-container page-padding">
    <div class="page-content container">

        <div class="row">
            <div class="col-sm-3">
                <?php
                include "account_nav.php";
                ?>
            </div>
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">MY WISHLIST</h3>
                    </div>
                    <div class="panel-body">
                        <!--product-listing-block-->
                        <?php
                        if (count($products) > 0) {
                            ?>
                            <div class="row product-listing-block">
                                <?php

                                foreach ($products as $k => $product) {

                                    if (IS_BRAND) {
                                        $brands = $this->catalog->get_brands("AND id=" . intval($product->brand_id));
                                        $data['brand'] = $brands[0];
                                    }

                                    $_product_cats = explode(',', $product->catagories_ids);
                                    $_cat_id = end($_product_cats);
                                    $data['category'] = $this->db->get_where('categories', array('id' => $_cat_id), 1)->row();

                                    $_parent_cats = array();
                                    $this->catalog->get_parent_categories($_cat_id, $_parent_cats, 1);
                                    $data['parent_categories'] = $_parent_cats;

                                    $parent_url = get_parent_url($data);

                                    ?>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="box text-center">
                                            <?php
                                            if ($product->is_new) {
                                                echo '<span class="label label-success is-new-product">New! </span>';
                                            }
                                            ?>
                                            <div class="product-img">
                                                <a href="<?php echo site_url($parent_url . $product->friendly_url . get_option('url_ext')); ?>">
                                                    <img width="230"
                                                         src="<?php echo _img('assets/front/products/' . $product->thumb, 230); ?>"
                                                         alt="<?php echo $product->name; ?>"/>
                                                </a>
                                            </div>

                                            <?php //echo get_product_rating($product->id); ?>
                                            <div class="product-desc">
                                                <a href="<?php echo site_url($parent_url . $product->friendly_url . get_option('url_ext')); ?>">
                                                    <h3><?php echo $product->name; ?></h3>
                                                </a>
                                                <?php
                                                if (!empty($product->short_description)) {
                                                    echo '<p> ' . substr($product->short_description, 0, 100) . '</p>';
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <a href="<?php echo site_url($parent_url . $product->friendly_url . get_option('url_ext')); ?>"
                                               class="btn btn-app"><span>More Details</span></a>
                                        </div>


                                    </div>
                                <?php } ?>

                            </div>
                        <?php } else { ?>
                            <p>You have no items in your wishlist.</p>
                        <?php } ?>
                        <!--product-listing-block-->
                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<?php echo get_footer(); ?>