<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thumbs extends CI_Controller
{
    /*public function index()
	{

        $image_src = urldecode(str_replace('thumbs/', '', urldecode(uri_string())));

        $_REQUEST_URI = parse_url($this->input->server('REQUEST_URI'));
        //$_params = '&' . $_REQUEST_URI['query'];

        $_GET['src'] = base_url($image_src);
        if(!isset($_GET['f'])){
            $_GET['f'] = 'png';
        }

        include dirname(__FILE__) . '/../libraries/phpThumb/phpThumb.php';
        exit(0);
	}*/

    public function index()
	{

        $image_src = urldecode(str_replace('thumbs/', '', urldecode(uri_string())));
        $this->load->library('timthumb', array('image_src' => $image_src));
        $this->timthumb->handleErrors();
        $this->timthumb->securityChecks();
        if ($this->timthumb->tryBrowserCache()) {
            exit(0);
        }
        $this->timthumb->handleErrors();
        if (FILE_CACHE_ENABLED && $this->timthumb->tryServerCache()) {
            exit(0);
        }
        $this->timthumb->handleErrors();
        $this->timthumb->run();
        $this->timthumb->handleErrors();
        exit(0);
	}
}

/* End of file thumbs.php */
/* Location: ./application/controllers/thumbs.php */