<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +923323103324
 * S: developer.adnan
 * @copyright 2014 * @date 18-09-2014
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_teaser_boxes extends CI_Model
{

    var $table = 'teaser_boxes';
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
        return TRUE;
        $this->form_validation->set_rules('image', 'Image', 'required');

        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function file_upload($file_name, $config = array())
    {

        if (count($config) == 0) {
            $config['upload_path'] = ASSETS_DIR . 'front/teaser_boxes/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
        }


        $this->load->library('upload');
        $this->upload->initialize($config);

        $rs = $this->upload->upload_multi($file_name);
        if (count($rs['error']) > 0) {
            $return['status'] = FALSE;
            $return['error'] = $rs;
        } else {
            $return['status'] = TRUE;
            $return['upload_data'] = $rs['upload_data'];
        }

        return $return;
    }

    /**
     * @param string $where
     * @param int $limit
     * @param int $offset
     * @param string $order_by
     * @param string $heaving
     * @return object $rows
     */
    function rows($where = '', $limit = 0, $offset = 0, $order_by = '', $heaving = '')
    {

        $SQL = "SELECT SQL_CALC_FOUND_ROWS {$this->table}.*
                FROM {$this->table}
        WHERE 1 {$where}";

        if (!empty($order_by)) {
            $SQL .= " ORDER BY {$order_by}";
        }
        if ($limit > 0) {
            $SQL .= " LIMIT {$offset}, {$limit}";
        }
        if (!empty($heaving)) {
            $SQL .= " {$heaving}";
        }

        $RES = $this->db->query($SQL);

        if ($RES) {
            $rows = $RES->result();
            $this->num_rows = $RES->num_rows();
            $this->total_rows = $this->db->query("SELECT FOUND_ROWS() as total")->row()->total;//$this->db->found_rows();
        } else {
            $rows = false;
            //$this->db_error = $this->db->error()['message'];
            //developer_log($this->table, $this->db_error);
        }

        return $rows;
    }


}



/* End of file m_banner_management.php */
/* Location: ./application/models/m_banner_management.php */