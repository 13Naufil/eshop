<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019 * @date 04-10-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_job_seekers extends CI_Model
{

    var $table = 'job_seekers';
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
        $this->form_validation->set_rules('father_name', 'Father Name', 'required');
        $this->form_validation->set_rules('dob', 'DOB', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('current_salary', 'Current Salary', 'required');
        $this->form_validation->set_rules('expected_salary', 'Expected Salary', 'required');

        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function file_upload($file_name, $config = array())
    {

        if (count($config) == 0) {
            $config['upload_path'] = ASSETS_DIR . 'admin/cv/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
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

}



/* End of file m_job_seekers.php */
/* Location: ./application/models/m_job_seekers.php */