<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Product_catalog
 * @property Template $template
 * @property Catalog $catalog
 */
class Product_catalog extends CI_Controller
{
    var $is_brand = false;

    function __construct()
    {

        parent::__construct();
        $this->load->helper('frontend');

    }

    public function index()
    {

        $url_segments = str_ireplace('.html', '', $this->uri->segments);
        $brand_uri = $url_segments[1];

        $categories = array();
        if (count($url_segments) > 0) {

            foreach ($url_segments as $k => $url_segment) {
                if ($k == 1 && IS_BRAND) {
                    $catalog_type = 'brand';
                    $brand = $this->db->get_where('brands', array('status' => 'Active', 'friendly_url' => $brand_uri), 1)->row();
                }
                if($catalog_type == 'brand' && $brand->friendly_url != $url_segment){
                    $catalog_type = '404';
                }

                $chk_cat = $this->db->select('*')->get_where('categories', array('status' => 'Active', 'friendly_url' => $url_segment));
                if ($chk_cat->num_rows > 0) {
                    $catalog_type = 'categories';
                    $categories[] = $chk_cat->row();
                } else {
                    $chk_product = $this->db->select('id')->get_where('products', array('status' => 'Active', 'friendly_url' => $url_segment));
                    if ($chk_product->num_rows > 0) {
                        $catalog_type = 'product';
                        $product_id = $chk_product->row()->id;
                    }
                    if($catalog_type == 'categories' && $categories[0]->friendly_url != $url_segment){
                        $catalog_type = '404';
                    }
                }

            }
        }
        if (!IS_BRAND) {
            $brand = 0;
        }

        if ($catalog_type == 'brand' && IS_BRAND) {
            $this->brand($brand);
        } elseif ($catalog_type == 'categories') {
            $this->categories($brand, $categories);
        } elseif ($catalog_type == 'product') {
            $this->product($brand, $categories, $product_id);
        } else {
            $this->template->error_404();
        }
    }

    /**
     * @param $brand Object
     */
    function brand($brand)
    {
        $data['brand'] = $brand;
        $this->breadcrumb->add_item($brand->title, '');

        $this->template->set_site_title($data['category']->meta_title);
        $this->template->meta('keywords', $data['category']->meta_keywords);
        $this->template->meta('description', $data['category']->meta_description);

        $this->categories($brand, null);
        /*$data['sub_categories'] = $this->catalog->get_brand_categories($brand->id);
        $data['parent_url'] = get_parent_url($data);
        $this->template->load('categories', $data);*/
    }


    /**
     * @param $brand Object
     * @param $categories Object
     */
    function categories($brand, $categories)
    {
        if (IS_BRAND && $brand->id > 0) {
            $data['brand'] = $brand;
            $this->breadcrumb->add_item($brand->title, site_url($brand->friendly_url . get_option('url_ext')));
        }

        if (count($categories) > 0) {

            $category = end($categories);
            $data['category'] = $category;
            $where = "AND parent_id=" . $category->id;
            # Meta
            $this->template->set_site_title($data['category']->meta_title);
            $this->template->meta('keywords', $data['category']->meta_keywords);
            $this->template->meta('description', $data['category']->meta_description);

            foreach ($categories as $_cat) {
                if ($_cat->friendly_url != $category->friendly_url) {
                    $data['parent_categories'][] = $_cat;
                }
                $this->breadcrumb->add_item($_cat->title, site_url($brand->friendly_url . '/' . $_cat->friendly_url . get_option('url_ext')));
            }
        }

        $data['sub_categories'] = $this->catalog->get_categories($where);
        $data['categories_ids'] = $this->catalog->get_categories_ids(array_merge((array)$data['sub_categories'], array((array)$category)));


        /*if (count($data['sub_categories']) > 0) {

            $data['parent_url'] = get_parent_url($data);
            $this->template->load('categories', $data);
        } else*/
        {
            $where = " AND products.visibility IN('Catalog', 'Catalog - Search')";
            # Category Products
            $order_by = '';
            $limit = 20;
            $offset = 0;
            if (getVar('limit') > 0) {
                $limit = intval(getVar('limit'));
            }
            if (getVar('per_page') > 0) {
                $offset = intval(getVar('per_page'));
            }
            if (getVar('order') != '') {
                $order_by = getVar('order') . ' ' . (getVar('dir') == '' ? 'DESC' : getVar('dir'));
            }
            $data['limit'] = $limit;

            //$where = "AND product_cat_rel.category_id=" . $category->id;

            $filter_clause = $this->catalog->get_filter_clause();

            if (IS_BRAND && $brand->id > 0) {
                $where .= " AND products.brand_id=" . $brand->id;
            } else if (IS_BRAND) {
                $brand_filter = $this->catalog->get_brands_for_filter($data['categories_ids']);
            }
            $categories_filter = $this->catalog->get_categories_for_filter($category->id, $where);
            if (!isset($filter_clause['categories_clause'])) {
                //$categories_filter = $this->catalog->get_categories_for_filter($filter_clause['categories_clause']);
                //$categories_filter = $this->catalog->get_categories_for_filter($category->id, $where);
                $where .= " AND product_cat_rel.category_id IN (" . join(',', $data['categories_ids']) . ")";
            }

            $data['products'] = $this->catalog->get_products($where . $filter_clause['filter_clause'], $order_by, $limit, $offset, array('images', 'brands', 'categories'));
            //echo '<pre>';print_r($this->db->last_query());echo '</pre>'; die('Call');
            //$total_record = $this->db->found_rows();
            $total_record = $this->db->query("SELECT FOUND_ROWS() as total")->row()->total;

            $data['parent_url'] = get_parent_url($data);
            $_WHERE_CAT = $where;
            $attributes_filte = $this->catalog->get_filter_attributes("AND products.status='Active' AND attributes.used_in_filtering='Yes'" . $_WHERE_CAT . $filter_clause['filter_clause']);
            $data['filtering_attributes'] = array_merge((array)$brand_filter, (array)$categories_filter, (array)$attributes_filte);
            //echo '<pre>';print_r($this->db->last_query());echo '</pre>';

            /**
             * pagination
             */
            $config['base_url'] = generate_url('per_page');
            $config['total_rows'] = $total_record;
            $config['per_page'] = $limit;
            $config['page_query_string'] = TRUE;

            $choice = $config["total_rows"] / $config["per_page"];
            $config["total_links"] = ceil($choice);
            $config["num_links"] = 6;

            $config['full_tag_open'] = '<div class="page-numbers">';
            $config['full_tag_close'] = '</div>';

            $config['first_tag_open'] = '<div class="page -prev">';
            $config['first_tag_close'] = '</div>';
            $config['prev_tag_open'] = '<div class="page -prev">';
            $config['prev_tag_close'] = '</div>';
            $config['prev_link'] = 'Prev';

            $config['next_link'] = 'Next';
            $config['next_tag_open'] = '<div class="page -next">';
            $config['next_tag_close'] = '</div>';
            $config['last_tag_open'] = '<div class="page -last">';
            $config['last_tag_close'] = '</div>';

            $config['num_tag_open'] = '<div class="page">';
            $config['num_tag_close'] = '</div>';
            $config['cur_tag_open'] = '<div class="page current">';
            $config['cur_tag_close'] = '</div>';

            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $this->template->load('listing', $data);
        }

    }


