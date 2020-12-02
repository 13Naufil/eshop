<?php

if(count($attributes) > 0){
    $set_title = '--Other';
    foreach ($attributes as $i => $attribute) {
        $_classes = $_attr = array();
        $_styles = '';

        if($i > 0 && $set_title != $attribute->set_title){
            echo '</div></div>';
        }
        if($set_title != $attribute->set_title){
            $set_title = $attribute->set_title;
        echo '<div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-wand2"></i>'.(!empty($set_title) ? $set_title : 'Other').'</h6>
                </div>
                <div class="panel-body">';
        }

        echo '<div class="form-group">';

        echo '<label class="col-sm-3 control-label text-right text-right">' . $attribute->admin_label . ' : ';
        if($attribute->is_required == 'Yes'){
            echo '<span class="mandatory">*</span>';
        }
        echo '</label>';
        echo '<div class="col-sm-9">';

        if($product_id <= 0){
            if(!empty($attributes_data[$attribute->id])){
                $attribute_value = htmlentities($attributes_data[$attribute->id]);
            }else {
                $attribute_value = trim(htmlentities($attribute->default_value_text));
            }
        }else{
            if(!empty($attributes_data[$attribute->id])){
                $attribute_value = htmlentities($attributes_data[$attribute->id]);
            }else {
                $attribute_value = trim(htmlentities($attribute->attribute_value, ENT_QUOTES, "UTF-8"));
            }
        }

        if($attribute->is_required == 'Yes'){
            if(!empty($attribute->validation_class)){
                $_classes[] = 'validate[required,' . $attribute->validation_class . ']';
            }else{
                $_classes[] = 'validate[required]';
            }
        }

        switch($attribute->frontend_input){
            case 'textarea':
                echo '<textarea name="attributes['.$attribute->id.']" id="attributes-'.$attribute->id.'" cols="20" rows="5" class="form-control col-sm-12 '.join(' ', $_classes).'">'.$attribute_value.'</textarea>';
                break;
            case 'boolean':
            case 'multiselect':
            case 'select':
                $_first_option = '<option value="">- Select -</option>';

                if($attribute->frontend_input == 'boolean'){
                    $_options = array('No' => 'No', 'Yes' => 'Yes');
                }else{
                    $_options = "SELECT attr_value_id, admin_value FROM attributes_option_values_rel WHERE attribute_id='".intval($attribute->id)."' ORDER BY admin_value";
                }
                $multi = '';
                if($attribute->frontend_input == 'multiselect'){
                    $_attr[] = 'multiple="multiple"';
                    $_attr[] = 'size="6"';
                    $_classes[] = 'multi-select-all';
                    $multi = '[]';
                    $attribute_value = explode(',', $attribute_value);
                }else{
                    $_classes[] = 'select form-control';
                }

                echo '<select '.join(' ', $_attr).' name="attributes['.$attribute->id.']'.$multi.'" id="attributes-'.$attribute->id.'" class="'.join(' ', $_classes).'">';
                echo $_first_option;

                echo selectBox($_options, $attribute_value);
                echo '</select>';
                break;
            case 'file':
                echo '<input type="file" class="'.join(' ', $_classes).' form-control" name="attributes['.$attribute->id.']" id="attributes-'.$attribute->id.'" value="'.$attribute_value.'"/>';
                if(!empty($attribute_value)){
                    echo '<input type="hidden" class="" name="attributes['.$attribute->id.']" id="attributes-'.$attribute->id.'" value="'.$attribute_value.'"/>';
                    echo '<a href="'.asset_url('admin/img/' . $attribute_value).'" class="lightbox">'.$attribute_value.'</a>';
                }
                break;
            default:
                if($attribute->frontend_input == 'date'){
                    $_classes[] = 'datepicker';
                }
                echo '<input type="text" class="'.join(' ', $_classes).' form-control" name="attributes['.$attribute->id.']" id="attributes-'.$attribute->id.'" value="'.stripslashes($attribute_value).'"/>';
                break;
        }
        echo '</div></div>';
    }
}