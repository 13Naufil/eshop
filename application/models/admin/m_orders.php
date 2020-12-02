<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019
 * @date 07-11-2019
 */
/**
 * @property M_coupons $m_coupons;
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_orders extends CI_Model
{

    var $table = 'orders';
    var $id_field = 'id';

    function __construct()
    {

        parent::__construct();
        if (empty($this->table)) {
            $this->table = getUri(2);
        }
    }

    function validate()
    {
        //$this->form_validation->set_rules('transaction_date', 'Transaction Date', 'required|callback_period_check');
        $this->form_validation->set_rules('customer_id', 'Customer', 'required');

        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function file_upload($file_name, $config = array())
    {
        if (count($config) == 0) {
            $config['upload_path'] = ASSETS_DIR . 'admin/img/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
        }

        $this->load->library('upload');
        $this->upload->initialize($config);

        $rs = $this->upload->upload_multi($file_name);
        if (count($rs['error']) > 0) {
            $return['status'] = FALSE;
            $return['error'] = $rs;
        } else {
            $return['status'] = TRUE;
            $return['upload_data'] = $rs['upload_data'];
        }

        return $return;
    }

    function _cancel($order_id){

        save($this->table, array('status' => 'Cancel'), "id='$order_id'");
        $order_dtl = $this->db->query("SELECT product_id, qty FROM order_details WHERE 1 AND order_id='{$order_id}'");
        if (count($order_dtl) > 0) {
            foreach ($order_dtl as $dtl) {
                $this->catalog->update_stock($dtl->product_id, $dtl->qty, 'delete');
            }
        }
        activity_log('Cancel Order', $this->table, $order_id);
    }

    function _delete($order_id){

        delete_rows($this->table, "id='$order_id'");
        $order_dtl = $this->db->query("SELECT product_id, qty FROM order_details WHERE 1 AND order_id='{$order_id}'");
        if (count($order_dtl) > 0) {
            foreach ($order_dtl as $dtl) {
                $this->catalog->update_stock($dtl->product_id, $dtl->qty, 'delete');
            }
            delete_rows('order_details', "order_id='$order_id'");
        }
        activity_log('Delete Order', $this->table, $order_id);
    }

    function order_email_tags($order_id){
        $this->load->model('catalog');
        $this->load->model(ADMIN_DIR . 'm_customers');
        $this->load->model(ADMIN_DIR . 'm_coupons');

        $data['order'] = $this->db->get_where('orders', array('id' => $order_id))->row();

        $data['customer'] = $this->m_customers->customer($data['order']->customer_id);
        /*$data['billing'] = $data['customer'];
        $data['shipping'] = $data['customer'];*/

        $customer_address = $this->m_customers->customer_address($data['order']->customer_id, "", $data['order']->billing_add_id);
        $data['billing'] = $customer_address['billing'];
        $customer_address = $this->m_customers->customer_address($data['order']->customer_id, "", $data['order']->shipping_add_id);
        $data['shipping'] = $customer_address['shipping'];

        $data['order_detail'] = $this->catalog->order_detail($order_id);

        $total_r = $this->catalog->total($order_id, true);
        $total_amount = ($total_r->amount + $total_r->shipping_amount - $total_r->discount);
        $data['shipping_amount'] = $total_r->shipping_amount;
        $data['discount'] = ($total_r->discount);
        $data['total_amount'] = ($total_amount);

        /*$_shipping = unserialize(get_option('shipping'));
        $rule = $this->m_coupons->validate_rules($order_id);
        $data['shipping_amount'] = (($rule->free_shipping) ? 0 : $_shipping['amount']);
        $data['discount'] = $rule->discount;*/


        extract($data);

        $email_data = array(
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'order_status' => $order->status,
            'order_created' => $order->created,
            'billing_address' => $this->load->view(ADMIN_DIR . 'email_temp/billing_address', $data, true),
            'payment_method' => $order->payment_method,
            'shipping_address' => $this->load->view(ADMIN_DIR . 'email_temp/shipping_address', $data, true),
            'shipping_method' => 'Courier',
            'order_items' => $this->load->view(ADMIN_DIR . 'email_temp/order_items', $data, true),
            'order_note' => $order->note,
            //'order_total_amount' => $order->total_amount,
            'order_total_amount' => $total_amount,
            'order_discount' => $order->discount,
        );

        return $email_data;
    }

}



/* End of file m_purchase_orders.php */
/* Location: ./application/models/m_purchase_orders.php */