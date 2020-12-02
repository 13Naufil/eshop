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
                <label class="col-sm-2 control-label text-right">Prefix : </label>

                <div class="col-sm-7">
                    <input type="text" name="prefix" id="prefix" class="form-control  "
                           value="<?php echo $row->prefix ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">First Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="first_name" id="first_name" class="form-control  validate[required]"
                           value="<?php echo $row->first_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Last Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="last_name" id="last_name" class="form-control  validate[required]"
                           value="<?php echo $row->last_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Company : </label>

                <div class="col-sm-7">
                    <input type="text" name="company" id="company" class="form-control  "
                           value="<?php echo $row->company ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Email : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="email" id="email" class="form-control  validate[required,custom[email]]"
                           value="<?php echo $row->email ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">
                    Password : <?php if($row->id == 0 ){echo '<span class="mandatory">*</span>';}?>
                </label>

                <div class="col-sm-7">
                    <?php if($row->id > 0 ){ echo '<input type="checkbox" name="change_pass" id="change_pass" class="styled " value="1"/> Change Password?'; }?>
                    <input <?php echo ($row->id > 0 ? 'disabled' : '');?> type="password" name="password" id="password" class="form-control <?php if($row->id == 0 ){echo 'validate[required]';}else{ echo 'hide';}?>" value=""/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Address : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="address" id="address" class="form-control  validate[required]"
                           value="<?php echo $row->address ?>"/>
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
                <label class="col-sm-2 control-label text-right">State : </label>

                <div class="col-sm-7">
                    <input type="text" name="state" id="state" class="form-control  "
                           value="<?php echo $row->state ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Zip : </label>

                <div class="col-sm-7">
                    <input type="text" name="zip" id="zip" class="form-control  " value="<?php echo $row->zip ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Country : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <select name="country" id="country" class="validation[required] select-search">
                        <option value="">Please select region, state or province</option>
                        <?php echo selectBox("SELECT countryName, countryName AS country FROM `countries`", $row->country);?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Phone : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="phone" id="phone" class="form-control  validate[required]"
                           value="<?php echo $row->phone ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Fax : </label>

                <div class="col-sm-7">
                    <input type="text" name="fax" id="fax" class="form-control  " value="<?php echo $row->fax ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Newsletter : </label>

                <div class="col-sm-7">
                    <input type="checkbox" name="newsletter" id="newsletter" class="styled " <?php echo _checkbox($row->newsletter, 1); ?> value="1"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Status : </label>

                <div class="col-sm-7">
                    <select name="status" id="status" class="select ">
                        <option value="">-- Select --</option>
                         <?=selectBox(get_enum_values($this->table, 'status'),$row->status);?>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>

<script>
    (function ($) {
        $(document).ready(function () {
            $(document).on('click', '#change_pass', function () {
                if($(this).is(':checked')){
                    $('#password').removeClass('hide').attr('disabled', false);
                }else{
                    $('#password').addClass('hide').attr('disabled', true);
                }
            });
        });
    })(jQuery)
</script>