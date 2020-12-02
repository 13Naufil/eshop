<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Index
 * @property Cms $cms
 */
class Blog extends CI_Controller
{
    var $_MEMBERDATA = null;
    var $_LOGGEDIN = null;
    var $_SOURCE = null;

    function __construct()
    {
        parent::__construct();
        $this->load->helper('frontend');
        $this->load->model('cms');

        /*if ($this->session->userdata('_LOGGEDIN')) {
            $this->_MEMBERDATA = $this->session->userdata('_MEMBERDATA');
            $this->_SOURCE = $this->session->userdata('source');
            $this->_LOGGEDIN = $this->session->userdata('_LOGGEDIN');
        }*/

        $this->load->library('pagination');

    }




    public function index()
    {
        $type = getUri(2);
        $meta = getUri(3);

        $where = '';
        $offset_limit = 0;
        $limit = 12;

        if ($type == 'page' && $meta > 0) {
            $offset_limit = $meta;
        }
        if ($type == 'category') {
            $data['type'] = 'category';
            $where .= " AND bc.slug = '" . dbEscape($meta) . "'";
        }else if ($type == 'tag') {
            $where .= " AND bt.slug = '" . dbEscape($meta) . "'";
        }else if (strlen($type) == 4 && strlen($meta) == 2 && !is_string($meta) && !is_string($type)) {
            $where .= " AND DATE_FORMAT(bp.datetime,'%Y-%m') = '" . dbEscape(getUri(2) . '-' . getUri(3)) . "'";
        }else if (!empty($type) && !empty($meta) && !in_array($type, array('page', 'archive', 'category', 'tag'))) {
            $data['type'] = 'post';
            $this->single_post();
            return;
            //$where .= " AND bc.slug = '" . dbEscape($type) . "' AND bp.slug='".dbEscape($meta)."' ";
        }

        $sql_post = "SELECT SQL_CALC_FOUND_ROWS
          bp.*,
          bc.slug as category_slug,
          bc.category AS category, 
          GROUP_CONCAT(DISTINCT CONCAT(' <a href=\"" . site_url() . "blog/category/',bc.slug,'\">',bc.category,'</a>')) AS categories,
          GROUP_CONCAT(DISTINCT CONCAT(' <a href=\"" . site_url() . "blog/tag/',bt.slug,'\">',bt.tags,'</a>')) AS tags
        
        FROM blog_posts AS bp
          LEFT JOIN blog_relations AS br ON (bp.id = br.post_id)
          LEFT JOIN blog_categories AS bc ON (br.id = bc.id AND br.rel_type='categories')
          LEFT JOIN blog_tags AS bt ON (br.id = bt.id AND br.rel_type='tags')
        WHERE `status`='publish' " . $where . "
        GROUP BY bp.id
        ORDER BY bp.datetime DESC LIMIT $offset_limit,$limit";

        $data['posts'] = $this->db->query($sql_post)->result();


        $total_record = $this->db->query("SELECT FOUND_ROWS() as total")->row()->total;

        $config['base_url'] = site_url() . 'blog/page/';
        $config['total_rows'] = $total_record;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();


        $blog_page_id = get_option('blog_page');
        $data['page'] = get_page($blog_page_id);
        $data['author'] = get_member($data['page']->created_by);

        switch ($type){
            case 'category':
                $data['page']->meta_title = $data['page']->title = $data['posts'][0]->category;
                break;
        }

        $this->template->set_site_title($data['page']->meta_title);
        $this->template->meta('keywords', $data['page']->meta_keywords);
        $this->template->meta('description', $data['page']->meta_description);


        $template = (in_array($data['page']->template, ['', 'default']) ? 'blog/listing' : $data['page']->template);

        $this->template->load($template, $data);
    }

