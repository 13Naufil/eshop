<?php
$SQL = "SELECT * FROM `categories` WHERE `parent_id`=0 AND `status`='Active' AND index_category = 1 ORDER BY ordering ASC";
$categories = $this->db->query($SQL)->result();
if(count($categories) > 0){
    echo '<div class="container">';
    foreach($categories as $category){
        ?>
        <section class="section mobile_and_tablets">
            <div class="">
                <div class="panel new-panel col-sm-12" style="background-color: <?php echo $category->color;?>;" >
                    <h2><img src="<?php echo _img('assets/admin/img/' . $category->icon,55,55); ?>"/> <?php echo $category->title;?> </h2>
                    <a href="<?php echo site_url($category->friendly_url . get_option('url_ext')); ?>"><h2>VIEW MORE</h2></a>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="slick-slider">
                            <style>
                                .hover-show-<?php echo $category->id;?>:hover{
                                    border: 1px solid <?php echo $category->color;?> !important;
                                }
                            </style>
                            <?php
                            $where = "AND parent_id=" . $category->id;
                            $sub_categories = $this->catalog->get_categories($where);
                            $categories_ids = $this->catalog->get_categories_ids(array_merge((array)$sub_categories, array((array)$category)));
                            $where .= " AND product_cat_rel.category_id IN (" . join(',', $categories_ids) . ")";
                            //$where = " AND categories.id='{$category->id}'";
                            //GROUP_CONCAT(DISTINCT product_cat_rel.category_id SEPARATOR ',') AS catagories_ids
                            $_index_main_products = $this->catalog->get_products($where, '', 15, 0, array('images', 'brands', 'categories'));

                            if (count($_index_main_products) > 0) {
                                //echo '<div class="carousel">';
                                foreach ($_index_main_products as $product) {
                                    if(!file_exists(ROOT . '/assets/front/products/' .$product->thumb)) {
                                        var_dump(file_put_contents(ROOT . '/assets/front/products/' . $product->thumb, file_get_contents('http://www.advancestore.pk/assets/front/products/' . $product->thumb)));
                                    }
                                    $product_url = get_product_url($product, array('brand' => $brand));
                                    ?>
                                    <div class="topboxes">
                                        <a href="<?php echo site_url($product_url); ?>" class="img-thumbnail hover_show hover-show-<?php echo $category->id;?>">
                                            <div class="buy_now text-center">
                                                <img src="<?php echo _img('assets/front/products/' . $product->thumb,250,250); ?>" width="250" height="250" alt="<?php echo $product->name;?>" class="img-responsive">
                                                <h3 class="buy_inner yellow" style="background-color: <?php echo $category->color;?>">Buy Now</h3>
                                            </div>
                                            <h4><?php echo $product->name;?></h4>
                                            <br>
                                            <?php include "includes/price.temp.php"; ?>
                                        </a>
                                    </div>
                                    <?php
                                }
                                //echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
    <?php }
    echo '</div>';
} ?>