<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 *
 * @property M_cpanel $m_cpanel
 * @property M_dealers $m_dealers * @copyright 2019 * @date 19-01-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dealers extends CI_Controller
{

    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $module_route;
    var $where = '';

    /**
     * *****************************************************************************************************************
     * @method dealers __construct
     * @model dealers main_model    | m_dealers
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

        if(user_info('id') == get_option('client_type_id')){
            $this->where = " AND dealers.created_by='".user_info('id')."'";
        }

    }

    /**
     * *****************************************************************************************************************
     * @method dealers index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {

        $where = $this->where;
        $query = "SELECT
           id,
           business_name,
           phone,
           country,
           city,
           `area`,
           `status`
    FROM {$this->table} WHERE 1 " . $where;

        //$this->session->set_userdata(array('export_query' => $query));
        $data['query'] = $query;
        $data['query'] .= getFindQuery($data['query']);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));

        $this->admin_template->load($this->module_name . '/grid', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method dealers form
     * *****************************************************************************************************************
     */
    public function form($Request = '')
    {

        $data = array();
        $id = intval(getUri(4));

        if (!empty($id)) {
            $where = $this->where;
            $SQL = "SELECT * FROM {$this->table} WHERE {$this->id_field}='{$id}' " . $where;
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
     * @method dealers view
     * *****************************************************************************************************************
     */
    public function view()
    {

        $data = array();
        $id = intval(getUri(4));

        $where = $this->where;
        $query = "SELECT * FROM {$this->table} WHERE {$this->id_field}='{$id}'" . $where;
        $data['query'] = $query;

        $data['config']['buttons'] = array('new', 'update', 'delete', 'refresh', 'print', 'back');
        $data['title'] = $this->module_title;

        activity_log('view_dealers', $this->table, $id);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item('View');

        $this->admin_template->load('includes/record_view', $data);
    }


    function opening_inventory(){
        $id = intval(getUri(4));

        $where = $this->where;
        $query = "SELECT * FROM {$this->table} WHERE {$this->id_field}='{$id}'" . $where;
        $data['dealer'] = $this->db->query($query)->row();

        $data['opening_inventory'] = $this->db->query("SELECT
        dealer_open_inventory.*
        ,products.name as product_name
        FROM dealer_open_inventory
        LEFT JOIN products ON(products.id=dealer_open_inventory.product_id)
        WHERE 1 AND dealer_id='{$data['dealer']->id}'")->result();

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item('Opening inventory');

        $this->admin_template->load($this->module_name . '/open_inventory_form.php', $data);
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
            $DBdata['created_by'] = user_info('id');
            $DBdata['created'] = date('Y-m-d H:i:s');
            $id = save($this->table, $DBdata);
            activity_log('create_dealers', $this->table, $id);

            $this->session->set_flashdata('success', 'Record has been inserted.');
            redirect(ADMIN_DIR . $this->module_route);
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
            //$DBdata['created_by'] = user_info('id');
            $DBdata['created'] = date('Y-m-d H:i:s');
            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);
            activity_log('update_dealers', $this->table, $id);

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

        $where = $this->id_field . " IN({$id})" . $this->where;

        /*
        $delete_files = array(
            'image' => './assets/amdin/img/'
        );*/

        delete_rows($this->table, $where);

        activity_log('view_dealers', $this->table, explode(',', $id));
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

        $where = $this->id_field . " IN({$id})" . $this->where;

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
            case 'save_inventory':
                $dtl_id = intval(getVar('dtl_id'));
                $product_id = intval(getVar('product_id'));
                $qty = intval(getVar('qty'));
                $price = floatval(getVar('price'));
                $dealer_id = intval(getVar('dealer_id'));
                //$warehouse_id = intval(getVar('warehouse_id'));
                if ($product_id > 0) {
                    $dbdata = array(
                        'dealer_id' => $dealer_id,
                        'product_id' => $product_id,
                        'qty' => $qty,
                        'price' => $price,
                        //'warehouse_id' => $warehouse_id,
                        'modified' => date('Y-m-d H:i:s'),
                        'modified_by' => user_info('id')
                    );

                    $where = "";
                    if($dtl_id == 0){
                        $dbdata['created'] = date('Y-m-d H:i:s');
                        $dbdata['created_by'] = user_info('id');
                        activity_log('add_dealer_inventory', 'dealer_open_inventory', $id, 0, "Add");
                    }else{
                        $where = "id={$dtl_id}";
                        activity_log('update_dealer_inventory', 'dealer_open_inventory', $id, 0, "Update");
                    }

                    $id = save('dealer_open_inventory', $dbdata, $where);


                    if($id){
                        $__dtl_id = ($id === true ? $dtl_id : $id);

                        $JSON['status'] = 'success';
                        $JSON['dtl_id'] = $__dtl_id;
                    }else{
                        $JSON['status'] = 'error';
                    }

                    echo json_encode($JSON);
                }
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


/* End of file dealers.php */
/* Location: ./application/controllers/admin/dealers.php */