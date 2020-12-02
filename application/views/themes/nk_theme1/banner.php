<!-- Banner
================================================== -->
<Style>
     @media (min-width: 768px){
    .hero-slider{
        margin-top:140px
    }
     }
     @media (max-width: 768px){
          .hero-slider{
        margin-top:100px
    }
     }
</Style>
<?php

$banner_indicator = '';
$banner_item = '';

$_banners = $this->cms->get_banners();
/*echo '<pre>';print_r($this->db->last_query());echo '</pre>';*/
if(count($_banners) > 0){

    ?>
    <!-- Slider Section Start -->
    <section class="hero-slider" style="">
        <div class="main-slider">
        <?php foreach ($_banners as $i => $banner): ?>
            <div>
                <a href="<?php echo $banner->link;?>"><img src="<?php echo asset_url('front/banners/' . $banner->image); ?>" style="height:auto" class="slide-img desk-view" alt="">
                <img src="<?php echo asset_url('front/banners/' . $banner->mobileimage); ?>" class="slide-img mob-view" draggable="false">
                </a>
            </div>
        <?php endforeach; ?>
        </div>
    </section>
    <!-- Slider Section End -->


<?php }
?>




