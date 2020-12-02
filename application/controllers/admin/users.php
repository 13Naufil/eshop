<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 *
 * @property M_cpanel $m_cpanel
 * @property M_users $m_users * @copyright 2019 * @date 03-06-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
{

    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $module_route;

    /**
     * *****************************************************************************************************************
     * @method users __construct
     * @model users main_model    | m_users
     * *****************************************************************************************************************
     */

    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->m_cpanel->checkLogin();

        //TODO:: Module Name
        $this->module_name = getUri(2);
        $this->module = 'm_' . $this->module_name;
        $this->load->model(ADMIN_DIR . $this->module);
        $this->module = $this->{$this->module};

        $this->table = $this->module->table;
        $this->id_field = $this->module->id_field;

        $this->module_route = $this->router->class;
        $this->module_title = getModuleDetail()->module_title;

    }




    /**
     * *****************************************************************************************************************
     * @method users profile
     * *****************************************************************************************************************
     */
    public function profile($Request = '')
    {
        $data = array();
        $id = intval($this->session->userdata('cct_user_id'));

        if (!empty($id)) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
            $RS = $this->db->query($SQL);
            if ($RS->num_rows() == 0) { $this->admin_template->not_found(); }
            $data['row'] = $RS->row();

        } elseif ($Request) {
            $data['row'] = $Request;
        }

        if($this->input->server('REQUEST_METHOD') == 'POST'){

            $_POST['id'] = $id;
            $_POST['user_type_id'] = $data['row']->user_type_id;

            if (!$this->module->validate($id)) {
                $data['row'] = array2object($this->input->post());
                unset($data['photo']);
            } else {

                $DbArray = getDbArray($this->table);
                $DBdata = $DbArray['dbdata'];
                if ($_FILES['photo']['name']) {
                    $upload = $this->module->file_upload('photo');

                    if (!$upload['status']) {
                        $this->form($this->input->post(NULL, TRUE));
                    } else {
                        $file_name = $upload['upload_data']['file_name'];
                    }
                    $DBdata['photo'] = $file_name;
                }
                if (getVar('password') != '') {
                    $DBdata['password'] = encryptPassword(getVar('password'));
                }else{
                    unset($DBdata['password']);
                }

                $DBdata['newsletter'] = getVar('newsletter');
                $where = $DbArray['where'];
                save($this->table, $DBdata, $where);


                $chk_user_info = $this->session->userdata('user_info');
                if (getVar('password') != '')
                    $chk_user_info->password = $DBdata['password'];
                $chk_user_info->username = $DBdata['username'];
                $this->session->set_userdata('user_info', $chk_user_info);


                $cookie = explode('|', $this->input->cookie('logged_in'));
                $remember = ($cookie[2]);
                $user_name = getVar('username');
                if (getVar('password') != '') $password = getVar('password');
                else $password = ($cookie[1]);

                $logged_in_string = $user_name . '|' . $password . '|' . $remember;
                if ($remember) set_cookie('logged_in', $logged_in_string, time() + 60 * 60 * 24 * 30);
                else { set_cookie('logged_in', '', -70 + time());}


                activity_log('update_profile', $this->table, $id);

                $this->session->set_flashdata('success', 'Profile has been updated.');
                redirect(ADMIN_DIR . $this->module_name . '/profile');
            }
        }



        $this->admin_template->load($this->module_name . '/profile', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method users index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {

        $where = '';
        $where = str_ireplace("AND full_name LIKE", "AND CONCAT(u.first_name,' ', u.last_name) LIKE", $where);

        $query = "SELECT
             u.id
             , ut.user_type
             , CONCAT(u.first_name,' ', u.last_name) as full_name
             , u.email
             , u.phone
             , u.city
             , u.status
             , u.created
         FROM
             " . $this->table . " AS u
             INNER JOIN user_types AS ut
                 ON (u.user_type_id = ut.id)
         WHERE 1 " . $where;

        //$this->session->set_userdata(array('export_query' => $query));
        $data['query'] = $query;
        $data['query'] .= getFindQuery($data['query']);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->admin_template->load($this->module_name . '/grid', $data);
    }

    function files()
    {
        $id = intval(getUri(4));

        $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
        $data['row'] = $this->db->query($SQL)->row();

        $SQL = "SELECT * FROM user_files WHERE rel = 'users' AND user_id=" . $id;
        $data['files'] = $this->db->query($SQL)->result();

        $this->admin_template->load($this->module_name . '/files', $data);
    }



    /**
     * *****************************************************************************************************************
     * @method users form
     * *****************************************************************************************************************
     */
    public function form($Request = '')
    {

        $data = array();
        $id = intval(getUri(4));

        if (!empty($id)) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
            $RS = $this->db->query($SQL);
            if($RS->num_rows() == 0) { $this->admin_template->not_found(); }
            $data['row'] = $RS->row();

        } elseif ($Request) {
            $data['row'] = $Request;
        }

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item(($id > 0) ? 'Edit' : 'Add New');

        $this->admin_template->load($this->module_name . '/form', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method users form
     * *****************************************************************************************************************
     */
    public function view()
    {

        $data = array();
        $id = intval(getUri(4));

        $query = "SELECT
            users.id
            , user_types.user_type
            , users.username
            , users.first_name
            , users.last_name
            , users.photo
            , users.cnic
            , users.email
            , users.phone
            , users.address
            , users.city
            , users.country
            , users.zip_code
            , users.created
            , users.created_by as created_by_id
            , CONCAT(created_users.first_name, ' (', created_users.email,')') as created_by
            , IF(users.newsletter =1,'Yes','No') AS newsletter
            , users.status
            , users.modified
        FROM
            users
            INNER JOIN user_types
                ON (users.user_type_id = user_types.id)
            LEFT JOIN users AS created_users
                ON (users.created_by = created_users.id)
        WHERE users." . $this->id_field . "='{$id}' LIMIT 1";

        $data['user_row'] = $this->db->query($query)->row_array();


        $data['config']['buttons'] = array('refresh', 'print', 'back');
        $data['title'] = $this->module_title;

        activity_log('view_user', $this->table, $id);
        $this->admin_template->load($this->module_name . '/view', $data);
        //$this->admin_template->load('includes/record_view', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method action
     * @action Save / Add
     * *****************************************************************************************************************
     */
    public function add()
    {
        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            if ($_FILES['photo']['name']) {
                $upload = $this->module->file_upload('photo');

                if (!$upload['status']) {
                    $this->form($this->input->post(NULL, TRUE));
                } else {
                    $file_name = $upload['upload_data']['file_name'];
                }
                $DBdata['photo'] = $file_name;
            }
            /*if (getVar('user_type_id') != get_option('admin_user_type') && isset($_POST['old_record'])) {
                $DBdata['status'] = 'Active';
                $DBdata['activated'] = date('Y-m-d H:i:s');
            }elseif (getVar('user_type_id') != get_option('admin_user_type')) {
                $DBdata['status'] = 'Pending';
            }*/


            $DBdata['password'] = encryptPassword(getVar('password'));
            $DBdata['created'] = date('Y-m-d H:i:s');
            $DBdata['created_by'] = $this->session->userdata('cct_user_id');

            $id = save($this->table, $DBdata);
            activity_log('create_user', $this->table, $id);


            $this->session->set_flashdata('success', 'Record has been inserted.');
            redirect(ADMIN_DIR . $this->module_name);
        }
    }


    public function update()
    {

        $id = $this->uri->segment(4);

        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            if ($_FILES['photo']['name']) {
                $upload = $this->module->file_upload('photo');

                if (!$upload['status']) {
                    $this->form($this->input->post(NULL, TRUE));
                } else {
                    $file_name = $upload['upload_data']['file_name'];
                }
                $DBdata['photo'] = $file_name;
            }
            if (getVar('password') != '') {
                $DBdata['password'] = encryptPassword(getVar('password'));
            }else{
                unset($DBdata['password']);
            }

            $DBdata['newsletter'] = getVar('newsletter');
            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);


            activity_log('update_user', $this->table, $id);

            if($id == intval($this->session->userdata('cct_user_id'))){
                $chk_user_info = $this->session->userdata('user_info');
                $chk_user_info->password = $DBdata['password'];
                $this->session->set_userdata('user_info', $chk_user_info);
            }



            $this->session->set_flashdata('success', 'Record has been updated.');
            redirect(ADMIN_DIR . $this->module_name);
        }
    }


    /**
     * *****************************************************************************************************************
     * @method Delete
     * @unlink Delete Files (unlink)
     * *****************************************************************************************************************
     */
    function delete()
    {

        $id = intval(getUri(4));
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }

        $where = $this->id_field . " IN({$id})";

        /*
        $delete_files = array(
            'image',
            dirname(__FILE__) . '/../views/' . ADMIN_DIR . 'images/'
        );*/

        delete_rows($this->table, $where);
        activity_log('delete_user', $this->table, explode(',', $id));

        $this->session->set_flashdata('success', 'Record has been deleted.');
        redirect(ADMIN_DIR . $this->module_name);
    }

    function download_file()
    {

        $id = intval(getUri(4));
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }

        $file_name = $this->db->select('file_name')->from('user_files')->where_in('id', $id)->where('rel', 'users')->get()->row()->file_name;

        activity_log('download_file', 'user_files', explode(',', $id), 0, 'File Name is: ' . $file_name);

        $file = "./assets/admin/users_files/" . $file_name; //file location
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;

    }



    public function username_check($username)
    {
        if(getUri(3) == 'profile'){ $user_id = intval($this->session->userdata('cct_user_id'));}else {$user_id = getUri(4);}

        $email_exists = $this->db->get_where($this->table, array('username' => $username, 'id <>' => $user_id))->num_rows() > 0 ? true : false;
        if ($email_exists) {
            $this->form_validation->set_message('username_check', 'This username is already exists');
            return FALSE;
        }
    }

    public function email_check($email)
    {
        if(getUri(3) == 'profile'){ $user_id = intval($this->session->userdata('cct_user_id'));}else {$user_id = getUri(4);}

        $email_exists = $this->db->get_where($this->table, array('email' => $email, 'id <>' => $user_id))->num_rows() > 0 ? true : false;
        if ($email_exists) {
            $this->form_validation->set_message('email_check', 'This email is already exists');
            return FALSE;
        }
    }


    /**
     * *****************************************************************************************************************
     * @method Status
     * @unlink Delete Files (unlink)
     * *****************************************************************************************************************
     */
    function status()
    {
        $id = intval(getUri(4));
        $status = getVar('status');
        if ($id > 0 && !empty($status)) {

            $where = $this->id_field . " IN({$id})";


            $data['status'] = $status;
            save($this->table, $data, $where);

            activity_log('change_status', $this->table, explode(',', $id));

            $this->session->set_flashdata('success', 'Status has been changed.');
        }
        redirect($this->input->server('HTTP_REFERER'));
    }


    function AJAX($action, $id)
    {
        switch ($action) {
            case 'delete_img':
                $del_img = array('photo' => './assets/admin/img/users/');
                delete_rows($this->table, $this->id_field . "=" . intval($id), false, '', 'photo', $del_img);
                break;
        }
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Ajax Validation
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function validate($name)
    {
        $id = intval($this->input->get('id'));
        $value = $this->input->get('value');

        switch ($name) {
            case 'email':
                if (empty($value)) {
                    $output['message'] = 'This field is required';
                } else if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $output['message'] = 'Invalid email address';
                } else {
                    $email_exists = $this->db->get_where($this->table, array('email' => $value, 'id <>' => $id))->num_rows() > 0 ? true : false;
                    if ($email_exists) {
                        $output['message'] = 'This email is already exists';
                    }
                }
                break;

            case 'username':
                if (empty($value)) {
                    $output['message'] = 'This field is required';
                } else if (!preg_match('/^[\w]+$/', $value)) {
                    $output['message'] = 'Invalid username';
                } else {
                    $username_exists = $this->db->get_where($this->table, array('username' => $value, 'id <>' => $id))->num_rows() > 0 ? true : false;
                    if ($username_exists) {
                        $output['message'] = 'This username is already exists';
                    }
                }
                break;
        }

        echo json_encode($output);
    }


    public function file_uploader()
    {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $user_id = getUri(4);

        if (!empty($_FILES)) {

            $users_files_dir = './assets/admin/users_files/';
            if (!is_dir($users_files_dir . $user_id)) {
                mkdir($users_files_dir . $user_id);
            }
            $config['upload_path'] = $users_files_dir . $user_id;
            $config['allowed_types'] = trim(str_replace(',', '|', get_option('user_files_ext')));

            $this->load->library('upload');
            $this->upload->initialize($config);


            if ($this->upload->do_upload('file')) {
                $fileinfo = $this->upload->data();
                $output['result']['filename'] = $fileinfo['file_name'];

                $id = save('user_files', array('user_id' => $user_id, 'file_name' => $fileinfo['file_name'], 'rel' => 'users'));
                $output['result']['id'] = $id;
                $output['result']['filesize'] = number_format(((filesize($users_files_dir . $user_id . '/' . $fileinfo['file_name']) / 1024)), 2);

                /*$output['result']['thumb_url'] = image_thumb('assets/admin/img/dogs/' . $fileinfo['file_name'], 200, 150);
                $output['result']['image_url'] = site_url('assets/admin/img/dogs/' . $fileinfo['file_name']);*/
            } else {
                $output['error']['filename'] = $_FILES['file']['name'];
                $output['error']['message'] = $this->upload->display_errors();
            }

            echo json_encode($output);
        } else {
            redirect((ADMIN_DIR . $this->module_route));
        }
    }

    /**
     * *****************************************************************************************************************
     * @method import
     * *****************************************************************************************************************
     */

    public function import()
    {

        $data = array();
        if (getVar('import')) {
            $path = dirname(__FILE__) . '/csv/';
            if (!is_dir($path)) {
                mkdir($path);
            }

            $this->load->library('import');
            $import = new Import();
            $import->type = getVar('type');
            $import->table = $this->table;
            $import->upload_path = $path;
            $import->file_field = 'file';
            $import->cols_custom_func = array('password' => 'encryptPassword');
            $data_imp = $import->do_import();
            $data += $data_imp;
        }

        $this->admin_template->load('includes/import_view', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method export
     * @type csv and xml
     * *****************************************************************************************************************
     */
    function export()
    {

        $type = $this->uri->segment(4);
        $this->load->dbutil();
        if ($this->session->userdata('export_query')) {
            $query = $this->session->userdata('export_query');
            $this->session->unset_userdata('export_query');
        } else {
            $query = "SELECT * FROM " . $this->table;
        }

        $query = $this->db->query($query);


        $dir = dirname(__FILE__) . "/";


        switch ($type) {
            case 'xml':
                $config = array(
                    'root' => 'rows',
                    'element' => 'row',
                    'newline' => "\n",
                    'tab' => "\t"
                );

                $xml = $this->dbutil->xml_from_result($query, $config);
                write_file($dir . $this->table . '.xml', $xml);
                fileDownload($dir . $this->table . '.xml');
                @unlink($dir . $this->table . '.xml');
                break;
            default:
                $csv = $this->dbutil->csv_from_result($query);
                write_file($dir . $this->table . '.csv', $csv);

                fileDownload($dir . $this->table . '.csv');
                @unlink($dir . $this->table . '.csv');
        }


        $this->index();
    }
}


/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */