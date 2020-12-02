<?php
/**
 * Developed by Naufil khan.
 * Email: pisces_adnan@hotmail.com
 * Autour: Naufil khan
 * Date: 5/25/12
 * Time: 1:58 PM
 */

class grid
{

    private  $DB;

    var $title = '';
    var $query = '';
    var $url = '';
    var $limit = 25;

    var $id_field = 'id';

    var $adjacents = 3;
    var $module_uri = 2;

    var $form_buttons = array();
    var $grid_buttons = array();

    var $actionColumn = TRUE;
    var $is_front = FALSE;
    var $sorting = TRUE;

    var $selectAllCheckbox = TRUE;
    var $serial = FALSE;

    var $search_box = FALSE;
    var $advance_search_html = '';
    var $notification_message = '';
    var $record_not_found = 'Record not found.';

    var $show_paging_bar = TRUE;
    var $show_validation_errors = TRUE;

    var $image_path = null;
    var $phpthumb_str = 'h=70';

    var $date_format = 'Y-m-d H:i:s'; //d/m/Y H:i:s
    var $date_fileds = array('created', 'added', 'updated', 'modified', 'date');

    var $custom_func = array();
    var $center_fields = array();
    var $image_fields = array();
    var $hide_fields = array();
    var $to_from_fields = array();
    var $search_fields_html = array();

    var $filter_column = 'filter';
    var $filter_options = array(
        '%-%' => 'Contain',
        '%!-%' => 'Not Contain',
        '-%' => 'Start With',
        '%-' => 'End With',
        '=' => 'Equal',
        '!=' => 'Not Equal',
        '>' => 'Greater Then',
        '>=' => 'Greater Then Equal',
        '<' => 'Less Then',
        '=<' => 'Less Then Equal',
    );


    var $show_entries = array('25' => '25', '50' => '50', '100' => '100', 'all' => 'All');

    var $total_record = 0;
    var $total_pages;

    var $get_search_column = 'search';
    var $get_limit_column = 'limit';
    var $get_page_column = 'page';

    var $get_order_column = 'order_by';
    var $order_column = '';

    var $get_order = 'order';
    var $order = 'DESC';

    var $form_action_privilege = 'private';
    var $grid_action_privilege = 'private';
    var $grid_action_url = '';

    var $css_class = '';

    var $grid_start = '<div class="widget">';
    var $grid_end = '</div>';


    private $form_method = 'GET';
    private $order_by = '';
    private $start_limit = 0;
    private $fields = array();
    private $result_array = array();
    private $init = false;
    private $QUERY_STRING;
    private $CI;


    function __construct() {
        if($this->image_path == null){
            $this->image_path = 'assets/admin/img/';
        }
        $CI =& get_instance();
        $this->CI = $CI;

        $this->DB = $CI->db;


        if (empty($this->url)) {
            $this->url = current_url() . '/';
        }
        $this->QUERY_STRING = str_replace('token=1', '', $CI->input->server('QUERY_STRING'));


    }


