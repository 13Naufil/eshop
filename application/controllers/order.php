<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Orders
 * @property Template $template
 * @property Catalog $catalog
 */
class Order extends CI_Controller
{
    var $table = 'orders';

    function __construct()
    {

        parent::__construct();
        $this->load->helper('frontend');
    }


    /**
     * *****************************************************************************************************************
     * @method action
     * @action Save / Add
     * *****************************************************************************************************************
     */
    public function create()
    {
        print_r($this->input->post());
        exit();
        /*if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else */
        {

            $DbArray = getDbArray($this->table);

            $DBdata = $DbArray['dbdata'];
            $DBdata['created'] = date('Y-m-d H:i:s');
            $DBdata['transaction_date'] = date('Y-m-d');
            $DBdata['invoice_date'] = date('Y-m-d');
            $DBdata['customer_id'] = $this->session->userdata('frontend_user_id');
            $DBdata['created_by'] = $this->session->userdata('frontend_user_id');

            $id = save($this->table, $DBdata);
            activity_log('create_sales_orders', $this->table, $id);

            //set_inventory
            $total_amount = $this->set_order_detail($id, $this->input->post(), 'Sales');
            save($this->table, array('invoice_num' => str_pad($id, 10, '0', STR_PAD_LEFT), 'total_amount' => $total_amount), "id='{$id}'");

            $this->session->set_flashdata('success', 'Order has been genereted.');
            redirect($this->input->server('HTTP_REFERER') . '#dealer-login');
        }
    }

    private function set_order_detail($order_id, $post_data, $type = 'Sale')
    {

        $total_amount = 0;

        $table = 'order_detail';
        $update = false;
        $order = array();
        $del_order = array();
        $order_rs = $this->db->get_where($table, array('order_id' => $order_id));
        if ($order_rs->num_rows() > 0) {
            $_order = $order_rs->result();
            $update = true;
            foreach ($_order as $ord) {
                $order[$ord->product_id] = $ord->qty;
                $del_order[$ord->id] = $ord;
            }
        }
        delete_rows($table, "order_id='{$order_id}'");

        $del_dtl_ids = $post_data['del_dtl_ids'];
        if (count($del_dtl_ids) > 0) {
            foreach ($del_dtl_ids as $del_id) {

                $dtl = $del_order[$del_id];
                $has_qty = $this->db->select('qty')->get_where('products', array('id' => $dtl->product_id), 1)->row();
                $qty_total = ($has_qty - $dtl->qty);
                save('products', array('qty' => $qty_total), "id='{$dtl->product_id}'");
            }
        }

        if (count($post_data['product_ids']) > 0) {
            foreach ($post_data['product_ids'] as $k => $product_id) {

                if ($product_id <= 0) {
                    continue;
                }

                $inventory = $this->db->select('*, IF(NOW() BETWEEN special_from_date AND special_to_date, 1, 0) AS is_special', false)->get_where('products', array('id' => $product_id),1)->row();

                $new_qty = intval($post_data['qty'][$k]);
                $__qty = $new_qty;
                if ($update) {
                    $__qty = $order[$product_id];
                    $__qty = ($new_qty - $__qty);
                }

                if (in_array($type, array('Sales'))) {

                    if (($inventory->qty) < $__qty && ($__qty >= $inventory->min_sale_qty && $__qty <= $inventory->max_sale_qty)) {
                        $this->session->set_flashdata('error', $inventory->name . ' have ' . $new_qty . ' in stock!');
                        continue;
                    }
                }

                $price = ($inventory->is_special == 1 ? $inventory->special_price : $inventory->price);
                $total_amount += ($new_qty * $price);
                $dataDB = array(
                    'order_id' => intval($order_id),
                    'product_id' => intval($product_id),
                    'price' => $price,
                    'qty' => $new_qty,
                    'tax' => intval($post_data['tax'][$k])
                );
                $dtl_id = save($table, $dataDB);
                save('products', array('qty' => ($inventory->qty - $__qty)), "id='$product_id'");

            }
        }

        return $total_amount;
    }



    function sell_through(){

        $product_ids = getVar('product_ids');
        $IMEI = getVar('IMEI');
        $qty = getVar('qty');

        if(count($product_ids) > 0){
            foreach($product_ids as $k => $product_id){
                $dataDB = array(
                    'product_id' => intval($product_id),
                    'qty' => intval($qty[$k]),
                    'IMEI' => $IMEI[$k],
                    'customer_id' => $this->session->userdata('frontend_user_id'),
                    'created' => date('Y-m-d H:i:s'),
                );

                $dtl_id = save('sell_through', $dataDB);

                activity_log('create_sell_through','sell_through',$dtl_id);
            }
        }


        $this->session->set_flashdata('success', 'Sell through has been genereted.');
        redirect($this->input->server('HTTP_REFERER') . '#dealer-login');
    }



