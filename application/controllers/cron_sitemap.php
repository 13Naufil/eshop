<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cron_sitemap extends CI_Controller
{
    var $start = 0;
    var $limit = 500;

    var $level = 1;
    var $file_name = 'db%d-sitemap.xml';

    var $images = true;

    function __construct()
    {
        set_time_limit(60 * 20);
        ini_set('memory_limit', '256M');

        parent::__construct();
    }


    function index()
    {
        $this->sitemap(1);

        $XML = '<?xml version="1.0" encoding="UTF-8"?>
        <?xml-stylesheet type="text/xsl" href="' . base_url('sitemaps/main-sitemap.xsl') . '"?>
        <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $root_dir = dirname(__FILE__) . '/../../';
        foreach (glob($root_dir . 'sitemaps/*.xml') as $xml_file) {
            $file_name = end(explode('/', $xml_file));
            $XML .= '<sitemap>
                    <loc>' . base_url('sitemaps/' . $file_name) . '</loc>
                    <lastmod>' . date(DATE_ATOM) . '</lastmod>
                </sitemap>';
        }
        $XML .= '</sitemapindex>';

        $full_file_name = $root_dir . 'db-sitemap_index.xml';
        @unlink($full_file_name);
        file_put_contents($full_file_name, $XML);
    }


    function sitemap($level = 1)
    {
        $this->level = $level;
        if ($this->level > 1) {
            $this->start = (($this->level - 1) * $this->limit);
        }

        $this->db->select('SQL_CALC_FOUND_ROWS id, title, friendly_URL', false)->from('products')->where(array('status' => 'Active'));
        $this->db->limit($this->limit, $this->start);
        $dogs_rs = $this->db->get();


        $total_rows = $this->db->found_rows();
        $num_rows = $dogs_rs->num_rows();

        $file_name = sprintf($this->file_name, $this->level);
        $full_file_name = dirname(__FILE__) . '/../../sitemaps/' . $file_name;
        @unlink($full_file_name);


        $XML = '<?xml version="1.0" encoding="UTF-8"?>
        <?xml-stylesheet type="text/xsl" href="' . base_url('sitemaps/main-sitemap.xsl') . '"?>
        <urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
                xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
                xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        file_put_contents($full_file_name, $XML, FILE_APPEND);

        if ($num_rows > 0) {
            $dogs = $dogs_rs->result();
            foreach ($dogs as $product) {

                $XML = '<url>
                        <loc>' . site_url('dog/' . $product->id . '-' . $product->friendly_URL) . '</loc>
                        <lastmod>' . date(DATE_ATOM) . '</lastmod>
                        <changefreq>weekly</changefreq>
                        <priority>0.8</priority>' . "\n";
                                    file_put_contents($full_file_name, $XML, FILE_APPEND);

                                    if ($this->images) {
                                        $images = $this->db->select('image')->from('product_images')->where(array('dog_id' => $product->id))->order_by('default', 'DESC')->get()->result();
                                        if (count($images) > 0) {
                                            foreach ($images as $image) {
                                                $XML = '    <image:image>
                            <image:loc>' . base_url('assets/front/dogs/' . $product->id . '/' . $image->image) . '</image:loc>
                            <image:caption><![CDATA[' . $product->title . ']]></image:caption>
                        </image:image>' . "\n";
                            file_put_contents($full_file_name, $XML, FILE_APPEND);
                        }
                    }
                }
                $XML = '</url>' . "\n";
                file_put_contents($full_file_name, $XML, FILE_APPEND);
            }
            $XML = '</urlset>' . "\n";
            file_put_contents($full_file_name, $XML, FILE_APPEND);

            if ($total_rows > ($this->start + $this->limit)) {
                $this->sitemap(($this->level + 1));
            }
        }
    }

}

/* End of file cron_membership_renewal.php */
/* Location: ./application/controllers/cron_membership_renewal.php */