<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Breadcrumb
{
    public $crumbs = array();

    public function set_home($text, $link = null)
    {
        $this->crumbs[0] = array('text' => $text, 'link' => $link);
    }

    public function add_item($text, $link = null)
    {
        $n = count($this->crumbs) + 1;
        $this->crumbs[$n] = array('text' => $text, 'link' => $link);
    }

    public function get_items()
    {
        ksort($this->crumbs);
        return $this->crumbs;
    }

    public function display($id = '', $class = '')
    {
        $crumbs = $this->get_items();
        $last_item = count($crumbs) - 1;
        $output = '<ul id="' . $id . '" class="' . $class . '">' . PHP_EOL;
        foreach ($crumbs as $i => $item) {
            $output .= '<li class="' . ($i == $last_item ? 'active' : '') . '"><a href="' . $item['link'] . '">' . $item['text'] . '</a></li>' . PHP_EOL;
        }
        $output .= '</ul>' . PHP_EOL;
        echo $output;
    }
}

/* End of file breadcrumb.php */
/* Location: ./application/libraries/breadcrumb.php */