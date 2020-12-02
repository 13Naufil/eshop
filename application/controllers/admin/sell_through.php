<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 *
 * @property M_cpanel $m_cpanel
 * @property M_sell_through $m_sell_through
 * @property M_sell_through $module
 * @copyright 2019 * @date 07-11-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sell_through extends CI_Controller
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
     * @method sell_through __construct
     * @model sell_through main_model    | m_sell_through
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
            $this->where = " AND sell_through.created_by='".user_info('id')."'";
        }
    }

    /**
     * *****************************************************************************************************************
     * @method sell_through index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {

        $where = $this->where;

        replace_find_query('created_by',"CONCAT(users.first_name,' ', users.last_name)", $where);

        $query = "SELECT
        sell_through.id
        , dealers.business_name
        , products.name
        , sell_through.qty
        , sell_through.IMEI
        , sell_through.created
  FROM sell_through
  LEFT JOIN dealers ON dealers.id=sell_through.customer_id
  LEFT JOIN products ON products.id=sell_through.product_id
WHERE 1 " . $where;

        //$this->session->set_userdata(array('export_query' => $query));
        $data['query'] = $query;
        $data['query'] .= getFindQuery($data['query']);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));

        $this->admin_template->load($this->module_name . '/grid', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method sell_through form
     * *****************************************************************************************************************
     */
    public function form($Request = '')
    {

        $data = array();
        $id = intval(getUri(4));

        if (!empty($id)) {
            $where = $this->where;
            $SQL = "SELECT * FROM {$this->table} WHERE {$this->id_field}='{$id}'" . $where;
            $RS = $this->db->query($SQL);
            if ($RS->num_rows() == 0) {
                $this->admin_template->not_found();
            }
            $data['row'] = $RS->row();
            $data['order_detail'] = $this->db->query("SELECT sell_through.*,products.name as product_name FROM sell_through LEFT JOIN products ON(products.id=sell_through.product_id) WHERE sell_through.id='{$id}'")->result();

        } elseif ($Request) {
            $data['row'] = $Request;
        }

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item(($id > 0) ? 'Edit' : 'Add New');

        $this->admin_template->load($this->module_name . '/form', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method sell_through view
     * *****************************************************************************************************************
     */
    public function view()
    {

        $data = array();
        $id = intval(getUri(4));
        $where = $this->where;
        $query = "SELECT * FROM {$this->table} WHERE {$this->id_field}='{$id}'" . $where;
        $data['row'] = $this->db->query($query)->row();

        $data['member'] = get_member($data['row']->customer_id);
        $data['order_detail'] = $this->db->query("SELECT order_detail.*,products.name as product_name
        FROM order_detail
        LEFT JOIN products ON(products.id=order_detail.product_id)
        WHERE `order_id`='{$id}'")->result();

        $data['config']['buttons'] = array('new', 'update', 'delete', 'refresh', 'print', 'back');
        $data['title'] = $this->module_title;

        activity_log('view_sell_through', $this->table, $id);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item('View');

        $this->admin_template->load($this->module_name . '/view', $data);
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
            $customer_id = intval(getVar('customer_id'));
            $product_ids = getVar('product_ids');
            $IMEI = getVar('IMEI');
            $qty = getVar('qty');

            if(count($product_ids) > 0){
                foreach($product_ids as $k => $product_id){
                    $dataDB = array(
                        'product_id' => intval($product_id),
                        'qty' => intval($qty[$k]),
                        'IMEI' => $IMEI[$k],
                        'customer_id' => $customer_id,
                        'created' => date('Y-m-d H:i:s'),
                        'created_by' => user_info('id'),
                    );

                    $dtl_id = save('sell_through', $dataDB);

                    activity_log('create_sell_through','sell_through',$dtl_id);
                }
            }


            $this->session->set_flashdata('success', 'Sell through has been genereted.');
            redirect(ADMIN_DIR . $this->module_route);
        }
    }


    public function update()
    {
        $id = $this->uri->segment(4);

        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->form();
            //$this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $customer_id = intval(getVar('customer_id'));
            $product_ids = getVar('product_ids');
            $IMEI = getVar('IMEI');
            $qty = getVar('qty');

            if(count($product_ids) > 0){
                foreach($product_ids as $k => $product_id){
                    $dataDB = array(
                        'product_id' => intval($product_id),
                        'qty' => intval($qty[$k]),
                        'IMEI' => $IMEI[$k],
                        'customer_id' => $customer_id,
                        'created' => date('Y-m-d H:i:s'),
                        //'created_by' => user_info('id'),
                    );

                    $dtl_id = save('sell_through', $dataDB);

                    activity_log('create_sell_through','sell_through',$dtl_id);
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

        $where = $this->id_field . " IN({$id})" . $this->where;
        delete_rows($this->table, $where);

        activity_log('delete_sell_through', $this->table, explode(',', $id));
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
    /*function export()
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
    }*/
}


/* End of file sell_through.php */
/* Location: ./application/controllers/admin/sell_through.php */