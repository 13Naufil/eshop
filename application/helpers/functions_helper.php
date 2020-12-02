<?php
/**
 * @param $page Object | array | string
 * @return string
 */
function if_null($value, $replace_str = 'N/A', $equal_str = ''){
    if(empty($value) || $value == $equal_str){
        $value = $replace_str;
    }
    return $value;
}

function ordinal_suffix($num)
{
    if ($num < 11 || $num > 13) {
        switch ($num % 10) {
            case 1:
                return 'st';
            case 2:
                return 'nd';
            case 3:
                return 'rd';
        }
    }
    return 'th';
}

function generate_url($remove_param, $url = '')
{
    $ci =& get_instance();
    if (empty($url)) {
        $url = current_url() . '?' . $ci->input->server('QUERY_STRING');
    }
    $parse_url = parse_url($url);

    if (!empty($parse_url['query'])) {
        $QUERY_STRING = $parse_url['query'];
        $_QUERY_STRING = explode('&', $QUERY_STRING);

        if (count($_QUERY_STRING)) {
            foreach ($_QUERY_STRING as $k => $v) {
                $__QUERY_STRING = explode('=', $v);
                if ($__QUERY_STRING[0] == 'do') {
                    unset($_QUERY_STRING[$k]);
                }
                if ($__QUERY_STRING[0] == $remove_param) {
                    unset($_QUERY_STRING[$k]);
                }
                if(empty($__QUERY_STRING[1])){
                    unset($_QUERY_STRING[$k]);
                }
            }
        }
    }

    if(ROOT_DIR != '' && ROOT_DIR != '/'){
        $curent_path = str_replace(ROOT_DIR, '', $parse_url['path']);
    }else{
        $curent_path = $parse_url['path'];
    }

    if (count($_QUERY_STRING) && is_array($_QUERY_STRING)) {
        $NEW_QUERY_STRING = "?" . join('&', $_QUERY_STRING);
    }else{
        $NEW_QUERY_STRING = "?do=1";
    }
    //return site_url($curent_path . '/' . $NEW_QUERY_STRING);
    return site_url($curent_path .  $NEW_QUERY_STRING);
}


function activity_log($activity_name, $table = '', $rel_id = 0, $user_id = 0, $description = null)
{

    $CI =& get_instance();

    if(!is_array($rel_id)){
        $rel_id = array($rel_id);
    }

    if (is_array($rel_id) && count($rel_id) > 0) {

        foreach ($rel_id as $relid) {

            if (getUri(1) == substr(ADMIN_DIR, 0, -1)) {
                $table = (!empty($table) ? $table : getUri(2));
                $user_id = ($user_id > 0) ? $user_id : $CI->session->userdata('cct_user_id');
            } else {
                $table = (!empty($table) ? $table : getUri(1));
                $user_id = ($user_id > 0) ? $user_id : $CI->session->userdata('frontend_user_id');
            }
            $data = array(
                'activity_datetime' => date('Y-m-d H:i:s'),
                'activity_name' => $activity_name,
                'table' => $table,
                'user_id' => $user_id,
                'user_ip' => $CI->input->ip_address(),
                'user_agent' => $CI->input->user_agent(),
                'rel_id' => $relid,
                'current_URL' => current_url(),
                'description' => $description
            );
            $CI->db->insert('activity_log', $data);
        }
    }

}

/**
 * @param string $uri
 * @return string
 */
function template_url($uri = '')
{
    if(!defined('TEMPLATE_NAME')){
        $template = get_option('theme');
        define('TEMPLATE_NAME', $template);
    }else{
        $template = TEMPLATE_NAME;
    }
    return base_url(APPPATH . 'views/themes/' . $template . '/' . $uri);
}
/**
 * @param string $uri
 * @return string
 */
function media_url($uri = '')
{
    if(!defined('TEMPLATE_NAME')){
        $template = get_option('theme');
        define('TEMPLATE_NAME', $template);
    }else{
        $template = TEMPLATE_NAME;
    }
    return asset_url($template . '/' . $uri);
}

/**
 * @param bool $view For load view
 * @return string
 */
function get_template_directory($view = false)
{
    if (!defined('TEMPLATE_NAME')) {
        $template = get_option('theme');
        define('TEMPLATE_NAME', $template);
    } else {
        $template = TEMPLATE_NAME;
    }
    if ($view) {
        return 'themes/' . $template . '/';
    } else {
        return APPPATH . 'views/themes/' . $template . '/';
    }
}

function get_permalink($page, $url_field = 'url', $external_url = '')
{
    $friendly_url = '';
    switch ($page) {
        case is_object($page) :
            $friendly_url = $page_obj->{$url_field};
            break;
        case is_array($page) :
            $friendly_url = $page_obj[$url_field];
            break;
        case is_string($page) :
            $friendly_url = $page;
            break;
    }


    preg_match('/((http|https|ftp|ftps)\:\/\/)+?/i', $friendly_url, $matches);
    if (count($matches) > 0) {
        return $friendly_url;
    } else if (!empty($external_url)) {
        return $external_url . $friendly_url;
    } else {
        return site_url($friendly_url);
    }
}

/**
 * @param $query
 * @param string $selected
 * @return string
 */