    function single_post(){

        $cat = getUri(2);
        $url = getUri(3);

        $where = " AND bc.slug = '" . dbEscape($cat) . "' AND bp.slug='".dbEscape($url)."' ";

        $sql_post = "SELECT SQL_CALC_FOUND_ROWS
          bp.*,
          bc.slug as category_slug,
          GROUP_CONCAT(DISTINCT CONCAT(' <a href=\"" . site_url() . "blog/category/',bc.slug,'\">',bc.category,'</a>')) AS categories,
          GROUP_CONCAT(DISTINCT CONCAT(' <a href=\"" . site_url() . "blog/tag/',bt.slug,'\">',bt.tags,'</a>')) AS tags
        
        FROM blog_posts AS bp
          LEFT JOIN blog_relations AS br ON (bp.id = br.post_id)
          LEFT JOIN blog_categories AS bc ON (br.id = bc.id AND br.rel_type='categories')
          LEFT JOIN blog_tags AS bt ON (br.id = bt.id AND br.rel_type='tags')
        WHERE `status`='publish' " . $where . "
        GROUP BY bp.id
        ORDER BY bp.datetime DESC LIMIT 1";

        $data['post'] = $this->db->query($sql_post)->row();
        $data['author'] = get_member($data['post']->created_by);


        $this->db->query("UPDATE `blog_posts` SET `view_count` = (view_count + 1) WHERE `id` = '{$data['post']->id}'");

        $_SQL = "SELECT DISTINCT
    blog_posts.id
    , blog_posts.title
    , blog_posts.slug
    , blog_posts.view_count
    , blog_categories.category
    , blog_categories.slug AS category_slug
FROM blog_posts
    LEFT JOIN blog_relations ON (blog_posts.id = blog_relations.post_id)
    LEFT JOIN blog_categories AS bc ON (blog_relations.id = bc.id AND blog_relations.rel_type='categories')
    LEFT JOIN blog_categories ON (blog_relations.id = blog_categories.id)";

        $Recent_SQL = $_SQL . " GROUP BY blog_posts.id ORDER BY blog_posts.datetime DESC LIMIT 5";
        $data['recent'] = $this->db->query($Recent_SQL)->result();

        $Popular_SQL = $_SQL . " GROUP BY blog_posts.id ORDER BY blog_posts.view_count DESC LIMIT 5";
        $data['Popular'] = $this->db->query($Popular_SQL)->result();


        //echo '<pre>';print_r($data);echo '</pre>';

        $this->template->set_site_title($data['post']->meta_title);
        $this->template->meta('keywords', $data['post']->meta_keywords);
        $this->template->meta('description', $data['post']->meta_description);


        $img = 'front/blog_imgs/' . $data['post']->featured_image;
        list($width, $height, $type, $attr) = getimagesize(ASSETS_DIR . $img);
        $this->template->meta('og:title', $data['post']->meta_title);
        $this->template->meta('og:description', $data['post']->meta_description);
        $this->template->meta('og:type', 'website');//$data['page']->type
        $this->template->meta('og:url', current_url());
        //$this->template->meta('og:url', current_url());
        $this->template->meta('og:image', asset_url($img));
        $this->template->meta('og:image:type', $type);
        $this->template->meta('og:image:width', $width);
        $this->template->meta('og:image:height', $height);
        /*  Twitter */
        $this->template->meta('twitter:card', 'summary');
        $this->template->meta('twitter:title', $data['post']->meta_title);
        $this->template->meta('twitter:description', $data['post']->meta_description);
        $this->template->meta('twitter:image:src', asset_url($img));
        $this->template->meta('twitter:image:width', $width);
        $this->template->meta('twitter:image:height', $height);
        $this->template->meta('twitter:site', '@' . end(explode('/', get_option('twitter_url'))));
        $this->template->meta('twitter:creator', '@' . end(explode('/', get_option('twitter_url'))));

        $template = ($data['post']->template == '' ? 'blog/single_post' : $data['post']->template);

        $this->template->load($template, $data);
    }

}


/* End of file index.php */
/* Location: ./application/controllers/index.php */