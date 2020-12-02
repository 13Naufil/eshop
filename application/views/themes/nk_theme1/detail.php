<?php get_header(); ?>
<style>
   
    @media only screen and (max-width: 600px) {
  .slider-small-img{
        height:35px
    }
}

</style>
<main class="main-content page-padding" style="padding-top: 90px" role="main">
    <div class="container">
        <style>
            .col-sm-8 .draggable{
                width:500px;
            }
            /*.product-img-box{*/
            /*    height:700px;*/
            /*}*/
            
            .header_top_table p {
                width: 33.33%;
                float: left;
                margin: 0;
            }
            /*.slick-track,.draggable{*/
            /*    height:500px!important;*/
                
            /*}*/
.bid-gallery-nav .slick-slide{
                    width:100px!important;
                }
            @media (min-width: 768px){
                .header-bottom.on {
                    top: 0 !important;
                    z-index:2;
                }
               
                .product-img-box{
                height:700px;
            }
            .slick-track,.draggable{
                height:500px!important;
                
            }
            }
             @media (max-width: 768px){
             
               
               .slick-track{
                   width:100%;
                   margin-top:2%;
               }
                .col-sm-8 .draggable {
                    /*width: 100%;*/
                      width:390px;
                }
                .bid-gallery-nav .slick-slide{
                    width:60px!important;
                }
                .sideimages{
                    width:100%;
                }
            }

        </style>
        <?php include dirname(__FILE__) . "/includes/breadcrumb.php"; ?>
        <?php echo show_validation_errors(); ?>

        <div class="row">
            <div class="col-xs-9 col-main">
                <div itemscope itemtype="" class="product">

                    <div class="row">
                        <div class="col-xs-12 col-sm-7 product-img-box ">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8">
                                    <div class="bid-slider-gallery">
                                        <?php
                                        if (count($images) > 0) {
                                            $count = 1;
                                            foreach ($images as $img) {
                                                
                                                ?>
                                                <!--<div>-->
                                                <!--    <img class="zoom-img" id="zoom_<?php echo $count; ?>" src="<?php echo base_url('assets/front/products/' . $img->image); ?>"  data-zoom-image="<?php echo base_url('assets/front/products/' . $img->image); ?>" alt="*" />-->
                                                <!--</div>-->
                                                <div class="product-wrapper zoom-image">
  <img class="product-photo"
       data-original-image="<?php echo base_url('assets/front/products/' . $img->image); ?>"
       src="<?php echo base_url('assets/front/products/' . $img->image); ?>">
</div>
                                            <?php $count++; }
                                        } ?>
                                    </div>
                                    
                                    
                                </div>
                                <div class="col-sm-4 col-xs-4 sideimages" style="width:100%;margin-top:2%">
                                    <div class="bid-gallery-nav">
                                        <?php
                                        if (count($images) > 0) {
                                            $count = 1;
                                            foreach ($images as $img) {
                                            
                                                ?>
                                                <div class="gallery-slide"><img class="slider-small-img" src="<?php echo base_url('assets/front/products/' . $img->image); ?>" alt="*" /></div>
                                                <?php $count++; }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-5 product-shop">
                            <header class="product-title has-btn"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                <h2 itemprop="name">
                                    <span><?php echo $product->name; ?></span>
                                </h2>
                            </header>
                            <div class="product-info__sku pull-left" >SKU <strong class="sku"> - <?php echo $product->SKU; ?></strong>
                            </div>
                            <div itemprop="offers" itemscope itemtype="javascript:;">
                                <?php include "includes/addcart.temp.php"; ?>
                                <div class="clearfix"></div>
                                <strong>In Stock <i class="fa fa-check" style="color: <?php echo ($product->is_in_stock == 'In Stock' ? '#00ba00' : '#FFba00');?>"></i> </strong>
                            </div>
                            <div id="notify_me_form" style="display:none">
                                <form method="post"id="contact_form" class="contact-form">
                                    <input type="hidden" name="form_type" value="contact" /><input type="hidden" name="utf8" value="✓" />
                                    <div id="notify-me-wrapper" class="clearfix" >
                                        <input style="margin-bottom: 10px;" required="required" type="email" name="contact[email]" placeholder="your@email.com" class="styled-input" value="" />
                                        <input type="hidden" id="notify-me-body" name="contact[body]" value="" />
                                        <input class="btn styled-submit" type="submit" value="Email Me When Available" />
                                    </div>
                                </form>
                            </div>
                            <a class="btn_size-wishlist" href='<?php echo site_url('customer/add_wishlist/' . $product->id);?>'> <span class="fa fa-heart-o"></span>
                                <span>&nbsp;Add to wishlist</span>
                            </a>
                            <div class="share_toolbox">
                                <p><strong>Share:</strong></p>
                                <ul>
                                    <li><a href="" target="_blank" title="Email"><img src="<?php echo media_url('img/social_icon_1.png'); ?>" alt="" /></a></li>
                                    <li><a href="javascript:;" target="_blank" title="Share Facebook"><img src="<?php echo media_url('img/social_icon_2.png'); ?>" alt="" /></a></li>
                                    <li><a href="javascript:;" target="_blank" title="Twitter"><img src="<?php echo media_url('img/social_icon_3.png'); ?>" alt="" /></a></li>
                                    <li><a href="javascript:;" target="_blank" title="Pinterest"><img src="<?php echo media_url('img/social_icon_4.png'); ?>" alt="" /></a></li>
                                    <li><a href="javascript:;" target="_blank" title="Google+"><img src="<?php echo media_url('img/social_icon_4.png'); ?>" alt="" /></a></li>
                                </ul>
                            </div>
                            <div class="panel-group" id="accordion">
                                <div class="panel product-description rte">
                                    <div class="panel-heading">
                                        <h4 class="panel-title active">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse-tab1">
                                                <span>Details </span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse-tab1" class="panel-collapse collapse in">
                                        <div class="panel-body" itemprop="description">
                                            <?php echo stripslashes($product->description);?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include "product_related.php"; ?>

</main>

<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.7.18/jquery.zoom.min.js"></script>
<script>
    $(function() {
  $('.zoom-image').each(function(){
    var originalImagePath = $(this).find('img').data('original-image');
    $(this).zoom({
      url: originalImagePath,
      magnify: 1
    });
  });
}); 
</script>