function selectBox($query, $selected = '', $template = '<option {selected} value="{key}">{val}</option>')
{
    $CI = & get_instance();
    $options = '';

    if (is_array($query)) {
        $array = $query;
        if (count($array) > 0) {
            foreach ($array as $key => $val) {
                if (is_array($selected)) {
                    $_selected = ((in_array($key, $selected)) ? 'selected' : '');
                    $options .= str_replace(array('{key}', '{val}', '{selected}'), array($key, $val, $_selected), $template);
                    //$options .= '<option value="' . $key . '" ' . ((in_array($key, $selected)) ? 'selected' : '') . '>' . $val . '</option>';
                } else {
                    $_selected = (($key == $selected) ? 'selected' : '');
                    $options .= str_replace(array('{key}', '{val}', '{selected}'), array($key, $val, $_selected), $template);
                    //$options .= '<option value="' . $key . '" ' . (($key == $selected) ? 'selected' : '') . '>' . $val . '</option>';
                }
            }
        }
    } else {
        $result = $CI->db->query($query);

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $key_ar = array_keys($row);
                $row['key'] = $key = $row[$key_ar[0]];
                $row['val'] = $row[$key_ar[1]];

                $_option = $template;
                foreach($row as $k => $v){
                    $_option = str_replace('{'.$k.'}', stripslashes($v) , $_option);
                }

                if (is_array($selected)) {
                    $_selected = ((in_array($key, $selected)) ? 'selected' : '');
                    $options .= str_replace('{selected}', $_selected , $_option);
                } else {
                    $_selected = (($key == $selected) ? 'selected' : '');
                    $options .= str_replace('{selected}', $_selected , $_option);
                }
            }
        }
    }
    return $options;
}

/**
 * @param $query
 * @param $name
 * @param string $checked
 * @param string $label_position
 * @param array $attrs
 * @param string $type
 * @return string
 */
function checkBox($query, $name, $checked = '', $label_position = 'right', $attrs = '', $type = 'checkbox')
{
    $CI = & get_instance();
    $CI->load->database();


    $options = '';
    if (is_array($query)) {
        $array = $query;
        if (count($array) > 0) {
            foreach ($array as $key => $val) {

                if (is_array($checked)) {
                    $options .= '<li class="checkbox_li li_' . $key . '">' . (($label_position != 'right') ? $val : '');
                    $options .= '<input type="' . $type . '" value="' . $val . '" name="' . $name . '" ' . ((in_array($key, $checked)) ? 'checked' : '') . ' ' . $attrs . '> ';
                    $options .= (($label_position == 'right') ? $val : '') . "</li>";
                } else {
                    $options .= '<li class="checkbox_li li_' . $key . '">' . (($label_position != 'right') ? $val : '');
                    $options .= '<input type="' . $type . '" value="' . $val . '" name="' . $name . '" ' . (($key == $checked) ? 'checked' : '') . ' ' . $attrs . '> ';
                    $options .= (($label_position == 'right') ? $val : '') . "</li>";
                }
            }
        }
    } else {
        $result = $CI->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $key = array_keys($row);

                if (is_array($checked)) {
                    $options .= '<li class="checkbox_li li_' . $row[$key[0]] . '">' . (($label_position != 'right') ? $row[$key[1]] : '');
                    $options .= '<input type="' . $type . '" value="' . $row[$key[0]] . '" name="' . $name . '" ' . ((in_array($row[$key[0]], $checked)) ? 'checked' : '') . ' ' . $attrs . '> ';
                    $options .= (($label_position == 'right') ? $row[$key[1]] : '') . "</li>";
                } else {
                    $options .= '<li class="checkbox_li li_' . $row[$key[0]] . '">' . (($label_position != 'right') ? $row[$key[1]] : '');
                    $options .= '<input type="' . $type . '" value="' . $row[$key[0]] . '" name="' . $name . '" ' . (($row[$key[0]] == $checked) ? 'checked' : '') . ' ' . $attrs . '> ';
                    $options .= (($label_position == 'right') ? $row[$key[1]] : '') . "</li>";
                }
            }
        }
    }
    return $options;
}

/**
 * @param $name
 * @param bool $xss_clean
 * @return string
 */

function getVar($name, $xss_clean = TRUE, $escape_sql = TRUE)
{
    $CI = & get_instance();
    if ($escape_sql) {
        return $CI->db->escape_str($CI->input->get_post($name, $xss_clean));
    } else {
        return $CI->input->get_post($name, $xss_clean);
    }
}

function getVarDB($name, $xss_clean = TRUE)
{
    $CI = & get_instance();
    return $CI->db->escape_str($CI->input->get_post($name, $xss_clean));
}

function dbEscape($string)
{
    $CI = & get_instance();
    return $CI->db->escape_str($string);
}


/**
 * @param $table
 * @param $column
 * @param string $where
 * @return mixed
 */
function getVal($table, $column, $where = '')
{
    $CI = & get_instance();
    $CI->load->database();
    $q = "SELECT $column FROM `$table` " . $where . " LIMIT 1";
    return $CI->db->query($q)->row()->$column;

}

/**
 * @param $table
 * @param string $column
 * @param string $where
 * @return mixed
 */
function getValues($table, $column = '*', $where = '', $single = true)
{
    $CI = & get_instance();
    $CI->load->database();
    $RS = $CI->db->query("SELECT $column FROM `$table` " . $where);
    return (($single) ? $RS->row() : $RS->result());

}

/**
 * @deprecated
 * @param $name
 * @param bool $xss_clean
 * @return string
 */
function gerVar($name, $xss_clean = TRUE)
{
    return getVar($name, $xss_clean);
}

function encryptPassword($password)
{
    return md5('adnan87' . $password . 'tgm786');
}

/**
 * @param $number
 * @return string
 */
function getUri($number)
{
    $CI = & get_instance();
    return $CI->uri->segment($number);
}


function cellNumber($cellnumber)
{
    if (!empty($cellnumber)) {
        $cellnumber = (substr($cellnumber, 0, 1) != '0' ? '0' . $cellnumber : $cellnumber);
    }
    return $cellnumber;
}

function removeZero($str)
{
    $str = (substr($str, 0, 1) === '0' ? substr($str, 1) : $str);
    return $str;
}


function replaceChar($string, $num = 3, $replacement = 'x')
{

    $newStr = '';
    $length = (strlen($string) - $num);
    for ($i = 1; $i <= $length; $i++) {
        $newStr .= $replacement;
    }
    return $newStr . substr($string, $length, $num);
}

/**
 * @param $page
 * @param $per_page
 * @return string
 */
function getLimit($page, $per_page)
{
    $offset = ($page > 0 ? $page : 0);
    return " LIMIT " . $offset . ", " . $per_page;
}

