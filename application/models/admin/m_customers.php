<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 04-08-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_customers extends CI_Model
{

    var $table = 'customers';
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
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
        if(getVar('id') == 0){
            $this->form_validation->set_rules('password', 'Password', 'required');
        }
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');

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

    function customer($id = null, $where = '')
    {
        if ($id > 0) {
            $where .= " AND id='{$id}'";
        }
        $SQL = "SELECT *
        , TRIM(CONCAT(IFNULL(first_name,''),' ',IFNULL(last_name,''))) AS full_name
        , TRIM(CONCAT(IFNULL(address,''),', ',IFNULL(city,''),', ',IFNULL(country,''))) AS full_address
        FROM customers WHERE 1 " . $where;

        $RS = $this->db->query($SQL);

        if ($id > 0) {
            return $RS->row();
        } else {
            return $RS->result();
        }
    }


    function customer_address($customer_id = 0, $where = '', $address_id = 0, $last_addrs = true)
    {
        if ($customer_id > 0) {
            $where .= " AND customer_addresses.customer_id='{$customer_id}'";
        }
        if ($address_id > 0) {
            $where .= " AND customer_addresses.id='{$address_id}'";
        }

        $SQL = "SELECT customer_addresses.*
        , customers.company
        , TRIM(CONCAT(IFNULL(customer_addresses.first_name,''),' ',IFNULL(customer_addresses.last_name,''))) AS full_name
        , TRIM(CONCAT(IFNULL(customer_addresses.address,''),', ',IFNULL(customer_addresses.city,''),', ',IFNULL(customer_addresses.country,''))) AS full_address
        FROM customer_addresses
        INNER JOIN customers ON(customers.id = customer_addresses.customer_id)
        WHERE 1 " . $where . " ORDER BY default_billing, default_shipping,id DESC";

        $RS = $this->db->query($SQL);
        if($last_addrs){
            $RS = $RS->result();

            $rows = array();
            if(count($RS) > 0){
                foreach ($RS as $row) {
                    if($row->default_shipping == 1 && !is_object($rows['shipping'])){
                        $rows['shipping'] = $row;
                    }else if($row->default_billing == 1 && !is_object($rows['billing'])){
                        $rows['billing'] = $row;
                    }
                }
            }
            return $rows;
        }
        return $RS->result();
    }


    function wishlist($customer_id)
    {
        $this->load->model('catalog');

        $where = "AND products.id IN(SELECT customer_wishlist.product_id FROM customer_wishlist WHERE customer_id='{$customer_id}')";
        $products = $this->catalog->get_products($where, $order_by, $limit, $offset);

        return $products;
    }


    function orders($customer_id)
    {
        $SQL = "SELECT
                orders.*
                , customers.first_name
                , customers.last_name
                , TRIM(CONCAT(IFNULL(customers.first_name,''), ' ', IFNULL(customers.last_name,''))) AS full_name
                , customers.phone
                , customers.email
                , customers.address
                , customers.city
                FROM orders INNER JOIN customers ON customers.id = orders.customer_id WHERE customers.id='{$customer_id}' AND orders.status !='Process'
                ORDER BY orders.id DESC";
        return $this->db->query($SQL)->result();
    }

}



/* End of file m_customers.php */
/* Location: ./application/models/m_customers.php */