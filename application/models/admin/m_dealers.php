<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com

 * @copyright 2019 * @date 19-01-2019 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_dealers extends CI_Model {

    var $table = 'dealers';
    var $id_field = 'id';

    function __construct() {

        parent::__construct();
        if (empty($this->table)) {
            $this->table = getUri(2);
        }
    }

    function validate() {
                $this->form_validation->set_rules('business_name', 'Business Name', 'required');
                                $this->form_validation->set_rules('owner_name', 'Owner Name', 'required');
                                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                                $this->form_validation->set_rules('country', 'Country', 'required');
                                $this->form_validation->set_rules('state', 'State', 'required');
                                $this->form_validation->set_rules('city', 'City', 'required');
                                $this->form_validation->set_rules('area', 'Area', 'required');
                                $this->form_validation->set_rules('market', 'Market', 'required');
                
        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function file_upload($file_name, $config = array()) {

        if(count($config) == 0){
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

}



/* End of file m_dealers.php */
/* Location: ./application/models/m_dealers.php */