/**
 * @param $table
 * @param $data array() 'key' => 'value'
 * @param string $where (WHERE 1=1)
 * @return string insert_id | WHERE
 */
function save($table, $data, $where = '')
{
    $CI = & get_instance();
    $CI->load->database();

    if (empty($where)) {
        $SQL = $CI->db->insert_string($table, $data);

        if($CI->db->query($SQL))
            return $CI->db->insert_id();
        else
            return false;
    } else {
        $SQL = $CI->db->update_string($table, $data, $where);
        if($CI->db->query($SQL))
            return true;
        else
            return false;
    }
}


function saveDB2($table, $data, $where = '', $db = 'ivr')
{
    $CI = & get_instance();
    $db2 = $CI->load->database($db, TRUE);

    if (empty($where)) {
        $SQL = $db2->insert_string($table, $data);
        $db2->query($SQL);
        return $db2->insert_id();
    } else {
        $SQL = $db2->update_string($table, $data, $where);
        $db2->query($SQL);
        return true;
    }
}

/*-------------------------------------------------------*/
$SEARCH_Q = array();
function getWhereClause($SQL, $key = 'search'){
    global $SEARCH_Q;
    $CI = & get_instance();
    $search_REQ = $CI->input->get($key);

    $query_col_str = ',' . substr($SQL, 6, (stripos(trim($SQL), 'FROM') - 6));

    /**
     * $exp = "/(?:select|\\G)\\s+\\K(?:(?:.*?\\s+as\\s+([^,]+),?)|([^,]+),?)(?=.*?\\bfrom\\b)/si";
     * preg_match_all($exp, $SQL, $columns);
     */

    /**
     * OK
     * $query_col_str = ', ' . substr($SQL, (stripos($SQL, 'SQL_CALC_FOUND_ROWS') + 28), (stripos($SQL, 'FROM') - 35));
     */

    foreach ($search_REQ as $field => $search_v) {
        preg_match('/\,(.*)? as ' . $field . '/i', $query_col_str, $table_alias);

        preg_match('/\,(.*?)\,/i', $table_alias[0], $_table_alias);

        if(!empty($_table_alias[0])){
            $column_alias = trim(substr($table_alias[1], strlen(substr($_table_alias[0], 1))));
        }else{
            $column_alias = trim($table_alias[1]);
        }


        if (empty($column_alias)) {
            preg_match('/\,(.*)?\.' . $field . '\b/i', $query_col_str, $table_alias);
            $column_alias = trim($table_alias[1] . '.' . $field);
            if (!isset($table_alias[1])) {
                $column_alias = $field;
            }
        }

        //echo '<pre>';print_r($field . ': ' .$column_alias);echo '</pre>';
        $SEARCH_Q[$key.'_q'][$field] = $column_alias;
    }
}

function getFindQuery($query, $key = 'search')
{
    global $SEARCH_Q;
    $CI = & get_instance();
    getWhereClause($query);
    $search_REQ = $CI->input->get($key);
    //$search_QUERY = $CI->input->get($key . '_q');
    $search_QUERY = $SEARCH_Q[$key . '_q'];

    $filter = $CI->input->get('filter');
    $search_q = '';

    foreach ($search_REQ as $search_f => $search_v) {
        $search_arr = null;
        if (!empty($search_v)) {
            $search_arr = explode(':', $search_f);
            $_operator = $filter[$search_f];
            if(!empty($search_QUERY[$search_f])){
                $s_coulum = ($search_QUERY[$search_f]);
                $s_coulum = strip_tags($s_coulum);
            }else if (count($search_arr) >= 2) {
                $s_coulum = (!empty($search_arr[0])) ? $search_arr[0] . '.' . $search_arr[1] : $search_arr[1];
            } elseif (count($search_arr) == 1) {
                $s_coulum = $search_arr[0];
            }

            if(is_array($search_REQ[$search_f])){
                if($search_REQ[$search_f]['from_date'] != '' && $search_REQ[$search_f]['to_date'] != ''){
                    $from = date2mysql($search_REQ[$search_f]['from_date']);
                    $to = date2mysql($search_REQ[$search_f]['to_date']);

                    $search_q .= " AND DATE_FORMAT({$s_coulum}, '%Y-%m-%d') BETWEEN '{$from}' AND '{$to}'";
                }else if($search_REQ[$search_f]['from'] != '' && $search_REQ[$search_f]['to'] != ''){
                    $from = ($search_REQ[$search_f]['from']);
                    $to = ($search_REQ[$search_f]['to']);

                    $search_q .= " AND $s_coulum BETWEEN {$from} AND {$to}";
                }

            }else{

                switch ($_operator) {
                    case '%-%':
                        $search_q .= " AND {$s_coulum} LIKE '%{$CI->db->escape_like_str($search_v)}%'";
                        break;
                    case '%!-%':
                        $search_q .= " AND {$s_coulum} NOT LIKE '%{$CI->db->escape_like_str($search_v)}%'";
                        break;
                    case '-%':
                        $search_q .= " AND {$s_coulum} LIKE '{$CI->db->escape_like_str($search_v)}%'";
                        break;
                    case '%-':
                        $search_q .= " AND {$s_coulum} LIKE '%{$CI->db->escape_like_str($search_v)}'";
                        break;
                    case '=':
                        $search_q .= " AND {$s_coulum} = '".dbEscape($search_v)."'";
                        break;
                    case '!=':
                        $search_q .= " AND {$s_coulum} != '".dbEscape($search_v)."'";
                        break;
                    case '>':
                        $search_q .= " AND {$s_coulum} > '".dbEscape($search_v)."'";
                        break;
                    case '>=':
                        $search_q .= " AND {$s_coulum} >= '".dbEscape($search_v)."'";
                        break;
                    case '<':
                        $search_q .= " AND {$s_coulum} < '".dbEscape($search_v)."'";
                        break;
                    case '<=':
                        $search_q .= " AND {$s_coulum} <= '".dbEscape($search_v)."'";
                        break;
                    default:
                        $search_q .= " AND {$s_coulum} LIKE '%{$CI->db->escape_like_str($search_v)}%'";

                }
            }
        }
    }

    return $search_q;
}

