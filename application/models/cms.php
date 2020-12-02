<?php
/**
 * Developed by Naufil khan.
 * Email: pisces_adnan@hotmail.com
 * Autour: Naufil khan
 * Date: 9/20/14
 * Time: 7:19 PM
 */
class Cms extends CI_Model {

    function __construct(){
        parent::__construct();
    }


    /**
     * @return mixed
     */
    function get_banners($type = 'main-slider'){

        return $this->db->order_by('ordering','ASC')->get_where('banner_management', array('status' => 'Active','type'=>$type))->result();
    }
    
      function get_modules($where = '')
    {
        $SQL = "SELECT * FROM `modules` WHERE `show_on_menu`=1 " . $where;
        return $this->db->query($SQL)->result();
    }


    function get_block($identifier, $get_all = false){

        $_static_block = $this->db->select("*, REPLACE(content, '../../../../assets/', '".asset_url()."/') as content", false)->get_where('static_blocks', array('status' => 'Active', 'block_identifier' => $identifier), 1);
        if($_static_block->num_rows > 0){
            $static_block = $_static_block->row();
            if($get_all){
                $static_block->content = do_shortcode($static_block->content);
                return $static_block;
            }else{
                return do_shortcode($static_block->content);
            }
        }else{
            return false;
        }
    }


}