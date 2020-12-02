<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class feature_slider extends CI_Controller
{

    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $module_route;

    /**
     * *****************************************************************************************************************
     * @method brands __construct
     * @model brands main_model    | m_brands
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
     * @method brands index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {

        $where = 'and pi.default=1 ';
        $query = "SELECT ps.id,pi.image as 'Product Image',p.name as 'Product Name',p.price as 'Product Price',ps.order as 'Ordering' FROM " . $this->table . " ps inner join products p on ps.product_id = p.id inner join product_images pi on p.id=pi.product_id WHERE 1 " . $where;
        //$this->session->set_userdata(array('export_query' => $query));
        $data['query'] = $query;
        $data['query'] .= getFindQuery($data['query']);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));

        $this->admin_template->load($this->module_name . '/grid', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method brands form
     * *****************************************************************************************************************
     */
    public function form($Request = '')
    {

        $data = array();
        $id = intval(getUri(4));

        if (!empty($id)) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
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
     * @method brands view
     * *****************************************************************************************************************
     */
    public function view()
    {

        $data = array();
        $id = intval(getUri(4));
        $query = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='{$id}'";
        $data['query'] = $query;

        $data['config']['buttons'] = array('new', 'update', 'delete', 'refresh', 'print', 'back');
        $data['config']['image_fields'] = array('logo');
        $data['config']['custom_func'] = array('status' => 'status_field');


        $data['title'] = $this->module_title;

        activity_log('view_brands', $this->table, $id);

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
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];

            
            
            $DBdata['status'] = "Active";
            
            $id = save($this->table, $DBdata);
            
            activity_log('new_quick_order', $this->table, $id);

            $this->session->set_flashdata('success', 'Record has been inserted.');
            redirect($_SERVER['HTTP_REFERER']);

        }
    }

    public function getproduct(){
        $post=$this->input->post();
        $category=$post['category'];
        $products = $this->catalog->get_products("and products.id in (select product_id from product_cat_rel where category_id='$category')",'RAND()','100');
        
        
            echo json_encode($products);

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
            
            
           
            $where = $DbArray['where'];
            // print_r($DBdata);
            save($this->table, $DBdata, $where);
            activity_log('update_quick_order', $this->table, $id);

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

        activity_log('view_brands', $this->table, explode(',', $id));
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

        if ($id > 0) {
            $order = $this->db->get_where($this->table, array('id' => $id), 1)->row();
            $status = getVar('Status');

            $status_row = $this->db->select('order_statuses.*, email_templates.name as email_temp')->join('email_templates', 'email_templates.id = order_statuses.email_template','left')->get_where('order_statuses', array('status_code' => $status), 1)->row();
            if ($status_row->id > 0) {
                $where = $this->id_field . " IN({$id})";
                $data = array('status' => $status_row->status_code);
                save($this->table, $data, $where);

                activity_log('Update Order Status', $this->table, $id, 0, getVar('comment'));
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # order_email
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                // $order_email_tags = $this->m_orders->order_email_tags($order->id);

                // $email_tags = array_merge((array)$order, (array)$order_email_tags);
                // $msg = get_email_template($email_tags, $status_row->email_temp);
               

                // $flash_msg = array();
                // if ($msg->status == 'Active') {
                //     $emaildata = array(
                //         'to' => $order->customer_email,
                //         'subject' => $msg->subject,
                //         'message' => $msg->message
                //     );

                //     if (!send_mail($emaildata)) {
                //         $flash_msg['error'][] = 'Email sending failed.';
                //     } else {
                //         $flash_msg['success'][] = 'Please check your email for order invoice!';
                //     }
                // }
                // if ($msg->sms_status == 'Active') {

                //     $sms = get_email_template($email_tags, '', $msg->sms_message);
                //     if (!send_sms($sms, $customer->phone)) {
                //         $flash_msg['error'][] = 'SMS sending faild.';
                //     }/*else{
                //     $flash_msg['success'][] = ('Please check your email for order invoice!');
                // }*/
                // }
                $flash_msg['success'][] = 'Status has been changed.';
                $this->session->set_flashdata('success', join('<br>', $flash_msg['success']));

                // if (count($flash_msg['error']) > 0) {
                //     $this->session->set_flashdata('error', join('<br>', $flash_msg['error']));
                // }

            }
        }

        redirect($this->input->server('HTTP_REFERER'));
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


/* End of file brands.php */
/* Location: ./application/controllers/admin/brands.php */