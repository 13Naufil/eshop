<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 13-08-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_coupons extends CI_Model
{

    var $table = 'coupons';
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
        $this->form_validation->set_rules('coupon_name', 'Coupon Name', 'required');
        if(getVar('coupon_type') == 'Coupon'){
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'required');
        }
        $this->form_validation->set_rules('discount_type', 'Discount Type', 'required');
        $this->form_validation->set_rules('discount', 'Discount', 'required');
        $this->form_validation->set_rules('total_amount', 'Total Amount', 'required');
        if(getVar('usage_policy') == 'Limited') {
            $this->form_validation->set_rules('usage_limit', 'Usage Limit', 'required');
        }

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

    function validate_rules($order_id){
        $this->load->model('catalog');
        //$order = $this->db->get_where('orders', array('id' => $order_id), 1)->row();
        $total_amount = $this->catalog->total($order_id)->amount;

        $SQL = "SELECT * FROM {$this->table} WHERE `coupon_type`='Price Rule' AND NOW() BETWEEN `start_date` AND `end_date` AND total_amount <= '{$total_amount}'";
        $rules = $this->db->query($SQL)->result();

        $response = new stdClass();
        $response->free_shipping = false;
        $response->discount = 0;
        if(count($rules) > 0){
            foreach($rules as $rule){
                //if($total_amount >= $rule->total_amount)
                {
                    if($rule->discount_type == 'Percentage'){
                        $response->discount += floatval((($total_amount * $rule->discount) / 100));
                    }else{
                        $response->discount += floatval($rule->discount);
                    }
                    if($rule->free_shipping == 'Yes'){
                        $response->free_shipping = true;
                    }
                }
            }
        }
        return $response;
    }

}



/* End of file m_coupons.php */
/* Location: ./application/models/m_coupons.php */