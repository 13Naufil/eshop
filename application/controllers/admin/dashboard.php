<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->m_cpanel->checkLogin();
    }


    public function index()
    {
        $query = "SELECT *, IF(icon != '', icon, 'module.png') AS icon FROM `modules` WHERE `status`='1' AND `show_on_menu`=1 AND id IN (SELECT `module_id` FROM `user_type_module_rel` WHERE user_type_id='" . intval($this->session->userdata('user_type')) . "') ORDER BY parent_id,ordering ASC";
        $modules = $this->db->query($query)->result();

        $this->admin_template->assign('modules', $modules);
        $this->admin_template->load('dashboard/dashboard');

    }



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */