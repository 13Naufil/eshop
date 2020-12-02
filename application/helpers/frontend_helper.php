<?php
/**
 * Adnan Bashir
 * Email:  developer.adnan@gmail.com

 */

$ci = &get_instance();
$ci->load->model('template');


/**
 * @param $title
 * @param string $sep |
 * @param string $seplocation letf |right | none
 */
function site_title($title, $sep = '|', $seplocation = 'right')
{
    if ($seplocation == 'right') {
        return $title . ' ' . $sep . ' ' . get_option('site_title');
    } else if ($seplocation == 'left') {
        return get_option('site_title') . ' ' . $sep . ' ' . $title;
    } else {
        return $title;
    }
}

/**
 * @param null $name
 */
function get_head($name = null)
{
    $ci = & get_instance();
    $name = (string)$name;
    if ('' !== $name) {
        $templates = "head-{$name}";/*.php*/
    } else {
        $templates = 'head';/*.php*/
    }

    $ci->load->view(get_template_directory(true) . $templates);
}

/**
 * @param null $name
 */
function get_header($name = null)
{
    $ci = & get_instance();

    $name = (string)$name;
    if ('' !== $name) {
        $templates = "header-{$name}";/*.php*/
    } else {
        $templates = 'header';/*.php*/
    }

    $ci->load->view(get_template_directory(true) . $templates);

}

/**
 * @param null $name
 */
function get_footer($name = null)
{
    $ci = & get_instance();

    $name = (string)$name;
    if ('' !== $name) {
        $templates = "footer-{$name}";/*.php*/
    } else {
        $templates = 'footer';/*.php*/
    }

    $ci->load->view(get_template_directory(true) . $templates);
}

/*------------------------------------------Pages----------------------------------------------------*/
function get_page($id = null, $where = '')
{
    $ci = & get_instance();
    if($id > 0){
        $where .= ' AND pages.id=' . intval($id);
    }

    $sql_pages = "SELECT pages.*,
              REPLACE(pages.content, '../../../../assets/', '".asset_url()."/') AS content,
              pages.parent_id AS page_parent_id,
              menus.id AS menu_id,
              menus.parent_id,
              menus.menu_title,
              menus.menu_link,
              IF(menus.menu_type = '', 'custom', menus.menu_type) AS menu_type,
              menus.menu_type_id,
              menus.ordering
            FROM pages
              LEFT JOIN menus ON (pages.id = menus.menu_link)
            WHERE 1 " . $where;
    return $page_row = $ci->db->query($sql_pages)->row();
}



/**
 * Retrieve the post content.
 *
 * @since 0.71
 *
 * @param string $more_link_text Optional. Content for when there is more text.
 * @param bool $stripteaser Optional. Strip teaser content before the more text. Default is false.
 * @return string
 */
function parse_content($content, $page_obj = null)
{
    $ci = &get_instance();
    $content = stripslashes($content);

    if (preg_match('/<!--more(.*?)?-->/', $content, $matches)) {
        $content = explode($matches[0], $content, 2);
        if (!empty($matches[1]) && !empty($more_link_text))
            $more_link_text = strip_tags((trim($matches[1])));

    } else {
        $content = array($content);
    }

    $output = $content;

    if (count($content) > 1) {

        if (!empty($more_link_text))

            /**
             * Filter the Read More link text.
             * @param string $more_link_element Read More link element.
             * @param string $more_link_text Read More text.
             */
            $output .= '<a href="' . get_permalink($page_obj) . "#more-{$page_obj->id}\" class=\"more-link\">$more_link_text</a>";

    }else{
        $output = $content[0];
    }

    $output = run_shortcode($output);
    return $output;
}


if(file_exists(get_template_directory() . 'shortcode_function.php')){
    $ci =& get_instance();
    $ci->load->helper('shortcodes');

    include_once get_template_directory() . 'shortcode_function.php';
}


/*------------------------------------------Other----------------------------------------------------*/



function get_nav($nav_id, $config = array(), $limit = '')
{

    $ci = get_instance();

    $ci->multilevels->id_Column = 'id';
    $ci->multilevels->title_Column = 'menu_title';
    $ci->multilevels->link_Column = 'friendly_url';

    $ci->multilevels->active_class = 'active';
    $ci->multilevels->active_link = getUri(1);

    $ci->multilevels->has_child_html = '';

    $ci->multilevels->child_li_start = "<li id='menu-{id}' class='menu-item  menu-item-{id} menu-type-{menu_type} {active_class}'>\n  <a href='{href}'>{title}</a>\n";

    $ci->multilevels->parent_li_start = "<li id='menu-{id}' class='menu-item menu-item-{id} menu-type-{menu_type} {active_class} dropdown'>\n  <a href='{href}' class='dropdown-toggle' data-toggle='dropdown' role='button'>{title}{has_child}</a>";
    $ci->multilevels->child_ul_start = "<ul class='dropdown-menu'>\n";

    $ci->multilevels->url = site_url();

    $ci->multilevels->query = "SELECT
                                m.id
                                , m.parent_id
                                , m.menu_title
                                , m.menu_type
                                , IF(m.menu_type = 'custom',m.menu_link,p.friendly_url) as friendly_url
                                , REPLACE(REPLACE(IF(m.menu_type = 'custom',m.menu_link,p.friendly_url),'-',' '),'.html','') as alt_tag
                            FROM
                                menus AS m
                                LEFT JOIN pages AS p
                                    ON (m.menu_link = p.id AND p.`status`='published')
                            WHERE m.`status`='active' AND m.menu_type_id='" . $nav_id . "' ORDER BY m.ordering ASC " . $limit;


    if (count($config) > 0) {
        foreach ($config as $key => $val) {
            if (isset($config[$key])) {
                $ci->multilevels->$key = $config[$key];
            }
        }
    }

    return $multiLevelComponents = $ci->multilevels->build();

}


function getFeed($feed_url)
{

    $content = file_get_contents($feed_url);
    if (!empty($content)) {

        $x = new SimpleXmlElement($content);

        $feeds = array();
        foreach ($x->channel->item as $entry) {
            array_push($feeds, $entry);
        }

        return $feeds;
    }
}

if(file_exists(dirname(__FILE__)."/../views/".get_template_directory(true) . 'shortcode_function.php')){
    include_once dirname(__FILE__)."/../views/".get_template_directory(true) . 'shortcode_function.php';
}