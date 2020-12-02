<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class M_cpanel
 * @property Admin_template $admin_template
 */
class M_cpanel extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }

    public function checkLogin()
    {
        $QUERY_STRING = $this->input->server('QUERY_STRING');
        $QS = '';
        if (!empty($QUERY_STRING)) {
            $QS = '?' . $QUERY_STRING;
        }
        if ($this->session->userdata('cct_user_id') == '') {
            $this->session->set_userdata('REFERER', current_url() . $QS);
            redirect(ADMIN_DIR . 'login');
        } else {
            $chk_user_info = $this->session->userdata('user_info');
            $this->load->model(ADMIN_DIR . 'm_login');
            if (!$this->m_login->chklogin($chk_user_info->username, $chk_user_info->password)) {
                $this->session->set_userdata('REFERER', current_url() . $QS);
                redirect(ADMIN_DIR . 'login');
            }
        }
        if (getUri(1) == substr(ADMIN_DIR, 0, -1)) {
            $this->checkModule();
        }
    }

    function checkModule()
    {
        $module = $this->uri->segment(2);
        $action = $this->uri->segment(3);
        $user_type = intval($this->session->userdata('user_type'));

        $mod_sql = "SELECT
                       um.module_id,
                       m.module,
                       um.actions
                   FROM
                       users AS u
                       INNER JOIN user_type_module_rel AS um
                           ON (u.user_type_id = um.user_type_id)
                       INNER JOIN modules AS m
                           ON (m.id = um.module_id)
                      WHERE um.user_type_id='" . $user_type . "'
                      AND m.module='" . dbEscape($module) . "'
                      AND m.status='1'";

        $mod_rs = $this->db->query($mod_sql);

        if ($mod_rs->num_rows() > 0) {
            $U_modules = array();
            $actions = array();
            foreach ($mod_rs->result() as $u_module) {
                array_push($U_modules, $u_module->module_id);
                if (!($u_module->module == '#' || $u_module->module == ''))
                    $my_modules[$u_module->module_id] = $u_module->module;
                if ($u_module->actions != '') {
                    $actions[$u_module->module] = $u_module->actions;
                }
            }
        }


        $user_modules = $my_modules;

        $sql = "SELECT id, module,actions FROM modules WHERE module='" . addslashes($module) . "'";
        $mod_rs = $this->db->query($sql)->row();
        $module_actions = array_unique(explode('|', $mod_rs->actions));


        $user_actions = $actions;

        $search = array('edit', 'update', 'export_csv');
        $replace = array('update|form', 'update|form', 'export');

        $user_actions = array_unique(explode('|', str_replace($search, $replace, $user_actions[$module])));

        if (in_array('new', $user_actions)) {
            array_push($user_actions, 'add');
        }
        if (in_array($module, $user_modules)) {
            if ($module == 'price_list') {
                $user_actions[] = 'grid';
            }
            array_push($user_actions, 'index');
            if (!in_array($action, $user_actions) && in_array($action, $module_actions)) {
                $this->admin_template->error_403();
                //show_404('This module action has no access allowed');
                exit;
                //die('This module action has no access allowed');
            }
            return TRUE;
        } elseif (count($mod_rs) == 0) {
            return TRUE;
        } else {
            $this->admin_template->error_403();
            //show_404('This module has no access allowed');
            exit;
            //die('This module has no access allowed');
        }
    }
}

/* End of file m_events.php */
/* Location: ./application/models/m_events.php */