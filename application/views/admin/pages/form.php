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
                        <div class="input-group col-sm-11" style="margin: 0 15px;">
                            <span class="input-group-addon tip" style=""  data-original-title="Show Title">
                                <input type="checkbox" name="show_title" value="1" class="styled" <?php echo ($row->show_title == '' || intval($row->show_title) === 1) ? 'checked' : ''; ?>/>
                            </span>
                            <input type="text" class="validate[required] form-control col-sm-12" name="title" id="title" value="<?php echo $row->title; ?>" placeholder="Enter title here"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group col-sm-11" style="margin: 0 15px;">
                            <label class="">Friendly URL : </label>
                            <div class="input-group" style="">
                                <span class="input-group-addon"><?php echo site_url('/'); ?></span>
                                <input type="text" name="friendly_url" id="friendly_url" class="form-control validate[funcCall[unique_alias]]" value="<?php echo $row->friendly_url; ?>">
                                <span class="input-group-addon">/</span>
                            </div>
                            <span class="help-inline pull-left" style="">Only alphanumerics and hyphen ( - ) are allowed</span>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group" style="margin: 0 2px;">
                        <label class="">Tagline: </label>

                        <div class="">
                            <input type="text" class=" form-control" name="tagline" id="tagline" value="<?php echo $row->tagline; ?>"/>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <br/>

                    <div class="form-horizontal panel">
                        <div class="panel-heading border-bottom">
                            <h6 class="panel-title"><i class="icon-paragraph-left"></i>Content</h6>
                        </div>
                        <div class="" style="padding-top: 16px;">
                            <textarea name="content" id="content" cols="50" class="editor col-sm-12" rows="40"><?php echo stripslashes($row->content); ?></textarea>
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

                    <div class="panel-heading border-bottom">
                        <h6 class="panel-title"><i class="icon-file-upload"></i>Publish</h6>
                    </div>

                    <div class="well with-padding">

                        <label class="control-label">Status :</label>
                        <div class="">
                            <select name="status" class="select-full">
                                <?php
                                $status = array('published' => 'published', 'unpublished' => 'unpublished');
                                echo selectBox($status, $row->status);
                                ?>
                            </select>
                        </div>
                        <br/>
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger" name="form_submit"><?php echo $form_action == 'add' ? 'Submit' : 'Update'; ?></button>&nbsp;&nbsp;
                            <button type="button" class="btn" onclick="window.history.back();">Cancel</button>
                        </div>

                    </div>


                    <br/>

                    <div class="panel-heading border-bottom">
                        <h6 class="panel-title"><i class="icon-image3"></i>Featured Image</h6>
                    </div>

                    <div class="well with-padding">
                        <div class="row">
                            <?php if (isset($row->thumbnail)) { ?>
                                <div class="col-sm-12 image-display">
                                    <a href="<?php echo site_url('assets/front/uploads/' . $row->thumbnail); ?>" title="<?php echo $row->title; ?>" class="lightbox">
                                        <img src="<?php echo site_url('assets/front/uploads/'.$row->thumbnail);?>" alt="" width="100%" />
                                    </a>
                                    <button type="button" class="img-remove btn"><b class="icon-trash"></b> &nbsp;Delete Image</button>
                                </div>
                            <?php } ?>

                            <div class="file-choose col-sm-12" style="display: <?php echo isset($row->thumbnail) ? 'none' : 'block'; ?>">
                                <label class="control-label">Choose File :</label>
                                <input type="file" name="thumbnail" id="thumbnail" class="styled" <?php if (isset($row->thumbnail)) echo 'disabled'; ?> />
                                <span class="file-name help-inline">No file chosen</span>
                            </div>
                        </div>
                    </div>


                    <br/>

                    <div class="panel-heading border-bottom">
                        <h6 class="panel-title"><i class="icon-target2"></i>Attributes</h6>
                    </div>

                    <div class="well">
                        <label class="control-label">Template :</label>
                        <div class="">
                            <select name="template" class="select-full">
                                <?php
                                $template['default'] = 'Default';
                                if(function_exists('get_theme_templates')){
                                    $template += get_theme_templates();
                                }
                                echo selectBox($template, $row->template);
                                ?>
                            </select>
                        </div>

                        <br/>
                        <label class="control-label">Parent :</label>
                        <div class="">
                            <select name="parent_id" id="parent_id" class="select-full">
                                <option value="0" <?= ($row->title == '') ? 'selected' : ''; ?>> /</option>
                                <?php
                                $this->multilevels->type = 'select';
                                $this->multilevels->id_Column = 'id';
                                $this->multilevels->title_Column = 'title';
                                $this->multilevels->link_Column = 'parent_id';
                                $this->multilevels->level_spacing = 10;
                                $this->multilevels->selected = $row->parent_id;
                                $this->multilevels->query = "SELECT * FROM pages";
                                echo $multiLevelComponents = $this->multilevels->build();
                                ?>
                            </select>
                        </div>

                        <br/>
                        <label class="control-label">Ordering</label>
                        <div>
                            <input type="text" min="0" class="form-control" name="ordering" value="<?php echo intval($row->ordering); ?>" />
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
                <!-- END -->


<script type="text/javascript">

    $(function () {
        $(document).on('click','.img-remove',function(e){
            var parent = $(this).parents('.image-display').parent();
            parent.find('.image-display').hide();
            parent.find('.file-choose').show().find('input[type="file"]').removeAttr('disabled');
        });

        $('#title').on('keyup',function () {
            if($('.id').val() > 0) return;
            var title = $(this).val();
            title = title.trim();
            title = title.toLowerCase();
            title = title.replace(/[^a-z0-9\s\-]/g, '');
            title = title.replace(/\s/g, '-');
            $('#friendly_url').val(title);
        });

    });

    function unique_alias(field, rules, i, options) {
        if (field.val() != "") {
            var data = {};
            var check_msg = '';

            data.value = field.val();
            <?php if ($row->id > 0) { ?>
            data.id = <?php echo $row->id; ?>;
            <?php } ?>

            $.ajax({
                url: '<?php echo admin_url('pages/alias_validate'); ?>',
                dataType: 'json',
                async: false,
                data: data,
                success: function (data) {
                    check_msg = data.message;
                }
            });

            if (check_msg != '') return check_msg;
        }
    }
</script>