    /**
     * @param $brand Object
     * @param $catgories Object
     * @param $product_id int
     */
    function product($brand, $catgories, $product_id)
    {
        if (IS_BRAND) {
            $data['brand'] = $brand;
            $this->breadcrumb->add_item($brand->title, site_url($brand->friendly_url . get_option('url_ext')));
            //$this->breadcrumb->add_item($brand->title, '');
        }

        $catgory = end($catgories);
        $data['category'] = $catgory;

        foreach ($catgories as $_cat) {
            if ($_cat->friendly_url != $catgory->friendly_url) {
                $data['parent_categories'][] = $_cat;
            }
            $this->breadcrumb->add_item($_cat->title, site_url($brand->friendly_url . '/' . $_cat->friendly_url . get_option('url_ext')));
        }

        $data['sub_categories'] = $this->catalog->get_categories("AND parent_id=" . $catgory->id);
        if (count($data['sub_categories']) > 0) {
            $data['parent_url'] = get_parent_url($data);

            //$this->template->load('category', $data);
        }

        $products = $this->catalog->get_products("AND products.id=" . $product_id);
        $data['product'] = $products[0];
        if ($data['product']->brand_id) {
            $data['brand'] = $this->db->get_where('brands', array('id' => $data['product']->brand_id), 1)->row();
        }

        $data['images'] = $this->catalog->get_product_images($product_id);
        $_img = asset_url('front/products/' . $data['images'][0]->image);
        list($img_width, $img_height, $img_type, $img_attr) = getimagesize($_img);

        # Meta
        $this->template->set_site_title($data['product']->meta_title);
        $this->template->meta('keywords', $data['product']->meta_keywords);
        $this->template->meta('description', $data['product']->meta_description);

        # FB Meta
        $this->template->meta('og:title', $data['product']->meta_title);
        $this->template->meta('og:description', $data['product']->meta_description);
        $this->template->meta('og:type', 'article');
        $this->template->meta('og:url', current_url());
        $this->template->meta('og:image', $_img);
        $this->template->meta('og:image:type', image_type_to_mime_type($img_type));
        $this->template->meta('og:image:width', $img_width);
        $this->template->meta('og:image:height', $img_height);

        # Twitter Meta
        $this->template->meta('twitter:card', 'photo');
        $this->template->meta('twitter:title', $data['product']->meta_title);
        $this->template->meta('twitter:description', $data['product']->meta_description);
        $this->template->meta('twitter:site', '@inovipk');
        $this->template->meta('twitter:creator', '@inovipk');
        $this->template->meta('twitter:image:src', $_img);
        $this->template->meta('twitter:image:width', $img_width);
        $this->template->meta('twitter:image:height', $img_height);


        #product_attributes
        $data['attributes'] = $this->catalog->get_product_attributes($product_id, '', ',', true);//, "AND attributes.is_visible_on_front='Yes'"
        $data['related_products'] = $this->catalog->get_products("AND products.id IN(SELECT product_id FROM related_products WHERE related_product_id='{$product_id}')", '', 0, 0, array('images', 'brands', 'categories'));

        #reviews_rating
        $data['product_rating_types'] = $this->catalog->product_rating_types();
        $data['product_reviews'] = $this->catalog->get_product_reviews_rating($product_id);

        $this->breadcrumb->add_item($data['product']->name, site_url($data['product']->friendly_url . get_option('url_ext')));
        $this->template->load('detail', $data);
    }


