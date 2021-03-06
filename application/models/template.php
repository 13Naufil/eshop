<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Model
{
    public $site_title;
    public $meta_data;
    private $template_data = array();

    public function __construct()
    {
        # Load Helpers
        $this->load->helper('text');

        # Site Title
        $this->site_title = get_option('site_title');
    }

    /**
     * @param $name | keywords , description or etc
     * @param $value
     */

    public function set_site_title($title, $sep = '|')
    {
        $_title = '';
        if(get_option('title_prefix') != '')
            $_title .= get_option('title_prefix') . ' ' . $sep . ' ' . $title;
        elseif(get_option('title_suffix') != '')
            $_title .= $title . ' ' . $sep . ' ' . get_option('title_suffix');
        else
            $_title = site_title($title, $sep, $seplocation);


        $this->site_title = $_title;
    }

    /**
     * @param $name | keywords , description or etc
     * @param $value
     */

    public function meta($name, $value = '')
    {
        if(!empty($value)){
            $this->meta_data[$name] = $value;
        }else{
            if(empty($this->meta_data[$name])){
                return get_option('meta_' . $name);
            }else
                return $this->meta_data[$name];
        }
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Assign Template Variable
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function assign($name, $value)
    {
        $this->template_data[$name] = $value;
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Load Template
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function load($tpl_name, $data = array())
    {
        $tpl_name = (!empty($tpl_name)) ? $tpl_name : 'index';

        $template_dir = get_template_directory(true);
        $this->load->view($template_dir . $tpl_name, array_merge($this->template_data, $data));
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Error Templates
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function error_403()
    {
        /*---------------------------------------------------------------------------------------*/
        $where = " AND friendly_url='403'";
        $data['page'] = get_page(null, $where);

        $this->site_title = $data['page']->meta_title;
        $this->meta('keywords', $data['page']->meta_keywords);
        $this->meta('description', $data['page']->meta_description);
        /*---------------------------------------------------------------------------------------*/
        if (is_array($data['page']) && count($data['page']) > 0) {

        } else {
            $page = new stdClass();
            $page->show_title = true;
            $page->title = $data['page']->title;

            $page->content = $data['page']->content;
            $data['page'] = $page;

            /*$this->site_title = $page->title = "403 Access Forbidden";
            $page->content = "Sorry, you do not have privileges to access this page.";*/


            $template_dir = get_template_directory(true);
            $this->load->view($template_dir . 'page', array_merge($this->template_data, $data));
        }
        $this->output->_display();
        exit;
    }

    public function error_404()
    {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        /*---------------------------------------------------------------------------------------*/
        $where = " AND friendly_url='404'";
        $data['page'] = get_page(null, $where);

        $this->site_title = $data['page']->meta_title;
        $this->meta('keywords', $data['page']->meta_keywords);
        $this->meta('description', $data['page']->meta_description);
        /*---------------------------------------------------------------------------------------*/

        $page = new stdClass();
        $page->show_title = true;
        $page->title = $data['page']->title;

        $page->content = $data['page']->content;
        $data['page'] = $page;

        $template_dir = get_template_directory(true);
        $this->load->view($template_dir . 'page', array_merge($this->template_data, $data));

        $this->output->_display();
        exit;
    }
}

/* End of file template.php */
/* Location: ./application/models/template.php */
