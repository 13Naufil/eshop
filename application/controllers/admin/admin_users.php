<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Banned_users
 * @property M_Modules $m_modules
 * @property M_cpanel $m_cpanel
 */
class Admin_users extends CI_Controller
{
    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $iic_user_type;

    function __construct()
    {
        parent::__construct();
        $this->m_cpanel->checkLogin();

        //TODO:: Module Name
        $this->module_name = getUri(2);
        $this->module = 'm_' . $this->module_name;
        $this->load->model(ADMIN_DIR . $this->module);
        $this->module = $this->{$this->module};

        $this->table = $this->module->table;
        $this->id_field = $this->module->id_field;

        $this->module_title = ucwords(str_replace('_', ' ', $this->module_name));

        $this->iic_user_type = intval(get_option('iic_user_type'));
    }

    public function index()
    {
        $where = '';
        $where = str_ireplace(array('Active', 'Inactive'), array(1, 0), $where);

        $data['title'] = $this->module_title;
        $data['query'] = "SELECT
            u.id
            , ut.user_type
            , u.username
            , u.email
            , IF(u.status = 1, 'Active', 'Inactive') as status
            , u.created
        FROM
            users AS u
            INNER JOIN user_types AS ut
                ON (u.user_type = ut.id)  WHERE u.user_type !='" . $this->iic_user_type . "' " . $where;

        $data['query'] .= getFindQuery($data['query']);

        $this->load->view(ADMIN_DIR . $this->module_name . '/grid', $data);
    }


    public function form()
    {
        $id = intval(getUri(4));

        if ($id > 0) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE user_type !='" . $this->iic_user_type . "' AND " . $this->id_field . "='" . $id . "'";
            $RS = $this->db->query($SQL);
            if($RS->num_rows() == 0) { $this->admin_template->not_found(); }
            $data['row'] = $RS->row();
        }

        $data['title'] = $this->module_title;
        $this->load->view(ADMIN_DIR . $this->module_name . '/form', $data);
    }

    public function view()
    {
        $id = intval(getUri(4));

        if ($id > 0) {
            $SQL = "SELECT
                        u.id
                        , ut.user_type
                        , u.username
                        , u.email
                        , u.status
                        , u.created
                        , u.modified
                    FROM
                        users AS u
                        INNER JOIN user_types AS ut
                            ON (u.user_type = ut.id) WHERE u.user_type !='" . $this->iic_user_type . "' AND u." . $this->id_field . "='" . $id . "'";
            $data['row'] = $this->db->query($SQL)->row();
        }
        $data['buttons'] = array();
        $data['title'] = $this->module_title;
        $this->load->view(ADMIN_DIR . '/includes/record_view', $data);
    }


    function status()
    {

        $id = intval(getUri(4));
        $status = (getUri(5));

        $where = $this->id_field . "='" . $id . "'";
        save($this->table, array('result' => $result), $where);
        redirect(ADMIN_DIR . $this->module_name);
    }

    public function add()
    {
        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->load->view(ADMIN_DIR . $this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            $DBdata['password'] = encryptPassword(getVar('password'));

            $id = save($this->table, $DBdata);

            $this->session->set_flashdata('success', 'Record has been inserted.');
            redirect(ADMIN_DIR . $this->module_name);
        }
    }


    public function update()
    {
        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->load->view(ADMIN_DIR . $this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];

            $DBdata['password'] = encryptPassword(getVar('password'));
            if (getVar('password') == '%%password%%') {
                unset($DBdata['password']);
            }

            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);
            $this->session->set_flashdata('success', 'Record has been updated.');
            redirect(ADMIN_DIR . $this->module_name);

        }
    }


    public function delete()
    {
        $id = intval(getUri(4));
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }
        $SQL = "DELETE FROM " . $this->table . " WHERE `" . $this->id_field . "` IN(" . $id . ")";

        $this->db->query($SQL);
        $this->session->set_flashdata('success', 'Record has been deleted.');
        redirect(ADMIN_DIR . $this->module_name);
    }
}

/* End of file pages.php */
/* Location: ./application/controllers/admin/pages.php */