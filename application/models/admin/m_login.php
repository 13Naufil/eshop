<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_login extends CI_Model
{

    function __construct()
    {
        parent::__construct();

    }

    function validate()
    {
        $this->form_validation->set_rules('user_name', 'user_name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }


    function chklogin($username, $password)
    {
        $SQL = "SELECT * FROM users WHERE username='" . ($username) . "' AND `password`='" . ($password) . "' and `status`='Active'";

        $result = $this->db->query($SQL);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}

/* End of file m_events.php */
/* Location: ./application/models/m_events.php */