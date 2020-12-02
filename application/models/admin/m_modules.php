<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_modules extends CI_Model
{
    var $table = 'modules';
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
        $this->form_validation->set_rules('parent_id', 'Parent', 'required');
        $this->form_validation->set_rules('module', 'Module', 'required');
        $this->form_validation->set_rules('module_title', 'Module Title', 'required');
        $this->form_validation->set_rules('ordering', 'Ordering', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }

    function file_upload($file_name, $config = array())
    {

        if (count($config) == 0) {
            $config['upload_path'] = ASSETS_DIR . 'admin/img/icons/';
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
            $file_name = $rs['upload_data']['file_name'];
            $file_path = $rs['upload_data']['file_path'];

            generate_image($rs['upload_data']['full_path'], $file_path . '22_' . $file_name, 22, 22);
            generate_image($rs['upload_data']['full_path'], $rs['upload_data']['full_path'], 64, 64);
        }

        return $return;
    }
}

/* End of file m_events.php */
/* Location: ./application/models/m_events.php */