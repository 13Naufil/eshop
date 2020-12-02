<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 *
 * @property M_cpanel $m_cpanel
 * @property M_income $m_income * @copyright 2019 * @date 11-06-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Activity_log extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->m_cpanel->checkLogin();

        //TODO:: Module Name
        $this->module_name = getUri(2);
        $this->module_route = $this->router->class;
        $this->module_title = getModuleDetail()->module_title;

    }

    /**
     * *****************************************************************************************************************
     * @method income index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {

        $where = '';

        $query = "SELECT
            a.id
            ,a.activity_datetime
            , a.activity_name
            , a.table
            , a.rel_id
            , concat('<a href=\"".admin_url('users/view/')."/',a.user_id,'\">',u.first_name,'</a>') as performe_by
            , a.user_ip
            -- , a.current_URL
        FROM
            activity_log AS a
            LEFT JOIN users AS u
                ON (a.user_id = u.id)
        WHERE 1 " . $where;
        $data['query'] = $query;
        $data['query'] .= getFindQuery($data['query']);

        $this->admin_template->load($this->module_name . '/grid', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method income form
     * *****************************************************************************************************************
     */
    /*public function form($Request = '')
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
    }*/

    /**
     * *****************************************************************************************************************
     * @method income form
     * *****************************************************************************************************************
     */
    public function view()
    {

        $data = array();
        $id = intval(getUri(4));
        $query = "SELECT
                    a.*
                    , concat('<a href=\"".admin_url('users/view/')."/',a.user_id,'\">',u.first_name,'</a>') as performe_by
                FROM
                    activity_log AS a
                    LEFT JOIN users AS u
                        ON (a.user_id = u.id)
                WHERE 1
                AND  a.id ='{$id}'";
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
    /*
    public function add()
    {
        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            $DBdata['created'] = date('Y-m-d H:i:s');
            $id = save($this->table, $DBdata);
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
            $DBdata['created'] = date('Y-m-d H:i:s');
            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);

            $this->session->set_flashdata('success', 'Record has been updated.');
            redirect(ADMIN_DIR . $this->module_name);
        }
    }*/


    /**
     * *****************************************************************************************************************
     * @method Delete
     * @unlink Delete Files (unlink)
     * *****************************************************************************************************************
     */
    /*function delete()
    {

        $id = intval(getUri(4));
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }
        $where = $this->id_field . " IN({$id})";

        delete_rows($this->table, $where);

        $this->session->set_flashdata('success', 'Record has been deleted.');
        redirect(ADMIN_DIR . $this->module_name);
    }*/

    /**
     * *****************************************************************************************************************
     * @method Status
     * @unlink Delete Files (unlink)
     * *****************************************************************************************************************
     */
    /*function status()
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
    }*/


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

        $this->admin_template->load('includes/import_view', $data);
    }*/

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


/* End of file income.php */
/* Location: ./application/controllers/admin/income.php */