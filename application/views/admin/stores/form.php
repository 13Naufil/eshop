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
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Country : </label>

                <div class="col-sm-7">
                    <select name="country" id="country" class="select-search validate[required]">
                         <?php
                         if($row->id <= 0) {$row->country = 'Pakistan';}
                         echo selectBox("SELECT countryName,`countryName` as show_short_name from countries WHERE 1 ",$row->country); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">City : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" list="cities" name="city" id="city" class="form-control  validate[required]" value="<?php echo $row->city ?>"/>
                    <datalist id="cities">
                        <?php echo selectBox("SELECT city, city as _city FROM stores GROUP BY city",'');?>
                    </datalist>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Area : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="area" id="area" class="form-control  validate[required]" value="<?php echo $row->area ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Business Name : <span
                        class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="business_name" id="business_name" class="form-control  validate[required]" value="<?php echo $row->business_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Phones : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="phone" id="phone" class="form-control  validate[required]" value="<?php echo $row->phone ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Address : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="address" id="address" class="form-control  validate[required]" value="<?php echo $row->address ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Latitude : </label>

                <div class="col-sm-2">
                    <input type="text" name="lat" id="lat" class="form-control  " placeholder="Latitude (Optional)" value="<?php echo $row->lat ?>"/>
                </div>
                <label class="col-sm-2 control-label text-right">Longitude : </label>

                <div class="col-sm-2">
                    <input type="text" name="lng" id="lng" class="form-control  " placeholder="Longitude (Optional)" value="<?php echo $row->lng ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Emails : </label>

                <div class="col-sm-7">
                    <input type="text" name="emails" id="emails" class="form-control  " value="<?php echo $row->emails ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Working Days : </label>

                <div class="col-sm-7">
                    <input type="text" name="working_days" id="working_days" class="form-control  " value="<?php echo $row->working_days ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Timing : </label>

                <div class="col-sm-7">
                    <input type="text" name="timing" id="timing" class="form-control  " value="<?php echo $row->timing ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Status : </label>

                <div class="col-sm-7">
                    <select name="status" id="status" class="select ">
                         <?php echo selectBox(get_enum_values($this->table,'status'),$row->status); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Image : </label>

                <div class="col-sm-7">
                    <input type="file" name="image" id="image" class="styled " value="<?php echo $row->image; ?>"/>

                    <?php
                    if (!empty($row->image)) {
                        echo '</div>';
                        $thumb_url = base_url('assets/admin/img/' . $row->image);
                        $delete_img_url = admin_url($this->module_route . '/AJAX/delete_img/' . $row->id . '/' . $row->image);
                        echo thumb_box($thumb_url, $delete_img_url);
                    } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Ordering : </label>

                <div class="col-sm-2">
                    <input type="text" name="ordering" id="ordering" class="form-control  " value="<?php echo $row->ordering ?>"/>
                </div>
            </div>

            <div class="with-padding">
                <h6 class="heading-hr"><i class="icon-file"></i> Promotion Products</h6>
                <div class="" style="display:table; width: 100%;">
                <div class="left-box">
                    <input type="text" id="box1Filter" class="form-control" placeholder="Filter products...">
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
                      <input type="text" id="box2Filter" class="form-control" placeholder="Filter products...">
                      <button type="button" id="box2Clear" class="filter">x</button>

                      <select id="box2View" multiple="multiple" class="form-control" name="product_ids[]">
                          <?php
                          $rel_id = intval($row->id);
                          if (count($product_ids) > 0) {
                              echo selectBox("SELECT id, CONCAT(products.name,' - ', products.sku) AS product FROM products WHERE id IN (" . join(',', $product_ids) . ")", '');
                          } else {
                              echo selectBox("SELECT products.id, CONCAT(products.name,' - ', products.sku) AS product FROM products INNER JOIN store_promotion_products ON store_promotion_products.product_id = products.id WHERE store_promotion_products.store_id='{$rel_id}'", '');
                          } ?>

                      </select>
                      <span id="box2Counter" class="count-label"></span>
                  </div>
                    <!-- /right box -->
                </div>
            </div>
        </div>

    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</div>

</form>