<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Login
 * @property M_Modules $m_modules
 * @property M_cpanel $m_cpanel
 */
class Modules extends CI_Controller
{
    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $module_route;

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

        $this->module_route = $this->router->class;
        $this->module_title = ucwords(str_replace('_', ' ', $this->module_name));

    }

    public function index()
    {
        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));

        $where = '';
        $data['query'] = "SELECT
            m.id
            , m.module_title
            , m.ordering
            , m.show_on_menu
            , m.actions
            , m.created
            , m.status
        FROM
            modules AS m
            LEFT JOIN modules AS pm
                ON (m.parent_id = pm.id) WHERE 1 " . $where;

        $data['query'] .= getFindQuery($data['query']);

        $this->admin_template->load($this->module_name . '/grid', $data);
    }


    public function form()
    {
        $id = intval(getUri(4));

        if ($id > 0) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
            $RS = $this->db->query($SQL);
            if($RS->num_rows() == 0) { $this->admin_template->not_found(); }
            $data['row'] = $RS->row();
        }

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item(($id > 0) ? 'Edit' : 'Add New');

        $this->admin_template->load($this->module_name . '/form', $data);
    }

    public function view()
    {
        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));

        $id = intval(getUri(4));

        if ($id > 0) {
            $SQL = "SELECT
                m.id
                , m.module
                , IFNULL(pm.module_title, 'Main') AS parent
                , m.module_title
                , m.ordering
                , m.show_on_menu
                , m.actions
                , m.created
                , m.status
            FROM
                modules AS m
                LEFT JOIN modules AS pm
                    ON (m.parent_id = pm.id)
                    WHERE " . $this->id_field . "='" . $id . "'";
            $data['row'] = $this->db->query($SQL)->row();
        }

        $data['title'] = $this->module_title;
        //$this->admin_template->load($this->module_name . '/form', $data);
        $this->admin_template->load('includes/record_view', $data);
    }

    public function add()
    {

        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());

            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];

            $DBdata['icon'] = getVar('icon_class');
            if ($_FILES['icon']['name']) {
                $upload = $this->module->file_upload('icon');

                if (!$upload['status']) {
                    $this->form($this->input->post(NULL, TRUE));
                } else {
                    $file_name = $upload['upload_data']['file_name'];
                }
                $DBdata['icon'] = $file_name;
            }

            $id = save($this->table, $DBdata);

            if($this->session->userdata('user_type')  == get_option('admin_user_type')){
                save('user_type_module_rel', array('user_type_id' => get_option('admin_user_type') , 'module_id' => $id, 'actions' => $DBdata['actions']));
            }

            $this->session->set_flashdata('success', 'Record has been inserted.');
            redirect(ADMIN_DIR . $this->module_name);
        }
    }


    public function update()
    {
        $id = intval(getUri(4));

        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            $DBdata['show_on_menu'] = getVar('show_on_menu');
            $DBdata['icon'] = getVar('icon_class');

            if ($_FILES['icon']['name']) {
                $upload = $this->module->file_upload('icon');
                if (!$upload['status']) {
                    $this->form($this->input->post(NULL, TRUE));
                } else {
                    $file_name = $upload['upload_data']['file_name'];
                }
                $DBdata['icon'] = $file_name;
            }

            $where = $DbArray['where'];

            save($this->table, $DBdata, $where);

            if ($this->session->userdata('user_type') == get_option('admin_user_type')) {
                delete_rows('user_type_module_rel', "user_type_id='" . get_option('admin_user_type') . "' AND module_id='{$id}'");
                save('user_type_module_rel', array('user_type_id' => get_option('admin_user_type'), 'module_id' => $id, 'actions' => $DBdata['actions']));
            }
            $this->session->set_flashdata('success', 'Record has been updated.');
            redirect(ADMIN_DIR . $this->module_name);

        }
    }


    /**
     * *****************************************************************************************************************
     * @method Status
     * @unlink Delete Files (unlink)
     * *****************************************************************************************************************
     */
    function status()
    {

        $id = intval(getUri(4));
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }

        $where = $this->id_field . " IN({$id})";

        $status = 1;
        if (getVar('status') == 1) {
            $status = 0;
        }
        $data = array('status' => $status);

        save($this->table, $data, $where);
        $this->session->set_flashdata('success', 'Status has been changed.');
        redirect(ADMIN_DIR . $this->module_route);
    }

    public function delete()
    {
        $id = intval(getUri(4));
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }

        $where = $this->id_field . " IN({$id})";

        /*$delete_files = array(
            'file_name' => './assets/admin/users_files/'
        );*/

        delete_rows($this->table, $where);
        /*$SQL = "DELETE FROM " . $this->table . " WHERE `" . $this->id_field . "` IN(" . $id . ")";
        $this->db->query($SQL);*/

        $this->session->set_flashdata('success', 'Record has been deleted.');
        redirect(ADMIN_DIR . $this->module_name);
    }

    function AJAX($action, $id)
    {
        switch ($action) {
            case 'delete_img':
                $del_img = array('icon' => './assets/admin/img/icons/');
                delete_rows($this->table, $this->id_field . "=" . intval($id), false, '', 'icon', $del_img);
                break;
        }
    }
}

/* End of file pages.php */
/* Location: ./application/controllers/admin/pages.php */