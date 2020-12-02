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
                <label class="col-sm-2 control-label text-right">Customer Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="customer_name" id="name" class="form-control  validate[required]"
                           value="<?php echo $row->customer_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Customer Email : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="customer_email" id="customer_email" class="form-control validate[required]" value="<?php echo $row->customer_email ?>"/>
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-2 control-label text-right">Customer Mobile : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="customer_mobile" id="customer_mobile" class="form-control validate[required]" value="<?php echo $row->customer_mobile ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Delivery Address : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="delivery_address" id="delivery_address" class="form-control validate[required]" value="<?php echo $row->delivery_address ?>"/>
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-2 control-label text-right">Delivery City : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="delivery_city" id="delivery_city" class="form-control validate[required]" value="<?php echo $row->delivery_city ?>"/>
                </div>
            </div>
            

    </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>