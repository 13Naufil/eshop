<?php
/**
 * Developed by Naufil khan.
 * Email: pisces_adnan@hotmail.com
 * Autour: Naufil khan
 * Date: 5/26/12
 * Time: 12:16 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('get_form_actions')) {

    function get_form_actions($buttons = array('new', 'save', 'edit', 'update'), $module_uri = 2, $action_privilege = 'private')
    {

        $CI = & get_instance();
        $module = getUri($module_uri);
        //$user_actions = $CI->session->userdata('actions');
        $user_actions = $CI->db->query("SELECT um.actions FROM users AS u INNER JOIN user_type_module_rel AS um ON (u.user_type_id = um.user_type_id) INNER JOIN modules AS m ON (m.id = um.module_id) WHERE um.user_type_id = '" . intval($CI->session->userdata('user_type')) . "' AND m.`module`='" . addslashes($module) . "'")->row()->actions;

        $search = array('update');
        $replace = array('save');
        $user_actions = explode('|', str_replace($search, $replace, $user_actions));


        if (in_array('add', $user_actions)) {
            array_push($user_actions, 'new');
        }
        if (in_array('import', $user_actions)) {
            array_push($user_actions, 'import_db');
        }


        if (in_array('new', $user_actions)) {
            array_push($user_actions, 'save');
        }
        if ($action_privilege != 'private') {
            $user_actions = $buttons;
        }


        if (in_array('new', $buttons) || array_key_exists('new', $buttons)) {

            $href = (!empty($buttons['new']['href']) ? $buttons['new']['href'] : admin_url($module . '/form'));
            $new = '<li><a action="new" href="' . $href . '"><i class="icon-file-plus"></i><span>New</span></a></li>';
        }


        if (in_array('delete', $buttons) || array_key_exists('delete', $buttons)) {
            $href = (!empty($buttons['delete']['href']) ? $buttons['delete']['href'] : admin_url($module . '/delete'));
            $delete = '<li><a action="delete" class="" href="' . $href . '"><i class="icon-remove4"></i><span>Delete</span></a></li>';
        }

        if (in_array('duplicate', $buttons) || array_key_exists('duplicate', $buttons)) {
            $href = (!empty($buttons['duplicate']['href']) ? $buttons['delete']['duplicate'] : admin_url($module . '/duplicate/' . getUri(4)));
            $duplicate = '<li><a action="duplicate" class="" href="' . $href . '"><i class="icon-copy"></i><span>Duplicate</span></a></li>';
        }
        /*if (in_array('edit', $buttons)) {
            $edit = '<li><a action="edit" href="'.site_url(ADMIN_DIR . $module. '/form/').'"><i class="icon-edit"></i><span>Edit</span></a></li>';
        }*/
        if (in_array('update', $buttons)) {
            $href = (!empty($buttons['update']['href']) ? $buttons['update']['href'] : admin_url($module . '/update'));
            $update = '<li><a action="update" href="' . $href . '"><i class="icon-edit"></i><span>Update</span></a></li>';
        }

        if (in_array('print', $buttons)) {
            $print = '<li><a action="print" href="javascript: void(0);"><i class="icon-print"></i><span>Print</span></a></li>';
        }
        if (in_array('x_print', $buttons)) {
            $x_print = '<li><a action="x_print" href="javascript: void(0);"><i class="icon-print"></i><span>Print</span></a></li>';
        }
        if (in_array('save', $buttons)) {
            $save = '<li><a action="save" href="javascript: void(0);"><i class="icon-disk"></i><span>Save</span></a></li>';
        }
        if (in_array('reset', $buttons)) {
            $reset = '<li><a action="reset" href="javascript: void(0);"><i class="icon-refresh"></i><span>Reset</span></a></li>';
        }
        if (in_array('back', $buttons)) {
            $back = '<li><a action="back" href="javascript: window.history.back();"><i class="icon-backward"></i><span>Back</span></a></li>';
        }
        if (in_array('export_csv', $buttons)) {
            $export_csv = '<li><a action="export_csv" href="javascript: void(0);"><i class="icon-download"></i><span>Export CSV</span></a></li>';
        }
        if (in_array('refresh', $buttons)) {
            $refresh = '<li><a action="refresh" href="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"><i class="icon-refresh"></i><span>Refresh</span></a></li>';
        }
        if (in_array('fetch_info', $buttons)) {
            $href = (!empty($buttons['fetch_info']['href']) ? $buttons['fetch_info']['href'] : admin_url($module . '/fetch_info'));
            $fetch_info = '<li><a action="fetch_info" href="' . $href . '"><i class="icon-cogs"></i><span>Fetch Info</span></a></li>';
        }
        if (in_array('import', $buttons)) {
            $href = (!empty($buttons['import']['href']) ? $buttons['import']['href'] : admin_url($module . '/import'));
            $import = '<li><a action="import" href="' . $href . '"><i class="icon-upload"></i><span>Import</span></a></li>';
        }
        if (in_array('import_db', $buttons)) {
            $import_db = '<li><a action="import_db" href="javascript: void(0);" title="Import"><i class="icon-hdd"></i><span>Import</span></a></li>';
        }
        if (in_array('assigning', $buttons)) {
            $href = (!empty($buttons['assigning']['href']) ? $buttons['assigning']['href'] : admin_url($module . '/assigning'));
            $assigning = '<li><a action="assigning" href="' . $href . '"><i class="icon-share"></i><span>Assigning</span></a></li>';
        }
        if (in_array('DNA_results', $buttons)) {
            $href = (!empty($buttons['DNA_results']['href']) ? $buttons['DNA_results']['href'] : admin_url($module . '/DNA_results'));
            $DNA_results = '<li><a action="assigning" href="' . $href . '"><i class="icon-share"></i><span>DNA Results</span></a></li>';
        }
        /*if (in_array('view', $buttons) || array_key_exists('view', $buttons)) {
            $href = (!empty($buttons['view']['href']) ? $buttons['view']['href'] : site_url(ADMIN_DIR . $module . '/view'));
            $view = '<li><a action="view" href="' . $href . '"><i class="icon-eye-open"></i><span>View</span></a></li>';
        }*/


        if (in_array('calendar', $buttons)) {
            $calendar = '<li>
                    <a class="form_button" action="calendar" href="' . site_url() . $CI->uri->segment(2) . '/calendar/">
                        <div class="button_icon">
                            <p align="center">
                                <img src="' . site_url() . 'images/pictos/calendar.png" alt="" width="40" height="40"></p>
                        </div>
                        <div><p align="center">Calendar</p></div>
                    </a>
                </li>';
        }


        /*if (in_array('export_xml', $buttons)) {
            $export_xml = '<li>
                            <a class="form_button" action="export_xml" href="' . site_url() . $CI->uri->segment(2) . '/export/xml">
                                <div class="button_icon">
                                    <p align="center">
                                        <img src="' . site_url() . 'images/pictos/settings11.png" alt="" width="40" height="40">
                                    </p>
                                </div>
                                <div><p align="center">Export XML</p></div>
                            </a>
                        </li>';
        }
        if (in_array('export_xls', $buttons)) {
            $export_xls = '<li>
                            <a class="form_button" action="export_xls" href="' . site_url() . $CI->uri->segment(2) . '/export_xls/' . $CI->uri->segment(4) . '/">
                                <div class="button_icon">
                                    <p align="center">
                                        <img src="' . site_url() . 'images/pictos/ms-excel.png" alt="" width="40" height="40">
                                    </p>
                                </div>
                                <div><p align="center">Export XSLs</p></div>
                            </a>
                        </li>';
        }
        if (in_array('import', $buttons)) {
            $import = '<li>
                            <a class="form_button" action="import_csv" href="' . site_url() . $CI->uri->segment(2) . '/import/">
                                <div class="button_icon">
                                    <p align="center">
                                        <img src="' . site_url() . 'images/pictos/inbox2.png" alt="" width="40" height="40">
                                    </p>
                                </div>
                                <div><p align="center">Import</p></div>
                            </a>
                        </li>';
        }

        if (in_array('import_db', $buttons)) {
            $import_db = '<li>
                            <a class="form_button" action="import_db" href="' . site_url() . $CI->uri->segment(2) . '/import/">
                                <div class="button_icon">
                                    <p align="center">
                                        <img src="' . site_url() . 'images/pictos/inbox2.png" alt="" width="40" height="40">
                                    </p>
                                </div>
                                <div><p align="center">Import</p></div>
                            </a>
                        </li>';
        }


        if (in_array('db_backup', $buttons)) {
            $db_backup = '<li>
                            <a class="form_button" action="db_backup" href="' . site_url() . $CI->uri->segment(2) . '/db_backup">
                                <div class="button_icon">
                                    <p align="center">
                                        <img src="' . site_url() . 'images/pictos/data.png" alt="" width="40" height="40">
                                    </p>
                                </div>
                                <div><p align="center">DB Backup</p></div>
                            </a>
                        </li>';
        }

        if (in_array('download', $buttons)) {
            $download = '<li>
                            <a class="form_button" action="download" href="' . site_url() . $CI->uri->segment(1) . '/download">
                                <div class="button_icon">
                                    <p align="center">
                                        <img src="' . site_url() . 'images/pictos/download.png" alt="" width="40" height="40">
                                    </p>
                                </div>
                                <div><p align="center">Download</p></div>
                            </a>
                        </li>';
        }*/


        /*---------------------------------------------------------------------------------------------*/
        $user_actions[] = 'back';
        $form_btn = '';


        if(in_array('print', $user_actions) && in_array('x_print', $buttons)){
            $user_actions[] = 'x_print';
        }


        foreach ($buttons as $key_btn => $button) {
            if (in_array($button, $user_actions) || (array_key_exists($key_btn, $user_actions) && is_string($key_btn))) {
                if (array_key_exists($key_btn, $user_actions) && is_array($button)) {
                    $button = $key_btn;
                }
                $form_btn .= ${$button};
            }
        }

        if(!empty($form_btn)){
            return $action_btn = '<ul class="panel-toolbar x-print">' . $form_btn . '</ul>';
        }

    }


}