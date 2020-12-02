<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +923323103324
 * S: developer.adnan
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
                <label class="col-sm-2 control-label text-right">Image : <span class="mandatory">*</span></label>

                <div class="col-sm-5">
                    <input type="file" name="image" id="image" class="styled" value="<?php echo $row->image; ?>"/>

                    <?php
                    if (!empty($row->image)) {
                    ?>
                </div>
                <div class="col-sm-3 " style="">
                    <div class="block">
                        <div class="thumbnail thumbnail-boxed">
                            <div class="thumb">
                                <img alt="" src="<?php echo base_url('assets/front/teaser_boxes/' . $row->image);?>">
                                <div class="thumb-options">
                                    <span>
                                        <a href=" <?php echo base_url('assets/front/teaser_boxes/' . $row->image); ?>"
                                     class="view-back lightbox btn btn-icon  btn-success"><i class="icon-eye2"></i></a>
                                    <a href="<?php echo admin_url($this->module_route . '/AJAX/delete_img/' . $row->id . '/' . $row->image); ?>"
                                    class="btn btn-icon btn-success"><i class="icon-remove"></i>
                                    </a>
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
            <label class="col-sm-2 control-label text-right">Title : </label>
            <div class="col-sm-5">
                <input type="text" name="title" id="title" class="form-control " value="<?php echo $row->title; ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label text-right">Type : </label>
            <div class="col-sm-5">
                <select name="type" id="type" class="select ">
                    <?php echo selectBox(get_enum_values($this->table, 'type'),$row->type); ?>
                </select>
            </div>
        </div>
         <div class="form-group">
            <label class="col-sm-2 control-label text-right">Position : </label>

            <div class="col-sm-3">
                <select name="position" id="position" class="select ">
                    <?php echo selectBox(get_enum_values($this->table, 'position'),$row->position); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label text-right">Link : </label>

            <div class="col-sm-5">
                <input type="text" name="link" id="link" class="form-control " value="<?php echo $row->link ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label text-right">Ordering : </label>

            <div class="col-sm-1">
                <input type="text" name="ordering" id="ordering" class="form-control  " value="<?php echo $row->ordering ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label text-right">Description : </label>

            <div class="col-sm-5">
                <textarea name="description" id="description" class="form-control "><?php echo $row->description; ?></textarea>
            </div>
        </div>

    </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>