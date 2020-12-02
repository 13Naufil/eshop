<?php
$_products = $this->catalog->get_products("AND NOW() BETWEEN products.news_from_date AND products.news_to_date", "products.id DESC", 0, 0, array('images', 'brands', 'categories'));
//echo '<pre style="display: none;">';print_r($this->db->last_query());echo '</pre>';
if (count($_products) > 0) {
?>
<section class="section">
    <div class="panel bd-none">
        <div class="container">
            <h2><img src="<?php echo template_url('assets/img/icon1.PNG') ; ?>"/>New Arrivals</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="new-arivals-slider responsive fivebox">
                    <?php
                    foreach ($_products as $product) {
                        $product_url = get_product_url($product);
                    ?>
                    <div class="col-xs-12 col-sm-6 col-md-2 topboxes">
                        <a href="<?php echo site_url($product_url); ?>" class="img-thumbnail">
                            <img class="img-responsive" src="<?php echo _img('assets/front/products/' . $product->thumb, 245, 245); ?>" alt="<?php echo $product->name; ?>" />
                            <h4><?php echo $product->name; ?></h4>
                            <br>
                            <?php include "price.temp.php"; ?>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<?php } ?>