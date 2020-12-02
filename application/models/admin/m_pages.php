<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pages extends CI_Model
{

    var $table = '';
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
        $this->form_validation->set_rules('title', 'Title', 'required');
        //$this->form_validation->set_rules('friendly_url', 'Friendly URL', 'required');
        //$this->form_validation->set_rules('content', 'Page content', 'required');
        /*$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
        $this->form_validation->set_rules('meta_keywords', 'Meta keywords', 'required');
        $this->form_validation->set_rules('meta_description', 'Meta description', 'required');*/

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }


    function file_upload($file_name, $config = array())
    {

        if (count($config) == 0) {
            $config['upload_path'] = ASSETS_DIR . 'front/uploads/';
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

            //generate_image($rs['upload_data']['full_path'], $file_path . 'thumb_' . $file_name, 300, 110);
        }

        return $return;
    }

}

/* End of file m_events.php */
/* Location: ./application/models/m_events.php */