    /**
     * @param $brand Object
     * @param $catgories Object
     */
    function search()
    {
        $_where = '';

        $q = getVar('q');
        $cat = getVar('cat');

        if ($cat > 0) {
            $catgory = $this->db->select('*')->get_where('categories', array('status' => 'Active', 'id' => $cat), 1)->row();
            $data['child_cats'] = $this->catalog->get_categories("AND parent_id={$cat}");
            $child_cat_ids = array_keys($data['child_cats']);
            $child_cat_ids = array_merge(array($cat), $child_cat_ids);

            if (IS_BRAND) {
                $brand = $this->db->get_where('brands', array('status' => 'Active', 'id' => $catgory->brand_id), 1)->row();
                $data['brand'] = $brand;
                $_where .= " AND products.brand_id='{$brand->id}'";
            }
            $_where .= " AND product_cat_rel.category_id IN(" . join(',', $child_cat_ids) . ")";
        }

        $this->breadcrumb->add_item('Search results for: ' . $q);

        # Meta
        $this->template->set_site_title('Search results for: ' . $q);


        # Category Products
        $order_by = '';
        $limit = 20;
        $offset = 0;
        if (getVar('limit') > 0) {
            $limit = intval(getVar('limit'));
        }
        if (getVar('per_page') > 0) {
            $offset = intval(getVar('per_page'));
        }
        if (getVar('order') != '') {
            $order_by = getVar('order') . ' ' . (getVar('dir') == '' ? 'DESC' : getVar('dir'));
        }
        $data['limit'] = $limit;
        # Category Products
        $_where .= " AND products.name LIKE '%{$q}%'";
        $_where .= " AND products.visibility IN('Search', 'Catalog - Search')";
        $data['products'] = $this->catalog->get_products($_where, $order_by, $limit, $offset, array('images', 'brands', 'categories'));
        //$total_record = $this->db->found_rows();
        $data['total_record'] = $total_record = $this->db->query("SELECT FOUND_ROWS() as total")->row()->total;

        /**
         * pagination
         */
        $config['base_url'] = generate_url('per_page');
        $config['total_rows'] = $total_record;
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;

        $choice = $config["total_rows"] / $config["per_page"];
        $config["total_links"] = ceil($choice);
        $config["num_links"] = 6;

        $config['full_tag_open'] = '<div class="page-numbers">';
        $config['full_tag_close'] = '</div>';

        $config['first_tag_open'] = '<div class="page -prev">';
        $config['first_tag_close'] = '</div>';
        $config['prev_tag_open'] = '<div class="page -prev">';
        $config['prev_tag_close'] = '</div>';
        $config['prev_link'] = 'Prev';

        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<div class="page -next">';
        $config['next_tag_close'] = '</div>';
        $config['last_tag_open'] = '<div class="page -last">';
        $config['last_tag_close'] = '</div>';

        $config['num_tag_open'] = '<div class="page">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div class="page current">';
        $config['cur_tag_close'] = '</div>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();


        $this->template->load('search_result', $data);


    }

    function submit_reviews()
    {
        $score = getVar('score', true, false);

        $rating = (array_sum($score) / count($score)); // get average value;

        $RQ_Data = getDbArray('product_reviews');
        $dbData = $RQ_Data['dbdata'];

        $dbData += array(
            'rating' => $rating,
            'customer_id' => intval(getSession('customer_user_id')),
            'customer_ip' => $this->input->server('REMOTE_ADDR'),
            'customer_user_agent' => $this->input->server('HTTP_USER_AGENT')
        );

        $id = save('product_reviews', $dbData);
        if (count($score) > 0) {
            foreach ($score as $rating_type_id =>  $rating) {
                save('product_rating_rel', array(
                    'review_id' => $id,
                    'product_id' => $dbData['product_id'],
                    'rating_type_id' => $rating_type_id,
                    'score' => $rating,
                ));
            }
        }

        $this->session->set_flashdata('success', 'Review has been submitted.');

        redirectBack();
    }

    function submit_question()
    {
        $RQ_Data = getDbArray('product_question');
        $dbData = $RQ_Data['dbdata'];

        $dbData += array(
            'customer_id' => intval(getSession('customer_user_id')),
            'customer_ip' => $this->input->server('REMOTE_ADDR'),
            'customer_user_agent' => $this->input->server('HTTP_USER_AGENT')
        );

        $id = save('product_question', $dbData);

        $this->session->set_flashdata('success', 'Your question has been submitted.');

        redirectBack();
    }

}

/* End of file thumbs.php */
/* Location: ./application/controllers/thumbs.php */