    /**
     * @return string
     */
    function pagingQuery()
    {

        $this->init = true;
        if (strpos($this->query, 'SQL_CALC_FOUND_ROWS') !== 7) {
            $this->query = "SELECT SQL_CALC_FOUND_ROWS" . substr($this->query, 6);
        }

        /**
         * ***********************************************************************************
         * Start
         * Ordering
         * ***********************************************************************************
         */

        if (isset($_GET[$this->get_order_column])) {
            $this->order_column = getVar($this->get_order_column);
        }else if (!empty($this->order_column)) {
            $this->order_column = getVar($this->get_order_column);
        }else{
            $this->order_column = $this->id_field;
        }

        if (getVar($this->get_order)) {
            $this->order = getVar($this->get_order);
        }

        if ($this->order_column != '' && $this->order != '') {
            $this->order_by = " ORDER BY " . $this->order_column . ' ' . $this->order;
        }
        if (strtoupper($this->order) == 'DESC') {
            $this->order = 'ASC';
        } else {
            $this->order = 'DESC';
        }
        /**
         * ***********************************************************************************
         * Start
         * Page and page limit
         * ***********************************************************************************
         */
        $page = getVar($this->get_page_column);
        if ($page) {
            $this->start_limit = ($page - 1) * $this->limit; //first item to display on this page
        }
        /*---------------------------------LIMIT----------------------------------------*/
        if (getVar($this->get_limit_column)) {
            $this->limit = (getVar($this->get_limit_column));
        }

        if (strtolower($this->limit) != 'all') {
            $this->query .= " {$this->order_by} LIMIT {$this->start_limit}, {$this->limit}";
        }

        $result = $this->DB->query($this->query);

        $list_fields = $result->list_fields();

        foreach ($list_fields as $field) {
            array_push($this->fields, $field);
        }

        $this->result_array = $result->result_array();
        $this->total_record = $this->DB->query("SELECT FOUND_ROWS() as total")->row()->total;

        $this->total_pages = ceil($this->total_record / $this->limit);

        return $this->query;
    }

    private function init()
    {
        if (!$this->init) {
            $this->pagingQuery();
        }
    }

    public function showGrid()
    {
        
        $grid = '';
        if($this->show_validation_errors){
            $grid .= show_validation_errors();
        }
        $grid .= '<form action="' . $this->url . '" method="' . $this->form_method . '" enctype="multipart/form-data" class="grid_form"><div class="print">';
        $grid .= '<div class="panel panel-default">';
        $grid .= $this->gridHeader();
        $grid .= $this->getAdvanceSearch();
        $grid .= '<div class="table-responsive"><table class="xgrid table table-bordered table-checks table-striped">';
        $grid .= $this->getTHead();
        $grid .= $this->getTBody();
        $grid .= '</table></div>';
        if ($this->show_paging_bar) {
            $grid .= $this->getTFoot();
        }
        $grid .= '</div></div></div></form>';


        return $grid;
    }

    /**
     * @return string
     */
    function gridHeader()
    {
        $this->init();
        ob_start();
        if (!empty($this->title)) {
            echo '<div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-insert-template"></i> ' . $this->title . '</h6>
                  </div>';
        }
        if (count($this->form_buttons) > 0) {
            echo get_form_actions($this->form_buttons, $this->module_uri, $this->form_action_privilege);
        }

        return ob_get_clean();
    }


    function getAdvanceSearch()
    {
        if (!empty($this->advance_search_html)) {
            return '<span class="x-print">' . $this->advance_search_html . '<span>';
        }
    }

