<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Login
 * @property M_pages $m_pages
 * @property M_cpanel $m_cpanel
 */
class Pages extends CI_Controller
{
    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;

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
        $where = '';
        $data['query'] = "SELECT `id`, `title`, `friendly_url` FROM " . $this->table . " WHERE 1 " . $where;
        $data['query'] .= getFindQuery($data['query']);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));

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
        $this->breadcrumb->add_item(($id > 0) ?'Edit' : 'Add New');


        $this->admin_template->load($this->module_name . '/form', $data);
    }

    public function view()
    {
        $id = intval(getUri(4));

        if ($id > 0) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
            $data['row'] = $this->db->query($SQL)->row();
        }

        $data['title'] = $this->module_title;

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item('View');

        $this->admin_template->load('includes/record_view', $data);
    }


    function status()
    {

        $id = intval(getUri(4));
        $status = (getUri(5));

        $where = $this->id_field . "='" . $id . "'";
        save($this->table, array('result' => $status), $where);
        redirect(ADMIN_DIR . $this->module_name);
    }

    public function add()
    {
        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            unset($DBdata['content']);
            $DBdata['content'] = getVar('content', FALSE, FALSE);
            if (!empty($_FILES['thumbnail']['name'])) {
                $upload = $this->module->file_upload('thumbnail');

                if (!$upload['status']) {
                    $this->form($this->input->post(NULL, TRUE));
                } else {
                    $file_name = $upload['upload_data']['file_name'];
                }
                $DBdata['thumbnail'] = $file_name;
            }

            $id = save($this->table, $DBdata);

            $this->session->set_flashdata('success', 'Record has been inserted.');
            redirect(ADMIN_DIR . $this->module_name);
        }
    }


    public function update()
    {
        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            $DBdata['show_title'] = getVar('show_title');
            $DBdata['content'] = getVar('content', FALSE, FALSE);

            if (!empty($_FILES['thumbnail']['name'])) {
                $upload = $this->module->file_upload('thumbnail');

                if (!$upload['status']) {
                    $this->form($this->input->post(NULL, TRUE));
                } else {
                    $file_name = $upload['upload_data']['file_name'];
                }
                $DBdata['thumbnail'] = $file_name;
            }

            //echo '<pre>';print_r($DBdata);echo '</pre>';die('Call');
            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);
            $this->session->set_flashdata('success', 'Record has been updated.');
            redirect(ADMIN_DIR . $this->module_name);

        }
    }

    function alias_validate()
    {

        $id = intval($this->input->get('id'));
        $value = $this->input->get('value');
        $message = '';

        if (!empty($value)) {
            if (!preg_match('/^[A-z0-9\-]+$/', $value)) {
                $message = 'You entered invalid characters';
            } else {
                $result = $this->db->get_where($this->table, array('friendly_url' => $value, 'id <>' => $id));
                if ($result->num_rows() > 0) {
                    $message = 'Already exists!';
                }
            }
        }

        echo json_encode(array('message' => $message));
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
}

/* End of file pages.php */
/* Location: ./application/controllers/admin/pages.php */