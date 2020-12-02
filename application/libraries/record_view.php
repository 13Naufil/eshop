<?php


class record_view
{

    var $DB;
    var $title = '';
    var $query = '';
    var $url = '';
    var $limit = 1;
    var $id_field = '';

    var $image_fields = array();
    var $image_path = 'assets/admin/img/';
    var $phpthumb_str = 'w=120';

    var $is_front = FALSE;
    var $css_class = '';
    var $grid_buttons = array('view', 'edit', 'status', 'delete', 'back');
    var $custom_func = array();

    private $start_limit = 0;
    private $total_pages = 0;

    function __construct()
    {

        $CI =& get_instance();
        $CI->load->database();
        $this->DB = $CI->db;
    }


    function showView()
    {

        $CI =& get_instance();
        $result = $this->DB->query($this->query);
        $this->query;

        if (!$this->total_pages) {
            $this->total_pages = $result->num_rows();
        }

        $id_checkbox = FALSE;
        ob_start();
        ?>


                <form action="<?php admin_url($CI->router->class); ?>" method="get" enctype="multipart/form-data"
                      class="form-horizontal ">

                        <table class="table table-bordered table-view">
                            <?php
                            $s = -1;
                            foreach ($result->result_array() as $row) {
                                foreach ($row as $field => $val) {
                                    $s++;
                                    if ($s == 0 && $this->id_field == '') {
                                        $this->id_field = $field;
                                    }
                                    if ($this->id_field == $field && !$id_checkbox) {
                                        echo '<input style="display:none;" type="checkbox" name="ids[]" value="' . intval($val) . '" class="chk_box" checked>';
                                        $id_checkbox = TRUE;
                                    }
                                    ?>
                                    <tr>
                                        <th class="span2"><?= ucwords(str_replace('_', ' ', $field)); ?>:</th>
                                        <td>
                                            <?php

                                            if(in_array($field, $this->image_fields)){
                                                $val = '<div class="thumbnail " style="text-align: left;"><div class="thumb"><a href="'.base_url($this->image_path . $val).'" class=" lightbox">
                                                <img src="' . site_url('thumbs/' .$this->image_path . $val . "?" . $this->phpthumb_str .'&hash='.md5($this->image_path)) . '" alt="' . $val . '">
                                                </a>';
                                            }
                                            if (array_key_exists($field, $this->custom_func)) {
                                                $val = call_user_func($this->custom_func[$field], $val, $row);
                                            }

                                            echo nl2br(stripslashes($val)); ?>
                                        </td>
                                    </tr>
                                <?
                                }
                            }
                            ?>
                        </table>

                </form>


        <?
        return $html = ob_get_clean();
    }
}