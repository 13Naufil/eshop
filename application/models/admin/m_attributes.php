<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 20-09-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_attributes extends CI_Model
{

    var $table = 'attributes';
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
        $this->form_validation->set_rules('attribute_code', 'Attribute Code', 'required');
        $this->form_validation->set_rules('admin_label', 'Admin Label', 'required');
        $this->form_validation->set_rules('frontend_input', 'Frontend Input', 'required');

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

}



/* End of file m_attributes.php */
/* Location: ./application/models/m_attributes.php */