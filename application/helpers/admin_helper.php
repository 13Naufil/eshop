<?php
/**
 * Naufil khan
 * Email: developer.systech@gmail.com
 */

function admin_url($url = '')
{
    return site_url(ADMIN_DIR . $url);
}
function asset_url($url = '')
{
    return base_url('assets/' . $url);
}

function get_member($user_id, $where = '')
{
    $ci = & get_instance();
    $ci->db->select('users.*, user_types.user_type,users.id as id');
    $ci->db->from('users');
    $ci->db->join('user_types', 'user_types.id = users.user_type_id', 'left');
    $ci->db->where('users.id', intval($user_id));

    if(!empty($where)){
        $ci->db->where($where);
    }

    $ci->db->limit(1);
    return $ci->db->get()->row();
}

function mysql2date($date, $format = 'd F, Y')
{
    if(empty($date) || date('Y-m-d', strtotime($date)) == '1970-01-01'){
        return '0000-00-00';
    }else
    return date($format, strtotime($date));
}

function date2mysql($date, $format = 'Y-m-d')
{
    if(empty($date) || date('Y-m-d', strtotime($date)) == '1970-01-01'){
        return '0000-00-00';
    }else{
        return date($format, strtotime($date));
    }
}

function user_types(){

    $types[1] = get_option('admin_user_type');
    //$types[2] = get_option('driver_type_id');
    $types[3] = get_option('client_type_id');

    $returns = array();
    $args = func_get_args();
    if(count($args) > 0){
        foreach ($args as $k) {
            if(!empty($types[$k]))
            array_push($returns, $types[$k]);
        }
    }else{
        $returns = array_merge($types);
    }

    return $returns;
}