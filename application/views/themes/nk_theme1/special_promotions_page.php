<div class="bg-container">
    <div class="page-content container">
        <br>
        <div class="row listing-row">
            <div class="col-sm-3">
                <?php echo get_ads('special-promotions');?>
            </div>
            <div class="col-sm-9">
                <!--product-listing-block-->
                <?php
                # Category Products
                $order_by = '';
                $limit = 12;
                $offset = 0;
                if (getVar('limit') > 0) {
                    $limit = intval(getVar('limit'));
                }
                if (getVar('per_page') > 0) {
                    $offset = intval(getVar('per_page'));
                }
                if (getVar('order') != '') {
                    $order_by = getVar('order') . ' ' . (getVar('dir') == '' ? 'DESC' : getVar('dir'));
                }

                //$where = " AND NOW() BETWEEN products.special_from_date AND products.special_to_date";
                $where = " AND attributes.attribute_code='deals' AND attributes_option_values_rel.admin_value='Special Promotion'";
                $products = $this->catalog->get_products($where, $order_by, $limit, $offset);
                //echo '<pre>';print_r($this->db->last_query());echo '</pre>';die('Call');

                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # Pagination
                $total_record = $this->db->found_rows();
                $config['base_url'] = generate_url('per_page');
                $config['total_rows'] = $total_record;
                $config['per_page'] = $limit;
                $config['page_query_string'] = TRUE;

                $choice = $config["total_rows"] / $config["per_page"];
                $config["total_links"] = ceil($choice);
                $config["num_links"] = 4;

                $config['full_tag_open'] = '<ul class="cd-pagination no-space move-buttons custom-icons">';
                $config['full_tag_close'] = '</ul>';

                $config['prev_tag_open'] = '<li class="button">';
                $config['prev_tag_close'] = '</li>';
                $config['prev_link'] = 'Prev';

                $config['next_link'] = 'Next';
                $config['next_tag_open'] = '<li class="button">';//<span>...</span></li><li><a href="'.generate_url('per_page','per_page=' . ($config["total_rows"] * $config["per_page"])).'">'.$config["total_links"].'</a></li><li class="button">
                $config['next_tag_close'] = '</li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li><a class="current" href="javascript: void(0);">';
                $config['cur_tag_close'] = '</li>';

                $this->pagination->initialize($config);
                $pagination = $this->pagination->create_links();

                if (count($products) > 0) {
                    ?>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="product-listing-block ">

                                <?php

                                foreach ($products as $k => $product) {
                                    $product_url = get_product_url($product);
                                    ?>
                                    <div class="col-sm-4 col-xs-6 nopadding">
                                        <div class="promotion-box">
                                            <div class="product-img  text-center">
                                                <a href="<?php echo site_url($product_url); ?>">
                                                    <img src="<?php echo _img('assets/front/products/' . $product->thumb,340); ?>" alt="<?php echo $product->name; ?>" class="img-responsive"/>
                                                    <span class="btn-shop-now">Shop Now ></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="clearfix"></div>
                                <div class="col-sm-12 text-center">
                                    <nav role="navigation">
                                        <?php echo $pagination; ?>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!--product-listing-block-->
            </div>
        </div>

        <div class="clearfix"></div>
        <p class="widget-space">&nbsp;</p>

    </div>
</div>