<section class="related-products ">
    <h2>Related Products </h2>

    <div class="products-grid row owl-carousel">

        <?php foreach ($related_products as $product) {?>
        <div class="no_crop_image grid-item col-xs-6 col-sm-4  col-lg-3">
            <?php
            $product_url = get_product_url($product);
            include "includes/product_box.php";
            ?>
        </div>
        <?php } ?>
    </div>

    <script>
        jQuery(document).ready(function() {
            jQuery(".related-products .products-grid").owlCarousel({
                autoPlay : 3000,
                navigation : true,
                stopOnHover : true,
                items : 4,
                itemsDesktop : [1200,3],
                itemsTablet: [767,3],
                itemsTabletSmall: [721,2]
            });
        });
    </script>
</section>
