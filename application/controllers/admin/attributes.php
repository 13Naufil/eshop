<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 *
 * @property M_cpanel $m_cpanel
 * @property M_attributes $m_attributes * @copyright 2019 * @date 20-09-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Attributes extends CI_Controller
{

    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $module_route;

    /**
     * *****************************************************************************************************************
     * @method attributes __construct
     * @model attributes main_model    | m_attributes     * *****************************************************************************************************************
     */

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

    /**
     * *****************************************************************************************************************
     * @method attributes index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {

        $where = '';
        $query = "SELECT id,
          attribute_code,
          admin_label,
          is_required,
          -- is_comparable,
          is_visible_on_front,
          used_in_product_listing,
          `status` FROM {$this->table} WHERE 1 " . $where;

        //$this->session->set_userdata(array('export_query' => $query));
        $data['query'] = $query;
        $data['query'] .= getFindQuery($data['query']);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));

        $this->admin_template->load($this->module_name . '/grid', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method attributes form
     * *****************************************************************************************************************
     */
    public function form($Request = '')
    {

        $data = array();
        $id = intval(getUri(4));

        if (!empty($id)) {
            $SQL = "SELECT * FROM {$this->table} WHERE {$this->id_field}='{$id}'";
            $RS = $this->db->query($SQL);
            if ($RS->num_rows() == 0) {
                $this->admin_template->not_found();
            }
            $data['row'] = $RS->row();
            $data['attributes_option_values'] = $this->db->get_where('attributes_option_values_rel', array('attribute_id' => $id))->result();

        } elseif ($Request) {
            $data['row'] = $Request;
        }

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item(($id > 0) ? 'Edit' : 'Add New');

        $this->admin_template->load($this->module_name . '/form', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method attributes view
     * *****************************************************************************************************************
     */
    public function view()
    {

        $data = array();
        $id = intval(getUri(4));
        $query = "SELECT id, attribute_set_id AS attribute_set, attribute_code, admin_label, is_required AS values_required, is_comparable AS comparable_on_front-end, is_visible_on_front AS visible_on_front, used_in_product_listing, status FROM {$this->table} WHERE {$this->id_field}='{$id}'";
        $data['query'] = $query;

        $data['config']['buttons'] = array('new', 'update', 'delete', 'refresh', 'print', 'back');
        $data['title'] = $this->module_title;

        activity_log('view_attributes', $this->table, $id);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item('View');

        $this->admin_template->load('includes/record_view', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method action
     * @action Save / Add
     * *****************************************************************************************************************
     */
    public function add()
    {
        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            $DBdata['attribute_code'] = url_title(getVar('attribute_code'), '_', true);

            #attribute_sets
            $attribute_set = getVar('attribute_set');
            $attribute_sets = $this->db->get_where('attribute_sets', array('set_title' => $attribute_set), 1);

            if(!empty($attribute_set) && $attribute_sets->num_rows == 0){
                $DBdata['attribute_set_id'] = save('attribute_sets', array('set_title' => $attribute_set));
            }elseif($attribute_sets->num_rows > 0){
                $DBdata['attribute_set_id'] = $attribute_sets->row()->id;
            }

            //if(empty($DBdata['frontend_label'])) $DBdata['frontend_label'] = $DBdata['admin_label'];
            if ($_FILES['attribute_img']['name']) {
                $upload = $this->module->file_upload('attribute_img');
                if (!$upload['status']) {
                    getFlash('error', $upload['error']);
                } else {
                    $file_name = $upload['upload_data']['file_name'];
                }
                $DBdata['attribute_img'] = $file_name;
            }

            $id = save($this->table, $DBdata);
            activity_log('create_attributes', $this->table, $id);

            #attributes_option_values_rel
            $options_value = getVar('options');
            if(count($options_value['admin']) > 0){
                foreach ($options_value['admin'] as $k => $admin_value) {
                    if(!empty($admin_value)){
                        $attributes_option_values_rel = array(
                            'attribute_id'  => $id,
                            'admin_value'  => $admin_value,
                            'frontend_value'  => $options_value['front'][$k],
                            'extra'  => $options_value['extra'][$k],
                            'position'  => $options_value['position'][$k],
                            'default'  => intval($options_value['default'][$k]),
                        );
                        save('attributes_option_values_rel', $attributes_option_values_rel);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Record has been inserted.');
            redirect(ADMIN_DIR . $this->module_route);
        }
    }


    public function update()
    {

        $id = $this->uri->segment(4);

        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            $DBdata['attribute_code'] = url_title(getVar('attribute_code'), '_', true);

            #attribute_sets
            $attribute_set = getVar('attribute_set');
            $attribute_sets = $this->db->get_where('attribute_sets', array('set_title' => $attribute_set), 1);
            if(!empty($attribute_set) && $attribute_sets->num_rows == 0){
                $DBdata['attribute_set_id'] = save('attribute_sets', array('set_title' => $attribute_set));
            }elseif($attribute_sets->num_rows > 0){
                $DBdata['attribute_set_id'] = $attribute_sets->row()->id;
            }

            if ($_FILES['attribute_img']['name']) {
                $upload = $this->module->file_upload('attribute_img');
                if (!$upload['status']) {
                    getFlash('error', $upload['error']);
                } else {
                    $file_name = $upload['upload_data']['file_name'];
                }
                $DBdata['attribute_img'] = $file_name;
            }

            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);
            activity_log('update_attributes', $this->table, $id);

            #attributes_option_values_rel
            //delete_rows('attributes_option_values_rel',"attribute_id=" . $id);
            $options_value = getVar('options');

            if(count($options_value['admin']) > 0){
                foreach ($options_value['admin'] as $k => $admin_value) {
                    if(!empty($admin_value)){
                        $attributes_option_values_rel = array(
                            'attribute_id'  => $id,
                            'admin_value'  => $admin_value,
                            'frontend_value'  => $options_value['front'][$k],
                            'extra'  => $options_value['extra'][$k],
                            'position'  => $options_value['position'][$k],
                            'default'  => (($options_value['default'] == $k) ? 1 : 0),
                        );
                        $_WHERE = '';
                        if($options_value['attr_value_id'][$k] > 0){
                            $_WHERE = "attr_value_id=". intval($options_value['attr_value_id'][$k]);
                        }
                        save('attributes_option_values_rel', $attributes_option_values_rel, $_WHERE);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Record has been updated.');
            redirect(ADMIN_DIR . $this->module_route);
        }
    }


    /**
     * *****************************************************************************************************************
     * @method Delete
     * @unlink Delete Files (unlink)
     * *****************************************************************************************************************
     */
    function delete()
    {

        $id = intval(getUri(4));
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }
        $where = $this->id_field . " IN({$id})";

        /*
        $delete_files = array(
            'image' => './assets/amdin/img/'
        );*/

        delete_rows($this->table, $where);

        activity_log('view_attributes', $this->table, explode(',', $id));
        $this->session->set_flashdata('success', 'Record has been deleted.');
        redirect(ADMIN_DIR . $this->module_route);
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
        activity_log('change_status', $this->table, explode(',', $id));

        $this->session->set_flashdata('success', 'Status has been changed.');
        redirect(ADMIN_DIR . $this->module_route);
    }

    /**
     * *****************************************************************************************************************
     * @method AJAX
     * *****************************************************************************************************************
     */

    function AJAX($action, $id)
    {
        switch ($action) {
            case 'delete_img':
                $del_img = array('image' => './assets/admin/img/');
                delete_rows($this->table, $this->id_field . "=" . intval($id), false, '', 'image', $del_img);
                activity_log($action, $this->table, $id);
                break;
        }
    }

    /**
     * *****************************************************************************************************************
     * @method import
     * *****************************************************************************************************************
     */

    public function import()
    {

        $data = array();
        if (getVar('import')) {
            $path = dirname(__FILE__) . '/csv/';
            if (!is_dir($path)) {
                mkdir($path);
            }

            $import = new Import();
            $import->type = getVar('type');
            $import->table = $this->table;
            $import->upload_path = $path;
            $import->file_field = 'file';
            $data_imp = $import->do_import();
            $data += $data_imp;

        }

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item('Import');

        $this->admin_template->load('includes/import_view', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method export
     * @type csv and xml
     * *****************************************************************************************************************
     */
    function export()
    {

        $type = $this->uri->segment(4);
        $this->load->dbutil();
        if ($this->session->userdata('export_query')) {
            $query = $this->session->userdata('export_query');
            $this->session->unset_userdata('export_query');
        } else {
            $query = "SELECT * FROM " . $this->table;
        }

        $query = $this->db->query($query);


        $dir = dirname(__FILE__) . "/";


        switch ($type) {
            case 'xml':
                $config = array(
                    'root' => 'rows',
                    'element' => 'row',
                    'newline' => "\n",
                    'tab' => "\t"
                );

                $xml = $this->dbutil->xml_from_result($query, $config);
                write_file($dir . $this->table . '.xml', $xml);
                fileDownload($dir . $this->table . '.xml');
                @unlink($dir . $this->table . '.xml');
                break;
            default:
                $csv = $this->dbutil->csv_from_result($query);
                write_file($dir . $this->table . '.csv', $csv);

                fileDownload($dir . $this->table . '.csv');
                @unlink($dir . $this->table . '.csv');
        }


        $this->index();
    }
}


/* End of file attributes.php */
/* Location: ./application/controllers/admin/attributes.php */