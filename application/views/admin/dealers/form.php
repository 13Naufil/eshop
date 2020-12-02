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
                <label class="col-sm-2 control-label text-right">Business Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="business_name" id="business_name" class="form-control  validate[required]" value="<?php echo $row->business_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Owner Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="owner_name" id="owner_name" class="form-control  validate[required]" value="<?php echo $row->owner_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Email : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="email" id="email" class="form-control  validate[required,custom[email]]" value="<?php echo $row->email ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Phone : </label>

                <div class="col-sm-7">
                    <input type="text" name="phone" id="phone" class="form-control  " value="<?php echo $row->phone ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Country : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" list="countries" name="country" id="country" class="form-control  validate[required]" value="<?php echo $row->country ?>"/>
                    <datalist id="countries">
                        <?php echo selectBox("SELECT country FROM dealers GROUP BY country", '', '<option value="{country}">'); ?>
                    </datalist>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">State : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" list="states" name="state" id="state" class="form-control  validate[required]" value="<?php echo $row->state ?>"/>
                    <datalist id="states">
                        <?php echo selectBox("SELECT state FROM dealers GROUP BY state", '', '<option value="{state}">'); ?>
                    </datalist>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">City : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" list="cities" name="city" id="city" class="form-control  validate[required]" value="<?php echo $row->city ?>"/>
                    <datalist id="cities">
                        <?php echo selectBox("SELECT city FROM dealers GROUP BY city", '', '<option value="{city}">'); ?>
                    </datalist>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Area : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="area" id="area" class="form-control  validate[required]" value="<?php echo $row->area ?>"/>
                    <datalist id="cities">
                        <?php echo selectBox("SELECT area FROM dealers GROUP BY area", '', '<option value="{area}">'); ?>
                    </datalist>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Market : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="market" id="market" class="form-control  validate[required]" value="<?php echo $row->market ?>"/>
                </div>
            </div>

        </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>