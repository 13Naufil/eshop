<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_blog_categories extends CI_Model
{
    var $table = 'blog_categories';
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
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }

    function do_upload($name, $config = array())
    {
        if (count($config) == 0) {

            $config['upload_path'] = "./assets/frontend/img/";
            $config['allowed_types'] = 'gif|jpg|jpeg|bmp|png';
        }
        $this->load->library('upload');

        $this->upload->initialize($config);

        if (!$this->upload->do_upload($name)) {
            $result = array('error' => $this->upload->display_errors());
        } else {
            $result = $this->upload->data();
        }
        return $result;
    }
}

/* End of file m_events.php */
/* Location: ./application/models/m_events.php */