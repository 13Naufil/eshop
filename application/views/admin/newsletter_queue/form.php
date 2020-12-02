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
                <label class="col-sm-2 control-label text-right">Start Date : </label>
                <div class="col-sm-7">
                    <input type="text" name="start_date" id="start_date" class="form-control  medium datepicker"
                        value="<?php echo $row->start_date ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">End Date : </label>
                <div class="col-sm-7">
                    <input type="text" name="end_date" id="end_date" class="form-control  medium datepicker"
                        value="<?php echo $row->end_date ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Email Template : <span
                        class="mandatory">*</span></label>
                <div class="col-sm-7">
                    <select name="email_template_id" id="email_template_id" class="select-search validate[required]">
                        <option value="">-- Select --</option>
                         <?php echo selectBox("SELECT * FROM email_templates",$row->email_template_id); ?>
                    </select>
                </div>
            </div>
            <!--<div class="form-group">
                <label class="col-sm-2 control-label text-right">Status : </label>
                <div class="col-sm-7">
                    <select name="status" id="status" class="select ">
                        <option value="">-- Select --</option>
                         <?php /*echo selectBox(get_enum_values($this->table, 'status'),$row->status); */?>
                    </select>
                </div>
            </div>-->

        </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>