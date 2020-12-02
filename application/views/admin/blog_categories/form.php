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
            <small>Form of <?php echo $this->module_title; ?>.</small>
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
      action="<?php echo admin_url($this->module_route . (!empty($row->id) ?'/update/' . $row->id : '/add')) ; ?>"
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
                    <label class="col-sm-2 control-label text-right">Parent Category : <span class="mandatory">*</span></label>

                    <div class="col-sm-7">
                        <select name="parent_id" id="parent_id" class="select-search">
                            <option value="0" <?php echo ($row->parent_id == '') ? 'selected' : ''; ?>> /</option>
                            <?php
                            $this->multilevels->type = 'select';
                            $this->multilevels->id_Column = 'id';
                            $this->multilevels->title_Column = 'category';
                            $this->multilevels->link_Column = 'category';
                            $this->multilevels->level_spacing = 5;
                            $this->multilevels->selected = $row->parent_id;
                            $this->multilevels->query = "SELECT id, category,parent_id FROM blog_categories";
                            echo $multiLevelComponents = $this->multilevels->build();
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label text-right">Blog Category : <span class="mandatory">*</span></label>

                    <div class="col-sm-7">
                        <input type="text" class="validate[required] form-control" name="category" id="category" value="<?php echo $row->category; ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label text-right">Ordering: </label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="ordering" id="ordering" value="<?php echo intval($row->ordering == 0 ? 1 : $row->ordering); ?>"/>
                    </div>
                </div>

            </div>

        </div>

        <div class="form-actions text-right well">
            <button type="submit" class="btn btn-info">Submit</button>
            <button type="reset" class="btn">Reset</button>
        </div>
    </form>