    /**
     * *****************************************************************************************************************
     * @method AJAX
     * *****************************************************************************************************************
     */

    function AJAX($action, $id)
    {
        switch ($action) {

            case 'search':
                $JSON = array();

                $term = getVar('term');
                $where = " AND products.name LIKE '%" . $term . "%' OR products.SKU LIKE '%" . $term . "%'";
                $SQL = $this->product_sql($where);

                $products = $this->db->query($SQL)->result();
                if (count($products) > 0) {
                    foreach ($products as $product) {

                        $row['id'] = $product->product_id;
                        $row['value'] = ($product->name);
                        $row['label'] = ($product->name . ' - SKU: ' . $product->SKU);
                        //$row['new_thumb'] = _img('assets/front/products/'.$product->thumb,80,35);
                        $row['new_thumb'] = 'Product';

                        $row['product'] = array(
                            'id' => $product->product_id,
                            'name' => $product->name,
                            'thumb' => $product->thumb,
                            'is_special' => $product->is_special,
                            'actual_price' => $product->price,

                            //'price' => ($product->is_special == 1 ? $product->special_price : $product->price),
                            'price' => $this->catalog->get_product_price($product->product_id)->amount,
                            'qty' => $product->qty,
                            'min_sale_qty' => $product->min_sale_qty,
                            'max_sale_qty' => $product->max_sale_qty,
                            'weight' => $product->weight,
                            'taxable' => $product->taxable,
                            'custom_tax' => $product->custom_tax,
                            'tax_amount' => ($product->taxable == 'Yes' ? (($product->price * $product->custom_tax) / 100) : 0),
                            'is_in_stock' => $product->is_in_stock,
                        );
                        array_push($JSON, $row);
                    }
                }
                echo json_encode($JSON);
                break;
        }
    }


    private function product_sql($where = '', $limit = 0, $offset = 0, $order_by = '')
    {
        $_limit = "";
        if ($limit > 0) {
            $_limit = " LIMIT {$offset}, {$limit}";
        }

        $_order_by = " ORDER BY products.id DESC";
        if (!empty($order_by)) {
            $_order_by = " ORDER BY " . $order_by;
        }

        $where .= " AND products.status='Active'";
        $SQL = "SELECT
                products.*
                , products.id AS product_id
                , IF(NOW() BETWEEN products.news_from_date AND products.news_to_date, 1, 0) AS is_new
                , IF(NOW() BETWEEN products.special_from_date AND products.special_to_date, 1, 0) AS is_special
                -- , (SELECT image FROM product_images WHERE product_id=products.id ORDER BY `default` DESC LIMIT 1) AS image
                , (SELECT image FROM product_images WHERE product_id=products.id ORDER BY `thumb` DESC LIMIT 1) AS thumb
                , GROUP_CONCAT(DISTINCT product_cat_rel.category_id SEPARATOR ',') AS catagories_ids

            FROM
                products
                LEFT JOIN product_cat_rel ON (products.id = product_cat_rel.product_id)
            WHERE 1 {$where}
            GROUP BY products.id
            {$_order_by} {$_limit}";

        return $SQL;
    }

    function update_desc(){
            $rows = $this->db->get('products')->result();
            if(count($rows) > 0){
                foreach ($rows as $key => $val) {
                    $count = 0;
                    $desc = $val->description;
                    $pat = '/<img(.*?) class\=\"/i';
                    $rep = '<img$1 class="img-responsive ';
                    $desc = preg_replace($pat, $rep, $desc, -1, $count);
                    if($count == 0){
                        $pat = '/<img(.*?)/i';
                        $rep = '<img class="img-responsive" ';
                        $desc = preg_replace($pat, $rep, $desc);
                    }

                    $pat = '/<img(.*?) (width\=\"(.*?)\")/';
                    $rep = '<img$1';
                    $desc = preg_replace($pat, $rep, $desc);

                    $pat = '/<img(.*?) (height\=\"(.*?)\")/';
                    $rep = '<img$1';
                    $desc = preg_replace($pat, $rep, $desc);

                    save('products', array('description' => $desc), "id='{$val->id}'");
                    //echo '<pre>';print_r($this->db->last_query());echo '</pre>';
                }
            }
        }

}

/* End of file orders.php */
/* Location: ./application/controllers/orders.php */