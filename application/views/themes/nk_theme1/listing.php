<?php get_header(); ?>
<style>
@media only screen and (min-width: 700px) {
 
  .product-pagination{
          margin-left: 90%;
    }
    .page-numbers{
        display:flex;
    }
    .page {
        border: 2px solid #ff8030;
        padding: 3% 8%;
        height: 30px;
        color: #ff8030;
        margin-left: 10px;
        text-align: center;
    }
    .current{
        background-color:#ff8030;
        color:white;
    }
    .page:hover{
        background-color:#ff8030;
        color:white;
    }
    .page:hover a{
        color:white;
    }
    .page a{
        text-decoration:none;
    }
}

@media only screen and (max-width: 700px) {
 
  .product-pagination{
       text-align:center;
    }
    .page-numbers{
        display:flex;
    }
    .page{
      border: 2px solid #ff8030;
    /*padding: 3% 8%;*/
    height:30px;
    width:40px;
    line-height:25px;
    color: #ff8030;
    margin-left: 10px;
    text-align:center;
    }
    .current{
        background-color:#ff8030;
        color:white;
    }
    .page:hover{
        background-color:#ff8030;
        color:white;
    }
    .page:hover a{
        color:white;
    }
    .page a{
        text-decoration:none;
    }
}
   
</style>
    <main class="main-content page-padding" role="main">
        <header class="page-header"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></header>
        <div class="container">

            <div class="row custom">

                <div class="block-row col-xs-9 col-main">

                    <!-- Filters -->
                    <?php /*include('listing_filters.php');*/ ?>
                    <div style="padding-top: 50px" ></div>

                    <div class="products-grid row">

                        <?php
                        foreach ($products as $k => $product) {
                            /*if(!file_exists(ROOT . '/assets/front/products/' .$product->thumb)) {
                                var_dump(file_put_contents(ROOT . '/assets/front/products/' . $product->thumb, file_get_contents('http://www.advancestore.pk/assets/front/products/' . $product->thumb)));
                            }*/
                            $product_url = get_product_url($product, array('brand' => $brand));
                            ?>

                            <div class=" no_crop_image grid-item col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                <?php
                                include "includes/product_box.php";
                                ?>
                            </div>
                        <?php } ?>
                    </div>

                    <!--<div class="padding">-->
                    <!--    <div class="infinite-scrolling">-->
                    <!--        <a href="" >-->
                    <!--            Show more-->
                    <!--        </a>-->
                    <!--        <a href="javascript:void(0)" class="disabled" style="display:none" >-->
                    <!--            No more product-->
                    <!--        </a>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <div class="product-pagination">
                        <?php echo $pagination; ?>
                    </div>

                </div>
            </div>
        </div>
    </main>
<?php get_footer(); ?>