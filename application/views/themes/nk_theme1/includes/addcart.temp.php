<?php
$is_config_attr = false;
if($product->is_in_stock == 'In Stock' && ($product->manage_stock == 'No' || ($product->qty > 0 && $product->manage_stock == 'Yes'))){
?>
<form action="<?php echo site_url('cart/addcart');?>" method="post" id="add-to-cart-form">
    <input type="hidden" name="id" id="id" value="<?php echo $product->id;?>"/>
    <div class="prices">
        <span class="price" itemprop="price"><?php include "price.temp.php"; ?></span>
    </div>
    <div class="clearfix"></div>


    <div id="product-variants">
    <?php
    $color_attr_id = intval(get_option('color_attr_id'));

    //$_attr_where = "AND attributes.id IN(SELECT attr_id FROM product_configurable_rel WHERE product_id={$product->id}) ";
    $_configurable_attrs = $this->catalog->get_product_attributes($product->id, $_attr_where ."AND attributes.used_in_configurable='Yes' AND attributes.frontend_input IN('select', 'multiselect')");
    if(count($_configurable_attrs) > 0){
        $is_config_attr = true;
        foreach($_configurable_attrs as $_attrs){

            if (in_array(strtolower($_attrs->id), array($color_attr_id))) {
                $color_ids = explode(', ', $_attrs->attr_ids);
                $colors = explode(', ', $_attrs->attr_value); ?>
                <div class="wrapper text-center Color" style="">
                    <div class="swatch clearfix" data-option-index="0">
                        <span class="option-label"><?php echo $_attrs->attr_label;?> :</span>
                        <?php foreach($colors as $k => $color){
                    echo '<div data-value="' . $color . '" class="swatch-element swatch-element-'.$k.' color swatchbky bky soldout">';
                    echo '<input id="swatch-'.$k.'-'.$color.'" color-id="'.$color_ids[$k].'" type="radio" class="color-bky" name="order_attr['.$_attrs->id.']" value="' . $color . '" '._checkbox($color,$colors[0]).'>';
                    echo '<label for="swatch-'.$k.'-'.$color.'" style="background-color: ' . $color . '" data-title="<?php echo $product->name; ?>" data-variant="' . $color . '" class="cstm_notifyme_form_show"  class="color-bky"></label>';
                    echo '<div class="tooltip">' . $color . '</div>';
                    echo '</div>';
                         } ?>
                    </div>
                </div>
            <? } else {
                ?>
                <div class="wrapper text-center Color" style="">
                    <div class="swatch clearfix" data-option-index="0">
                        <span class="option-label"><?php echo $_attrs->attr_label;?> :</span>
                        <?php
                        $_attr_ids = explode(', ', $_attrs->attr_ids);
                        $_attr_value = explode(', ', $_attrs->attr_value);
                        foreach ($_attr_ids as $k => $attr_id) {
                            echo '<div data-value="' . $attr_id . '" class="swatch-element swatch-element-'.$k.' color swatchbky bky soldout">';
                            echo '<input id="swatch-'.$k.'-'.$_attr_value[$k].'" type="radio" class="color-bky" name="order_attr['.$_attrs->id.']" value="' . $_attr_value[$k] . '" '._checkbox($_attr_ids,$_attr_ids[0]).'>';
                            echo '<label for="swatch-'.$k.'-'.$_attr_value[$k].'" data-title="<?php echo $product->name; ?>" data-variant="' . $_attr_value[$k] . '" class="cstm_notifyme_form_show"  class="color-bky">' . $_attr_value[$k] . '</label>';
                            echo '<div class="tooltip">' . $_attr_value[$k] . '</div>';
                            echo '</div>';
                        } ?>
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>
    </div>

    <div class="notify_me_form_active">
        <label for="quantity" >Quantity: </label>
        <?php
        $product->min_sale_qty = ($product->min_sale_qty == 0) ? 1 : $product->min_sale_qty;
        $product->max_sale_qty = ($product->max_sale_qty == 0) ? 100000000000000000000 : $product->max_sale_qty;
        ?>
        <input type="number" min="<?php echo $product->min_sale_qty;?>" max="<?php echo $product->max_sale_qty;?>" name="qty" id="qty" class="form-control qty" value="<?php echo $product->min_sale_qty;?>" style="width: 158px;">
        <button type="submit" class="btn btn-cart">Add to Cart</button>
    </div>
</form>
<?php } ?>