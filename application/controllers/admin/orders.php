<?php
/**
 * Naufil khan
 * E: abashir@codecreativetech.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 *
 * @property M_cpanel $m_cpanel
 * @property M_products $m_products
 * @property M_customers $m_customers
 * @property LCS $LCS
 * @property Catalog $catalog
 * @copyright 2019 * @date 05-05-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller
{

    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $module_route;

    /**
     * *****************************************************************************************************************
     * @method products __construct
     * @model products main_model    | m_products
     * *****************************************************************************************************************
     */

    function __construct()
    {
        parent::__construct();
        $this->m_cpanel->checkLogin();

        //TODO:: Module Name
        $this->module_name = getUri(2);

        $this->table = 'orders';
        $this->id_field = 'id';

        $this->module_route = $this->router->class;
        $this->module_title = getModuleDetail()->module_title;

        $this->load->model(ADMIN_DIR . 'm_orders');
        $this->load->model(ADMIN_DIR . 'm_customers');
        $this->load->model(ADMIN_DIR . 'm_coupons');
        $this->load->model('catalog');
    }

    /**
     * *****************************************************************************************************************
     * @method products index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {

        $where = '';
        replace_find_query('customer', "TRIM(CONCAT(IFNULL(customers.first_name, ''),' ', IFNULL(customers.last_name,'')))", $where);

        $query = "SELECT
            orders.id
            , orders.order_number
            , TRIM(CONCAT(IFNULL(customers.first_name, ''),' ', IFNULL(customers.last_name,''))) AS customer
            , customers.phone
            , orders.total_amount
            , orders.created
            , orders.status
        FROM orders
        INNER JOIN customers ON (orders.customer_id = customers.id)
        WHERE 1 AND orders.status !='Process'" . $where;

        $data['query'] = $query;
        $data['query'] .= getFindQuery($data['query']);

        $this->admin_template->load($this->module_name . '/grid', $data);

    }


    public function view()
    {

        $data = array();
        $id = intval(getUri(4));
            if($id > 0){
            $query = "SELECT * FROM {$this->table} WHERE $this->id_field='{$id}'";
            $data['order'] = $this->db->query($query)->row();

            $data['customer'] = $this->m_customers->customer($data['order']->customer_id);
            /*$data['billing'] = $data['customer'];
            $data['shipping'] = $data['customer'];*/
            $billing = $this->m_customers->customer_address($data['order']->customer_id,'',$data['order']->billing_add_id);
            $shipping = $this->m_customers->customer_address($data['order']->customer_id, '', $data['order']->shipment_add_id);
            $data['billing'] = $billing['billing'];
            $data['shipping'] = $shipping['shipping'];

            $data['order_detail'] = $this->catalog->order_detail($id);

            $total_r = $this->catalog->total($id, true);
            //$data['shipping_amount'] = ($total_r->shipping_amount);
            /*$data['discount'] = ($total_r->discount);
            $data['total_amount'] = ($total_amount);*/

            $data['order_history_sql'] = "SELECT DISTINCT activity_log.id
              , activity_log.activity_name as activity
              , activity_log.description AS comment
              , activity_log.activity_datetime AS `datetime`
              , IF(POSITION('/admin/' IN activity_log.current_URL) > 0
                , concat('<a href=\"".admin_url('users/view/')."/',users.id,'\">',users.first_name,'</a>')
                , concat('<a href=\"".admin_url('users/view/')."/',customers.id,'\">',customers.first_name,'</a>'))
              AS performe_by
            FROM activity_log
            INNER JOIN orders ON(orders.id = activity_log.rel_id AND activity_log.`table` = 'orders' AND activity_log.activity_name IN('Create Order','Update Order','Update Order Status','Book Packet'))
            LEFT JOIN users ON (activity_log.user_id = users.id)
            LEFT JOIN customers ON (activity_log.user_id = customers.id)
            WHERE 1 AND orders.id='{$id}'";

            $this->admin_template->load($this->module_name . '/view', $data);
        }else{
            $this->admin_template->not_found();
        }
    }


    function print_invoice()
    {
        $id = intval(getUri(4));
        if ($id > 0) {
            $query = "SELECT * FROM orders WHERE id='{$id}'";
            $data['order'] = $this->db->query($query)->row();
            if ($data['order']->id == $id) {

                $data['customer'] = $this->m_customers->customer($data['order']->customer_id);

                $customer_address = $this->m_customers->customer_address($data['order']->customer_id, "", $data['order']->billing_add_id);
                $data['billing'] = $customer_address['billing'];
                $customer_address = $this->m_customers->customer_address($data['order']->customer_id, "", $data['order']->shipping_add_id);
                $data['shipping'] = $customer_address['shipping'];

                $data['order_detail'] = $this->catalog->order_detail($id);

                /*$total_r = $this->catalog->total($id, true);
                $total_amount = ($total_r->amount + $total_r->shipping_amount - $total_r->discount);
                $data['shipping_amount'] = ($total_r->shipping_amount);
                $data['discount'] = ($total_r->discount);
                $data['total_amount'] = ($total_amount);*/

                //$this->admin_template->load($this->module_name . '/order_print', $data);
                $this->load->view(ADMIN_DIR . $this->module_name . '/order_print', $data);
                return;
            }
        }else{
            $this->admin_template->not_found();
        }
    }
    /**
     * *****************************************************************************************************************
     * @method sales_orders form
     * *****************************************************************************************************************
     */
    public function form($Request = '')
    {

        $data = array();
        $id = intval(getUri(4));

        if (!empty($id)) {
            $SQL = "SELECT * FROM orders WHERE {$this->id_field}='{$id}'";
            $RS = $this->db->query($SQL);
            if ($RS->num_rows() == 0) {
                $this->admin_template->not_found();
            }
            $data['row'] = $RS->row();

            //$data['customer'] = $this->m_customers->customer($data['row']->customer_id);
            $data['order_detail'] = $this->catalog->order_detail($id);

            $shipping_dtl = unserialize(get_option('shipping'));
            $rule = $this->m_coupons->validate_rules($id);
            $data['shipping_amount'] = (($rule->free_shipping) ? 0 : $shipping_dtl['amount']);
            $data['discount'] = $data['row']->discount;

        } elseif ($Request) {
            $data['row'] = $Request;
        }

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item(($id > 0) ? 'Edit' : 'Add New');

        $this->admin_template->load($this->module_name . '/form', $data);
    }


    public function add()
    {
        /*if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else */
        {
            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Billing Address
            $_billing = getVar('billing', true, false);
            $DbArray = getDbArray('customer_addresses', array(), $_billing);
            save('customer_addresses', $DbArray['dbdata'], $DbArray['where']);

            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Shippinh Address
            $_shipping = getVar('shipping', true, false);
            $DbArray = getDbArray('customer_addresses', array(), $_shipping);
            save('customer_addresses', $DbArray['dbdata'], $DbArray['where']);

            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Order
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            //$DBdata['created'] = date('Y-m-d H:i:s');
            $DBdata['created_by'] = user_info()->id;
            $DBdata['billing_add_id'] = $_billing['id'];
            $DBdata['shipment_add_id'] = $_shipping['id'];
            $id = save($this->table, $DBdata);
            activity_log('Create Order', $this->table, $id);

            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # set_inventory
            $total_amount = $this->set_order_detail($id, $this->input->post(), 'Sales');
            save($this->table, array('order_number' => str_pad($id, 10, '0', STR_PAD_LEFT), 'total_amount' => $total_amount), "id='{$id}'");

            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++#
            $this->session->set_flashdata('success', 'Order has been genereted.');
            redirect(admin_url($this->module_route));
        }
    }
    
    public function update_address()
    {
         $id = $this->uri->segment(4);

        if ($this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            // $this->admin_template->load($this->module_name . '/form', $data);
            echo "asd";
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            
            
            echo "asd";
            $where = $DbArray['where'];
            print_r($DBdata);
            // save($this->table, $DBdata, $where);
            // activity_log('update_quick_order', $this->table, $id);

            // $this->session->set_flashdata('success', 'Record has been updated.');
            // redirect(ADMIN_DIR . $this->module_route);
        }
    }


    public function update()
    {
        $id = $this->uri->segment(4);

        /*if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else */
        {
            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Billing Address
            $_billing = getVar('billing', true, false);
            $DbArray = getDbArray('customer_addresses', array(), $_billing);
            save('customer_addresses', $DbArray['dbdata'], $DbArray['where']);

            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Shippinh Address
            $_shipping = getVar('shipping', true, false);
            $DbArray = getDbArray('customer_addresses', array(), $_shipping);
            save('customer_addresses', $DbArray['dbdata'], $DbArray['where']);

            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Order
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            
            //$DBdata['created'] = date('Y-m-d H:i:s');
            $DBdata['created_by'] = user_info()->id;
            $DBdata['billing_add_id'] = $_billing['id'];
            $DBdata['shipment_add_id'] = $_shipping['id'];
            save($this->table, $DBdata, $DbArray['where']);
            activity_log('Update Order', $this->table, $id);

            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # set_inventory
            $total_amount = $this->set_order_detail($id, $this->input->post(), 'Sales');
           save($this->table, array('order_number' => str_pad($id, 10, '0', STR_PAD_LEFT), 'total_amount' => $total_amount), "id='{$id}'");

            
            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++#
            $this->session->set_flashdata('success', 'Order has been updated.');
            redirect(admin_url($this->module_route));
        }
    }


    private function set_order_detail($order_id, $post_data, $type = 'Sale')
    {

        $total_amount = 0;

        $table = 'order_details';
        $update = false;
        $order = array();
        $del_order = array();
        $order_rs = $this->db->get_where($table, array('order_id' => $order_id));
        if ($order_rs->num_rows() > 0) {
            $_order = $order_rs->result();
            $update = true;
            foreach ($_order as $ord) {
                $order[$ord->product_id] = $ord->qty;
                $del_order[$ord->id] = $ord;
            }
        }
        delete_rows($table, "order_id='{$order_id}'");

        $del_dtl_ids = $post_data['del_dtl_ids'];
        if (count($del_dtl_ids) > 0) {
            foreach ($del_dtl_ids as $del_id) {

                $dtl = $del_order[$del_id];
                $has_qty = $this->db->select('qty')->get_where('products', array('id' => $dtl->product_id), 1)->row();
                $qty_total = ($has_qty - $dtl->qty);
                save('products', array('qty' => $qty_total), "id='{$dtl->product_id}'");
            }
        }

        if (count($post_data['product_ids']) > 0) {
            foreach ($post_data['product_ids'] as $k => $product_id) {

                if ($product_id <= 0) {
                    continue;
                }

                //$inventory = $this->db->select('*, IF(NOW() BETWEEN special_from_date AND special_to_date, 1, 0) AS is_special', false)->get_where('products', array('id' => $product_id), 1)->row();
                $inventory = $this->catalog->get_product_price($product_id);

                $new_qty = intval($post_data['qty'][$k]);
                $__qty = $new_qty;
                if ($update) {
                    $__qty = $order[$product_id];
                    $__qty = ($new_qty - $__qty);
                }

                if (in_array($type, array('Sales'))) {

                    if (($inventory->qty) < $__qty && ($__qty >= $inventory->min_sale_qty && $__qty <= $inventory->max_sale_qty)) {
                        $this->session->set_flashdata('error', $inventory->name . ' have ' . $new_qty . ' in stock!');
                        continue;
                    }
                }

                //$price = ($inventory->is_special == 1 ? $inventory->special_price : $inventory->price);
                $price = $inventory->amount;
                $total_amount += ($new_qty * $price);
                $dataDB = array(
                    'order_id' => intval($order_id),
                    'product_id' => intval($product_id),
                    'price' => $price,
                    'qty' => $new_qty,
                    'tax' => floatval($post_data['tax'][$k]),
                    'discount' => floatval($post_data['discount'][$k])
                );
                $dtl_id = save($table, $dataDB);
                save('products', array('qty' => ($inventory->qty - $__qty)), "id='$product_id'");
            }
        }

        return $total_amount;
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
            $status = getVar('status');

            $status_row = $this->db->select('order_statuses.*, email_templates.name as email_temp')->join('email_templates', 'email_templates.id = order_statuses.email_template','left')->get_where('order_statuses', array('status_code' => $status), 1)->row();
            if ($status_row->id > 0) {
                $where = $this->id_field . " IN({$id})";
                $data = array('status' => $status_row->status_code);
                save($this->table, $data, $where);

                activity_log('Update Order Status', $this->table, $id, 0, getVar('comment'));
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # order_email
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                $customer = $this->m_customers->customer($order->customer_id);
                $order_email_tags = $this->m_orders->order_email_tags($order->id);
                
                $email_tags = array_merge((array)$customer, (array)$order_email_tags);
                $msg = get_email_template($email_tags, $status_row->email_temp);
               
                $flash_msg = array();
                if ($msg->status == 'Active') {
                    $emaildata = array(
                        'to' => $customer->email,
                        'subject' => $msg->subject,
                        'message' => $msg->message
                    );

                    if (!send_mail($emaildata)) {
                        $flash_msg['error'][] = 'Email sending failed.';
                    } else {
                        $flash_msg['success'][] = 'Please check your email for order invoice!';
                    }
                }
                if ($msg->sms_status == 'Active') {

                    $sms = get_email_template($email_tags, '', $msg->sms_message);
                    if (!send_sms($sms, $customer->phone)) {
                        $flash_msg['error'][] = 'SMS sending faild.';
                    }/*else{
                    $flash_msg['success'][] = ('Please check your email for order invoice!');
                }*/
                }
                $flash_msg['success'][] = 'Status has been changed.';
                $this->session->set_flashdata('success', join('<br>', $flash_msg['success']));

                if (count($flash_msg['error']) > 0) {
                    $this->session->set_flashdata('error', join('<br>', $flash_msg['error']));
                }

            }
        }

        // redirect($this->input->server('HTTP_REFERER'));
    }


    public function delete()
    {
        $id = intval(getUri(4));
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }

        $ids = explode(',', $id);
        foreach ($ids as $_id) {
            $this->m_orders->_delete($_id);
            activity_log('Delete Order', $this->table, $id);
        }

        $this->session->set_flashdata('success', 'Record has been deleted.');
        redirect(ADMIN_DIR . $this->module_name);
    }





    function courier_options(){

        $id = intval(getUri(4));
        $action = (getUri(5));
        if($id > 0){
            $data['order'] = $this->db->get_where($this->table, array('id' => $id), 1)->row();
            $data['id'] = $id;
            //$track_number = $data['order']->track_number = 'KI76040877';

            $this->load->model('lcs');

            switch($action){
                case 'book_packet':
                    $lcs_data['special_instructions'] = 'Call Before Delivery';
                    $data['lcs'] = $this->lcs->bookPacket($id, $lcs_data);
                    if(!empty($data['lcs']->track_number)){
                        activity_log('Book Packet', $this->table, $id, 0, 'Book Packet : Tracking #: ' . $data['lcs']->track_number);
                        $this->session->set_flashdata('success', 'Order has been sent to LCS Book Packet!');
                    }
                    redirectBack();
                break;
                default:
                    $data['lcs'] = $this->lcs->trackBookedPacket($data['order']->track_number);
                    $JSON['track_number'] = ($data['order']->track_number);
                    $JSON['slip_link'] = "http://www.leopardscod.com/webservice/generateBookedPacketSlip".($this->lcs->test ? 'Test' : '')."/api_key/".$this->lcs->api_key."/api_password/".$this->lcs->api_password."/letter_type/all/track_number/" . base64_encode($data['order']->track_number);
                    $JSON['html'] = $this->load->view(ADMIN_DIR . $this->module_route . '/track_order', $data, true);
                break;
            }


        }else{
            ob_start();
            $this->admin_template->error_404();
            $JSON['html']  = ob_get_clean();
        }
        echo json_encode($JSON);
    }

}


/* End of file products.php */
/* Location: ./application/controllers/admin/products.php */