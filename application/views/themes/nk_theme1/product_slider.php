<!-- Porducts Slider Start -->
<style>
    .home-instagram,.home-pro-slider {
   
     padding-bottom:10px!important; 

}
</style>
<?php
$module=$this->cms->get_modules("and module='feature_slider'");
if(count($module)){
$products = $this->catalog->get_products("and products.id in (select product_id from feature_slider where status='Active' order by `order`)",'RAND()','');
if(count($products) > 0){
?>
<section class="home-pro-slider home-instagram">
    <div class="container">
        <div class="row">
             <h2><?php 
             
              echo $module[0]->module_title;
            
             ?></h2>
            <div class="pro-slider">
                <?php foreach ($products as $k => $product): ?>
                <div class="no_crop_image grid-item col-xs-6 col-sm-4  col-lg-3">
                    <?php
                    $product_url = get_product_url($product);
                    include "includes/product_box.php";
                    ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php }
}
?>


<?php
$module=$this->cms->get_modules("and module='product_slider'");
if(count($module)){
$products = $this->catalog->get_products("and products.id in (select product_id from product_slider where status='Active' order by `order`)",'RAND()','');
if(count($products) > 0){
?>
<section class="home-pro-slider home-instagram">
    <div class="container">
        <div class="row">
            <h2><?php 
             
              echo $module[0]->module_title;
            
             ?></h2>
            <div class="pro-slider">
                <?php foreach ($products as $k => $product): ?>
                <div class="no_crop_image grid-item col-xs-6 col-sm-4  col-lg-3">
                    <?php
                    $product_url = get_product_url($product);
                    include "includes/product_box.php";
                    ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php }
}
?>


<?php
$module=$this->cms->get_modules("and module='third_slider'");
if(count($module)){
$products = $this->catalog->get_products("and products.id in (select product_id from third_slider where status='Active' order by `order`)",'RAND()','');
if(count($products) > 0){
?>
<section class="home-pro-slider home-instagram">
    <div class="container">
        <div class="row">
            <h2><?php 
             
              echo $module[0]->module_title;
            
             ?></h2>
            <div class="pro-slider">
                <?php foreach ($products as $k => $product): ?>
                <div class="no_crop_image grid-item col-xs-6 col-sm-4  col-lg-3">
                    <?php
                    $product_url = get_product_url($product);
                    include "includes/product_box.php";
                    ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php }
}
?>




<?php
$module=$this->cms->get_modules("and module='fourth_slider'");
if(count($module)){
$products = $this->catalog->get_products("and products.id in (select product_id from fourth_slider where status='Active' order by `order`)",'RAND()','');
if(count($products) > 0){
?>
<section class="home-pro-slider home-instagram">
    <div class="container">
        <div class="row">
            <h2><?php 
             
              echo $module[0]->module_title;
            
             ?></h2>
            <div class="pro-slider">
                <?php foreach ($products as $k => $product): ?>
                <div class="no_crop_image grid-item col-xs-6 col-sm-4  col-lg-3">
                    <?php
                    $product_url = get_product_url($product);
                    include "includes/product_box.php";
                    ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php }
}
?>



