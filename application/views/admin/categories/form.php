<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */
$form_btns = array('save', 'reset', 'back');
?>
<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>
            <?php echo getModuleDetail()->module_icon; ?>
            <?php echo $this->module_title; ?>
            <small>Listing of <?php echo $this->module_title; ?>.</small>
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

<!-- START -->
<form id="validate" class="form-horizontal validate"
      action="<?php echo admin_url($this->module_route . (!empty($row->id) ? '/update/' . $row->id : '/add')); ?>"
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
            <div class="tabbable">
                <ul class="nav nav nav-tabs">
                    <li class="active"><a href="#iconified-pill1" data-toggle="tab"><?php echo getModuleDetail()->module_icon; ?> Category Detail</a></li>
                    <li><a href="#iconified-pill2" data-toggle="tab"><i class="icon-clipboard"></i> Category Products</a></li>
                </ul>
                <div class="tab-content with-padding">
                    <div class="tab-pane fade in active" id="iconified-pill1">




                        <?php if(IS_BRAND) { ?>
                        <!--<div class="form-group">
                            <label class="col-sm-2 control-label text-right">Brand : </label>

                            <div class="col-sm-7">
                                <select name="brand_id" id="brand_id" class="select">
                                    <?php
            /*                        echo selectBox('SELECT id, title FROM brands', $row->brand_id);
                                    */?>
                                </select>
                            </div>
                        </div>-->
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Parent : </label>

                            <div class="col-sm-7">
                                <select name="parent_id" id="parent_id" class="select-search">
                                    <option value="0" <?= ($row->title == '') ? 'selected' : ''; ?>> /</option>
                                    <?php
                                    $this->multilevels->type = 'select';
                                    $this->multilevels->id_Column = 'id';
                                    $this->multilevels->title_Column = 'title';
                                    $this->multilevels->link_Column = 'parent_id';
                                    $this->multilevels->level_spacing = 10;
                                    $this->multilevels->selected = $row->parent_id;
                                    $this->multilevels->query = "SELECT * FROM categories";
                                    echo $multiLevelComponents = $this->multilevels->build();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Title : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <input type="text" name="title" id="title" class="form-control validate[required]"
                                       value="<?php echo $row->title ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Friendly Url : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <input type="text" name="friendly_url" id="friendly_url"
                                       class="form-control validate[required]"
                                       value="<?php echo $row->friendly_url ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Include In Menu : </label>

                            <div class="col-sm-7">
                                <input type="checkbox" name="include_in_menu" id="include_in_menu" class="form-control styled " <?php echo _checkbox($row->include_in_menu, 1); ?> value="1"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Ordering : </label>

                            <div class="col-sm-1">
                                <input type="text" name="ordering" id="ordering" class="form-control validate[required,custom[integer]]" value="<?php echo $row->ordering;?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Thumb : </label>

                            <div class="col-sm-7">
                                <input type="file" name="thumb" id="thumb" class="styled "
                                       value="<?php echo $row->thumb; ?>"/>
                            </div>
                            <?php
                            if (!empty($row->thumb)) {
                                $thumb_url = base_url('assets/admin/img/' . $row->thumb);
                                $delete_img_url = admin_url($this->module_route . '/AJAX/delete_img/' . $row->id . '/' . $row->thumb);
                                echo thumb_box($thumb_url, $delete_img_url);
                            }
                            ?>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Image : </label>

                            <div class="col-sm-7">
                                <input type="file" name="image" id="image" class="styled "
                                       value="<?php echo $row->image; ?>"/>
                            </div>
                            <?php
                            if (!empty($row->thumb)) {
                                $thumb_url = base_url('assets/admin/img/' . $row->image);
                                $delete_img_url = admin_url($this->module_route . '/AJAX/delete_img/' . $row->id . '/' . $row->image);
                                echo thumb_box($thumb_url, $delete_img_url);
                            }
                            ?>

                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Icon : </label>

                            <div class="col-sm-7">
                                <input type="file" name="icon" id="icon" class="styled "
                                       value="<?php echo $row->icon; ?>"/>
                            </div>
                            <?php
                            if (!empty($row->icon)) {
                                $thumb_url = base_url('assets/admin/img/' . $row->icon);
                                $delete_img_url = admin_url($this->module_route . '/AJAX/delete_img/' . $row->id . '/' . $row->icon);
                                echo thumb_box($thumb_url, $delete_img_url);
                            }
                            ?>

                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label text-right">Color:</label>

                            <div class="col-md-2">
                                <div class="input-group color color-picker" data-color="#000000">
                                <input type="text" class="form-control" name="color" value="<?php echo $row->color;?>">
                                <span class="input-group-addon"><i style="background-color: #000000;"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Index Category : </label>

                            <div class="col-sm-7">
                                <select name="index_category" id="index_category" class="select">
                                    <?php
                                    $_OP = array('0' => 'No', '1' => 'Yes');
                                    echo selectBox($_OP , $row->index_category);
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Description : </label>

                            <div class="col-sm-10">
                                <textarea name="description" id="description" cols="" rows="50" class="col-sm-12 form-control editor"><?php echo stripslashes($row->description); ?></textarea>
                            </div>
                        </div>

                        <div class="panel-heading border-bottom">
                            <h6 class="panel-title"><i class="icon-flag3"></i>Metadata Information</h6>
                        </div>
                    <br/>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Meta Title : </label>

                            <div class="col-sm-7">
                                <input type="text" name="meta_title" id="meta_title" class="form-control " value="<?php echo $row->meta_title ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Meta Keywords : </label>

                            <div class="col-sm-7">
                                <textarea name="meta_keywords" id="meta_keywords" cols="5" rows="5" class="form-control col-sm-12"><?php echo $row->meta_keywords; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Meta Description : </label>

                            <div class="col-sm-7">
                                <textarea name="meta_description" id="meta_description" cols="5" rows="5" class="form-control col-sm-12"><?php echo $row->meta_description; ?></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="iconified-pill2">
                        <div class="" style="display:table; width: 100%;">
                            <div class="left-box">
                                <input type="text" id="box1Filter" class="form-control"
                                       placeholder="Filter products...">
                                <button type="button" id="box1Clear" class="filter">x</button>
                                <select id="box1View" multiple="multiple" class="form-control">
                                    <?php
                                    $rel_pro_q = "SELECT id, CONCAT(products.name,' - ', products.sku) AS product FROM products WHERE id <> " . intval($row->id);
                                    if (count($product_ids) > 0) {
                                        $rel_pro_q .= " AND id NOT IN (" . join(',', $product_ids) . ")";
                                    }
                                    echo selectBox($rel_pro_q, ''); ?>
                                </select>
                                <span id="box1Counter" class="count-label"></span>
                                <span id="" class=""><i>Duble click on product!</i></span>
                                <select id="box1Storage">
                                </select>
                            </div>
                            <!-- /left-box -->
                            <!-- Right box -->
                            <div class="right-box">
                                <input type="text" id="box2Filter" class="form-control"
                                       placeholder="Filter products...">
                                <button type="button" id="box2Clear" class="filter">x</button>

                                <select id="box2View" multiple="multiple" class="form-control" name="product_ids[]">
                                    <?php
                                    $rel_id = intval($row->id);
                                    if (count($product_ids) > 0) {
                                        echo selectBox("SELECT id, CONCAT(products.name,' - ', products.sku) AS product FROM products WHERE id IN (" . join(',', $product_ids) . ")", '');
                                    } else {
                                        echo selectBox("SELECT products.id, CONCAT(products.name,' - ', products.sku) AS product FROM products INNER JOIN product_cat_rel ON product_cat_rel.product_id = products.id WHERE product_cat_rel.category_id='{$rel_id}'", '');
                                    } ?>

                                </select>
                                <span id="box2Counter" class="count-label"></span>
                            </div>
                            <!-- /right box -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>