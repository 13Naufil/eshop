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
<style>
    #Categories ul{ list-style: none; padding: 0; margin: 0;}
    #Categories ul li { margin: 5px 0;}
</style>
<!-- START -->
<form id="validate" class="form-horizontal validate"
      action="<?php echo admin_url($this->module_route . (!empty($row->id) ? '/update/' . $row->id : '/add')); ?>"
      method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" class="id" value="<?php echo $row->id; ?>"/>

    <div class="panel panel-default ">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-bubble4"></i>
                <?php echo $this->module_title; ?> - Form
            </h6>
        </div>
        <?php
        echo get_form_actions($form_btns);
        ?>
        <div class="panel-body ">
            <div class="row">
                <div class="col-sm-9" style="border-right: 1px solid #ddd">

                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Title : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <input type="text" class="validate[required] form-control" name="title" id="title" value="<?php echo $row->title; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Post Name : <span class="mandatory">*</span></label>

                            <div class="col-sm-7">
                                <input type="text" class="validate[required] form-control" name="post_name" id="post_name" value="<?php echo $row->post_name; ?>"/>
                            </div>
                        </div>



                    <div class="panel-heading border-bottom">
                        <h6 class="panel-title"><i class="icon-file-upload"></i>Post Content</h6>
                    </div>
                    <div class="form-group">
                            <textarea name="content" id="content" cols="20" rows="50" class="editor col-sm-12 form-control""><?php echo stripslashes($row->content); ?></textarea>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Published Date Time: </label>

                        <div class="col-sm-3">

                            <div id="datetimepicker1" class="input-append date">
                                <input data-date-format="YYYY-MM-DD hh:mm:ss" class=" form-control datetime_picker" name="datetime" type="text" value="<?php echo (!empty($row->id) ? $row->datetime : date('Y-m-d H:i:s')); ?>">
                                <!--<span class="add-on">
                                  <i data-time-icon="icon-time"
                                     data-date-icon="icon-calendar">
                                  </i>
                                </span>-->
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Post Status: </label>

                        <div class="col-sm-7">
                            <select name="status" id="status" class="select">
                                <?php
                                $status = array(
                                    'publish' => 'Publish',
                                    'unpublish' => 'Unpublish',
                                    'draft' => 'Draft'
                                );
                                echo selectBox($status, $row->status);
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="widget form-horizontal panel">
                        <div class="panel-heading border-bottom">
                            <h6 class="panel-title"><i class="icon-flag3"></i>Metadata Information</h6>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label text-right">Meta Title: </label>

                                <div class="col-sm-7">
                                    <input type="text" class=" form-control" name="meta_title" id="meta_title" value="<?php echo $row->meta_title; ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label text-right">Meta Keywords: </label>

                                <div class="col-sm-7">
                                    <textarea name="meta_keywords" id="meta_keywords" cols="70" class="form-control" rows="5"><?php echo $row->meta_keywords; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label text-right">Meta Description: </label>

                                <div class="col-sm-7">
                                    <textarea name="meta_description" id="meta_description" cols="70" class="form-control" rows="5"><?php echo $row->meta_description; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                     <div class="accordion" id="accordion1">
                         <div class="panel panel-default">
                             <div class="panel-heading">
                               <h6 class="panel-title"><a href="#Categories" data-toggle="collapse"><i class="icon-stack"></i> Categories</a></h6>
                             </div>
                             <div id="Categories" class="panel-collapse with-padding collapse in">

                                     <?php

                                     $this->multilevels->type = 'checkbox';
                                     $this->multilevels->id_Column = 'id';
                                     $this->multilevels->title_Column = 'category';
                                     $this->multilevels->link_Column = 'category';
                                     $this->multilevels->attrs = ' name="categories[]" class="validate[required] styled"';
                                     $this->multilevels->level_spacing = 5;
                                     $this->multilevels->selected = $selected_cats;
                                     $this->multilevels->query = "SELECT id, category,parent_id FROM blog_categories";
                                     echo $multiLevelComponents = $this->multilevels->build();
                                     ?>

                             </div>
                         </div>

                         <div class="panel panel-default">
                             <div class="panel-heading">
                                <h6 class="panel-title"><a href="#Tags" data-toggle="collapse"><i class="icon-tags2"></i> Tags</a></h6>
                              </div>

                             <div id="Tags" class="panel-collapse collapse in">

                                     <input type="text" name="tags" id="tags3" class="post_tags-autocomplete"
                                            value="<?php echo $selected_tags; ?>"/>

                             </div>
                         </div>
                         <div class="panel panel-default">
                             <div class="panel-heading">
                                 <h6 class="panel-title"><a href="#featured_image" data-toggle="collapse"><i class="icon-image3"></i> Featured Images</a></h6>
                             </div>
                            <div id="featured_image" class="panel-collapse collapse in">


                                <div class="well with-padding">
                                    <div class="row">
                                        <?php if (isset($row->featured_image)) { ?>
                                            <div class="col-sm-12 image-display" style="text-align: center;">
                                                <a href="<?php echo asset_url('front/blog_imgs/' . $row->featured_image); ?>" title="<?php echo $row->title; ?>" class="lightbox">
                                                    <img src="<?php echo asset_url('front/blog_imgs/'.$row->featured_image);?>" alt="" width="100%" />
                                                </a>
                                                <button type="button" class="img-remove btn"><b class="icon-trash"></b> &nbsp;Delete Image</button>
                                            </div>
                                        <?php } ?>

                                        <div class="file-choose col-sm-12" style="display: <?php echo isset($row->featured_image) ? 'none' : 'block'; ?>">
                                            <label class="control-label">Choose File :</label>
                                            <input type="file" name="featured_image" id="featured_image" class="styled" />
                                            <span class="file-name help-inline">No file chosen</span>
                                        </div>

                                        <script type="text/javascript">
                                            $(function(){
                                                $(document).ready(function () {
                                                    $('.img-remove').on('click', function(){

                                                        var parent = $(this).parents('#featured_image');
                                                        parent.find('.image-display').hide();
                                                        parent.find('.file-choose').show().find('input[type="file"]').removeAttr('disabled');
                                                    });
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="form-actions text-right well">
                <button type="submit" class="btn btn-info">Submit</button>
                <button type="reset" class="btn">Reset</button>
            </div>

    </form>
<!-- /content -->

<script type="text/javascript">
    $(function () {
        $('.post_tags-autocomplete').tagsInput({
            width: '100%',
            autocomplete_url: '<?php echo site_url(ADMIN_DIR.'blog_posts/blog_tags');?>'
        });
    });
</script>