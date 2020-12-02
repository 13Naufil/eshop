<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 *
 * @property M_cpanel $m_cpanel
 * @copyright 2019 * @date 25-10-2019
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stock_report extends CI_Controller
{

    var $module_name;
    var $module_title;
    var $module_route;
    var $where = '';

    /**
     * *****************************************************************************************************************
     * @method stock_report __construct
     * *****************************************************************************************************************
     */

    function __construct()
    {
        parent::__construct();
        $this->m_cpanel->checkLogin();

        //TODO:: Module Name
        $this->module_name = getUri(2);


        $this->module_route = $this->router->class;
        $this->module_title = getModuleDetail()->module_title;

        if(user_info('id') == get_option('client_type_id')){
            $this->where = " AND created_by='".user_info('id')."'";
        }
    }

    /**
     * *****************************************************************************************************************
     * @method stock_report index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        
        if(in_array($this->input->server('REQUEST_METHOD'), array('POST'))){

            $this->breadcrumb->add_item('Report');

            $d_where = $WHERE = '';

            $dealer_id = getVar('dealer_id');
            $product_id = getVar('product_id');
            $from_date = $data['from_date'] = date2mysql(getVar('from_date'));
            $to_date = $data['to_date'] = date2mysql(getVar('to_date'));

            if(getVar('country') != ''){
                $d_where .= " AND country='".getVar('country')."'";
            }
            if(getVar('state') != ''){
                $d_where .= " AND state='".getVar('state')."'";
            }
            if(getVar('city') != ''){
                $d_where .= " AND city='".getVar('city')."'";
            }
            if(getVar('area') != ''){
                $d_where .= " AND area='".getVar('area')."'";
            }
            if(getVar('market') != ''){
                $d_where .= " AND market='".getVar('market')."'";
            }

            if($dealer_id > 0){
                $WHERE .= " AND [table].[column] IN({$dealer_id})";
                $data['dealer'] = $this->db->get_where('dealers', array('id' => $dealer_id))->row();
            }else{
                $dealer_ids = join(',', singleColArray("SELECT id FROM dealers WHERE 1 " . $d_where, 'id'));
                $WHERE .= " AND [table].[column] IN({$dealer_ids})";
            }

            if(getVar('from_date') != '') {
                $WHERE .= " AND [table].[column] BETWEEN '{$from_date}' AND '{$to_date}'";
            }




            $SQL = "SELECT
                products.name
                , GROUP_CONCAT(DISTINCT dealers.business_name SEPARATOR ', ') as dealers
                , SUM(stock.opn_qty) AS opn_qty
                , SUM(stock.ord_qty) AS ord_qty
                , SUM(stock.sell_qty) AS sell_qty
            FROM products
            INNER JOIN (
            SELECT
              doi.dealer_id
              , doi.product_id
              , SUM(doi.qty) AS opn_qty
              , 0 AS ord_qty
              , 0 AS sell_qty
            FROM dealer_open_inventory AS doi
            WHERE 1 " . str_replace(array('[table]', '[column]'), array('doi', 'dealer_id'), $WHERE) . "
            GROUP BY doi.product_id
            UNION ALL
            SELECT
              orders.customer_id AS dealer_id
              , order_detail.product_id
              , 0 AS opn_qty
              , SUM(order_detail.qty) AS ord_qty
              , 0 AS sell_qty

            FROM orders
            INNER JOIN order_detail ON order_detail.order_id = orders.id
            WHERE 1 " . str_replace(array('[table]', '[column]'), array('orders', 'customer_id'), $WHERE) . "
            GROUP BY order_detail.product_id
            UNION ALL
            SELECT
              sell_through.customer_id AS dealer_id
              , sell_through.product_id
              , 0 AS opn_qty
              , 0 AS ord_qty
              , SUM(sell_through.qty) AS sell_qty
            FROM sell_through
            WHERE 1 " . str_replace(array('[table]', '[column]'), array('sell_through', 'customer_id'), $WHERE) . "
            GROUP BY sell_through.product_id
            ) AS stock
            ON stock.product_id = products.id
            LEFT JOIN dealers ON dealers.id = stock.dealer_id
            GROUP BY products.id
            ORDER BY products.name";

            $data['rows'] = $this->db->query($SQL)->result();
            //echo '<pre>';print_r($this->db->last_query());echo '</pre>';die('Call');
            $this->admin_template->load($this->module_name . '/view', $data);
            return;
        }

        $data = array();
        $data['where'] = $this->where;
        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->admin_template->load($this->module_name . '/form', $data);

    }



}


/* End of file general_ledger_report.php */
/* Location: ./application/controllers/admin/general_ledger_report.php */

