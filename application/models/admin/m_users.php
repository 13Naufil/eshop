<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 * @copyright 2019
 * @date 03-06-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_users extends CI_Model
{

    var $table = 'users';
    var $id_field = 'id';

    function __construct()
    {

        parent::__construct();
        if (empty($this->table)) {
            $this->table = getUri(2);
        }
    }

    function validate($id = 0)
    {
        if($id == 0){ $id = getUri(4); }

        $this->form_validation->set_rules('user_type_id', 'User Type', 'required');

        if($id > 0){
            $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
        }else{
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required');
        }
        

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        //$this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        //$this->form_validation->set_rules('city', 'City', 'required');
        //$this->form_validation->set_rules('country', 'Country', 'required');

        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }



    public function file_upload($file_name, $config = array())
    {

        if (count($config) == 0) {
            $config['upload_path'] = ASSETS_DIR . 'admin/img/users/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
        }


        $this->load->library('upload');
        $this->upload->initialize($config);

        $rs = $this->upload->upload_multi($file_name);
        if (count($rs['error']) > 0) {
            $return = $rs;
            $return['status'] = FALSE;
        } else {
            $return['status'] = TRUE;
            $return['upload_data'] = $rs['upload_data'];
        }

        return $return;
    }



}



/* End of file m_users.php */
/* Location: ./application/models/m_users.php */