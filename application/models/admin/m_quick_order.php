<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_quick_order extends CI_Model
{

    var $table = 'quick_order';
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
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    // function file_upload($file_name, $config = array())
    // {

    //     if (count($config) == 0) {
    //         $config['upload_path'] = ASSETS_DIR . 'front/brands/';
    //         $config['allowed_types'] = 'gif|jpg|jpeg|png';
    //     }


    //     $this->load->library('upload');
    //     $this->upload->initialize($config);

    //     $rs = $this->upload->upload_multi($file_name);
    //     if (count($rs['error']) > 0) {
    //         $return['status'] = FALSE;
    //         $return['error'] = $rs;
    //     } else {
    //         $return['status'] = TRUE;
    //         $return['upload_data'] = $rs['upload_data'];
    //     }

    //     return $return;
    // }


}

