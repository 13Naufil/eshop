<?php

/**
 * Developed by Naufil khan.
 * Email: pisces_adnan@hotmail.com
 * Autour: Naufil khan
 * Date: 9/20/14
 * Time: 7:19 PM
 */
class Catalog extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    function get_brands($where = '')
    {
        $SQL = "SELECT * FROM `brands` WHERE `status`='Active' " . $where;
        return $this->db->query($SQL)->result();
    }


    /**
     * @param string $where
     * @return array|mixed|string
     */
    function get_brand_categories($brand_id, $parent = true)
    {
        $brand_categories = array();
        $categories = $this->get_categories("ORDER BY ordering ASC");
        //$categories = $this->db->get_where('categories', array('status' => 'Active'))->result();

        $_child_cat_ids = array();
        if (count($categories) > 0) {
            foreach ($categories as $_cat) {
                array_push($_child_cat_ids, $_cat['id']);
            }
        }

        $SQL = "SELECT product_cat_rel.category_id,products.brand_id
        FROM product_cat_rel
        INNER JOIN products ON products.id = product_cat_rel.product_id
        WHERE product_cat_rel.category_id IN(" . join(',', $_child_cat_ids) . ")
        AND products.brand_id='{$brand_id}'
        GROUP BY product_cat_rel.category_id ORDER BY products.brand_id DESC";
        $_categories = $this->db->query($SQL)->result();


        if (count($_categories) > 0) {
            foreach ($_categories as $_cat) {
                if ($parent) {
                    if ($categories[$_cat->category_id]['parent_id'] == 0) {
                        array_push($brand_categories, $categories[$_cat->category_id]['id']);
                    } else {
                        $parents = array();
                        $this->get_parent_cat($_cat->category_id, $parents);
                        if (count($parents) > 0) {
                            foreach ($parents as $row) {
                                if ($row->parent_id == 0) {
                                    array_push($brand_categories, $categories[$row->id]['id']);
                                }
                            }
                        }
                    }
                } else {
                    array_push($brand_categories, $categories[$_cat->category_id]['id']);
                }
            }

            $brand_categories = $this->db->query("SELECT * FROM categories WHERE status='Active' AND id IN(" . join(',', $brand_categories) . ") GROUP BY id ORDER BY ordering ASC")->result();
        }

        return $brand_categories;
    }


    /**
     * @param string $where
     * @return array|mixed|string
     */
    function get_categories($where = '')
    {

        $SQL = "SELECT * FROM `categories` WHERE `status`='Active' " . $where;

        $multilevels = new multilevels();
        $multilevels->type = 'array';
        $multilevels->id_Column = 'id';
        $multilevels->title_Column = 'title';
        $multilevels->link_Column = 'friendly_url';

        $multilevels->active_class = 'active';
        $multilevels->active_link = getUri(2);
        $multilevels->query = $SQL;

        $categories = $multilevels->build();
        return $categories['items'];
    }


    function get_child_categories($id, $where)
    {
        if ($id > 0) {
            //$where .= " AND parent_id='{$id}'";
        }
        $SQL = "SELECT * FROM `categories` WHERE 1 " . $where;

        $multilevels = new multilevels();
        $multilevels->type = 'child';
        $multilevels->parent = $id;
        $multilevels->id_Column = 'id';
        $multilevels->title_Column = 'title';
        $multilevels->link_Column = 'friendly_url';

        $multilevels->active_class = 'active';
        $multilevels->active_link = getUri(2);
        $multilevels->query = $SQL;

        return $multilevels->build();
    }


    function get_parent_categories($id, &$parent_categories, $level = 0)
    {
        $parent_cats = array();
        $this->get_parent_cat($id, $parent_cats, $level);
        foreach ($parent_cats as $k => $cat) {
            if ($k >= $level) {
                array_push($parent_categories, $cat);
            }
        }
    }


    function get_parent_cat($id, &$parent_cats)
    {
        $SQL = "SELECT * FROM `categories` WHERE id=" . intval($id);
        $QUERY = $this->db->query($SQL);
        if ($QUERY->num_rows() > 0) {
            $row = $QUERY->row();
            if (!in_array($row->parent_id, $parent_cats)) {
                array_push($parent_cats, $row);
                $this->get_parent_cat($row->parent_id, $parent_cats);
            }
        }
    }

    function get_categories_ids($categories = array())
    {

        $cat_ids = array();
        if (count($categories) > 0) {
            foreach ($categories as $cat) {
                if ($cat['id'] > 0) array_push($cat_ids, $cat['id']);
            }
        }
        return $cat_ids;
    }

    function get_brands_for_filter($categories_ids = array(), $where = '')
    {

        if (count($categories_ids) > 0) {
            $where .= " AND product_cat_rel.category_id IN(" . join(',', $categories_ids) . ") ";
        }

        $attrs = getVar('filter');
        if (count($attrs) > 0) {
            foreach ($attrs as $type => $attr_row) {
                if($type == 'brand'){
                    if(count($attr_row) > 0) {
                        $where .= " AND products.brand_id IN (" . dbEscape(join(',', array_keys($attr_row))) . ")";
                    }
                }

                if($type == 'category'){
                    if(count($attr_row) > 0) {
                        $where .= " AND product_cat_rel.category_id IN (" . dbEscape(join(',', array_keys($attr_row))) . ")";
                    }
                }
            }
        }


        $SQL = "SELECT brands.id
        , 'brand' AS `type`
        , 'Brands' AS attr_label
        , brands.title AS attr_value
        , brands.friendly_url
        , count(products.id) AS total_count

        FROM brands
        INNER JOIN products ON products.brand_id = brands.id
        INNER JOIN product_cat_rel ON product_cat_rel.product_id = products.id

        WHERE brands.status='Active'
        {$where}
        GROUP BY brands.id
        HAVING total_count > 0
        ORDER BY brands.title ASC";

        $filter_brands = $this->db->query($SQL)->result();
        if (count($filter_brands) > 0) {
            return array($filter_brands);
        } else {
            return array();
        }
    }

    function get_categories_for_filter($parent_id, $where = '')
    {

        $attrs = getVar('filter');
        if (count($attrs) > 0) {
            foreach ($attrs as $type => $attr_row) {
                if($type == 'brand'){
                    if(count($attr_row) > 0) {
                        $where .= " AND products.brand_id IN (" . dbEscape(join(',', array_keys($attr_row))) . ")";
                    }
                }

                if($type == 'category'){
                    if(count($attr_row) > 0) {
                        $where .= " AND product_cat_rel.category_id IN (" . dbEscape(join(',', array_keys($attr_row))) . ")";
                    }
                }
            }
        }

        if ($parent_id > 0) {
            $where .= " AND categories.parent_id={$parent_id} ";
        }
        $SQL = "SELECT categories.id
        , 'category' AS type
        , 'Categories' AS attr_label
        , categories.title AS attr_value
        , categories.friendly_url
        , count(products.id) AS total_count

        FROM categories
        INNER JOIN product_cat_rel ON product_cat_rel.category_id = categories.id
        INNER JOIN products ON products.id = product_cat_rel.product_id

        WHERE categories.status='Active'
        {$where}
        GROUP BY categories.id
        HAVING total_count > 0
        ORDER BY categories.ordering ASC";

        $filter_cats = $this->db->query($SQL)->result();

        if (count($filter_cats) > 0) {
            return array($filter_cats);
        } else {
            return array();
        }
    }

    function get_prices_for_filter($categories_ids = array(), $where = '')
    {

        if (count($categories_ids) > 0) {
            $where .= " AND product_cat_rel.category_id IN(" . join(',', $categories_ids) . ") ";
        }

        $SQL = "SELECT MIN(price) AS min_price , MAX(price) AS max_price
        FROM products
        LEFT JOIN product_cat_rel ON product_cat_rel.product_id = products.id
        WHERE 1
        AND products.status='Active'
        {$where} LIMIT 1";

        $filter_prices = $this->db->query($SQL)->row();

        return $filter_prices;
    }

    function get_filter_clause($attrs = array(), $key = 'filter')
    {

        $where = array();
        if (count($attrs) == 0) {
            $attrs = getVar($key);
        }

        //echo '<pre>'; print_r($attrs); echo '</pre>';
        if (count($attrs) > 0) {
            foreach ($attrs as $type => $attr_row) {
                foreach ($attr_row as $attr_id => $attr_val) {
                    switch ($type) {
                        case 'attr':
                            foreach($attr_val as $val){

                                $where['filter_clause'] .= " AND products.id IN (SELECT product_id FROM product_attributes_rel
                                LEFT join attributes_option_values_rel ON attributes_option_values_rel.attr_value_id = product_attributes_rel.attr_value_id
                                WHERE product_attributes_rel.attribute_id = '".dbEscape($attr_id)."' AND
                                IF(product_attributes_rel.attr_value_id > 0,
                                      IF(attributes_option_values_rel.frontend_value = '', attributes_option_values_rel.admin_value, attributes_option_values_rel.frontend_value)
                                      , product_attributes_rel.attr_value) = '".dbEscape($val)."' GROUP BY product_attributes_rel.product_id)";

                            }
                            //$where['product_clause'] .= " AND (product_attributes_rel.attribute_id='".dbEscape($attr_id)."' AND (IF(product_attributes_rel.attr_value_id > 0, IF(attributes_option_values_rel.frontend_value = '', attributes_option_values_rel.admin_value, attributes_option_values_rel.frontend_value), product_attributes_rel.attr_value)) IN('" . join("','", $attr_val) . "'))\n";
                            break;
                        case 'brand':
                            //$where['brands_clause'] = true;
                            $where['filter_clause'] .= " AND products.brand_id IN (".dbEscape($attr_id).")";
                            break;
                        case 'category':
                            $where['categories_clause'] = $attr_id;
                            $where['filter_clause'] .= " AND product_cat_rel.category_id IN (".dbEscape($attr_id).")";
                            break;
                    }
                }
                /*if($type == 'brand'){
                    if(count($attr_row) > 0) {
                        $where['filter_clause'] .= " AND products.brand_id IN (" . dbEscape(join(',', array_keys($attr_row))) . ")";
                    }
                }*/
                /*if($type == 'category'){
                    if(count($attr_row) > 0) {
                        $where['filter_clause'] .= " AND product_cat_rel.category_id IN (".dbEscape(join(',', array_keys($attr_row))).")";
                    }
                }*/
            }
        }
        //echo '<pre>';print_r($where);echo '</pre>';die('Call');
        return $where;
    }

    function get_products($where = '', $order_by = '', $limit = 0, $offset = 0, $tables = array('images', 'brands', 'categories', 'attributes'))
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

        $SQL = "SELECT SQL_CALC_FOUND_ROWS
            products.*
            , CONCAT(GROUP_CONCAT(DISTINCT categories.friendly_url SEPARATOR '/'), '/', products.friendly_url, '" . get_option('url_ext') . "') AS product_url
            , products.id AS product_id
            , IF(NOW() BETWEEN products.news_from_date AND products.news_to_date, 1, 0) AS is_new
            , IF(NOW() BETWEEN products.special_from_date AND products.special_to_date, 1, 0) AS is_special
            , REPLACE(products.description, '../../../assets/editor_img/', '" . asset_url() . "/editor_img/') AS description";

        if(in_array('images', $tables)) {
            $SQL .= ", (SELECT image FROM product_images WHERE product_id=products.id ORDER BY `default` DESC LIMIT 1) AS image
            , (SELECT image FROM product_images WHERE product_id=products.id ORDER BY `thumb` DESC LIMIT 1) AS thumb
            , (SELECT image FROM product_images WHERE product_id=products.id ORDER BY `hover` DESC LIMIT 1) AS hover";
        }
        if(in_array('brands', $tables)) {
            $SQL .= ", brands.title AS brand_title
            , brands.friendly_url AS brand_friendly_url
            , brands.logo AS brand_logo
            , brands.short_description AS brand_short_description";
        }
        if(in_array('categories', $tables)) {
            $SQL .= ", categories.title AS category
            , GROUP_CONCAT(DISTINCT product_cat_rel.category_id SEPARATOR ',') AS catagories_ids";
        }
        if(in_array('attributes', $tables)) {
            $SQL .= "-- , GROUP_CONCAT(DISTINCT product_tags_rel.tag_id SEPARATOR ',') AS tags_ids
            , GROUP_CONCAT(DISTINCT product_attributes_rel.attribute_id SEPARATOR ',') AS attribute_ids";
        }

        $SQL .= " FROM products ";

        if(in_array('categories', $tables)) {
            $SQL .= " LEFT JOIN product_cat_rel ON (products.id = product_cat_rel.product_id)
            LEFT JOIN categories ON (categories.id = product_cat_rel.category_id)";
        }
        if(in_array('brands', $tables)) {
            $SQL .= " LEFT JOIN brands ON (brands.id = products.brand_id)";

            /*LEFT JOIN product_tags_rel ON (products.id = product_tags_rel.product_id)*/
        }
        if(in_array('attributes', $tables)) {
            $SQL .= " LEFT JOIN product_attributes_rel ON (products.id = product_attributes_rel.product_id)
            LEFT JOIN attributes ON (attributes.id = product_attributes_rel.attribute_id)
            LEFT JOIN attributes_option_values_rel ON (product_attributes_rel.attr_value_id = attributes_option_values_rel.attr_value_id)";
        }

        $SQL .= " WHERE 1 {$where}
        GROUP BY products.id
        {$_order_by} {$_limit}";
        //echo '<pre>';print_r($SQL);echo '</pre>';
        //echo '<pre style="display: none;">';print_r($SQL);echo '</pre>';
        $products = $this->db->query($SQL)->result();

        return $products;
    }

    function get_product_price($product_id, $where = '')
    {
        $SQL = "SELECT id
        , special_from_date
        , special_to_date
        , tax_class_id
        , price
        , special_price
        , IF(NOW() BETWEEN special_from_date AND special_to_date, 1, 0) AS is_special

        , `name`
        , manage_stock
        , qty
        , min_sale_qty
        , max_sale_qty
        , is_in_stock
        , status
        FROM products WHERE id='{$product_id}' " . $where;
        $product = $this->db->query($SQL)->row();

        if ($product->is_special) {
            $price = $product->special_price;
        } else {
            $price = $product->price;
        }
        $product->amount = $price;

        return $product;
    }

    /**
     * @param $product_id
     * @param int $qty
     * @param string $type
     */
    function update_stock($product_id, $qty = 0, $type = 'sale')
    {
        $SQL = "SELECT id
        , `name`
        , manage_stock
        , qty
        FROM products WHERE id='{$product_id}' ";

        $product = $this->db->query($SQL)->row();

        if ($product->manage_stock/* && $qty > 0*/) {
            if ($type == 'sale') {
                save('products', array('qty' => ($product->qty - $qty)), "id='{$product_id}'");
            } else {
                save('products', array('qty' => ($product->qty + $qty)), "id='{$product_id}'");
            }
        }
    }

    /*
     *
     */
    function get_product_attributes($product_id, $where = '', $sep = ', ', $return_attr_code_key = false)
    {

        if ($product_id > 0) {
            $where .= " AND product_attributes_rel.product_id='{$product_id}'";
        }
        $SQL = "SELECT
            attributes.*
            , GROUP_CONCAT(DISTINCT product_attributes_rel.attr_value_id SEPARATOR '" . $sep . "')AS attr_ids
            , GROUP_CONCAT(DISTINCT
              IF(product_attributes_rel.attr_value_id > 0,
              IF(attributes_option_values_rel.frontend_value = '', attributes_option_values_rel.admin_value, attributes_option_values_rel.frontend_value)
              , product_attributes_rel.attr_value)
              SEPARATOR '" . $sep . "')AS attr_value

            , IF(attributes.frontend_label = '', attributes.admin_label, attributes.frontend_label) as attr_label

            , IF(attributes.frontend_label = '', attributes.admin_label, attributes.frontend_label) as attr_label
            , attributes.admin_label
            , attributes.frontend_label

            , attributes_option_values_rel.admin_value
            , attributes_option_values_rel.frontend_value
            , attributes_option_values_rel.position
            , IF(attribute_sets.set_title IS NULL, 'Other', attribute_sets.set_title) as set_title
            , attribute_groups.group_name
        FROM product_attributes_rel
            INNER JOIN attributes
                ON (product_attributes_rel.attribute_id = attributes.id)
            LEFT JOIN attributes_option_values_rel
                ON (product_attributes_rel.attr_value_id = attributes_option_values_rel.attr_value_id)
            LEFT JOIN attribute_sets
                ON (attributes.attribute_set_id = attribute_sets.id)
            LEFT JOIN attribute_group_rel
                ON (attributes.id = attribute_group_rel.attribute_id)
            LEFT JOIN attribute_groups
                ON (attribute_group_rel.attribute_group_id = attribute_groups.id)
        WHERE 1 {$where}
        GROUP BY attributes.id
        ORDER BY attributes.`position`, set_title, attr_label ASC";

        $attributes = $this->db->query($SQL)->result();
        if ($return_attr_code_key && count($attributes) > 0) {
            $new_attrs = array();
            foreach ($attributes as $attribute) {
                $new_attrs[$attribute->attribute_code] = $attribute;
            }
            $attributes = $new_attrs;
        }

        return $attributes;
    }

    function get_filter_attributes($where = '')
    {
        $SQL = "SELECT DISTINCT
            attributes.id
            , product_attributes_rel.attr_value_id
            , 'attr' AS `type`
            , attributes.admin_label
            , attributes.frontend_label
            , attributes_option_values_rel.extra
            , IF(attributes.frontend_label = '', attributes.admin_label, attributes.frontend_label) as attr_label

            , IF(product_attributes_rel.attr_value_id > 0, attributes_option_values_rel.frontend_value, product_attributes_rel.attr_value) AS attr_val

            , IF(product_attributes_rel.attr_value_id > 0,
              IF(attributes_option_values_rel.frontend_value = '', attributes_option_values_rel.admin_value, attributes_option_values_rel.frontend_value)
              , product_attributes_rel.attr_value) AS attr_value

            , COUNT(DISTINCT products.id) AS total_count
            FROM products
              LEFT JOIN product_attributes_rel ON (product_attributes_rel.product_id = products.id)
              LEFT JOIN attributes ON (attributes.id = product_attributes_rel.attribute_id)
              LEFT JOIN attributes_option_values_rel ON (product_attributes_rel.attr_value_id = attributes_option_values_rel.attr_value_id)
              LEFT JOIN product_cat_rel ON (product_cat_rel.product_id = product_attributes_rel.product_id)
        WHERE 1 {$where}
        GROUP BY attributes_option_values_rel.attr_value_id, attr_value
        HAVING total_count > 0
        ORDER BY attributes.position, attributes_option_values_rel.position, attr_val ASC";

        $attributes = $this->db->query($SQL)->result();
        //echo '<pre>';print_r($this->db->last_query());echo '</pre>';
        $_attributes = array();
        if (count($attributes) > 0) {
            foreach ($attributes as $attr) {
                $_attributes[$attr->id][] = $attr;
            }
        }
        return $_attributes;
    }

    /**
     * @param $product_id
     * @return mixed
     */
    function get_product_images($product_id)
    {

        $SQL = "SELECT * FROM product_images WHERE product_id='" . intval($product_id) . "' ORDER BY `default` DESC,`thumb` DESC, id ASC";
        $images = $this->db->query($SQL)->result();

        return $images;
    }

    function product_rating_types($where = ''){
        $SQL = "SELECT product_rating_types.*
            , COUNT(product_rating_rel.id) AS total_reviews
            , (SUM(product_rating_rel.score)/COUNT(product_rating_rel.id)) AS total_score
        FROM product_rating_types
        LEFT JOIN product_rating_rel ON (product_rating_rel.rating_type_id = product_rating_types.id)
        LEFT JOIN product_reviews ON (product_reviews.review_id = product_rating_rel.review_id)

        WHERE product_rating_types.status='Active'
        AND product_reviews.status='Approved'
        {$where}
        GROUP BY product_rating_types.id
        ORDER BY product_rating_types.ordering ASC";
        //echo '<pre>';print_r($SQL);echo '</pre>';

        $rating_types = $this->db->query($SQL)->result();

        return $rating_types;
    }

    /**
     * @param $product_id
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    function get_product_reviews_rating($product_id, $limit = 0, $offset = 0, $counter = true)
    {

        $this->db->order_by('posted_date_time', 'DESC');
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $product_reviews = $this->db->get_where('product_reviews', array('product_id' => $product_id, 'status' => 'Approved'));

        $total_reviews = $product_reviews->num_rows();
        $total_review_points = 0;
        $data['reviews'] = $product_reviews->result();

        if ($total_reviews > 0) {
            foreach ($data['reviews'] as $reviews) {
                $total_review_points += $reviews->score;

            }
        }
        $product_ratting = '';
        $rate = round(($total_review_points / ($total_reviews * 5)) * 5);

        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rate) {
                $product_ratting .= '<img src="' . template_url('assets/img/small-star.png') . '" alt="' . $i . '"/>';
            } else {
                $product_ratting .= '<img src="' . template_url('assets/img/small-blank-star.png') . '" alt="' . $i . '"/>';
            }
        }
        $data['product_ratting_stars'] = $product_ratting;
        if ($counter) {
            $product_ratting .= ' <span class="count-reviews">' . $total_reviews . ' Reviews</span>';
        }
        $data['product_ratting'] = $product_ratting;
        $data['total_reviews'] = $total_reviews;

        return $data;
    }

    /**
     * @param object $chk_product
     * @param int $qty
     */
    function stock_validation($chk_product, $qty)
    {
        if ($chk_product->status != 'Active') {
            getFlash('error', $chk_product->name . ' is ' . $chk_product->status);
            redirectBack();
        }

        if ($chk_product->manage_stock == 'Yes') {

            if ($chk_product->is_in_stock != 'In Stock') {
                getFlash('error', $chk_product->name . ' is ' . $chk_product->is_in_stock);
                redirectBack();
            }
            if ($qty > $chk_product->qty) {
                getFlash('error', $chk_product->name . ' available qty is ' . $chk_product->qty);
                redirectBack();
            }
            if ($qty < $chk_product->min_sale_qty && $chk_product->min_sale_qty > 0) {
                getFlash('error', $chk_product->name . ' minimum sale qty is ' . $chk_product->min_sale_qty);
                redirectBack();
            }

            if ($qty > $chk_product->max_sale_qty && $chk_product->max_sale_qty > 0) {
                getFlash('error', $chk_product->name . ' maximum sale qty is ' . $chk_product->max_sale_qty);
                redirectBack();
            }

            $order_id = getSession('customer_order_id');
            $customer_login = getSession('customer_login');
            $customer_id = getSession($this->session_user);

            if($customer_login && CHK_MAX_QTY){

                $max_sale_qty = $chk_product->max_sale_qty;
                $total_qty = $this->validate_max_qty($customer_id, $chk_product->id, $chk_product->max_sale_qty);
                $cart_qty = intval($this->db->select('order_details.qty')->get_where('order_details', array('order_id' => $order_id, 'product_id' => $chk_product->id))->row()->qty);
                $purchased_qty = ($total_qty - $cart_qty);

                if(getUri('2') == 'update_cart'){
                    $total_qty = ($purchased_qty + $qty);
                }else{
                    $total_qty += ($qty);
                }

                /*echo '<pre>total_qty: ';print_r($total_qty);echo '</pre>';
                echo '<pre>max_sale_qty: ';print_r($max_sale_qty);echo '</pre>';
                echo '<pre>purchased_qty: ';print_r($purchased_qty);echo '</pre>';
                echo '<pre>cart_qty: ';print_r($cart_qty);echo '</pre>';
                echo '<pre>qty: ';print_r($qty);echo '</pre>';
                echo '<pre>qty: ';print_r(($qty - $cart_qty));echo '</pre>';
                die('Call');*/

                if($total_qty > $max_sale_qty){
                    getFlash('error', '<strong>' . $chk_product->name . '</strong> you have already purchased ('.($purchased_qty).' + '.$cart_qty.') qty of ' . $max_sale_qty . ($remaining > 0 ? ' remaining : '. $remaining : ''));
                    redirectBack();
                }
            }
        }
    }

    function validate_max_qty($customer_id, $product_id, $max_sale_qty){
        $SQL = "SELECT SUM(qty) as total_qty FROM orders
        INNER JOIN order_details ON (order_details.order_id = orders.id)
        WHERE orders.customer_id='{$customer_id}' AND order_details.product_id='{$product_id}'";
        return $total_qty = $this->db->query($SQL)->row()->total_qty;

    }

    /**
     * @param int $order_id
     * @param string $where
     * @return mixed
     */
    function cart_detail($order_id = 0, $where = '')
    {
        if ($order_id <= 0) {
            $order_id = getSession('customer_order_id');
        }
        if ($order_id > 0) {
            $where .= " AND order_details.order_id='{$order_id}'";

            $products_sql = "SELECT
                        order_details.id as did
                        , products.id as product_id
                        , products.name
                        , products.sku
                        , products.name as title
                        , (SELECT image FROM `product_images` WHERE `product_id`=products.id ORDER BY `default` DESC,product_images.id ASC LIMIT 1) as image
                        , order_details.qty
                        , order_details.price
                        , (products.weight * order_details.qty) as total_weight
                        , (order_details.price * order_details.qty) as subtotal

                        , GROUP_CONCAT(CONCAT(attributes.admin_label, ': ', order_attributes.`attr_value`) SEPARATOR ', ') AS attributes";
            if(IS_BRAND) {
                $products_sql .= " , brands.title AS brand ";
            }
            $products_sql .="FROM order_details
                        INNER JOIN products ON (order_details.product_id = products.id)";
            if(IS_BRAND) {
                $products_sql .= " LEFT JOIN brands ON (brands.id = products.brand_id)";
            }
            $products_sql .= "LEFT JOIN order_attributes ON (order_attributes.order_detail_id = order_details.id AND order_attributes.product_id=order_details.product_id)
                        LEFT JOIN attributes ON (attributes.id = order_attributes.attr_id)
                    WHERE 1 " . $where;
            if(!UPDATE_CART){
                $products_sql .= " GROUP BY order_details.id,products.id";
            }else{
                $products_sql .= " GROUP BY products.id";
            }

            //echo '<pre>';print_r($products_sql);echo '</pre>';
            $products = $this->db->query($products_sql)->result();

            return $products;
        }
    }

    /**
     * @param $order_id
     * @param string $where
     * @return mixed
     */
    function order_detail($order_id, $where = '')
    {
        return $this->cart_detail($order_id, $where);
    }

    /**
     * @param int $order_id
     * @param bool|false $coupon_rules
     * @return stdClass
     */
    function total($order_id = 0, $coupon_rules = false)
    {
        if ($order_id <= 0) {
            $order_id = getSession('customer_order_id');
        }

        $total = 0;
        $total_product = 0;
        $total_weight = 0;
        $coupon_id = 0;

        $order = $this->db->get_where('orders', array('id' => $order_id), 1)->row();
        if ($order_id > 0) {
            $coupon_id = $order->coupon_id;
            $products = $this->cart_detail($order_id);
            if (count($products) > 0) {
                foreach ($products as $product) {
                    $total += $product->subtotal;
                    $total_product += $product->qty;
                    $total_weight += $product->total_weight;
                }
            }
        }

        $data = new stdClass();
        $data->coupon_id = $coupon_id;
        $data->amount = $total;
        $data->qty = $total_product;
        $data->total_weight = $total_weight;
        $data->discount = $order->discount;

        if($coupon_rules){
            $this->load->model(ADMIN_DIR . 'm_coupons');
            $shipping_dtl = unserialize(get_option('shipping'));
            $rule = $this->m_coupons->validate_rules($order_id);
            $data->shipping_amount = (($rule->free_shipping) ? 0 : $shipping_dtl['amount']);
            $data->discount += $rule->discount;
        }
        $data->total_amount = ($data->amount + $data->shipping_amount - $data->discount);

        return $data;

    }

}