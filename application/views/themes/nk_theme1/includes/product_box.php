

<div class="inner product-item">
    <div class="inner-top">
        <div class="product-top">
            <div class="product-image">
                <a href="<?php echo site_url($product_url); ?>" class="product-grid-image">
                    <img src="<?php echo _img('assets/front/products/' . $product->thumb); ?>" alt="<?php echo $product->name; ?>">
                    <div class="hover-image">
                        <img src="<?php echo asset_url('front/products/' . $product->hover)?>" alt="<?php echo $product->name; ?>">
                    </div>
                    <div class="hover">
                        
                    </div>
                </a>
            </div>

            <div class="shop_the_look_form pulllook_form">
                <button class='btn quick_buy' id="myBtn" style="margin-bottom:4%;"  data-id="<?php echo $product->id;?>" type="button"
                data-size="<?php
                  $color_attr_id = intval(get_option('color_attr_id'));
                $aatributes=$this->catalog->get_product_attributes($product->id);
                
                 foreach($aatributes as $_attrs){
                       if (!in_array(strtolower($_attrs->id), array($color_attr_id))) {
                    $colors = explode(' ', $_attrs->attr_value);
                        foreach($colors as $color){
                            echo $color;
                        }
                       }
                 }
                ?>"
                data-color="<?php
                  $color_attr_id = intval(get_option('color_attr_id'));
                $aatributes=$this->catalog->get_product_attributes($product->id);
                
                 foreach($aatributes as $_attrs){
                       if (in_array(strtolower($_attrs->id), array($color_attr_id))) {
                    $colors = explode(' ', $_attrs->attr_value);
                        foreach($colors as $color){
                            echo $color;
                        }
                       }
                 }
                ?>"
                
                >Quick Buy</button>
               
                <div class='cstm-pro-swatches-btnsss'>
                    
                    <form action="<?php echo site_url('cart/addcart');?>" method="post" id="add-to-cart-form">
                        <input type="hidden" name="id" id="id" value="<?php echo $product->id;?>"/>
                        
                        
                        <?php
                        if($product->attribute_group_id==0){
                        ?>
                        
                        <button class='btn btn_adds' style="margin-top:0px!important" type="submit">Add to Cart</button>
                        <?php
                        }
                        else{
                        ?>
                      
                        <a href="<?php echo site_url($product_url); ?>" style="margin-top:0px!important;width:50%;" class='btn btn_adds'>Details</a>
                        <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
            <div class="product-label"></div>
        </div>

        <div class="product-bottom">
            <a class="product-title pull-left" href="<?php echo site_url($product_url); ?>">
                <?php echo $product->name; ?>
            </a>
            <div class="clearfix"></div>
            <div class="price-box">
                <p class="regular-product pull-left">
                <?php include "price.temp.php"; ?>
                </p>
            </div>
            <p class="pull-right" style="font-size: 10px;margin: 0px;"><b><?php echo $product->SKU; ?></b></p>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

