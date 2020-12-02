<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 02-01-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_email_templates extends CI_Model
{

    var $table = 'email_templates';
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
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');

        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function file_upload($file_name, $config = array())
    {

        if (count($config) == 0) {
            $config['upload_path'] = ASSETS_DIR . 'img/';
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


    function getemail_templates($id = '', $where = '')
    {

        $sql = "SELECT * FROM " . $this->table . " WHERE 1  ";
        if ($id) {
            $sql .= " AND " . $this->id_field . "='{$id}'";
        }
        $result = $this->db->query($sql . $where);

        return $result->result();

    }
}



/* End of file m_email_templates.php */
/* Location: ./application/models/m_email_templates.php */