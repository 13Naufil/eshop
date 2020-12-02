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
                                <img alt="" src="<?php echo base_url('assets/front/banners/' . $row->image);?>">
                                <div class="thumb-options">
                                    <span>
                                        <a href=" <?php echo base_url('assets/front/banners/' . $row->image); ?>"
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
                <input type="text" name="title" id="title" class="form-control " value="<?php echo $row->title ?>"/>
            </div>
        </div>
 <?php
                    if (empty($row->type)) {
                        
                    ?>
                    <script> $(".mobileview").hide();</script>
        <div class="form-group">
            <label class="col-sm-2 control-label text-right">Type : </label>
            <div class="col-sm-5">
                <select name="type" id="type">
                    <option disabled>-- SELECT --</option>
                    <option value="main-slider">Main Slider - 1920 x 600</option>
                    <option value="right-bottom">Right Bottom - 404 x 520</option>
                    <option value="left-bottom">Left Bottom - 810 x 520</option>
                </select>
            </div>
        </div>
        <?php
                    }
                    else{
        ?>
         <script> $(".mobileview").show();</script>
        <?php
                    }
        ?>
     <div class="form-group mobileview">
                <label class="col-sm-2 control-label text-right">Mobile View Image : <span class="mandatory">*</span></label>

                <div class="col-sm-5">
                    <input type="file" name="mobileimage" id="mobileimage" class="styled" value="<?php echo $row->mobileimage; ?>"/>

                    <?php
                    if (!empty($row->mobileimage)) {
                    ?>
                </div>
                <div class="col-sm-3 " style="">
                    <div class="block">
                        <div class="thumbnail thumbnail-boxed">
                            <div class="thumb">
                                <img alt="" src="<?php echo base_url('assets/front/banners/' . $row->mobileimage);?>">
                                <div class="thumb-options">
                                    <span>
                                        <a href=" <?php echo base_url('assets/front/banners/' . $row->mobileimage); ?>"
                                     class="view-back lightbox btn btn-icon  btn-success"><i class="icon-eye2"></i></a>
                                    <a href="<?php echo admin_url($this->module_route . '/AJAX/delete_img/' . $row->id . '/' . $row->mobileimage); ?>"
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
            <label class="col-sm-2 control-label text-right">Link : </label>

            <div class="col-sm-5">
                <input type="text" name="link" id="link" class="form-control " value="<?php echo $row->link ?>"/>
            </div>
        </div>
        <!--<div class="form-group">
            <label class="col-sm-2 control-label text-right">Description : </label>

            <div class="col-sm-10">
                <textarea name="description" id="description" cols="30" rows="10" class="form-control editor"><?php /*echo ($row->description) */?></textarea>
            </div>
        </div>-->
        <div class="form-group">
            <label class="col-sm-2 control-label text-right">Ordering : </label>

            <div class="col-sm-1">
                <input type="text" name="ordering" id="ordering" class="form-control  " value="<?php echo $row->ordering ?>"/>
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
   
    $("#type").change(function(){
       selectedvalue=$(this).val();
       
        if(selectedvalue=='main-slider'){
             $(".mobileview").show(500);
        }
        else{
            $(".mobileview").hide();
        }
        
    });
</script>