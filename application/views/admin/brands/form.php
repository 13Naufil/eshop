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
                <label class="col-sm-2 control-label text-right">Friendly Url : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="friendly_url" id="friendly_url" class="form-control validate[required]" value="<?php echo $row->friendly_url ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Include In Menu : </label>

                <div class="col-sm-7">
                    <input type="checkbox" name="include_in_menu" id="include_in_menu" class="form-control styled " <?php echo _checkbox($row->include_in_menu, 1); ?> value="1"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Short Description : </label>

                <div class="col-sm-7">
                    <textarea name="short_description" id="short_description" cols="20" rows="5"
                              class="form-control col-sm-12"><?php echo $row->short_description; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Logo : </label>

                <div class="col-sm-7">
                    <input type="file" name="logo" id="logo" class="styled " value="<?php echo $row->logo; ?>"/>

                    <?php
                    if (!empty($row->logo)) {
                    ?>
                </div>
                <div class="col-sm-3 " style="">
                    <div class="block">
                        <div class="thumbnail thumbnail-boxed">
                            <div class="thumb">
                                <img alt="" src="<?php echo base_url('assets/front/brands/' . $row->logo);?> ">
                                <div class="thumb - options">
                                    <span>
                                        <a href=" <?php echo base_url('assets/front/brands/' . $row->logo); ?>" class="view-back lightbox"></a>
                                        <a href="<?php echo admin_url($this->module_route . '/AJAX/delete_img/' . $row->id . '/' . $row->logo); ?>" class="btn btn-icon btn-success"><i class="icon-remove"></i></a>
                                    </span>
                                </div>
                            <!--<div class="caption"></div>-->
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label text-right">Index Slider : </label>

            <div class="col-sm-7">
                <select name="index_slider" id="index_slider" class="select">
                    <?php
                    $_OP = array('0' => 'No', '1' => 'Yes');
                    echo selectBox($_OP , $row->index_slider);
                    ?>
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