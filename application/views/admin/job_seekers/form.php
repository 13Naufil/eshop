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
            <input type="hidden" name="job_id" id="job_id" class="id " value="<?php echo $row->job_id; ?>"/>

            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="name" id="name" class="form-control  validate[required]"
                           value="<?php echo $row->name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Father Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="father_name" id="father_name" class="form-control  validate[required]"
                           value="<?php echo $row->father_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Dob : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="dob" id="dob" class="form-control  validate[required] datepicker"
                           value="<?php echo $row->dob ?>"/>
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
                <label class="col-sm-2 control-label text-right">Contcat No : </label>

                <div class="col-sm-7">
                    <input type="text" name="contcat_no" id="contcat_no" class="form-control  "
                           value="<?php echo $row->contcat_no ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Qualification : </label>

                <div class="col-sm-7">
                    <input type="text" name="qualification" id="qualification" class="form-control  "
                           value="<?php echo $row->qualification ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Currently Empolyed : </label>

                <div class="col-sm-7">
                    <input type="radio" name="currently_empolyed" id="currently_empolyed"
                           class="form-control styled "                                             <?php echo _checkbox($row->currently_empolyed, 1); ?>
                           value="1"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Company Name : </label>

                <div class="col-sm-7">
                    <input type="text" name="company_name" id="company_name" class="form-control  "
                           value="<?php echo $row->company_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Company Contcat : </label>

                <div class="col-sm-7">
                    <input type="text" name="company_contcat" id="company_contcat" class="form-control  "
                           value="<?php echo $row->company_contcat ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Last Designation : </label>

                <div class="col-sm-7">
                    <input type="text" name="last_designation" id="last_designation" class="form-control  "
                           value="<?php echo $row->last_designation ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Experience : </label>

                <div class="col-sm-7">
                    <input type="text" name="experience" id="experience" class="form-control  "
                           value="<?php echo $row->experience ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Current Salary : <span
                        class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="current_salary" id="current_salary"
                           class="form-control  validate[required,custom[number]]"
                           value="<?php echo $row->current_salary ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Expected Salary : <span
                        class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="expected_salary" id="expected_salary"
                           class="form-control  validate[required,custom[number]]"
                           value="<?php echo $row->expected_salary ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Describe Your Self : </label>

                <div class="col-sm-7">
                    <textarea name="describe_your_self" id="describe_your_self" cols="" rows=""
                              class="form-control "><?php echo $row->describe_your_self; ?></textarea>
                </div>
            </div>

        </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>