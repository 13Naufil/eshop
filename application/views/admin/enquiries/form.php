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
                <label class="col-sm-2 control-label text-right">Product: <span class="mandatory">*</span></label>
                <div class="col-sm-7">
                    <select data-placeholder="Select Product" class="select" name="product_id">
                      <?php echo selectBox("SELECT id, name FROM products", $row->product_id);?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="name" id="name" class="form-control  validate[required]" value="<?php echo $row->name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Email : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="email" id="email" class="form-control  validate[required,custom[email]]" value="<?php echo $row->email ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Department: <span class="mandatory">*</span></label>
                <div class="col-sm-7">
                    <select data-placeholder="Select department" class="required select-full" name="department" tabindex="2">
                      <?php echo selectBox(get_enum_values('enquiries', 'department'), '');?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Message : </label>

                <div class="col-sm-7">
                    <textarea name="message" id="message" cols="100" rows="20"
                        class="form-control col-sm-12"><?php echo $row->message; ?></textarea>
                </div>
            </div>

        </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>