<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 *
 * @property M_cpanel $m_cpanel
 * @property M_products $m_products * @copyright 2019 * @date 17-09-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller
{

    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $module_route;

    /**
     * *****************************************************************************************************************
     * @method products __construct
     * @model products main_model    | m_products
     * *****************************************************************************************************************
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
     * @method products index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {
        replace_find_query('brand', 'brands.title',$where);
        $query = "SELECT
          products.id,
          'product_image' as product_image,
          products.name,
          brands.title AS brand,
          products.SKU,
          products.qty,
          products.is_in_stock,
          products.created,
          products.status
        FROM products
          LEFT JOIN brands ON brands.id = products.brand_id
          WHERE 1 " . $where;

        //$this->session->set_userdata(array('export_query' => $query));
        $data['query'] = $query;
        $data['query'] .= getFindQuery($data['query']);

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));

        $this->admin_template->load($this->module_name . '/grid', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method products form
     * *****************************************************************************************************************
     */
    public function form($Request = '')
    {

        $data = array();
        $id = intval(getUri(4));

        if (!empty($id)) {
            $SQL = "SELECT * FROM {$this->table} WHERE {$this->id_field}='" . $id . "'";
            $RS = $this->db->query($SQL);
            if ($RS->num_rows() == 0) {
                $this->admin_template->not_found();
            }
            $data['row'] = $RS->row();

            $data['selected_categories'] = singleColArray("SELECT category_id FROM product_cat_rel WHERE product_id=" . $id,'category_id');

        } elseif ($Request) {
            $data['row'] = $Request;
        }

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item(($id > 0) ? 'Edit' : 'Add New');

        $this->admin_template->load($this->module_name . '/form', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method products view
     * *****************************************************************************************************************
     */
    public function view()
    {
        $data = array();
        $id = intval(getUri(4));
        $query = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='{$id}'";
        $data['query'] = $query;
        $data['query'] .= getFindQuery($data['query']);

        $data['config']['buttons'] = array('new', 'update', 'delete', 'refresh', 'print', 'back');
        $data['title'] = $this->module_title;

        activity_log('view_products', $this->table, $id);

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
            
        
            $data['row'] = $row = array2object($this->input->post());
            $data['related_products'] = $row->related_product_ids;
            $data['selected_categories'] = $row->categories;
            $product_images = array2object($row->images);
            if(count($product_images) > 0){
                $i = -1;
                foreach($product_images as $product_image){
                    if(!empty($product_image)){
                        $i++;
                        if($product_image == $row->default){ $data['product_images'][$i]->default = 1; }
                        if($product_image == $row->thumb){ $data['product_images'][$i]->thumb = 1; }
                        if($product_image == $row->hover){ $data['product_images'][$i]->hover = 1; }
                        $data['product_images'][$i]->image = $product_image;
                    }
                }
            }
            $data['attributes'] = $row->attributes;
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
          
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            $DBdata['friendly_url'] = url_title($DBdata['friendly_url'], '-', true);

            $DBdata['description'] = getVar('description', FALSE, FALSE);
            $DBdata['created'] = date('Y-m-d H:i:s');
             
            $id = save($this->table, $DBdata);
            
            activity_log('create_products', $this->table, $id);

            /* categories  */
            $categories  = getVar('categories');
            if(count($categories) > 0){
                foreach ($categories as $category_id) {
                    if($category_id > 0)
                        save('product_cat_rel', array('product_id' => $id, 'category_id' => $category_id));
                }
            }

            /* product_images */
            $product_images  = getVar('images');

            $exclude = getVar('exclude', true, false);
            $color_img = getVar('color_img', true, false);
            if(count($product_images) > 0){
                foreach ($product_images as $k => $img) {
                    if(!empty($img)) {
                        $_product_images = array(
                            'product_id' => $id,
                            'image' => $img,
                            'default' => (getVar('default') == $img ? 1 : 0),
                            'thumb' => (getVar('thumb') == $img ? 1 : 0),
                            'hover' => (getVar('hover') == $img ? 1 : 0),
                            'exclude' => $exclude[$k],
                        );
                        /* color_img */
                        $color_attr_id = intval(get_option('color_attr_id'));
                        if ($color_attr_id > 0) {
                            $_product_images['color_attr_id'] = $color_img[$k];
                        }
                        save('product_images', $_product_images);
                    }
                }
            }

            /* attributes */
            $attributes = getVar('attributes', TRUE, FALSE);
            if(count($_FILES['attributes']['name']) > 0){
                foreach($_FILES['attributes']['name'] as $attr_id => $name){
                    $attributes[$attr_id] = $name;
                }
            }

            delete_rows('product_attributes_rel', 'product_id=' . $id);
            if(count($attributes) > 0){
                foreach ($attributes as $attribute_id => $attr_value_id) {
                    $attrinput_type = $this->db->select('frontend_input')->get_where('attributes', array('id' => $attribute_id), 1)->row()->frontend_input;

                    if($attribute_id > 0){
                        $p_a_rel_data['product_id'] = $id;
                        $p_a_rel_data['attribute_id'] = $attribute_id;
                        $p_a_rel_data['attr_value_id'] = 0;
                        $p_a_rel_data['attr_value'] = '';
                        switch($attrinput_type){
                            case 'select':
                                if(!empty($attr_value_id)) {
                                    $p_a_rel_data['attr_value_id'] = $attr_value_id;
                                    save('product_attributes_rel', $p_a_rel_data);
                                }
                                break;
                            case 'multiselect':
                                if(is_array($attr_value_id) && count($attr_value_id) > 0){
                                    foreach($attr_value_id as $m_attr_v_id){
                                        if(!empty($m_attr_v_id)){
                                            $p_a_rel_data['attr_value_id'] = $m_attr_v_id;
                                            save('product_attributes_rel', $p_a_rel_data);
                                        }
                                    }
                                }
                                break;
                            case 'file':
                                if (count($_FILES['attributes']) > 0) {
                                    $files = $_FILES['attributes'];
                                    $cpt = count($_FILES['attributes']['name']);
                                    for ($i = 0; $i < $cpt; $i++) {
                                        $_FILES['attr_file']['name'] = $files['name'][$attribute_id];
                                        $_FILES['attr_file']['type'] = $files['type'][$attribute_id];
                                        $_FILES['attr_file']['tmp_name'] = $files['tmp_name'][$attribute_id];
                                        $_FILES['attr_file']['error'] = $files['error'][$attribute_id];
                                        $_FILES['attr_file']['size'] = $files['size'][$attribute_id];

                                        if(!empty($_FILES['attr_file']['name'])){
                                            $upload = $this->module->file_upload('attr_file');
                                            if ($upload['status']) {
                                                $file_name = $upload['upload_data']['file_name'];
                                                $p_a_rel_data['attr_value'] = $file_name;
                                                save('product_attributes_rel', $p_a_rel_data);
                                            }
                                        }
                                    }

                                }
                                break;
                            default:
                                if(!empty($attr_value_id)) {
                                    $p_a_rel_data['attr_value'] = $attr_value_id;
                                    save('product_attributes_rel', $p_a_rel_data);
                                }
                                break;
                        }
                    }
                }
            }

            /* related_product_ids */
            $related_product_ids = getVar('related_product_ids');
            delete_rows('related_products', 'product_id=' . $id);
            if (count($related_product_ids) > 0) {
                foreach ($related_product_ids as $related_product_id) {
                    if (!empty($related_product_id)) {
                        $_product_data = array(
                            'product_id' => $id,
                            'related_product_id' => $related_product_id,
                        );
                        save('related_products', $_product_data);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Record has been inserted.');
            redirect(ADMIN_DIR . $this->module_route);
        }
    }


    public function update()
    {


        $id = intval($this->uri->segment(4));

        //print_r($_POST);exit;

        if (!$this->module->validate()) {
            $data['row'] = $row = array2object($this->input->post());
            $data['related_products'] = $row->related_product_ids;
            $data['selected_categories'] = $row->categories;
            $product_images = array2object($row->images);
            if(count($product_images) > 0){
                $i = -1;
                foreach($product_images as $product_image){
                    if(!empty($product_image)){
                        $i++;
                        if($product_image == $row->default){ $data['product_images'][$i]->default = 1; }
                        if($product_image == $row->thumb){ $data['product_images'][$i]->thumb = 1; }
                        if($product_image == $row->hover){ $data['product_images'][$i]->hover = 1; }
                        $data['product_images'][$i]->image = $product_image;
                    }
                }
            }
            $data['attributes'] = $row->attributes;

            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            $DBdata['description'] = getVar('description', FALSE, FALSE);
            $DBdata['friendly_url'] = url_title($DBdata['friendly_url'], '-', true);

            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);
            activity_log('update_products', $this->table, $id);

            /* categories  */
            $categories  = getVar('categories');
            delete_rows('product_cat_rel', 'product_id=' . $id);
            if(count($categories) > 0){
                foreach ($categories as $category_id) {
                    if($category_id > 0)
                        save('product_cat_rel', array('product_id' => $id, 'category_id' => $category_id));
                }
            }


            /* product_images */
            $product_images  = getVar('images');
            delete_rows('product_images', 'product_id=' . $id);

            $exclude = getVar('exclude', true, false);
            $color_img = getVar('color_img', true, false);

            if(count($product_images) > 0){
                foreach ($product_images as $k => $img) {
                    if(!empty($img)) {
                        $_product_images = array(
                            'product_id' => $id,
                            'image' => $img,
                            'default' => (getVar('default') == $img ? 1 : 0),
                            'thumb' => (getVar('thumb') == $img ? 1 : 0),
                            'hover' => (getVar('hover') == $img ? 1 : 0),
                            'exclude' => $exclude[$k],
                        );
                        /* color_img */
                        $color_attr_id = intval(get_option('color_attr_id'));
                        if ($color_attr_id > 0) {
                            $_product_images['color_attr_id'] = $color_img[$k];
                        }
                        save('product_images', $_product_images);
                    }
                }
            }

            /* attributes */
            $attributes = getVar('attributes', TRUE, FALSE);
            if(count($_FILES['attributes']['name']) > 0){
                foreach($_FILES['attributes']['name'] as $attr_id => $name){
                    if(!empty($name)){
                        $attributes[$attr_id] = $name;
                    }
                }
            }

            delete_rows('product_attributes_rel', 'product_id=' . $id);
            if(count($attributes) > 0){
                foreach ($attributes as $attribute_id => $attr_value_id) {
                    $attrinput_type = $this->db->select('frontend_input')->get_where('attributes', array('id' => $attribute_id), 1)->row()->frontend_input;

                    if($attribute_id > 0){
                        $p_a_rel_data['product_id'] = $id;
                        $p_a_rel_data['attribute_id'] = $attribute_id;
                        $p_a_rel_data['attr_value_id'] = 0;
                        $p_a_rel_data['attr_value'] = '';
                        switch($attrinput_type){
                            case 'select':
                                if(!empty($attr_value_id)) {
                                    $p_a_rel_data['attr_value_id'] = $attr_value_id;
                                    save('product_attributes_rel', $p_a_rel_data);
                                }
                                break;
                            case 'multiselect':
                                if(is_array($attr_value_id) && count($attr_value_id) > 0){
                                    foreach($attr_value_id as $m_attr_v_id){
                                        if(!empty($m_attr_v_id)) {
                                            $p_a_rel_data['attr_value_id'] = $m_attr_v_id;
                                            save('product_attributes_rel', $p_a_rel_data);
                                        }
                                    }
                                }
                                break;
                            case 'file':
                                if(!empty($attr_value_id)) {
                                    $p_a_rel_data['attr_value'] = $attr_value_id;
                                    save('product_attributes_rel', $p_a_rel_data);
                                }
                                if (count($_FILES['attributes']) > 0) {
                                    $files = $_FILES['attributes'];
                                    $cpt = count($_FILES['attributes']['name']);
                                    for ($i = 0; $i < $cpt; $i++) {
                                        $_FILES['attr_file']['name'] = $files['name'][$attribute_id];
                                        $_FILES['attr_file']['type'] = $files['type'][$attribute_id];
                                        $_FILES['attr_file']['tmp_name'] = $files['tmp_name'][$attribute_id];
                                        $_FILES['attr_file']['error'] = $files['error'][$attribute_id];
                                        $_FILES['attr_file']['size'] = $files['size'][$attribute_id];

                                        if(!empty($_FILES['attr_file']['name'])){
                                            $upload = $this->module->file_upload('attr_file');
                                            if ($upload['status']) {
                                                $file_name = $upload['upload_data']['file_name'];
                                                $p_a_rel_data['attr_value'] = $file_name;
                                                save('product_attributes_rel', $p_a_rel_data);
                                            }
                                        }
                                    }
                                }

                                break;
                            default:
                                if(!empty($attr_value_id)) {
                                    $p_a_rel_data['attr_value'] = $attr_value_id;
                                    save('product_attributes_rel', $p_a_rel_data);
                                }
                                break;
                        }
                    }
                }
            }

            /* related_product_ids */



            $related_product_ids = getVar('related_product_ids');
            delete_rows('related_products', 'product_id=' . $id);
            if(count($related_product_ids) > 0){
                foreach ($related_product_ids as $related_product_id) {
                    if(!empty($related_product_id)) {
                        $_product_data = array(
                            'product_id' => $id,
                            'related_product_id' => intval($related_product_id),
                        );
                        save('related_products', $_product_data);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Record has been updated.');
            redirect(ADMIN_DIR . $this->module_route);
        }
    }


    public function sku_check($val)
    {
        $id = intval(getVar('id'));

        $email_exists = $this->db->get_where($this->table, array('SKU' => $val, 'id <>' => $id))->num_rows() > 0 ? true : false;
        if ($email_exists) {
            $this->form_validation->set_message('sku_check', 'This SKU is already exists');
            return FALSE;
        }
    }


    public function friendly_url_check($val)
    {
        $id = intval(getVar('id'));

        $email_exists = $this->db->get_where($this->table, array('friendly_url' => $val, 'id <>' => $id))->num_rows() > 0 ? true : false;
        if ($email_exists) {
            $this->form_validation->set_message('friendly_url_check', 'This friendly_url_check is already exists');
            return FALSE;
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

        activity_log('view_products', $this->table, explode(',', $id));
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

        $status = getVar('status');
        $data = array('status' => $status);

        save($this->table, $data, $where);
        activity_log('change_status', $this->table, explode(',', $id));

        $this->session->set_flashdata('success', 'Status has been changed.');
        redirect(ADMIN_DIR . $this->module_route);
    }

    /**
     * *****************************************************************************************************************
     * @method Status
     * @unlink Delete Files (unlink)
     * *****************************************************************************************************************
     */
    function is_in_stock()
    {

        $id = intval(getUri(4));
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }

        $where = $this->id_field . " IN({$id})";

        $status = getVar('is_in_stock');
        $data = array('is_in_stock' => $status);

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
                //$id = getVar('product_id');
                $del_img = array('image' => './assets/front/img/products/');
                delete_rows('product_images', "id=" . intval($id), true, '', 'image', $del_img);
                activity_log($action, $this->table, $id);
                $JSON['status'] = true;
                echo json_encode($JSON);
                break;
            case 'get_attribute_form':

                $attribute_group_id = intval(getVar('attribute_group_id'));
                $data['attributes_data'] = $attributes_data = getVar('attributes_data', true, false);
                $data['product_id'] = $product_id = intval(getVar('product_id'));

                $data['attributes'] = $this->db->query("SELECT
                    IF(attribute_sets.set_title IS NULL,'Other', attribute_sets.set_title) AS set_title
                    , attributes.*
                    , IF(par.attr_value_id > 0, GROUP_CONCAT(par.attr_value_id SEPARATOR ','), par.attr_value) AS attribute_value
                FROM
                    attribute_group_rel
                    INNER JOIN attributes
                        ON (attribute_group_rel.attribute_id = attributes.id)
                    LEFT JOIN attribute_sets
                        ON (attributes.attribute_set_id = attribute_sets.id)
                    LEFT JOIN product_attributes_rel as par
                        ON (par.attribute_id = attributes.id AND par.product_id={$product_id})
                WHERE attributes.status='Active'
                AND attribute_group_rel.attribute_group_id='" . $attribute_group_id . "'
                -- AND attributes.id !=124
                GROUP BY attributes.id
                ORDER BY attribute_sets.ordering, set_title, attributes.position")->result();

                $JSON['product_attr_form'] = $this->load->view(ADMIN_DIR . $this->module_name . '/product_attr_form', $data, true);
                echo json_encode($JSON);
                break;
            case 'get_brand_cats':
                $brand_id = intval(getVar('brand_id'));
                $selected_categories = getVar('selected_categories');

                $this->multilevels->type = 'checkbox';
                $this->multilevels->id_Column = 'id';
                $this->multilevels->title_Column = 'title';
                $this->multilevels->link_Column = 'parent_id';
                $this->multilevels->attrs = 'name="categories[]"';
                $this->multilevels->selected = $selected_categories;
                $this->multilevels->query = "SELECT * FROM categories WHERE brand_id=" . $brand_id;
                $JSON['categories'] = $this->multilevels->build();

                echo json_encode($JSON);
                break;
        }
    }

    public function images_upload() {

        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (!empty($_FILES)) {
            $id = intval(getVar('id'));
            $dir = 'assets/front/products/';
            /*if ($id > 0) {
                $dir = 'assets/front/products/' . $id . '/';
                mkdir($dir);
            }*/
            $config['upload_path'] = './' . $dir;
            $config['allowed_types'] = 'jpg|jpeg|gif|png';

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fileinfo = $this->upload->data();
                $output['result']['filename'] = $fileinfo['file_name'];
                $output['result']['thumb_url'] = image_thumb($dir . $fileinfo['file_name'], 200, 150);
                $output['result']['image_url'] = site_url($dir . $fileinfo['file_name']);
            } else {
                $output['error']['filename'] = $_FILES['file']['name'];
                $output['error']['message'] = $this->upload->display_errors();
            }

            echo json_encode($output);
        } else {
            redirect((ADMIN_DIR . $this->module_route));
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

    function duplicate(){
        $id = intval(getUri(4));

        $new_ids = DuplicateMySQLRecord($this->table, $this->id_field, $id,  array('id', 'SKU', 'friendly_url'));
        $new_id = $new_ids[0];
        activity_log('duplicate_products', $this->table, $new_id);

        DuplicateMySQLRecord('product_cat_rel', 'product_id', $id,  array(), array('product_id' => $new_id));
        DuplicateMySQLRecord('related_products', 'product_id', $id,  array('id'), array('product_id' => $new_id));
        DuplicateMySQLRecord('product_attributes_rel', 'product_id', $id,  array(), array('product_id' => $new_id));

        $images = $this->db->get_where('product_images', array('product_id' => $id))->result();
        if(count($images) > 0 ){
            $dir = 'assets/front/products/';
            foreach ($images as $k => $img_row) {
                unset($img_row->id);
                $file = $dir . $img_row->image;
                $newfile = $new_id . '-' . $k . $img_row->image;
                copy($file, $dir . $newfile);
                $img_row->image = $newfile;
                $img_row->product_id = $new_id;
                save('product_images', $img_row);
            }
        }
        //DuplicateMySQLRecord('product_images', 'product_id', $id,  array('id'), array('product_id' => $new_id));

        $this->session->set_flashdata('success', 'Product has been duplicated.');
        redirect(admin_url($this->module_route . '/form/' . $new_id));
    }
}


/* End of file products.php */
/* Location: ./application/controllers/admin/products.php */