    function getTHead()
    {
        $this->init();

        ob_start();
        echo '<thead>';
        if ($this->search_box) {
            echo '<tr class="x-print">';
            if ($this->selectAllCheckbox) {
                echo '<th width="40">&nbsp;</th>';
            }

            $query_col_str = ',' . substr($this->query, (stripos($this->query, 'SQL_CALC_FOUND_ROWS') + 28), (stripos($this->query, 'FROM') - 35));
            $query_seesion = array();
            $search_request = getVar($this->get_search_column, true, false);
            foreach ($this->fields as $i => $field) {

                if ($this->serial && $i == 0) {
                    echo '<th width="100">&nbsp;</th>';
                } else if (!in_array($field, $this->hide_fields)) {

                    $alias = '';
                    if (array_key_exists($field, $this->search_fields_html) !== FALSE) {
                        echo '<td>' . $this->search_fields_html[$field] . '</td>';
                    } else if (array_key_exists($field, $this->to_from_fields) !== FALSE) {
                        if(!is_array($search_request[trim($alias) . trim($field)])){
                            $search_request[trim($alias) . trim($field)]['from'] = $search_request[trim($alias) . trim($field)]['to'] = '';
                            $search_request[trim($alias) . trim($field)]['from_date'] = $search_request[trim($alias) . trim($field)]['to_date'] = '';
                        }
                        $from = 'from';
                        $to = 'to';
                        if($this->to_from_fields[$field] == 'date'){
                            $from = 'from_date';
                            $to = 'to_date';
                            $_date_pick_cls = 'datepicker';
                        }
                        echo '<td>
                                <input placeholder="'.ucwords(str_replace('_', ' ', $field)).'" class="search_input '.$_date_pick_cls.' form-control" type="text" name="' . $this->get_search_column . '[' . trim($alias) . trim($field) . ']['.$from.']" id="' . $this->get_search_column . '_' . $field . '_from" value="' . $search_request[trim($alias) . trim($field)][$from] . '">
                                <input placeholder="'.ucwords(str_replace('_', ' ', $field)).'" class="search_input '.$_date_pick_cls.' form-control" type="text" name="' . $this->get_search_column . '[' . trim($alias) . trim($field) . ']['.$to.']" id="' . $this->get_search_column . '_' . $field . '_to" value="' . $search_request[trim($alias) . trim($field)][$to] . '">
                            </td>';
                    } else {
                        $_date_pick_cls = (in_array($field, $this->date_fileds) ? ' datepicker' : '');

                        $filter_select = getVar($this->filter_column, true, false);
                        echo '<td>
                                <div class="input-group">
                                <input placeholder="'.ucwords(str_replace('_', ' ', $field)).'" class="search_input form-control col-sm-12 '.$_date_pick_cls.'" type="text" name="' . $this->get_search_column . '[' . trim($alias) . trim($field) . ']" id="' . $this->get_search_column . '_' . $field . '" value="' . htmlentities($search_request[trim($alias) . trim($field)]) . '">
                                
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-sm pd-lr-5 dropdown-toggle" data-toggle="dropdown"><span class="icon-filter"></span></button>
                                    <ul class="dropdown-menu icons-right dropdown-menu-right">
                                        <li>
                                            <select name="'.$this->filter_column.'[' . trim($alias) . trim($field) . ']" id="" class="select-full">
                                                '.selectBox($this->filter_options, $filter_select[trim($alias) . trim($field)]).'
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                </td>';
                    }
                }
            }

            //getSession($this->get_search_column, $query_seesion);

            echo '<th align="left"><input type="submit" class="go_btn btn btn-info" value="Search"></th>';
            echo '</tr>';
        }

        echo '<tr>';
        if ($this->serial) {
            echo '<th>S.No</th>';
        }
        if ($this->selectAllCheckbox) {
            echo '<th class="text-center"><input type="checkbox" name="checkRow" id="checkRow" class="styled"/></th>';
        }

        foreach ($this->fields as $key => $field) {
            if ($key == 0 && $this->id_field == '') {
                $this->id_field = $field;
            }
            if (!in_array($field, $this->hide_fields)) {
                $_order = '';
                if ($this->sorting) {
                    $_order = $this->url_sanitize($this->url, $this->get_order_column) . '&' . $this->get_order_column . '=' . $field;
                    $_order = generate_url($this->get_order, $_order) . '&' . $this->get_order . '=' . $this->order;

                    $_sorting = (getVar($this->get_order_column) == $field) ? 'sorting_' . strtolower(getVar($this->get_order)) : 'sorting';
                    $_sorting_link_s = '<a href="' . $_order . '">';
                    $_sorting_link_e = '</a>';
                }

                if ((count($this->grid_buttons) == 0 || !$this->actionColumn) && count($this->fields) == ($key + 1)) {
                    $colspan = ' colspan="2" ';
                }
                echo '<th ' . $colspan . ' class="' . $_sorting . '">' . $_sorting_link_s . ucwords(str_replace('_', ' ', $field)) . $_sorting_link_e . '</th>';
            }
        }
        if (count($this->grid_buttons) > 0 && $this->actionColumn) {
            echo '<th>Actions</th>';
        }
        echo '</tr>';
        echo '</thead>';

        return ob_get_clean();
    }


