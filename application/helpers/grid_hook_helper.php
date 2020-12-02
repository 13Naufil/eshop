<?php

/**
 * Naufil khan
 * Email: developer.systech@gmail.com
 */

function grid_yes_no_field($value, $row, $selected = '', $field_name = ''){

    switch($value){
        case '0':
        case 'No':
            return '<div class="text-center"><span class="label label-important"><i class="icon-remove"></i></span></div>';
            break;
        case '1':
        case 'Yes':
            return '<div class="text-center"><span class="label label-success"><i class="icon-ok"></i></span></div>';
            break;
        default:
            return '<div class="text-center"><span class="label">'.$value.'</span></div>';
    }
}

function icon_field($value, $row, $selected = '', $field_name = ''){
    return '<div class="text-center"><i class="fa-2x '.$value.'" style=""></i></div>';
}

function product_image($value, $row, $selected = '', $field_name = ''){
    $CI =& get_instance();
    $res = $CI->db->query("SELECT product_images.image FROM product_images WHERE product_images.product_id = {$row['id']} AND product_images.default = 1")->row();
    $HTML = '<img src="'._img('assets/front/products/'.$res->image,120,200) .'" />';
    return $HTML .= '</div>';
}

function status_options($value, $row, $selected = '', $field_name = ''){
    $CI =& get_instance();
    $_STATUS = get_enum_values($CI->table, $field_name);
    $cls = 'warning';
    switch($value){
        case 'Active':
        case 'In Stock':
        case 'Delivered':
            $cls = 'success';
            break;
        case 'Complete':
            $cls = 'primary';
            break;
        case 'Inactive':
        case 'Out of Stock':
        case 'Pending':
            $cls = 'danger';
            break;
    }
    $HTML = '<div class="dropdown text-center">';
    $HTML .= '<button class="btn btn-'.$cls.'" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                '.$value.'
            <span class="caret"></span>
            </button>
  <ul class="dropdown-menu" aria-labelledby="dLabel">';
    if (count($_STATUS) > 0) {
        foreach ($_STATUS as $STATUS) {
            $HTML .= '<li><a href="'.admin_url(getUri(2) . '/' . $field_name . '/' . $row['id'] . '/?' . $field_name . '=' . $STATUS).'">'.$STATUS.'</a></li>';
        }
    }
    $HTML .= '</ul>';
    return $HTML .= '</div>';
}

function status_field($value, $row, $selected = '', $field_name = ''){

    switch($value){
        case 'Inactive':
        case 'Tentative':
            return '<div class="text-center"><span class="label label-warning">'.$value.'</span></div>';
            break;
        case 'Pending':
        case 'Unpaid':
        case 'Not Proven':
            return '<div class="text-center"><span class="label label-important label-danger">'.$value.'</span></div>';
            break;
        case 'Used':
        case 'Active':
        case 'Approved':
        case 'Keep':
        case 'Proven':
        case 'Frontend':
        case 'Paid':
        case 'Booked':
            return '<div class="text-center"><span class="label label-success">'.$value.'</span></div>';
            break;
        case 'Microchipped':
        case 'Assign':
        case 'Stored':
        case 'Applied For':
        case 'Backend':

            return '<div class="text-center"><span class="label label-info">'.$value.'</span></div>';
            break;
        default:
            return '<div class="text-center"><span class="label label-default">'.$value.'</span></div>';
    }
}

function get_user_link ($value, $row, $selected, $field_name){

    switch($field_name){
        case 'member':
            $user_id = $row['member_id'];
            break;
        case 'created_by':
            $user_id = $row['created_by_id'];
            break;
        case 'created_by':
            $user_id = $row['created_by_id'];
            break;
    }

    return '<a class="" href="'.admin_url('users/view/'.$user_id).'">'.$value.'</a>';
}

function get_dog_link ($value, $row, $selected, $field_name){

    switch($field_name){
        case 'sire':
            $dog_id = $row['sire_id'];
            break;
        case 'dam':
            $dog_id = $row['dam_id'];
            break;
    }

    return '<a class="" href="'.admin_url('dogs/view/'.$dog_id).'">'.$value.'</a>';
}

function logs_url_redirect ($value, $row, $selected, $field_name){

    $search = array('update/', 'add/');
    $replace = array('form/', 'form/');
    $link  = str_replace($search, $replace, $value);

    return '<a class="" href="'.$link .'">'.$value.'</a>';
}


function check_domain($val, $row,$sel = ''){

    $regex = "/(http?:\\/\\/)?(www.)?([A-Za-z]+\\.){1,}([A-Za-z]{2,})\\/?/";
    preg_match($regex, $val, $match);
    return ($match[3] . $match[4]);
}

function created_domain($val, $row,$sel = ''){
    return date('Y-m-d H:i:s');
}