/**
 * @param $field_alias
 * @param $org_filed_str
 * @param $where_query
 */
function replace_find_query($field_alias, $org_filed_str, &$where_query){
    $where_query = str_ireplace('AND ' . $field_alias, 'AND ' . $org_filed_str, $where_query);
}


function fileDownload($file)
{


    $rs = get_file_info($file);
    $file_name = explode('/', $rs['name']);

    header('Content-Description: File Transfer');
    header('Content-Type: ' . $type);
    header('Content-Disposition: attachment; filename=' . end($file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    // Send file headers
}

/**
 * @param $table
 * @param array $ignore
 * @return array
 */
function getDbArray($table, $ignore = array(), $post_data = array())
{
    $CI = & get_instance();
    $CI->load->database();

    $fields = $CI->db->field_data($table);

    $dbArray = array();
    foreach ($fields as $field) {
        if(count($post_data) > 0){
            if (!in_array($field->name, $ignore) && (isset($post_data[$field->name]))) {
                if ($field->primary_key && !empty($post_data[$field->name])) {
                    $dbArray['where'] = "`" . $field->name . "`= '" . dbEscape($post_data[$field->name]) . "'";
                } else {
                    $dbArray['dbdata'][$field->name] = ($post_data[$field->name]);
                }
            }
        }else {
            if (!in_array($field->name, $ignore) && (isset($_REQUEST[$field->name]) || isset($_POST[$field->name]) || isset($_GET[$field->name]))) {
                if ($field->primary_key) {
                    $dbArray['where'] = "`" . $field->name . "`= '" . getVar($field->name) . "'";
                } else {
                    $dbArray['dbdata'][$field->name] = getVar($field->name, TRUE, FALSE);
                }
            }
        }
    }

    return $dbArray;
}

function getActionsCheckBox($params, $selected)
{
    $CI = & get_instance();
    $CI->load->database();

    $component_id = $params['component_id'];
    $actions = explode(',', $params['actions']);

    if (count($actions) > 0 && !empty($actions[0])) {
        $userAction = explode(',', $params['user_actions']);
        $html .= '<br>' . nbs(6);
        foreach ($actions as $action) {
            $html .= '<input type="checkbox" ' . ((in_array($action, $userAction)) ? "checked" : "") . ' name="actions[' . $component_id . '][]" id="actions_' . $component_id . '" value="' . $action . '"> ';
            $html .= $action . nbs(3);
        }
        $html .= '<br><br>';
    }
    return $html;
}


function singleColArray($query, $column)
{
    $ci = & get_instance();

    $rows = $ci->db->query($query)->result();
    $rt_array = array();
    if (count($rows) > 0) {
        foreach ($rows as $row) {
            array_push($rt_array, $row->$column);
        }
    }
    return $rt_array;
}

function array2url($array, $keyName)
{
    $url = '';
    foreach ($array as $key => $val) {
        $url .= (($key == 0) ? '' : '&') . $keyName . '=' . $val;
    }
    return $url;
}

function show_validation_errors($button = true, $show_notification = true)
{
    $CI = get_instance();
    $error = getVar('error');
    $msg = getVar('msg');
    $success = getVar('success');
    $alert = getVar('alert');
    $info = getVar('info');


    $button_html = '';
    if($button){
        $button_html = '<button type="button" class="close" data-dismiss="alert">×</button>';
    }

    $html = '';
    if (validation_errors() != '' || !(count($error) == 0 || $error == '')) {
        $errors = validation_errors() . (is_array($error) ? join('<br>', $error) : $error);
        $html .= '<div class="alert alert-danger ">' . $button_html;
        $html .= $errors . '</div>';
    }
    if (!(count($msg) == 0 || $msg == '')) {
        $html .= '<div class="alert alert-success ">' . $button_html;
        $html .= (is_array($msg) ? join('<br>', $msg) : $msg) . '</div>';
    }
    if (!(count($success) == 0 || $success == '')) {
        $html .= '<div class="alert alert-success ">' . $button_html;
        $html .= (is_array($success) ? join('<br>', $success) : $success) . '</div>';
    }
    if (!(count($alert) == 0 || getVar('alert') == '')) {
        $html .= '<div class="alert alert-danger ">' . $button_html;
        $html .= (is_array($alert) ? join('<br>', $alert) : $alert) . '</div>';
    }
    if (!(count($info) == 0 || $info == '')) {
        $html .= '<div class="alert alert-info ">' . $button_html;
        $html .= (is_array($info) ? join('<br>', $info) : $info) . '</div>';

    }
    if ($CI->session->flashdata('success')) {
        $html .= '<div class="alert alert-success fade in">' . $button_html;
        $html .= $CI->session->flashdata('success') . '</div>';
    }

    if ($CI->session->flashdata('alert')) {
        $html .= '<div class="alert fade in">' . $button_html;
        $html .= $CI->session->flashdata('alert') . '</div>';
    }

    if ($CI->session->flashdata('error')) {
        $html .= '<div class="alert alert-danger fade in"> ' . $button_html;
        $html .= $CI->session->flashdata('error') . '</div>';
    }

    if($show_notification){
        $html .= get_notification();
    }

    return $html;
}

/*function show_validation_errors()
{
    if (validation_errors() != '') {
        $html = '<div class="alert alert-error" style="margin-top: 16px;">
        	    <button type="button" class="close" data-dismiss="alert">×</button>';
        $html .= validation_errors();
        return $html .= '</div>';
    }
    return '';
}*/


function delete_rows($table, $where = '', $force_delete = TRUE, $delete_status = 'deleted', $status_column = 'status', $unlink_files = array())
{
    $CI = & get_instance();
    if (count($unlink_files) > 0) {
        foreach ($unlink_files as $field_name => $file_path) {
            $S_SQL = "SELECT {$field_name} FROM {$table} WHERE {$where}";
            $RS = $CI->db->query($S_SQL);
            foreach ($RS->result() as $row) {
                @unlink($file_path . $row->{$field_name});
            }
        }
    }
    if ($force_delete) {
        $SQL = "DELETE FROM {$table} WHERE {$where}";
    } else {
        $SQL = "UPDATE {$table} SET `$status_column` = '" . $delete_status . "' WHERE {$where}";
    }

    return $CI->db->query($SQL);

}

function _checkbox($value, $default = 1){
    if (is_array($value) && in_array($default, $value)) {
        return ' checked="checked" ';
    }elseif($value == $default){
        return ' checked="checked" ';
    }
}

function _radiobox($value, $default = 1){
    if (is_array($value) && in_array($default, $value)) {
        return ' checked="checked" ';
    } elseif ($value == $default) {
        return ' checked="checked" ';
    }
}

function _selectbox($value, $default = 1){
    if (is_array($value) && in_array($default, $value)) {
        return ' selected="selected" ';
    } elseif ($value == $default) {
        return ' selected="selected" ';
    }
}

function generate_image($source_image, $new_image, $width, $height = null)
{

    $obj =& get_instance();

    $obj->load->helper('url');
    $obj->load->helper('thumb');

    if(function_exists('thumb')){
        return thumb($source_image, $new_image, $width, $height);

    }else {
        $obj->load->library('image_lib');

        $config['image_library'] = 'gd2';

        $config['source_image'] = $source_image;
        $config['new_image'] = $new_image;
        $config['width'] = $width;
        $config['quality'] = 100;
        $config['maintain_ratio'] = FALSE;

        if (!empty($height)) {
            $config['height'] = $height;
        } else {
            $config['maintain_ratio'] = TRUE;
        }

        $obj->image_lib->initialize($config);

        $obj->image_lib->resize();

    }
    return $config['new_image'];
}


function array2object($array)
{
    $object = new stdClass();
    foreach ($array as $key => $value) {
        $object->$key = $value;
    }
    return $object;
}

function get_enum_values($table, $field, $assoc = true)
{
    $CI = & get_instance();
    $CI->load->database();
    $type = $CI->db->query("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'")->row()->Type;
    preg_match('/^enum\((.*)\)$/', $type, $matches);
    foreach (explode(',', $matches[1]) as $value) {
        if ($assoc) {
            $enum[trim($value, "'")] = trim($value, "'");
        } else {
            $enum[] = trim($value, "'");
        }
    }
    return $enum;
}

/*function getOneRowInArray($array,$key)
{
    foreach ($array as $key => $val) {

    }
}*/

function friendly_url($friendly_url)
{

    return site_url($friendly_url . '.php');
}


function getFlash($key, $value = '')
{
    $CI = & get_instance();
    if(!empty($value)){
        return $CI->session->set_flashdata($key, $value);
    }else{
        return $CI->session->flashdata($key);
    }
}

function redirectBack($redirect = true)
{
    $CI = & get_instance();
    $_redirect = $CI->input->server('HTTP_REFERER');
    if($redirect){
        redirect($_redirect);
    }else{
        return $_redirect;
    }
}

/**
 * @param $number
 * @return string
 */
function getSession($name, $value = '')
{
    $CI = & get_instance();
    if(!empty($value)){
        return $CI->session->set_userdata($name, $value);
    }else{
        return $CI->session->userdata($name);
    }
}

function has_option($option)
{
    $CI = & get_instance();
    $CI->load->database();

    if ($CI->db->query("SELECT * FROM `options` WHERE option_name=" . $CI->db->escape($option) . "")->num_rows()) {
        return true;
    } else
        return false;
}

$_options = array();
function get_option($option, $key = null)
{
    global $_options;
    if (in_array($option, $_options)) {
        if($key){
            $option_value = $_options[$option];
            $frontend_inputs = explode("\n", trim($option_value));
            foreach($frontend_inputs as $front_input){
                $front_inputs = explode('=', trim($front_input));
                if($front_inputs[1] == $key){
                    $option_value = trim($front_inputs[0]);
                }
                //$__frontend_inputs[trim($front_inputs[0])] = $front_inputs[1];
            }
            return $option_value;
        }else{
            return $_options[$option];
        }
    }

    $ci = & get_instance();
    $_option_vals = $ci->db->query("SELECT * FROM `options` WHERE 1 ")->result();

    if(count($_option_vals) > 0){
        foreach($_option_vals as $_val){
            $_options[$_val->option_name] = $_val->option_value;
        }
    }

    return $_options[$option];

    /*$option_value = $ci->db->query("SELECT option_value FROM `options` WHERE option_name=" . $ci->db->escape($option) . "")->row()->option_value;
    if($key){
        $frontend_inputs = explode("\n", trim($option_value));
        foreach($frontend_inputs as $front_input){
            $front_inputs = explode('=', trim($front_input));
            if($front_inputs[1] == $key){
                $option_value = trim($front_inputs[0]);
            }
            //$__frontend_inputs[trim($front_inputs[0])] = $front_inputs[1];
        }
    }
    return $option_value;*/
}


function object2array($object)
{
    $return = NULL;
    if (is_array($object)) {
        foreach ($object as $key => $value)
            $return[$key] = object2array($value);
    } else {
        $var = get_object_vars($object);

        if ($var) {
            foreach ($var as $key => $value)
                $return[$key] = ($key && !$value) ? NULL : object2array($value);
        } else return $object;
    }

    return $return;
}


function getDays($date1, $date2)
{
    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);
    $secondsDifference = abs($ts2 - $ts1);
    return $days = floor($secondsDifference / (60 * 60 * 24));
}


function doPlural($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals
function get_date_diff($start_date, $end_date)
{

    $datetime1 = new DateTime($start_date);
    $datetime2 = new DateTime($end_date);
    $interval = $datetime1->diff($datetime2);



    $format = array();
    if($interval->y !== 0) {
        $format[] = "%y ".doPlural($interval->y, "year");
    }
    if($interval->m !== 0) {
        $format[] = "%m ".doPlural($interval->m, "month");
    }
    if($interval->d !== 0) {
        $format[] = "%d ".doPlural($interval->d, "day");
    }
    if($interval->h !== 0) {
        $format[] = "%h ".doPlural($interval->h, "hour");
    }
    if($interval->i !== 0) {
        $format[] = "%i ".doPlural($interval->i, "minute");
    }
    if($interval->s !== 0) {
        if(!count($format)) {
            return "less than a minute ago";
        } else {
            $format[] = "%s ".doPlural($interval->s, "second");
        }
    }

    // We use the two biggest parts
    if(count($format) > 1) {
        $format = array_shift($format)." and ".array_shift($format);
    } else {
        $format = array_pop($format);
    }

    // Prepend 'since ' or whatever you like
    return $interval->format($format);
}


function getModuleDetail($module = '', $where = '')
{

    $CI =& get_instance();
    $CI->load->database();

    if (empty($module)) {
        $module = $CI->uri->segment(2);
    };
    $sql = "SELECT *, IF(icon !='', icon, 'module.png') AS icon FROM modules WHERE module=" . $CI->db->escape($module) . $where;
    $row = $CI->db->query($sql)->row();
    if(strpos($row->icon,'icon-') !== false){
        $row->module_icon = '<i class="'.$row->icon.'"></i>';
    }else{
        $row->module_icon = '<img width="22" src="'.base_url('assets/admin/img/icons/22_' . $row->icon).'"/>';
    }
    return $row;
}

function getUserActions($module = NULL)
{

    $CI =& get_instance();

    if (!$module) {
        $module = $CI->uri->segment(2);
    }
    $user_actions = $CI->session->userdata('actions');
    return $user_actions = array_unique(explode('|', str_replace(array('update'), array('edit'), $user_actions[$module])));
}

function multiFileArray($inputName)
{

    foreach ($_FILES[$inputName] as $key => $files) {
        /*foreach ($files['name'] as $_fk => $file){
            $_FILES[$files_str . $i][$key] = $files[$_fk];
            if (!in_array($files_str . $key, $_MYFILES))
                $_MYFILES[] = $files_str . $key;
        }*/
        for ($i = 0; $i < count($files); $i++) {
            $_FILES[$inputName . $i][$key] = $files[$i];
            if (!in_array($inputName . $i, $_MYFILES))
                $_MYFILES[] = $inputName . $i;
        }
    }
    unset($_FILES[$inputName]);
    return $_MYFILES;
}

if (!function_exists('array_trim')) {

    function array_trim(&$data)
    {
        foreach ($data as &$a) {
            $a = addslashes(trim($a));
        }
    }
}


function _lang($var)
{

    $CI =& get_instance();
    $CI->load->helper('language');

    $lang = $CI->session->userdata('lang');
    $language = getVal('languages', 'language', "WHERE iso_code='" . dbEscape($lang) . "'");

    $CI->lang->load($lang, strtolower($language));

    return $CI->lang->line($var);
}


function saveLang($table, $id, $lang, $langFields = array())
{
    $CI =& get_instance();
    if (!($lang == 'en' || empty($lang))) {
        $del_SQL = "DELETE FROM `translations` WHERE `table`='" . dbEscape($table) . "' AND pri_id='" . dbEscape($id) . "' AND lang='" . dbEscape($lang) . "'";
        $CI->db->query($del_SQL);
        foreach ($langFields as $field) {
            if (getVar($field, 1, 0) != '') {
                $data = array(
                    'lang' => $lang,
                    'table' => $table,
                    'pri_id' => $id,
                    'column' => $field,
                    'value' => addslashes(getVar($field, 0, 0))
                    //'value' => addslashes($_POST[$field])
                );

                save('translations', $data);
            }
        }
    }
}

function langRecord($table, $id, $lang, $langFields = array(), $rowData = array(), $is_object = true)
{
    $CI =& get_instance();
    if (!($lang == 'en' || empty($lang))) {
        $SQL = "SELECT * FROM `translations` WHERE `table`='" . dbEscape($table) . "' AND pri_id='" . dbEscape($id) . "' AND lang='" . dbEscape($lang) . "' AND `column` IN ('" . join("','", $langFields) . "')";
        $result = $CI->db->query($SQL)->result();

        foreach ($langFields as $field) {
            if ($is_object) {
                $rowData->{$field} = '';
            } else {
                $rowData[$field] = '';
            }
        }
        foreach ($result as $row) {
            if ($is_object)
                $rowData->{$row->column} = $row->value;
            else {
                $rowData[$row->column] = $row->value;
            }
        }
    }

    return $rowData;
}

function updateLangRecord($lang, $langFields, &$rowData)
{

    if (!($lang == 'en' || empty($lang))) {

        foreach ($langFields as $field) {
            unset($rowData[$field]);
        }
    }
}


function set_notification($message, $type)
{
    $CI = & get_instance();
    $notification = $CI->session->userdata('notification');
    $notification[$type][] = $message;
    $CI->session->set_userdata(array('notification' => $notification));
}

function get_notification()
{

    $CI = & get_instance();
    $notification_ar = $CI->session->userdata('notification');

    $CI->session->set_userdata(array('notification' => ''));
    $notification = '';
    if (count($notification_ar) > 0) {
        foreach ($notification_ar as $type => $message) {
            $notification .= '<div class="alert alert-' . $type . '">' . join('<br/>', $message) . '</div>';
        }
    }
    return $notification;
}


function decode_content($val, $row)
{
    $val = unserialize($val);
    $str = '';
    $youtube_url = 'http://www.youtube.com/watch?v=';
    if (count($val) > 0) {
        foreach ($val as $k => $v) {
            if ($k == 'source') {
                $youtube_url .= substr(end(explode('/', $v)), 0, -4);
            }
            $str .= '<strong>' . $k . '</strong> : ' . $v . '<br>';
        }
        $str .= '<strong style="color:red;">Youtube URL </strong> : ' . $youtube_url . '<br>';
    }
    return $str;
}

function image_thumb($image_path, $width = '', $height = '', $zoom_crop = 1, $alt_image = './assets/front/uploads/404_image.png')
{
    if (!(file_exists('./' . $image_path) && is_file('./' . $image_path))) {
        $image_path = $alt_image;
    }

    $_image_path = explode('/', $image_path);
    $_file_name = end($_image_path);
    $image_path = str_replace($_file_name, urlencode($_file_name), $image_path);
    return site_url('thumbs/' . ($image_path) . '?w=' . $width . '&h=' . $height . '&zc=' . $zoom_crop . '&hash=' . md5($image_path));
}


function _img($image_path, $width = '', $height = '', $alt_image = './assets/front/uploads/404_image.png')
{
    $_image_path = explode('/', $image_path);
    $_file_name = urlencode(end($_image_path));
    $new_image = str_replace($_file_name, $width . 'x' . $height . '_' . $_file_name, $image_path);

    if (file_exists('./' . $new_image) && is_file('./' . $new_image)) {
        $image_path = $new_image;
    }elseif (file_exists('./' . $image_path) && is_file('./' . $image_path)) {
        $image_path = generate_image('./' . $image_path, $new_image, $width,$height);
    }else{
        $_alt_image_path = explode('/', $alt_image);
        $_alt_image = urlencode(end($_alt_image_path));
        $new_alt_image = str_replace($_alt_image, $width . 'x' . $height . '___' . $_alt_image, $alt_image);

        if (file_exists($new_alt_image)) {
            $image_path = $new_alt_image;
        }else{
            $image_path = generate_image($alt_image, $new_alt_image, $width,$height);
        }

    }

    return base_url(str_replace('./','',$image_path));
}

function getLatLng($address)
{

    $gmap_url = "http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=" . urlencode($address);
    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $gmap_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $result = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($result);
    $result = $result->results[0]->geometry->location;

    return $result;
}

function post_without_wait($url, $params)
{

    foreach ($params as $key => &$val) {
      if (is_array($val)) $val = implode(',', $val);
        $post_params[] = $key.'='.urlencode($val);
    }
    $post_string = implode('&', $post_params);

    $parts=parse_url($url);

    $fp = fsockopen($parts['host'],
        isset($parts['port'])?$parts['port']:80,
        $errno, $errstr, 30);

    $out = "POST ".$parts['path']." HTTP/1.1\r\n";
    $out.= "Host: ".$parts['host']."\r\n";
    $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out.= "Content-Length: ".strlen($post_string)."\r\n";
    $out.= "Connection: Close\r\n\r\n";
    if (isset($post_string)) $out.= $post_string;

    fwrite($fp, $out);
    fclose($fp);
}



function multiRequest($URLs, $options = array())
{

    // array of curl handles
    $curly = array();
    // data to be returned
    $result = array();

    // multi handle
    $mh = curl_multi_init();

    // loop through $data and create curl handles
    // then add them to the multi-handle
    foreach ($URLs as $id => $d) {

        $curly[$id] = curl_init();

        $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
        curl_setopt($curly[$id], CURLOPT_URL, $url);
        curl_setopt($curly[$id], CURLOPT_HEADER, 0);
        curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);

        // post?
        if (is_array($d)) {
            if (!empty($d['post'])) {
                curl_setopt($curly[$id], CURLOPT_POST, 1);
                curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
            }
        }

        // extra options?
        if (!empty($options)) {
            curl_setopt_array($curly[$id], $options);
        }

        curl_multi_add_handle($mh, $curly[$id]);
    }

    // execute the handles
    $running = null;
    do {
        curl_multi_exec($mh, $running);
    } while ($running > 0);


    // get content and remove handles
    foreach ($curly as $id => $c) {
        $result[$id] = curl_multi_getcontent($c);
        curl_multi_remove_handle($mh, $c);
    }

    // all done
    curl_multi_close($mh);

    return $result;
}


function randomcode()
{
    $charsets = array();
    $charsets[] = array("count" => 5, "char" => "ABCDEFGHIJKLMNOPQRSTUVWXYZ");
    $charsets[] = array("count" => 5, "char" => "0123456789");
    $code = array();
    foreach ($charsets as $charset) {
        for ($i = 0; $i < $charset["count"]; $i++) {
            $code[] = $charset["char"][rand(0, strlen($charset["char"]) - 1)];
        }
    }
    shuffle($code);
    return implode("", $code);
}

/**
 * @param $var_data_query mixed query and data
 * @param $email_temp_name
 * @return mixed
 */
function get_email_template($var_data_query, $template_name, $message = '')
{
    $ci =& get_instance();

    if(!empty($template_name)){
        $template = $ci->db->query("SELECT *, REPLACE(message, '../../../assets/', '".asset_url()."/') AS message FROM email_templates WHERE name='{$template_name}'")->row();
    }else{
        $template->message = $template->subject = $message;
    }

    if (is_object($var_data_query)) {
        $var_data_query = object2array($var_data_query);
    }

    if (!is_array($var_data_query)) {
        $var_data_query = $ci->db->query($var_data_query)->row_array();
    }
    
    $var_data_query['site_url'] = site_url();
    $var_data_query['current_url'] = current_url();
    $var_data_query['base_url'] = base_url();
    $var_data_query['admin_url'] = admin_url();
    $var_data_query['site_title'] = get_option('site_title');
    $var_data_query['contact_email'] = get_option('contact_email');
    $var_data_query['copyright'] = get_option('copyright');
    $var_data_query['logo_url'] = asset_url(ADMIN_DIR . 'img/' . get_option('logo'));


    foreach ($var_data_query as $col => $val) {
        $template->subject = stripslashes(str_ireplace('[' . $col . ']', $val, $template->subject));
        $template->message = stripslashes(str_ireplace('[' . $col . ']', $val, $template->message));
    }
    $template->subject = preg_replace('/\[(.*)\]/', '', $template->subject);
    $template->message = preg_replace('/\[(.*)\]/', '', $template->message);

    if(empty($template_name) && !empty($message)){
        return $template->message;
    }
    return $template;

}

function send_mail($emaildata = array())
{

    if(empty($emaildata['to'])){
        return false;
    }

    $ci =& get_instance();

    $ci->load->library('email');

    $from = (!empty($emaildata['from']) ? $emaildata['from'] : get_option('contact_email'));
    $from_name = (!empty($emaildata['from_name']) ? $emaildata['from_name'] : get_option('site_title'));
    $ci->email->from($from, $from_name);

    $ci->email->to($emaildata['to']);

    if (isset($emaildata['cc'])) {
        $ci->email->cc($emaildata['cc']);
    }

    if (isset($emaildata['bcc'])) {
        $ci->email->bcc($emaildata['bcc']);
    }

    $ci->email->subject($emaildata['subject']);
    $ci->email->message($emaildata['message']);

    $ci->email->mailtype = 'html';

    if (isset($emaildata['attach'])) {
        foreach ($emaildata['attach'] as $attach) {
            if (!empty($attach))
                $ci->email->attach($attach);
        }
    }

    if (get_option('smtp')) {
        $ci->email->smtp_host = get_option('smtp_host');
        $ci->email->smtp_user = get_option('smtp_user');
        $ci->email->smtp_pass = get_option('smtp_pass');
        $ci->email->smtp_port = get_option('smtp_port');
    }

    if ($ci->email->send()){
        return true;
    }else{
        return false;
    }
}

function send_sms($message, $number){
    return true;
}

function random_db_field_value($table, $field, $value, $where = '') {
    $ci = & get_instance();

    $_WHERE = " WHERE " . $field . "='".$value."'";
    $SQL = "SELECT " . $field . " FROM " . $table . $_WHERE . str_ireplace('WHERE', 'AND', $where);

    $query = $ci->db->query($SQL);
    if($query->num_rows() > 0) {
        $value .= random_string('numeric',4);
        random_db_field_value($table, $field, $value, $where);
    }else{
        return $value;
    }
}

function user_info($key = '')
{
    $CI = & get_instance();
    $user_data = $CI->session->userdata('user_info');

    $user = new stdClass();
    if (count($user_data) > 0) {
        foreach ($user_data as $k => $u) {
            $user->{$k} = $u;
        }
    }
    if(!empty($key)){
        return $user->$key;
    }else
    return $user;
}




function user_do_action($action, $module = '')
{
    $ci = & get_instance();

    $module = (!empty($module) ? $module : getUri(2));

    $user_actions = $ci->db->query("SELECT um.actions FROM users AS u INNER JOIN user_type_module_rel AS um ON (u.user_type_id = um.user_type_id) INNER JOIN modules AS m ON (m.id = um.module_id) WHERE u.id = '" . intval($ci->session->userdata('cct_user_id')) . "' AND m.`module`='" . addslashes($module) . "'")->row()->actions;
    $user_actions = array_unique(explode('|', str_replace(array('update'), array('edit'), $user_actions)));
    if(in_array($action, $user_actions)){
        return true;
    }else{
        return false;
    }
}


function thumb_box($image_url, $delete_img_url = '', $caption = '', $col = 2){
    if(count(explode('.', $image_url)) == 1) {
        return;
    };

    $html ='<div class="col-sm-'.$col.'" style="">
        <div class="block">
            <div class="thumbnail thumbnail-boxed">
              <div class="thumb">
                  <img alt="" src="'.$image_url.'">
                <div class="thumb-options">
                    <span>';
                    $html .= '<a href="'.$image_url.'" class="btn btn-icon btn-success lightbox"><i class="icon-eye2"></i></a>';
                    if(!empty($delete_img_url)){
                        $html .= '<a href="'.$delete_img_url.'" class="btn btn-icon btn-success"><i class="icon-remove"></i></a>';
                    }
                $html .= '</span>
                </div>
              </div>';
    if(!empty($caption)){
        $html .= '<div class="caption">'.$caption.'</div>';
    }
    $html .= '</div>
          </div></div>';

    return $html;
}


/**
 * @param $table
 * @param $id_field
 * @param $id
 * @param array $null_cols
 * @param array $replace_col
 * @return array
 */
function DuplicateMySQLRecord($table, $id_field, $id, $null_cols = array('id'), $replace_col = array())
{
    $ci = &get_instance();
    $ids = array();
    // load the original record into an array
    $table_rs = $ci->db->query("SELECT * FROM `{$table}` WHERE `{$id_field}`='{$id}'")->result_array();

    if(count($table_rs) > 0){
        foreach($table_rs as $row){
            if(count($null_cols) > 0){
                foreach ($null_cols as $col) {
                    unset($row[$col]);
                }
            }
            if(count($replace_col) > 0){
                foreach ($replace_col as $col => $val) {
                    $row[$col] = $val;
                }
            }
            $id = save($table, $row);
            array_push($ids, $id);
        }
    }

    // return the new id
    return $ids;
}

/**
 * @param string $needle
 * @param array $haystack
 * @param null $key
 * @return bool|int|string
 */
$keys = array();
function array_search_recursive($needle, $haystack, $key = null)
{
    global  $keys;
    if(is_object($haystack)) {
        $haystack = object2array($haystack);
    }
    foreach ($haystack as $_key => $value) {
        if(is_array($value) || is_object($value)){
            array_search_recursive($needle, $value, $key);
        }else if($needle == $value){
            if($key != null && $key == $_key){
                array_push($keys, $_key);
            }else{ array_push($keys, $key); }
        }
    }
    return $keys;
}