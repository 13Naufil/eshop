<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AJAX extends CI_Controller
{
    function __construct()
    {

        parent::__construct();
    }


    public function index()
    {

        $action = getVar('action');
        switch ($action) {
            case 'WtoB_city':
                $country = getVar('country');
                echo '<option value="">Select City</option>';
                echo selectBox("SELECT DISTINCT city, city as s_city FROM cms_where_to_buy WHERE country='{$country}'", '');

                break;
            case 'WtoB_area':
                //$country = getVar('country');
                $city = getVar('city');
                echo '<option value="">Select Area</option>';
                echo selectBox("SELECT DISTINCT  area, area as s_area FROM cms_where_to_buy WHERE 1 AND city='{$city}'", '');
                break;
        }
    }

    function search()
    {
        $JSON = array();

        $term = getVar('term');
        $where = " AND products.name LIKE '%" . $term . "%' OR products.SKU LIKE '%" . $term . "%'";
        $SQL = $this->product_sql($where);

        $products = $this->db->query($SQL)->result();
        if (count($products) > 0) {
            foreach ($products as $product) {

                $row['id'] = $product->product_id;
                $row['value'] = ($product->name);
                $row['label'] = ($product->name);
                //$row['new_thumb'] = _img('assets/front/products/'.$product->thumb,80,35);
                $row['new_thumb'] = 'Product';

                $row['product'] = array(
                    'id' => $product->product_id,
                    'name' => $product->name,
                    'thumb' => $product->thumb,
                    'actual_price' => $product->price,
                    'price' => ($product->is_special ? $product->special_price : $product->price),
                    'qty' => $product->qty,
                    'min_sale_qty' => $product->min_sale_qty,
                    'max_sale_qty' => $product->max_sale_qty,
                    'weight' => $product->weight,
                    'taxable' => $product->taxable,
                    'custom_tax' => $product->custom_tax,
                    'tax_amount' => ($product->taxable ? (($product->price * $product->custom_tax) / 100) : 0),
                    'is_in_stock' => $product->is_in_stock,
                );
                array_push($JSON, $row);
            }
        }
        echo json_encode($JSON);
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
                -- , IF(NOW() BETWEEN products.news_from_date AND products.news_to_date, 1, 0) AS is_new
                , IF(NOW() BETWEEN products.special_from_date AND products.special_from_date, 1, 0) AS is_special
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
}

/* End of file AJAX.php */
/* Location: ./application/controllers/AJAX.php */