<?php
/**
 * Naufil khan
 * E:  developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 *
 * @property M_cpanel $m_cpanel
 * @copyright 2019
 * @date 02-01-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class settings extends CI_Controller
{

    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $module_route;

    /**
     * *****************************************************************************************************************
     * @method ayats __construct
     * @model ayats main_model    | m_ayats     * *****************************************************************************************************************
     */

    function __construct()
    {
        parent::__construct();
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
     * @method ayats index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {

        $where = '';
        $query = "SELECT id, option_name, option_value FROM " . $this->table . " WHERE 1 AND access='Public' " . $where;

        //$this->session->set_userdata(array('export_query' => $query));
        $data['query'] = $query;
        $data['query'] .= getFindQuery($data['query']);

        $this->admin_template->load($this->module_name . '/grid', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method ayats form
     * *****************************************************************************************************************
     */
    public function form($Request = '')
    {

        $data = array();
        $id = intval(getUri(4));

        if (!empty($id)) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
            $data['row'] = $this->db->query($SQL)->row();
        } elseif ($Request) {
            $data['row'] = $Request;
        }

        $this->admin_template->load($this->module_name . '/form', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method ayats form
     * *****************************************************************************************************************
     */
    public function view()
    {

        $data = array();
        $id = intval(getUri(4));
        $query = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='{$id}'";
        $data['query'] = $query;

        $data['config']['buttons'] = array('new', 'update', 'delete', 'refresh', 'print', 'back');
        $data['title'] = $this->module_title;
        $this->admin_template->load('includes/record_view', $data);
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
            $DBdata['option_value'] = (getVar('option_value', FALSE, FALSE));

            $id = save($this->table, $DBdata);

            $this->session->set_flashdata('success', 'Record has been inserted.');
            redirect(ADMIN_DIR . $this->module_name);
        }
    }


    public function update()
    {
        $settings = getVar('setting', false, false);
        if (count($settings) > 0) {
            foreach ($settings as $key => $setting) {
                if(is_array($setting)){
                    $setting = serialize($setting);
                }
                $data = array(
                    'option_name' => $key,
                    'option_value' => (trim($setting))
                );

                if(has_option($key)){
                    save($this->table, $data, "option_name='" . $key . "'");
                }else{
                    save($this->table, $data);
                }
            }
        }

        $settings_files = $_FILES['setting'];
        unset($_FILES);
        if (count($settings_files) > 0) {
            foreach ($settings_files['name'] as $key => $file_name) {
                if (!empty($file_name)) {
                    $config['upload_path'] = ASSETS_DIR . 'admin/img/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|xls|xlsx|doc|docx|pdf|html';
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    $_FILES[$key] = array(
                        'name' => $file_name,
                        'type' => $settings_files['type'][$key],
                        'tmp_name' => $settings_files['tmp_name'][$key],
                        'error' => $settings_files['error'][$key],
                        'size' => $settings_files['size'][$key],
                    );

                    $rs = $this->upload->upload_multi($key);
                    $file_name = $rs['upload_data']['file_name'];
                    if ($rs['error']) {
                        $this->session->set_flashdata('error', $rs['error']);
                    }

                    $data = array(
                        'option_name' => $key,
                        'option_value' => $file_name
                    );

                    if (has_option($key)) {
                        save($this->table, $data, "option_name='" . $key . "'");
                    } else {
                        save($this->table, $data);
                    }
                }
            }
        }


        $this->session->set_flashdata('success', 'Record has been updated.');
        redirect(ADMIN_DIR . $this->module_name);

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

        delete_rows($this->table, $where, $delete_files);
        $this->session->set_flashdata('success', 'Record has been deleted.');
        redirect(ADMIN_DIR . $this->module_name);

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
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }

        $where = $this->id_field . " IN({$id})";

        $status = 1;
        if (getVar('status') == 1) {
            $status = 0;
        }
        $data = array('status' => $status);

        save($this->table, $data, $where);

        $this->session->set_flashdata('success', 'Status has been changed.');
        redirect(ADMIN_DIR . $this->module_name);
    }


}


/* End of file ayats.php */
/* Location: ./application/controllers/admin/ayats.php */