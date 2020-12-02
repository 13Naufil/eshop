<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Canvas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $data = $_POST['data'];
        $file = md5(uniqid()) . '.png';

        // remove "data:image/png;base64,"
        $uri =  substr($data,strpos($data,",")+1);

        // save to file
        file_put_contents('./temp/'.$file, base64_decode($uri));

        // return the filename
        echo base_url('temp/' . $file); exit;
    }


    public function done()
    {

        $file = getVar('status');

        unlink('./temp/'.$file);

        exit;
    }



}

/* End of file gsdcp_header_footer.php */
/* Location: ./application/controllers/gsdcp_header_footer.php */