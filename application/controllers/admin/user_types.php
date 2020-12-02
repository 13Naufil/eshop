<?php
/**
 * Developed by Naufil khan.
 * Email: pisces_adnan@hotmail.com
 * Autour: Naufil khan
 * Cell # 0332-3103324
 * @copyright 2012 * @date 01-06-2012
 */

/**
 * Class User_types
 * @property M_user_types $m_user_types
 * @property M_cpanel $m_cpanel
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_types extends CI_Controller
{
    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $iic_user_type;

    function __construct()
    {

        //ini_set('memory_limit', '500M');

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
        $this->module_title = ucwords(str_replace('_', ' ', $this->module_name));
        $this->iic_user_type = intval(get_option('iic_user_type'));
    }

    /**
     * *****************************************************************************************************************
     * @method user_types index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {
        $where = '';
        $data['query'] = "SELECT * FROM " . $this->table . " WHERE id NOT IN(-1, '" . $this->iic_user_type . "') " . $where;
        $data['query'] .= getFindQuery($data['query']);
        $this->admin_template->load($this->module_name . '/grid', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method user_types form
     * *****************************************************************************************************************
     */
    public function form()
    {
        $id = intval(getUri(4));
        $data = array();

        if ($id) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
            $RS = $this->db->query($SQL);
            if($RS->num_rows() == 0) { $this->admin_template->not_found(); }
            $data['row'] = $RS->row();
        }

        /*------------------------------------Modules ------------------------------*/
        $sql = "SELECT module_id,actions FROM user_type_module_rel WHERE user_type_id='{$id}'";
        $rs = $this->db->query($sql);
        $modules = array();
        $selected_action = array();
        if ($rs->num_rows() > 0) {
            foreach ($rs->result() as $module) {
                array_push($modules, $module->module_id);
                $selected_action[$module->module_id] = explode('|', $module->actions);

            }

        }

        $data['modules'] = $modules;
        $data['selected_action'] = $selected_action;
        /*------------------------------------ END Modules ------------------------------*/

        $this->admin_template->load($this->module_name . '/form', $data);
    }


    public function add()
    {

        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());

            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            $id = save($this->table, $DBdata);

            if (count(getVar('modules')) > 0) {
                foreach (getVar('modules') as $module_id) {
                    $data = array(
                        'user_type_id' => $id,
                        'module_id' => $module_id,
                        'actions' => implode('|', $_REQUEST['actions'][$module_id])
                    );
                    save('user_type_module_rel', $data);
                }
            }
            $this->session->set_flashdata('success', 'Record has been inserted.');
            redirect(ADMIN_DIR . $this->module_name);
        }
    }


    public function update()
    {
        $id = intval(getVar('id'));
        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            unset($DbArray['dbdata']['show_on_menu']);

            $DbArray['dbdata']['show_on_menu'] = getVar('show_on_menu');

            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);

            $this->db->delete('user_type_module_rel', "`user_type_id` =" . $id);

            $modules = getVar('modules');
            if (count($modules) > 0) {
                foreach ($modules as $module_id) {
                    $data = array(
                        'user_type_id' => $id,
                        'module_id' => $module_id,
                        'actions' => implode('|', $_REQUEST['actions'][$module_id])
                    );
                    save('user_type_module_rel', $data);
                }
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
    public function delete()
    {
        $id = intval(getUri(4));
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }
        $where = $this->id_field . " IN({$id})";

        /*$delete_files = array(
            'file_name' => './assets/admin/users_files/'
        );*/

        delete_rows($this->table, $where);

        /*$SQL = "DELETE FROM " . $this->table . " WHERE `" . $this->id_field . "` IN(" . $id . ")";
        $this->db->query($SQL);*/
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
        $ids = $this->uri->segment(4);
        $status = 'active';
        if (getVar('status') == 'active') {
            $status = 'inactive';
        }
        $data = array('status' => $status);

        $where = $this->id_field . " IN ({$ids})";
        save($this->table, $data, $where);

        $this->session->set_flashdata('success', 'Status has been changed.');
        redirect(ADMIN_DIR . $this->module_name);
    }


    /**
     * *****************************************************************************************************************
     * @method import
     * *****************************************************************************************************************
     */

    /*public function import()
    {

        $data = array();
        if (getVar('import')) {
            $path = dirname(__FILE__) . '/csv/';
            if (!is_dir($path)) {
                mkdir($path);
            }

            $import = new Import();
            $import->type = getVar('type');
            $import->table = $this->table;
            $import->upload_path = $path;
            $import->file_field = 'file';
            $data_imp = $import->do_import();
            $data += $data_imp;
        }

        $data += $this->main_model->appOptions($this->table);

        $this->admin_template->load('includes/header', $data);
        $this->admin_template->load('includes/topmenu', $data);

        $this->admin_template->load('includes/import_view', $data);

        $this->admin_template->load('includes/footer', $data);

    }*/

    /**
     * *****************************************************************************************************************
     * @method export
     * @type csv and xml
     * *****************************************************************************************************************
     */
    /*function export()
    {

        $type = $this->uri->segment(3);
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
                $this->main_model->fileDownload($dir . $this->table . '.xml');
                @unlink($dir . $this->table . '.xml');
                break;
            default:
                $csv = $this->dbutil->csv_from_result($query);
                write_file($dir . $this->table . '.csv', $csv);

                $this->main_model->fileDownload($dir . $this->table . '.csv');
                @unlink($dir . $this->table . '.csv');
        }
        $this->index();
    }*/
}


