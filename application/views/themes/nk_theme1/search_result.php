<?php get_header(); ?>
    <div class="container">

        <!--<div class="col-sm-2"><?php /*include('left-side.php'); */?></div>-->
        <div class="col-sm-12 text326">

            <div class="breadcrumb-sort-block ">
                <!-- Breadcrumbs line -->
                <div class="col-sm-6 col-xs-12 breadcrumb-line pad-0">
                    <?php
                    include dirname(__FILE__) . "/includes/breadcrumb.php";
                    ?>
                </div>
                <!-- /breadcrumbs line -->
                <div class="col-sm-6 col-xs-12 pull-right text-right pad-0">
                    <ul class="breadcrumb">
                        <li><a href="javascript: window.history.back();"><&nbsp;&nbsp;Return to Previous Page</a></li>
                    </ul>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="welcome-bar for-search">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2 class="welcome-msg">Search results for '<?php echo getVar('q'); ?>'</span></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gap"></div>
            <!-- product listing -->

            <?php
            if (count($products) > 0) {
                ?>
                <div class="product-listing-block ">
                    <div class="row">
                        <?php
                        foreach ($products as $k => $product) {
                            /*if(!file_exists(ROOT . '/assets/front/products/' .$product->thumb)) {
                                var_dump(file_put_contents(ROOT . '/assets/front/products/' . $product->thumb, file_get_contents('http://www.advancestore.pk/assets/front/products/' . $product->thumb)));
                            }*/
                            $product_url = get_product_url($product, array('brand' => $brand));
                            ?>
                            <div class="col-sm-3 col-xs-12" data-eq-height="product">
                                <?php
                                include "includes/product_box.php";
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="container">
            <div class="clearfix"></div>
            <div class="product-pagination">
                <?php echo $pagination; ?>
            </div>
        </div>

    </div>

<script>
    (function ($) {
        $('#search-page').removeClass('is-open');
    })(jQuery);
</script>

<?php get_footer(); ?>

