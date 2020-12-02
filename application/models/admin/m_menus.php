<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_menus extends CI_Model
{

    var $table = 'menus';
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
        $this->form_validation->set_rules('link_title', 'Link title', 'required');
        $this->form_validation->set_rules('content', 'Page content', 'required');
        $this->form_validation->set_rules('meta_title', 'Meta title', 'required');
        $this->form_validation->set_rules('meta_keywords', 'Meta keywords', 'required');
        $this->form_validation->set_rules('meta_description', 'Meta description', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }

}

/* End of file m_events.php */
/* Location: ./application/models/m_events.php */