    function getTBody()
    {
        $this->init();
        ob_start();
        if ($this->total_record > 0) {
            echo '<tbody>';
            $i = 0;
            foreach ($this->result_array as $column => $row) {
                $i++;
                if ($i % 2 == 0) {
                    $color_td = "odd";
                } else {
                    $color_td = "even";
                }

                echo '<tr class="grid_row ' . $color_td . '">';
                if ($this->serial) {
                    echo '<td align="center">' . ((getVar($this->get_page_column) > 0) ? ($i + ((getVar($this->get_page_column) - 1)  * $this->limit)) : $i) . '</td>';
                }

                if ($this->selectAllCheckbox) {
                    echo '<td align="center"><input type="checkbox" id="check_' . $column . '" class="styled chk_box check_' . $column . '" name="ids[]" value="' . $row[$this->id_field] . '"/></td>';
                }
                $k = 0;

                foreach ($row as $field_name => $val) {

                    $k++;
                    $colspan = '';
                    if ((count($this->grid_buttons) == 0 || !$this->actionColumn) && count($this->fields) == ($k)) {
                        $colspan = ' colspan="2" ';
                    }

                    $center_class = (in_array($field_name, $this->center_fields) ? ' text-center ' : '');
                    if (!in_array($field_name, $this->hide_fields)) {
                        if (in_array($field_name, $this->image_fields)) {
                            if (!empty($val) || file_exists($this->image_path . $val)) {
                                $file = $this->image_path . $val;
                            } else {
                                $file = ASSETS_URL . "images/na.gif";
                            }
                            echo '<td ' . $colspan . ' valign="middle" align="center">
                            <div class="thumbnail"><div class="thumb"><a href="'.base_url($file).'" class=" lightbox">
                                <img src="' . site_url('thumbs/' .$file . "?" . $this->phpthumb_str .'&hash='.md5(rand())) . '" alt="' . $val . '">
                            </a>
                            </td>';
                        } else {
                            if(in_array($field_name, $this->date_fileds)){
                                $date_time_format = explode(' ', $this->date_format);
                                $date_format = (strpos($val, ':') === FALSE) ? $date_time_format[0] : $this->date_format;
                                $val = date($date_format, strtotime($val));
                            }
                            if (array_key_exists($field_name, $this->custom_func)) {
                                $val = call_user_func($this->custom_func[$field_name], $val, $row, $this->selected, $field_name);
                            }
                            echo '<td ' . $colspan . ' valign="middle" class="'.$center_class.'">' . stripslashes($val) . '</td>';
                        }
                    }
                }
                if (count($this->grid_buttons) > 0 && $this->actionColumn) {
                    echo '<td valign="middle" align="center"> ' . get_grid_actions($row, $this->id_field, $this->grid_buttons, $this->module_uri,array(),$this->grid_action_privilege, $this->grid_action_url) . '</td>';
                }
                echo '</tr>';
            }
        } else {
            echo '<td colspan="' . (count($this->fields) + 1) . '" valign="middle" align="center">' . $this->record_not_found . '</td>';
        }
        echo '</tbody>';

        return ob_get_clean();
    }

    function getTFoot()
    {
        $this->init();
        ob_start();

        ?>
        <div class="table-footer">
            <div class="table-actions">
                <label>Limit: </label>
                <select class="select-liquid" name="<?php echo $this->get_limit_column; ?>" onchange="$(this).parents('.grid_form').submit();">
                    <option value="<?php echo $this->limit;?>"><?php echo $this->limit;?></option>
                    <?php echo selectBox($this->show_entries, getVar($this->get_limit_column)); ?>
                </select>

                &nbsp;&nbsp;&nbsp;Showing <?= ($this->total_record > 0 ? ($this->start_limit + 1) : 0); ?> to <?= (($this->total_record) > ($this->start_limit + $this->limit)) ? ($this->limit) : $this->total_record; ?> of <?= $this->total_record; ?> entries

            </div>
          <ul class="pagination">
              <?php echo $this->showPaging(); ?>
          </ul>


        <?
        return ob_get_clean();
    }

