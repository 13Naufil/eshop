<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */
$form_btns = array('save', 'reset', 'back');
if($row->id > 0){ $form_btns[] =  'duplicate';}

?>
<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>
            <?php echo getModuleDetail()->module_icon; ?>
            <?php echo $this->module_title; ?>
            <small>Form of <?php echo $this->module_title; ?>.</small>
        </h3>
    </div>
</div>
<!-- /page header -->

<?php
include dirname(__FILE__) . "/../includes/breadcrumb.php";
?>

<?php
echo show_validation_errors();
?>

<style>
    #categories-tree input[type=checkbox]{ display: none;}
</style>

<script type="text/javascript">
    var product_id = parseInt('<?php echo intval($row->id);?>');
    var module_route = '<?php echo $this->module_route;?>';
    var module_route_url = '<?php echo admin_url($this->module_route);?>';
</script>

<!-- START -->
<form id="validate" class="form-horizontal validate tree-form" action="<?php echo admin_url($this->module_route . (!empty($row->id) ? '/update/' . $row->id : '/add')); ?>"
      method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" class="id" value="<?php echo $row->id; ?>"/>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-bubble4"></i>
                <?php echo $this->module_title; ?> - Form
            </h6>
        </div>
        <?php
        echo get_form_actions($form_btns);
        ?>
        <div class="panel-body">
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#general-tab" data-toggle="tab"><i class="icon-aid"></i> General</a></li>
                    <li><a href="#prices-tab" data-toggle="tab"><i class="icon-basket"></i> Prices</a></li>
                    <li><a href="#meta-tab" data-toggle="tab"><i class="icon-bars"></i> Meta Information</a></li>
                    <li><a href="#images-tab" data-toggle="tab"><i class="icon-camera3"></i> Images</a></li>
                    <li><a href="#categories-tab" data-toggle="tab"><i class="icon-tree3"></i> Categories</a></li>
                    <li><a href="#inventory-tab" data-toggle="tab"><i class="icon-calculate2"></i> Inventory</a></li>
                    <li><a href="#features-tab" data-toggle="tab"><i class="icon-list"></i> Features</a></li>
                    <li><a href="#related-tab" data-toggle="tab"><i class="icon-trophy"></i> Related Product</a></li>
                    <!--<li><a href="#associated-products-tab" data-toggle="tab"><i class="icon-hanger"></i> Associated Products</a></li>-->
                    <?php if (!CATALOG) { ?>
                    <li><a href="#tags-tab" data-toggle="tab"><i class="icon-tags"></i> Tags</a></li>
                    <li><a href="#custom-options-tab" data-toggle="tab"><i class="icon-podium"></i> Custom Options</a></li>
                    <?php } ?>
                </ul>
                <div class="tab-content with-padding">

                    <div class="tab-pane fade in active" id="general-tab">
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Name : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <input type="text" name="name" id="name" class="form-control validate[required]" value="<?php echo $row->name ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Short Description : </label>

                            <div class="col-sm-7">
                                <textarea name="short_description" id="short_description" cols="20" rows="5" class="form-control col-sm-12"><?php echo $row->short_description; ?></textarea>
                            </div>
                        </div>

                        <div class="panel-heading">
                            <h6 class="panel-title"><i class="icon-bubble4"></i>Description</h6>
                        </div>
                        <div class="col-sm-12">
                            <textarea name="description" id="description" cols="20" rows="30" class="form-control editor col-sm-12"><?php echo $row->description; ?></textarea>
                            <br/>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">SKU : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <input type="text" name="SKU" id="SKU" class="form-control validate[required]" value="<?php echo $row->SKU ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Weight : </label>

                            <div class="col-sm-7">
                                <input type="text" name="weight" id="weight" class="form-control " value="<?php echo $row->weight ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Friendly Url : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <input type="text" name="friendly_url" id="friendly_url" class="form-control validate[required]" value="<?php echo $row->friendly_url ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Product as New From : </label>

                            <div class="col-sm-2">
                                <input type="text" name="news_from_date" id="news_from_date" class="form-control datepicker" value="<?php echo if_null($row->news_from_date,'','0000-00-00');?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Product as New To : </label>

                            <div class="col-sm-2">
                                <input type="text" name="news_to_date" id="news_to_date" class="form-control datepicker" value="<?php echo if_null($row->news_to_date,'','0000-00-00');?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Country Of Manufacture : </label>

                            <div class="col-sm-7">
                                <select name="country_of_manufacture" id="country_of_manufacture" class="select-search ">
                                    <option value="">-- Select --</option>
                                     <?php echo selectBox("SELECT currencyCode, countryName FROM countries",$row->country_of_manufacture); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Status : </label>

                            <div class="col-sm-7">
                                <select name="status" id="status" class="select ">
                                    <?php echo selectBox((get_enum_values($this->table,'status')),$row->status); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Visibility : </label>

                            <div class="col-sm-7">
                                <select name="visibility" id="visibility" class="select ">
                                    <?php echo selectBox((get_enum_values($this->table,'visibility')),$row->visibility); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade in " id="prices-tab">
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Price : </label>

                            <div class="col-sm-5">
                                <input type="text" name="price" id="price" class="form-control " value="<?php echo $row->price; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Special Price : </label>

                            <div class="col-sm-5">
                                <input type="text" name="special_price" id="special_price" class="form-control " value="<?php echo $row->special_price; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Special Price From Date : </label>

                            <div class="col-sm-5">
                                <input type="text" name="special_from_date" id="special_from_date" class="form-control datepicker" value="<?php echo if_null($row->special_from_date,'','0000-00-00');?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Special Price To Date : </label>

                            <div class="col-sm-5">
                                <input type="text" name="special_to_date" id="special_to_date" class="form-control datepicker" value="<?php echo if_null($row->special_to_date,'','0000-00-00');?>"/>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade in " id="meta-tab">
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Meta Title : </label>

                            <div class="col-sm-7">
                                <input type="text" name="meta_title" id="meta_title" class="form-control " value="<?php echo $row->meta_title ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Meta Keyword : </label>

                            <div class="col-sm-7">
                                <textarea name="meta_keywords" id="meta_keywords" cols="20" rows="5" class="form-control col-sm-12"><?php echo $row->meta_keywords; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Meta Description : </label>

                            <div class="col-sm-7">
                                <textarea name="meta_description" id="meta_description" cols="20" rows="5" class="form-control col-sm-12"><?php echo $row->meta_description; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Old Site Url : </label>

                            <div class="col-sm-7">
                                <input type="text" name="old_url" id="old_url" class="form-control " value="<?php echo $row->old_url; ?>"/>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade in" id="images-tab">
                        <div class="row thumbnail-row">
                            <?php
                            $_ava_color_ids = array();
                            $_ava_colors = array();
                            $color_attr_id = intval(get_option('color_attr_id'));

                            if($color_attr_id > 0) {
                                $_configurable_attrs = $this->catalog->get_product_attributes($row->id, $_attr_where . "AND attributes.id='{$color_attr_id}'");// AND attributes.frontend_input IN('select', 'multiselect')
                                //echo '<pre>';print_r($this->db->last_query());echo '</pre>';
                                $_attrs = $_configurable_attrs[0];
                                $_ava_colors = explode(', ', $_attrs->attr_value);
                                $_ava_color_ids = explode(', ', $_attrs->attr_ids);
                            }

                            if($row->id > 0 && !$product_images) {
                                $product_images = $this->m_products->product_images($row->id);
                            }
                            if(count($product_images) == 0){
                                $product_images[] = null;
                            }
                            foreach ($product_images as $product_img) {

                                ?>
                                <div class="col-lg-3 col-md-6 col-sm-6 thumbnail-col" style="<?php echo ($product_img->id > 0 ? '' : 'display: none;');?>">
                                    <div class="block">
                                        <div class="thumbnail thumbnail-boxed">
                                            <div class="thumb">
                                                <img src="<?php echo base_url('assets/front/products/'.$product_img->image);?>" alt="<?php echo $product_img->image;?>" class="img-responsive">

                                                <div class="thumb-options">
                                            <span>
                                                <a href="<?php echo base_url('assets/front/products/'.$product_img->image);?>" class="btn btn-icon btn-success lightbox"><i class="icon-eye2"></i></a>
                                                <?php $delete_img_url = admin_url($this->module_route . '/AJAX/delete_img/' . $product_img->id . '/' . $product_img->image); ?>
                                                <a class="btn btn-icon btn-success remove-img" p_id="<?php echo $row->id; ?>" href="<?php echo $delete_img_url; ?>"><i class="icon-remove"></i></a>
                                            </span>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <div class="options">
                                                    <span><input type="radio" name="default" value="<?php echo $product_img->image;?>" class="-styled" <?php echo _radiobox($product_img->default, 1);?>/> Default</span>
                                                    <br/>
                                                    <span><input type="radio" name="thumb" value="<?php echo $product_img->image;?>" class="-styled" <?php echo _radiobox($product_img->thumb, 1);?>/> Thumb</span>
                                                    <!--<br/>
                                                    <span><input type="radio" name="feature" value="<?php /*echo $product_img->image;*/?>" class="-styled" <?php /*echo _radiobox($product_img->feature, 1);*/?>/> Feature</span>-->
                                                    <br/>
                                                    <span><input type="radio" name="hover" value="<?php echo $product_img->image;?>" class="" <?php echo _radiobox($product_img->hover, 1);?>/> Hover</span>
                                                    <br>
                                                    Exclude :
                                                    <select name="exclude[]" id="exclude" class="form-control -select-full">
                                                        <option value="1" <?php echo _selectbox($product_img->exclude, 1);?>>Yes</option>
                                                        <option value="" <?php echo _selectbox($product_img->exclude, 0);?>>No</option>
                                                    </select>
                                                    <br>
                                                    <?php
                                                    if($color_attr_id > 0){ ?>
                                                        Color :
                                                        <select name="color_img[]" id="color_img" class="color_img form-control -select-full">
                                                            <option value="">- Select Color -</option>
                                                            <?php
                                                            echo selectBox(array_combine($_ava_color_ids, $_ava_colors), $product_img->color_attr_id);
                                                            ?>
                                                        </select>
                                                    <?php } ?>
                                                </div>
                                                <input type="hidden" name="images[]" class="img-val" value="<?php echo $product_img->image;?>"/>
                                            </div>
                                       
                                        </div>
                                        
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                                 <h5 class="text-right" style="margin-right:4px;">Image Size 336 x 450</h5>
                        </div>
                        <!-- Multiple file uploader -->
                        <div class="block well">
                            <div class="images-uploader">Your browser doesn't support native upload.</div>
                        </div>
                        <!-- /multiple file uploader -->

                    </div>

                    <div class="tab-pane fade in" id="categories-tab">
                        <?php if(IS_BRAND) { ?>
                            <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Brand : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <select name="brand_id" id="-brand_id" class="select">
                                    <?php
                                    echo selectBox('SELECT id, title FROM brands', $row->brand_id);
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Categories : </label>
                            <div class="col-sm-7">
                        <div id="categories-tree">
                            <?php
                            $where = '';
                            if(IS_BRAND){
                                $row->brand_id = (($row->brand_id <= 0) ? getVal('brands','id') : $row->brand_id);
                                //$where .= " AND brand_id=" . $row->brand_id;
                            }
                            $this->multilevels->type = 'tree';
                            $this->multilevels->id_Column = 'id';
                            $this->multilevels->title_Column = 'title';
                            $this->multilevels->link_Column = 'parent_id';
                            $this->multilevels->attrs = 'name="categories[]"';
                            //$this->multilevels->level_spacing = 5;
                            $this->multilevels->selected = $selected_categories;
                            $this->multilevels->query = "SELECT * FROM categories WHERE 1 " . $where;
                            echo $multiLevelComponents = $this->multilevels->build();
                            ?>

                        </div>
                        </div>
                        </div>

                    </div>


                    <div class="tab-pane fade in" id="inventory-tab">
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Manage Stock : </label>

                            <div class="col-sm-7">
                                <select name="manage_stock" id="manage_stock" class="select ">
                                    <?php echo selectBox(array_reverse(get_enum_values($this->table,'manage_stock')),$row->manage_stock); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Qty : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <input type="text" name="qty" id="qty" class="form-control validate[required]" value="<?php echo $row->qty ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Min Sale Qty : </label>

                            <div class="col-sm-7">
                                <input type="text" name="min_sale_qty" id="min_sale_qty" class="form-control " value="<?php echo $row->min_sale_qty ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Max Sale Qty : </label>

                            <div class="col-sm-7">
                                <input type="text" name="max_sale_qty" id="max_sale_qty" class="form-control " value="<?php echo if_null($row->max_sale_qty,'',0) ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Is In Stock : </label>

                            <div class="col-sm-7">
                                <select name="is_in_stock" id="is_in_stock" class="select ">
                                    <?php echo selectBox((get_enum_values($this->table,'is_in_stock')),$row->is_in_stock); ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade in " id="features-tab">
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-right">Attribute Group : </label>
                            <div class="col-sm-9">
                                <select name="attribute_group_id" id="attribute_group_id" class="select-search ">
                                    <option value="">- Select -</option>
                                    <?php echo selectBox('SELECT * FROM attribute_groups',$row->attribute_group_id); ?>
                                </select>
                            </div>
                        </div>

                        <div class="attributes-form">

                        </div>
                    </div>

                    <div class="tab-pane fade in " id="related-tab">

                      <!-- Left box -->
                      <div class="left-box">
                        <input type="text" id="box1Filter" class="form-control" placeholder="Filter products...">
                        <button type="button" id="box1Clear" class="filter">x</button>
                        <select id="box1View" multiple="multiple" class="form-control">
                          <?php
                          $related_product_id = intval($row->id);
                          $rel_pro_q = "SELECT id, CONCAT(products.name,' - ', products.sku) AS product FROM products WHERE id <> " . intval($row->id);
                          if(count($related_products) > 0){
                              $rel_pro_q .=  " AND id NOT IN (".join(',', $related_products).")";
                          }if($related_product_id > 0){
                              $rel_pro_q .=  " AND id NOT IN (SELECT product_id FROM related_products WHERE related_product_id='{$related_product_id}')";
                          }

                          echo selectBox($rel_pro_q, '');?>
                        </select>
                        <span id="box1Counter" class="count-label"></span>
                        <select id="box1Storage">
                        </select>
                      </div>
                      <!-- /left-box -->
                      <!-- Control buttons -->
                      <div class="dual-control" style="margin-left: 30px;">
                        <button id="to2" type="button" class="btn btn-default">&nbsp;&gt;&nbsp;</button>
                        <button id="allTo2" type="button" class="btn btn-default">&nbsp;&gt;&gt;&nbsp;</button>
                        <br />
                        <button id="to1" type="button" class="btn btn-default">&nbsp;&lt;&nbsp;</button>
                        <button id="allTo1" type="button" class="btn btn-default">&nbsp;&lt;&lt;&nbsp;</button>
                      </div>
                      <!-- /control buttons -->
                      <!-- Right box -->
                      <div class="right-box">
                        <input type="text" id="box2Filter" class="form-control" placeholder="Filter products...">
                        <button type="button" id="box2Clear" class="filter">x</button>

                        <select id="box2View" class="form-control" name="related_product_ids[]" multiple>
                            <?php
                            $related_product_id = intval($row->id);
                            if(count($related_products) > 0){
                                echo selectBox("SELECT id, CONCAT(products.name,' - ', products.sku) AS product FROM products WHERE id IN (".join(',', $related_products).")", '');
                            }else{
                                echo selectBox("SELECT products.id, CONCAT(products.name,' - ', products.sku) AS product FROM products INNER JOIN related_products ON related_products.product_id = products.id WHERE related_products.related_product_id='{$related_product_id}'", '');
                            }?>

                        </select>
                        <span id="box2Counter" class="count-label"></span>
                      </div>
                      <!-- /right box -->

                    </div>
                    <div class="tab-pane fade in " id="associated-products-tab">
                        <?php
                        include "associated_products_tab.php";
                        ?>
                    </div>

                    <?php if (!CATALOG) { ?>
                    <div class="tab-pane fade in " id="tags-tab">
                        Tags
                    </div>

                    <div class="tab-pane fade in " id="custom-options-tab">
                        Custom Options
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions text-right well">
        <input type="submit" class="btn btn-info" value="submit">
        <!--<button type="submit" class="btn btn-info">Submit</button>-->
        <button type="reset" class="btn">Reset</button>
    </div>
</form>

<script>
    var image_block_row = null;
    $(document).ready(function () {
        image_block_row = $('.thumbnail-row .thumbnail-col:last').clone(true).css('display', 'block');
        console.log(image_block_row);

       // document.getElementById("box2View").multiple = true;

    });
    $(".images-uploader").pluploadQueue({
        runtimes: 'html5,html4',
        url: module_route_url + '/images_upload/' + product_id,
        max_file_size: '100mb',
        unique_names: true,
        filters: [
            {title: "Files", extensions: 'jpg,jpeg,gif,png'}
        ],
        //resize : {width : 320, height : 240, quality : 90},
        init: {
            FilesAdded: function (up, files) {
                console.log('FilesAdded');
            },
            UploadComplete: function (up, files) {
                // Called when all files are either uploaded or failed
                console.log('UploadComplete');
                //$('.caption .options input.styled').uniform({ radioClass: 'choice', selectAutoWidth: false });

            },
            FileUploaded: function (up, file, info) {
                // Called when file has finished uploading
                var data = $.parseJSON(info.response);
                console.log(data);

                //$('#' + file.id).remove();
                //var image_block = $('.thumbnail-row .thumbnail-col:last').clone(true).css('display', 'block');
                var image_block = image_block_row.clone(true);

                /*$('.caption .options input.styled', image_block).each(function(){
                 $(this).unwrap().unwrap();
                 });*/

                $('.thumb img', image_block).attr('src', data.result.thumb_url);
                $('.thumb img', image_block).attr('alt', data.result.filename);
                $('.img-val', image_block).attr('value', data.result.filename);
                $('.thumb .thumb-options .lightbox', image_block).attr('href', data.result.image_url).removeAttr('p_id');
                $('.thumb .thumb-options .remove-img', image_block).attr('href', '#').removeAttr('p_id');

                $('input[type=radio]', image_block).attr('value', data.result.filename).removeAttr('checked')/*.addClass('styled')*/;
                $('.thumbnail-row').append(image_block);


            }
        }
    });


    $(document).on('click', '.remove-img', function (e) {
        e.preventDefault();
        var ele = $(this);
        console.log(ele);
        var href = ele.attr('href');
        var product_id = ele.attr('p_id');

        if (product_id > 0) {
            $.ajax({
                type: "POST",
                url: href,
                dataType: 'json',
                data: {product_id: product_id},
                complete: function (data) {
                    var json = $.parseJSON(data.responseText);
                    if (json.status) {
                        ele.parents('.thumbnail-col').remove();
                    }
                }
            });
        } else {
            ele.parents('.thumbnail-col').remove();
        }
    });
</script>

<script>
    var color_attr_id = <?php echo get_option('color_attr_id');?>;
    var attributes = <?php echo json_encode($attributes);?>
</script>
<script src="<?php echo base_url( APPPATH . 'views/' . ADMIN_DIR . $this->module_route . '/product-fun.js');?>"></script>
