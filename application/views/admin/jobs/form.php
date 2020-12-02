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
                <label class="col-sm-2 control-label text-right">Title : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="title" id="title" class="form-control  validate[required]"
                           value="<?php echo $row->title ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Description : </label>

                <div class="col-sm-7">
                    <textarea name="description" id="description" cols="30" rows="30"
                              class="form-control editor  col-sm-12"><?php echo $row->description; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Position : <span class="mandatory">*</span></label>

                <div class="col-sm-2">
                    <input type="text" name="position" id="position"
                           class="form-control  validate[required,custom[integer]]"
                           value="<?php echo $row->position ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Location : </label>

                <div class="col-sm-7">
                    <input type="text" name="location" id="location" class="form-control  " placeholder="Karachi"
                           value="<?php echo $row->location ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Job Category : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="job_category" id="job_category" class="form-control  validate[required]" placeholder="Experienced (Non-Manager), etc"
                           value="<?php echo $row->job_category ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Job Type : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <select name="job_type" id="job_type" class="select">
                        <?php
                        echo selectBox(get_enum_values($this->table,'job_type'), $row->job_type);
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Job Subtype : </label>

                <div class="col-sm-7">
                    <select name="job_subtype" id="job_subtype" class="select">
                        <?php
                        echo selectBox(get_enum_values($this->table,'job_subtype'), $row->job_subtype);
                        ?>
                    </select>
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
                <label class="col-sm-2 control-label text-right">Posted Date : </label>

                <div class="col-sm-2">
                    <input type="text" name="posted_date" id="posted_date" class="form-control  datepicker"
                           value="<?php echo $row->posted_date ?>"/>
                </div>
            </div>

        </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>