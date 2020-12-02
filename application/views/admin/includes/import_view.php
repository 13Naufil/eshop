<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 19-09-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>
            <?php echo getModuleDetail()->module_icon; ?>
            <?php echo $this->module_title; ?>
            <small><?php echo $this->module_title; ?> - Import File In Database.</small>
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
<form id="validate" class="form-horizontal validate" action="<?= admin_url($this->module_route . '/import'); ?>"
      method="post" enctype="multipart/form-data">
    <div class="panel panel-default">

        <?php
        $buttons = array('import_db', 'refresh', 'back');
        echo get_form_actions($buttons);
        ?>
        <input type="hidden" name="import" value="1">

        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">File Type : <span class="mandatory">*</span></label>

                <div class="col-sm-4">
                    <select name="type" id="type" class="select">
                        <option value="csv">CSV</option>
                        <!--<option value="xml">XML</option>-->
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">File : <span class="mandatory">*</span></label>

                <div class="col-sm-4">
                    <input type="file" name="file" id="file" class="validate[required] styled">
                </div>
            </div>
            <?php if ($total_records) { ?>
                <div class="span12">
                    <p align="center" style="color: red; font-weight: bold;"><?= $total_records; ?> record import.</p>
                </div>
            <? } ?>


        </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>

</form>

