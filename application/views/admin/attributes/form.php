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
<style>
    div[class*=hide-]{
        display: none;
    }
</style>
<!-- START -->
<form id="validate" class="form-horizontal validate"
      action="<?php echo admin_url($this->module_route . (!empty($row->id) ? '/update/' . $row->id : '/add')); ?>"
      method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" class="id" value="<?php echo $row->id; ?>"/>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-newspaper"></i>
                <?php echo $this->module_title; ?> - Properties
            </h6>
        </div>
        <?php
        echo get_form_actions($form_btns);
        ?>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Attribute Set : </label>

                <div class="col-sm-4">
                    <select name="attribute_set_id" id="attribute_set_id" class="select-search ">
                        <option value="">-- Select --</option>
                         <?php echo selectBox("select * from attribute_sets",$row->attribute_set_id); ?>
                    </select>
                </div>
                <div class="col-sm-1 text-center" style="line-height: 30px;">- OR NEW -</div>
                <div class="col-sm-4">
                     <input type="text" name="attribute_set" class="form-control" id="attribute_set"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Attribute Code : <span
                        class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="attribute_code" id="attribute_code"
                           class="form-control  validate[required]" value="<?php echo $row->attribute_code ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Attribute Image : </label>

                <div class="col-sm-3">
                    <input type="file" name="attribute_img" id="attribute_img" class="styled " value="<?php echo $row->attribute_img; ?>"/>
                </div>
                <?php
                if (!empty($row->thumb)) {
                    $thumb_url = base_url('assets/admin/img/' . $row->attribute_img);
                    $delete_img_url = admin_url($this->module_route . '/AJAX/delete_img/' . $row->id . '/' . $row->attribute_img);
                    echo thumb_box($thumb_url, $delete_img_url);
                }
                ?>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Frontend Input : <span
                        class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <select name="frontend_input" id="frontend_input" class="select ">
                         <?php
                         $frontend_inputs = explode("\n", trim(get_option('frontend_inputs')));
                         foreach($frontend_inputs as $front_input){
                             $front_inputs = explode('=', trim($front_input));
                             $__frontend_inputs[trim($front_inputs[0])] = $front_inputs[1];
                         }
                         echo selectBox($__frontend_inputs,$row->frontend_input); ?>
                    </select>
                </div>
            </div>
            <div class="form-group hide-default_value_text">
                <label class="col-sm-2 control-label text-right">Default Value Text : </label>

                <div class="col-sm-7">
                    <input type="text" name="default_value_text" id="default_value_text" class="form-control" value="<?php echo $row->default_value_text ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Values Required : </label>

                <div class="col-sm-7">
                    <select name="is_required" id="is_required" class="select ">
                         <?php echo selectBox(array_reverse(get_enum_values($this->table,'is_required')),$row->is_required); ?>
                    </select>
                </div>
            </div>
            <div class="form-group hide-validation_class">
                <label class="col-sm-2 control-label text-right">Validation Class : </label>

                <div class="col-sm-7">
                    <select name="validation_class" id="validation_class" class="select">
                        <option value="">None</option>
                         <?php
                         $validation_types = explode("\n", trim(get_option('validation_types')));
                         foreach($validation_types as $vtype){
                             $val_type = explode('=', trim($vtype));
                             $__validation_types[trim($val_type[0])] = $val_type[1];
                         }
                         echo selectBox($__validation_types,$row->validation_class); ?>
                    </select>
                </div>
            </div>
            <!--<div class="form-group">
                <label class="col-sm-2 control-label text-right">Comparable on Front-end : </label>

                <div class="col-sm-7">
                    <select name="is_comparable" id="is_comparable" class="select ">
                        <?php /*echo selectBox(array_reverse(get_enum_values($this->table,'is_comparable')), $row->is_comparable); */?>
                    </select>
                </div>
            </div>-->
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Position : </label>

                <div class="col-sm-2">
                    <input type="text" name="position" id="position" class="form-control  "
                           value="<?php echo $row->position ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Used in Filtering : </label>

                <div class="col-sm-7">
                    <select name="used_in_filtering" id="used_in_filtering" class="select ">
                        <?php echo selectBox((get_enum_values($this->table,'used_in_filtering')),$row->used_in_filtering); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Visible On Front : </label>

                <div class="col-sm-7">
                    <select name="is_visible_on_front" id="is_visible_on_front" class="select ">
                        <?php echo selectBox((get_enum_values($this->table,'is_visible_on_front')),$row->is_visible_on_front); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Used In Product Listing : </label>

                <div class="col-sm-7">
                    <select name="used_in_product_listing" id="used_in_product_listing" class="select ">
                        <?php echo selectBox(array_reverse(get_enum_values($this->table,'used_in_product_listing')),$row->used_in_product_listing);?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Used In Configurable Product : </label>

                <div class="col-sm-7">
                    <select name="used_in_configurable" id="used_in_configurable" class="select ">
                        <?php echo selectBox(array_reverse(get_enum_values($this->table,'used_in_configurable')),$row->used_in_configurable); ?>
                    </select>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-stack"></i>
                Manage Label / Options
            </h6>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Admin Label : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="admin_label" id="admin_label" class="form-control  validate[required]"
                           value="<?php echo $row->admin_label ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Frontend Label : </label>

                <div class="col-sm-7">
                    <input type="text" name="frontend_label" id="frontend_label" class="form-control  "
                           value="<?php echo $row->frontend_label ?>"/>
                </div>
            </div>


            <div class="hide-option-list">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-wand2"></i> Manage Options (values of your attribute)</h6>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <table class="table table-responsive table-bordered">
                            <thead>
                            <tr>
                                <th>Admin Value</th>
                                <th>Front Value</th>
                                <th width="100">Position</th>
                                <th>Default</th>
                                <th>Extra</th>
                                <th class="text-center"><a href="#" class="btn add_more" clone-container=".clone-container"><i class="icon-plus-circle"></i>Add Option</a></th>
                            </tr>
                            </thead>
                            <tbody class="clone-container">
                            <?php

                            if(!$attributes_option_values){
                                $attributes_option_values[] = null;
                            }
                            foreach($attributes_option_values as $i => $attr_opt_value){
                                ?>
                                <tr class="clone">
                                    <input type="hidden" name="options[attr_value_id][]" class="form-control" value="<?php echo $attr_opt_value->attr_value_id; ?>"/>
                                    <td><input type="text" name="options[admin][]" class="form-control" value="<?php echo $attr_opt_value->admin_value; ?>"/></td>
                                    <td><input type="text" name="options[front][]" class="form-control" value="<?php echo $attr_opt_value->frontend_value; ?>"/></td>
                                    <td><input type="text" name="options[position][]" class="form-control" value="<?php echo $attr_opt_value->position; ?>"/></td>
                                    <td class="text-center"><input type="radio" name="options[default]" class="" value="<?php echo $i; ?>" <?php echo _checkbox($attr_opt_value->default, 1); ?>/></td>
                                    <td><input type="text" name="options[extra][]" class="form-control" value="<?php echo $attr_opt_value->extra; ?>" placeholder="color=#FFF000&tip=like here"/></td>
                                    <td class="text-center"><a href="#" class="btn" remove-el="parent-.clone"><i class="icon-minus-circle"></i>Delele</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
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

<script>
    (function ($) {
        $(document).ready(function () {
            $('#is_required').on('change', function () {
                if($(this).val() == 'Yes')
                    $('.hide-validation_class').show();
                else
                    $('.hide-validation_class').hide();
            });
            $('#frontend_input').on('change', function () {
                var frontend_inputs = $(this).val();
                console.log(frontend_inputs);

                var default_value_text = '';
                $('.hide-option-list').hide();
                switch (frontend_inputs){
                    case 'textarea':
                        default_value_text = '<textarea name="default_value_text" id="default_value_text" cols="30" rows="4" class="form-control col-sm-12">';
                        $('.hide-default_value_text').show();
                        $('#default_value_text').parent().html(default_value_text);
                        break;
                    case 'date':
                        default_value_text = '<input type="text" name="default_value_text" id="default_value_text" class="form-control datepicker-trigger"/>';
                        $('.hide-default_value_text').show();
                        $('#default_value_text').parent().html(default_value_text);
                        $('#default_value_text').datepicker({ showOtherMonths: true});
                        break;
                    case 'boolean':
                        default_value_text = '<select class="select" name="default_value_text" id="default_value_text"><option value="1">Yes</option><option value="0">No</option></select>';
                        $('.hide-default_value_text').show();
                        $('#default_value_text').parent().html(default_value_text);
                        $('#default_value_text').select2({
                        		minimumResultsForSearch: "-1",
                        		width: 200
                        	});
                        break;
                    case 'multiselect':
                    case 'select':
                        $('.hide-option-list').show();
                        $('.hide-default_value_text').hide();
                        break;
                    case 'media_image':
                        $('.hide-default_value_text').hide();
                        break;
                    default:
                        default_value_text = '<input type="text" name="default_value_text" id="default_value_text" class="form-control"/>';
                        $('.hide-default_value_text').show();
                        $('#default_value_text').parent().html(default_value_text);
                        break;
                }

            });

            /* - trigger - */
            $('#frontend_input,#is_required').trigger('change');
        });
    })(jQuery)
</script>