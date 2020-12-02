<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Login
 * @property M_blog_comments $m_blog_comments
 * @property M_cpanel $m_cpanel
 */
class Blog_comments extends CI_Controller
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
        $this->module_title = getModuleDetail()->module_title;

    }

    public function index()
    {
        $where = '';

        $data['title'] = $this->module_title;
        $data['query'] = "SELECT * FROM " . $this->table . " WHERE 1 " . $where;
        $data['query'] .= getFindQuery($data['query']);

        $this->admin_template->load($this->module_name . '/grid', $data);
    }


    public function form()
    {
        $id = (getUri(4));

        if (!empty($id)) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
            $RS = $this->db->query($SQL);
            if ($RS->num_rows() == 0) {
                $this->admin_template->not_found();
            }
            $data['row'] = $RS->row();
        }

        $this->admin_template->load($this->module_name . '/form', $data);
    }

    public function view()
    {
        $id = (getUri(4));

        if (!empty($id)) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='{$id}'";
            $data['row'] = $this->db->query($SQL)->row();
        }

        $data['title'] = $this->module_title;
        $this->admin_template->load($this->module_name . '/form', $data);
    }


    function status()
    {

        $id = (getUri(4));
        $status = (getUri(5));

        $where = $this->id_field . "='" . $id . "'";
        save($this->table, array('result' => $result), $where);
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
            $DBdata['content'] = addslashes(getVar('content', 0, 0));


            $id = save($this->table, $DBdata);

            redirect(ADMIN_DIR . $this->module_name . '/?msg=Record has been inserted..');
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
            $DBdata['content'] = addslashes(getVar('content', 0, 0));

            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);
            redirect(ADMIN_DIR . $this->module_name . '/?msg=Record has been updated..');

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
        redirect(ADMIN_DIR . $this->module_name . '/?msg=Record has been Deleted..');
    }
}

/* End of file pages.php */
/* Location: ./application/controllers/admin/pages.php */