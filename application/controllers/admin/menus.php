<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Login
 * @property M_pages $m_pages
 * @property M_cpanel $m_cpanel
 * @property Breadcrumb $breadcrumb
 */
class Menus extends CI_Controller
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

        $this->module_title = getModuleDetail()->module_title;

    }


    public function index()
    {
        $id = intval(getUri(4));

        if ($id > 0) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
            $data['row'] = $this->db->query($SQL)->row();
        }

        $data['title'] = $this->module_title;

        /*--------------------------------------------------------------*/
        $data['create_menu'] = true;
        //Create menu
        if ($this->input->post('create') !== false) {
            $this->form_validation->set_rules('type_name', 'Type', 'required');
            if ($this->form_validation->run() != FALSE) {
                $dbdata['type_name'] = $this->input->post('type_name');
                $insert = save('menu_types', $dbdata);
                if ($insert)
                    $data['successmsg'] = 'Successfully created.';
                else
                    $data['errormsg'] = '<strong>Error:</strong> ' . $this->db->display_error();
            }
        }


        $menus = $this->db->get_where('menu_types', array('status' => 'active'))->result_array();
        foreach ($menus as $menu) {
            $data['menus'][$menu['id']] = $menu['type_name'];
        }

        # Selected Menu
        $selected_menu = intval($this->input->get('m'));
        if (!array_key_exists($selected_menu, $data['menus'])) {
            $selected_menu = key($data['menus']);
        }
        $this->admin_template->assign('selected_menu', $selected_menu);

        # Menu Items
        $menu_items = $this->get_menu_items($selected_menu);
        $this->admin_template->assign('menu_items', $menu_items);

        $data['delete_menu'] = false;
        if (user_do_action('delete')) {
            $this->admin_template->assign('delete_menu', true);
        }
        //$data['set_menu'] = true;


        # Menu Types
        $menu_types = array(
            array(
                'title' => 'Pages',
                'name' => 'page',
                'url_base' => site_url(),
                'listing' => $this->db->order_by('title', 'asc')->get_where('pages', array('status' => 'published'))->result_array()
            ),
            array(
                'title'     => 'Product Categories',
                'name'      => 'product_category',
                'url_base'  => site_url() . '/',
                'listing'   => $this->db->order_by('title', 'ASC')->get_where('categories', array('status' => 'Active', 'parent_id' => 0))->result_array()
            )
        );

        $this->admin_template->assign('menu_types', $menu_types);


        $this->admin_template->load($this->module_name . '/form', $data);

    }

    /*
    * ----------------------------------------------------------------------------------------------------------------------
    *  Method: Get menu items
    * ----------------------------------------------------------------------------------------------------------------------
    */
    private function get_menu_items($menu_id, $parent = 0)
    {
        $items = $this->db->order_by('ordering')->get_where('menus', array('parent_id' => $parent, 'menu_type_id' => $menu_id))->result_array();

        for ($i = 0; $i < count($items); $i++) {
            switch ($items[$i]['menu_type']) {
                case 'page':
                    $row = $this->db->get_where('pages', array('id' => $items[$i]['menu_link']))->row_array();
                    $url_base = site_url();
                    break;

                case 'blog_category':
                    $row = $this->db->get_where('blog_categories', array('id' => $items[$i]['menu_link']))->row_array();
                    $url_base = site_url('blog/category') . '/';
                    break;

                case 'product category':
                    $row = $this->db->get_where('categories', array('id' => $items[$i]['menu_link']))->row_array();
                    $url_base = "site_url()";
                    break;
            }

            if ($items[$i]['link_type'] != 'custom') {
                if (!empty($row)) {
                    $items[$i]['link_url'] = $url_base . $row['friendly_url'];
                    if($items[$i]['link_type'] != 'product category'){
                        $items[$i]['link_url'] = $url_base . $row['friendly_url'] . get_option('url_ext');
                    }
                    $items[$i]['link_title'] = $row['title'];
                } else {
                    $items[$i]['link_url'] = site_url();
                    $items[$i]['link_title'] = 'Unknown';
                }
            }

            $sub_items = $this->get_menu_items($menu_id, $items[$i]['id']);
            if (!empty($sub_items)) {
                $items[$i]['sub_items'] = $sub_items;
            }
        }

        return $items;
    }


    public function view()
    {
        $id = intval(getUri(4));

        if ($id > 0) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
            $data['row'] = $this->db->query($SQL)->row();
        }

        $data['title'] = $this->module_title;
        $this->load->view(ADMIN_DIR . $this->module_name . '/form', $data);
    }


    public function add($menu_id = 0)
    {
        $menu_id = intval($menu_id);

        if ($menu_id != 0) {
            $items = $this->input->post('items');
            if (!empty($items)) {
                $affected_ids = $this->update_items($items, $menu_id);
                $this->db->where_not_in('id', $affected_ids);
            }
            $this->db->where('menu_type_id', $menu_id)->delete('menus');
            activity_log('menu_update', $this->table,$menu_id);
        }
    }

    /*
    * ------------------------------------------------------------------------------------------------------------------
    *  Update Menu Items
    * ------------------------------------------------------------------------------------------------------------------
    */
    public function update_items($items, $menu_id, $parent = 0)
    {
        static $affected;
        if (count($items) > 0 && is_array($items)) {
            foreach ($items as $order => $item) {

                $data['menu_title'] = $item['item_title'];
                $data['menu_link'] = $item['item_link'];
                $data['menu_type'] = $item['item_type'];
                $data['ordering'] = $order;
                $data['parent_id'] = $parent;
                $data['menu_type_id'] = $menu_id;

                $item_id = intval($item['item_id']);
                if ($item_id == 0) {
                    $item_id = save('menus', $data);
                } else {
                    save('menus', $data, "id = '{$item_id}'");
                }

                $affected[] = $item_id;

                if (isset($item['sub_items']) && count($item['sub_items']) > 0) {
                    $this->update_items($item['sub_items'], $menu_id, $item_id);
                }
            }
        }
        return $affected;
    }


    public function update()
    {
        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->load->view(ADMIN_DIR . $this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];

            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);

            $this->session->set_flashdata('success', 'Record has been updated.');
            redirect(ADMIN_DIR . $this->module_name);

        }
    }


    public function delete()
    {
        $id = intval(getUri(4));
        $SQL = "DELETE FROM menu_types WHERE `id` = '" . $id . "'";
        if ($this->db->query($SQL)) {
            $this->db->query("DELETE FROM menus WHERE menu_type = '{$id}'");
        }

        $this->session->set_flashdata('success', 'Record has been Deleted..');

        $location = $this->input->server('HTTP_REFERER');
        if ($location === false) {
            $location = admin_url($this->module->name);
        }

        redirect($location);
    }
}

/* End of file pages.php */
/* Location: ./application/controllers/admin/pages.php */