    /**
     * @return string
     */


    function showPaging()
    {

        $this->init();

        $adjacents = $this->adjacents;
        //$targetpage = str_replace(array('?', '//?', '/?'), '/?', $this->url);
        $targetpage = $this->url;

        $page = getVar($this->get_page_column);
        if ($page == 0) $page = 1;
        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil($this->total_record / $this->limit);

        $lpm1 = $lastpage - 1;


        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= '<div class=" ' . $this->css_class . '"><ul class="pagination pagination-sm">';
            //previous button
            if ($page > 1){
                $pagination .= "<li class=''><a href='" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=1'>&laquo; First</a></li><a href=\"" . $this->url_sanitize($this->url, 'page') . "page=$prev\">&laquo; Previous</a></li>";
            }else{
                $pagination .= "<li class=''><a href='" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=1'>&laquo; First</a></li><li><span class=\"disabled\">&laquo; Previous</span></li>";
            }
            //pages
            if ($lastpage < 7 + ($adjacents * 2)) //not enough pages to bother breaking it up
            {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class=\"active\"><span>$counter</span></li>";
                    } else {
                        $pagination .= '<li><a href="' . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . '=' . $counter . '">' . $counter . '</a></li>';
                    }
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
            {
                //close to beginning; only hide later pages
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li  class=\"active\"><span>$counter</span></li>";
                        else {
                            $pagination .= "<li class=''><a href=\"" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=$counter\">$counter</a></li>";
                        }
                    }
                    $pagination .= "...";
                    $pagination .= "<li><a href=\"" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=$lpm1\">$lpm1</a></li>";
                    $pagination .= "<li><a href=\"" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=$lastpage\">$lastpage</a></li>";
                } //in middle; hide some front and some back
                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= "<li><a href=\"" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=1\">1</a></li>";
                    $pagination .= "<li><a href=\"" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=2\">2</a></li>";
                    $pagination .= "...";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class=\"active\"><span>$counter</span></li>";
                        else {
                            $pagination .= "<li class=''><a href=\"" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=$counter\">$counter</a></li>";
                        }
                    }
                    $pagination .= ".   ..";
                    $pagination .= "<li><a href=\"" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=$lpm1\">$lpm1</a></li>";
                    $pagination .= "<li><a href=\"" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=$lastpage\">$lastpage</a></li>";
                } else {
                    $pagination .= "<li><a href=\"" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=1\">1</a></li>";
                    $pagination .= "<li><a href=\"" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=2\">2</a></li>";
                    $pagination .= "...";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class=\"active\">$counter</li>";
                        else
                            $pagination .= "<li class=''><a href=\"" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=$counter\">$counter</a></li>";
                    }
                }
            }
            //next button
            if ($page < $counter - 1)
                $pagination .= "<li><a href=\"$targetpage?page=$next\">Next &raquo;</a><li><a href='" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=$lastpage'>Last &raquo;</a></li>";
            else
                $pagination .= "<li><span class=\"disabled\">Next &raquo;</span></li><li><a href='" . $this->url_sanitize($this->url, $this->get_page_column) . '&' . $this->get_page_column . "=$lastpage'>Last &raquo;</a></li>";
            $pagination .= "</ul></div>";
        }
        return $pagination;
    }


    function url_sanitize($url, $add_arg = '')
    {
        return generate_url($add_arg);


        //$get = $this->input->get();
        $url_sanitize = preg_replace("/" . $add_arg . "\=\w+/", '', $url);
        $url_sanitize = str_replace(array("/&"), '/?', $url_sanitize);

        //$url_sanitize = preg_replace("/\&{1,}+/", '', $url_sanitize);

        if (strpos($url_sanitize, '?') === false) {
            $url_sanitize = str_replace($this->url, $this->url . '?', $url_sanitize);
            if(substr($url_sanitize,-1,1) == '?'){
                $url_sanitize = str_replace('?', '?token=1', $url_sanitize);
            }
        }


        return $url_sanitize;
    }


}
