<div class="bg-container">
    <div class="page-content container">
        <br>
        <div class="row listing-row">
            <div class="col-sm-3">
                <?php echo get_ads('price-promotions');?>
            </div>
            <div class="col-sm-9">
                <!--product-listing-block-->

                <?php
                $brands = $this->db->get_where('brands', array('status' => 'Active'))->result();
                if(count($brands) > 0){
                    foreach($brands as $brand){


                # Category Products
                $order_by = '';
                /*$limit = 12;
                $offset = 0;
                if (getVar('limit') > 0) {
                    $limit = intval(getVar('limit'));
                }
                if (getVar('per_page') > 0) {
                    $offset = intval(getVar('per_page'));
                }*/
                if (getVar('order') != '') {
                    $order_by = getVar('order') . ' ' . (getVar('dir') == '' ? 'DESC' : getVar('dir'));
                }
                $where = " AND products.brand_id='{$brand->id}'";
                //$where .= " AND NOW() BETWEEN products.special_from_date AND products.special_to_date";
                $where .= " AND attributes.attribute_code='deals' AND attributes_option_values_rel.admin_value='Price Promotion'";
                $products = $this->catalog->get_products($where, $order_by, $limit, $offset);
                //echo '<pre>';print_r($this->db->last_query());echo '</pre>';die('Call');

                if (count($products) > 0) {
                    ?>
                    <div class="brand-title-hr">
                        <i class="icon-compass"></i> <h4 class="text-uppercase inline"> <?php echo $brand->title;?> Deals</h4>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="product-listing-block ">

                                <?php
                                foreach ($products as $k => $product) {
                                    $product_url = get_product_url($product);
                                    ?>
                                    <div class="col-sm-4 col-xs-6 box-border">
                                        <div class="box">
                                            <?php
                                            if ($product->is_new) {
                                                echo '<span class="label label-success is-new-product">New! </span>';
                                            }
                                            ?>
                                            <div class="product-img  text-center">
                                                <a href="<?php echo site_url($product_url); ?>">
                                                    <img src="<?php echo _img('assets/front/products/' . $product->thumb,250); ?>" alt="<?php echo $product->name; ?>"/>
                                                </a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6 text-left">
                                                    <a href="<?php echo site_url($product_url); ?>">
                                                        <h4>
                                                            <?php echo $product->brand_title; ?>
                                                            <br>
                                                            <?php echo $product->name; ?>
                                                        </h4>
                                                    </a>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <a href="<?php echo site_url($product_url); ?>">Detail ></a>
                                                    <p><?php echo get_product_rating($product->id, false); ?></p>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="box-bottom">
                                                    <hr class="sm">
                                                    <i><?php include "includes/price.temp.php"; ?></i>
                                                    <a href="<?php echo site_url($parent_url . $product->friendly_url . get_option('url_ext')); ?>" class="btn btn-app pull-right">Buy Now</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php }
                }
                ?>
                <!--product-listing-block-->
            </div>
        </div>

        <div class="clearfix"></div>
        <p class="widget-space">&nbsp;</p>

    </div>
</div>