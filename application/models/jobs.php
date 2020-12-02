<?php
/**
 * Developed by Naufil khan.
 * Email: pisces_adnan@hotmail.com
 * Autour: Naufil khan
 * Date: 9/20/14
 * Time: 7:19 PM
 */
class Jobs extends CI_Model {

    function __construct(){
        parent::__construct();

    }


    function get_jobs($where = ''){

        $this->db->from('jobs');
        if(!empty($where)){
            $this->db->where($where, null,false);
        }
        return $this->db->order_by('id','DESC')->get()->result();

    }





}