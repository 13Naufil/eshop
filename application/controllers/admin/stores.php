<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 *
 * @property M_cpanel $m_cpanel
 * @property M_stores $m_stores * @copyright 2019 * @date 19-09-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stores extends CI_Controller
{

    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $module_route;

    /**
     * *****************************************************************************************************************
     * @method stores __construct
     * @model stores main_model    | m_stores
     * *****************************************************************************************************************
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
     * @method stores index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {

        $where = '';
        $query = "SELECT `id`,
          `city`,
          `area`,
          `business_name`,
          `phone`,
          `status` FROM {$this->table} WHERE 1 " . $where;

        //$this->session->set_userdata(array('export_query' => $query));
        $data['query'] = $query;
        $data['query'] .= getFindQuery($data['query']);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));

        $this->admin_template->load($this->module_name . '/grid', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method stores form
     * *****************************************************************************************************************
     */
    public function form($Request = '')
    {

        $data = array();
        $id = intval(getUri(4));

        if (!empty($id)) {
            $SQL = "SELECT * FROM {$this->table} WHERE {$this->id_field}='{$id}'";
            $RS = $this->db->query($SQL);
            if ($RS->num_rows() == 0) {
                $this->admin_template->not_found();
            }
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
     * @method stores view
     * *****************************************************************************************************************
     */
    public function view()
    {

        $data = array();
        $id = intval(getUri(4));
        $query = "SELECT * FROM {$this->table} WHERE {$this->id_field}='{$id}'";
        $data['query'] = $query;

        $data['config']['buttons'] = array('new', 'update', 'delete', 'refresh', 'print', 'back');
        $data['title'] = $this->module_title;

        activity_log('view_stores', $this->table, $id);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item('View');

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
            $data['row'] = $row = array2object($this->input->post());
            $data['product_ids'] = $row->product_ids;

            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            if ($_FILES['image']['name']) {
                $upload = $this->module->file_upload('image');

                if (!$upload['status']) {
                    $this->form($this->input->post(NULL, TRUE));
                } else {
                    $file_name = $upload['upload_data']['file_name'];
                }
                $DBdata['image'] = $file_name;
            }
            if(getVar('lat') == '' || getVar('lng') == ''){
                $lat_lang = getLatLng(getVar('address') . ', ' . getVar('city') . ', ' . getVar('country'));
                $DBdata['lat'] = $lat_lang->lat;
                $DBdata['lng'] = $lat_lang->lng;
            }

            $id = save($this->table, $DBdata);
            activity_log('create_stores', $this->table, $id);

            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # product_ids
            $product_ids = getVar('product_ids', true, false);
            delete_rows('store_promotion_products', 'store_id=' . $id);
            if(count($product_ids) > 0){
                foreach ($product_ids as $product_id) {
                    if(!empty($product_id)) {
                        $_product_data = array(
                            'product_id' => intval($product_id),
                            'store_id' => intval($id),
                        );
                        save('store_promotion_products', $_product_data);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Record has been inserted.');
            redirect(ADMIN_DIR . $this->module_route);
        }
    }


    public function update()
    {

        $id = $this->uri->segment(4);

        if (!$this->module->validate()) {
            $data['row'] = $row = array2object($this->input->post());
            $data['product_ids'] = $row->product_ids;
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            if ($_FILES['image']['name']) {
                $upload = $this->module->file_upload('image');

                if (!$upload['status']) {
                    $this->form($this->input->post(NULL, TRUE));
                } else {
                    $file_name = $upload['upload_data']['file_name'];
                }
                $DBdata['image'] = $file_name;
            }
            if(getVar('lat') == '' || getVar('lng') == ''){
                $lat_lang = getLatLng(getVar('address') . ', ' . getVar('city') . ', ' . getVar('country'));
                $DBdata['lat'] = $lat_lang->lat;
                $DBdata['lng'] = $lat_lang->lng;
            }

            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);
            activity_log('update_stores', $this->table, $id);

            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # product_ids
            $product_ids = getVar('product_ids', true, false);
            delete_rows('store_promotion_products', 'store_id=' . $id);
            if(count($product_ids) > 0){
                foreach ($product_ids as $product_id) {
                    if(!empty($product_id)) {
                        $_product_data = array(
                            'product_id' => intval($product_id),
                            'store_id' => intval($id),
                        );
                        save('store_promotion_products', $_product_data);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Record has been updated.');
            redirect(ADMIN_DIR . $this->module_route);
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
            'image' => './assets/amdin/img/'
        );*/

        delete_rows($this->table, $where);

        activity_log('view_stores', $this->table, explode(',', $id));
        $this->session->set_flashdata('success', 'Record has been deleted.');
        redirect(ADMIN_DIR . $this->module_route);
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
        activity_log('change_status', $this->table, explode(',', $id));

        $this->session->set_flashdata('success', 'Status has been changed.');
        redirect(ADMIN_DIR . $this->module_route);
    }

    /**
     * *****************************************************************************************************************
     * @method AJAX
     * *****************************************************************************************************************
     */

    function AJAX($action, $id)
    {
        switch ($action) {
            case 'delete_img':
                $del_img = array('image' => './assets/admin/img/');
                delete_rows($this->table, $this->id_field . "=" . intval($id), false, '', 'image', $del_img);
                activity_log($action, $this->table, $id);
                break;
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

            $import = new Import();
            $import->type = getVar('type');
            $import->table = $this->table;
            $import->upload_path = $path;
            $import->file_field = 'file';
            $data_imp = $import->do_import();
            $data += $data_imp;

        }

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item('Import');

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


/* End of file stores.php */
/* Location: ./application/controllers/admin/stores.php */