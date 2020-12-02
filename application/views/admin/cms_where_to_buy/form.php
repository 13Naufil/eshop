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
                <label class="col-sm-2 control-label text-right">Country : <span class="mandatory">*</span></label>

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
                    <input type="text" name="city" id="city" class="form-control  validate[required]"
                           value="<?php echo $row->city ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Area : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="area" id="area" class="form-control  validate[required]"
                           value="<?php echo $row->area ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Business Name : <span
                        class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="business_name" id="business_name" class="form-control  validate[required]"
                           value="<?php echo $row->business_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Business Type : <span
                        class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <select name="business_type" id="business_type" class="select validate[required]">
                        <option value="">- Select One -</option>
                         <?php echo selectBox(get_enum_values($this->table,'business_type'),$row->business_type); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Business Address : <span
                        class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="business_address" id="business_address"
                           class="form-control  validate[required]" value="<?php echo $row->business_address ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Office Description : </label>

                <div class="col-sm-7">
                    <textarea name="office_desc" id="office_desc" cols="30" rows="10" class="form-control"><?php echo $row->office_desc ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Latitude : </label>

                <div class="col-sm-2">
                    <input type="text" name="lat" id="lat" class="form-control  " placeholder="Latitude (Optional)" value="<?php echo $row->lat ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Longitude : </label>

                <div class="col-sm-2">
                    <input type="text" name="lng" id="lng" class="form-control  " placeholder="Longitude (Optional)" value="<?php echo $row->lng ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Ordering : </label>

                <div class="col-sm-2">
                    <input type="text" name="ordering" id="ordering" class="form-control  "
                           value="<?php echo $row->ordering ?>"/>
                </div>
            </div>

        </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>