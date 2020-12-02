<?php
$_products = $this->catalog->get_products("AND NOW() BETWEEN products.special_from_date AND products.special_to_date", "RAND()", 8, 0, array('images', '-brands', 'categories'));
//echo '<pre style="display: none;">';print_r($this->db->last_query());echo '</pre>';
if (count($_products) > 0) {
?>
<div class="container text326">
    <h2>Special Offer's</h2>

    <?php
    foreach ($_products as $product) {
        $product_url = get_product_url($product);
        ?>
        <div class="col-sm-3 col-xs-12" data-eq-height="product">
            <div class="proItem">
                <a href="<?php echo site_url($product_url); ?>">
                    <img class="xyz img-responsive" data-alt-src="<?php echo _img('assets/front/products/' . $product->hover, 400, 400); ?>" src="<?php echo _img('assets/front/products/' . $product->thumb, 400, 400); ?>"/>
                    <div class="product_name"><?php echo $product->name; ?></div>
                    <div class="product_price"><?php include "price.temp.php"; ?></div>
                </a>
            </div>
        </div>
    <?php } ?>

</div>
<?php } ?>