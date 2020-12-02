<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 17-09-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_third_slider extends CI_Model
{

    var $table = 'third_slider';
    var $id_field = 'id';

    function __construct()
    {

        parent::__construct();
        if (empty($this->table)) {
            $this->table = getUri(2);
        }
    }

    function validate()
    {
        $this->form_validation->set_rules('product_id', 'Product', 'required');
        


        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    // function file_upload($file_name, $config = array())
    // {

    //     if (count($config) == 0) {
    //         $config['upload_path'] = ASSETS_DIR . 'admin/img/';
    //         $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|xls|xlsx|doc|docx|rtf|txt';
    //     }


    //     $this->load->library('upload');
    //     $this->upload->initialize($config);

    //     $rs = $this->upload->upload_multi($file_name);
    //     if (count($rs['error']) > 0) {
    //         $return['status'] = FALSE;
    //         $return['error'] = $rs;
    //     } else {
    //         $return['status'] = TRUE;
    //         $return['upload_data'] = $rs['upload_data'];
    //     }

    //     return $return;
    // }

    // function product_images($product_id)
    // {
    //     $images = $this->db->get_where('product_images', array('product_id' => $product_id))->result();
    //     return $images;
    // }

    function product_categories($product_id)
    {
        $images = $this->db->select('categories.*, id AS category_id')->from('categories')
            ->join('product_cat_rel', "product_cat_rel.")
            ->result();
        return $images;
    }

}



/* End of file m_produucts.php */
/* Location: ./application/models/m_produucts.php */