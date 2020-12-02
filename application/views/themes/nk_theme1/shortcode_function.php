<?php
/**
 * Naufil khan
 * Email: developer.systech@gmail.com
 */

//////////////////////////////////////////////////////////////////
// Get Site URL
//////////////////////////////////////////////////////////////////
add_shortcode('site_url', 'site_url');
add_shortcode('asset_url', 'asset_url');
add_shortcode('template_url', 'template_url');
add_shortcode('base_url', 'base_url');

//////////////////////////////////////////////////////////////////
// Get Option
//////////////////////////////////////////////////////////////////
add_shortcode('option', 'get_option_value');
function get_option_value($atts, $content = null) {

    $ci =& get_instance();
    extract(shortcode_atts(array(
    		'name' => '',
    		'number_format' => '',
    	), $atts));

    if($atts['number_format'] == true){
        $_option_val = number_format(get_option($atts['name']));
    }else{
        $_option_val = get_option($atts['name']);
    }
    $html = $_option_val;

	return $html;
}

//////////////////////////////////////////////////////////////////
// Include File
//////////////////////////////////////////////////////////////////
add_shortcode('include', 'shortcode_include_file');
function shortcode_include_file($atts, $content = null) {
	$ci =& get_instance();

    if(file_exists(get_template_directory() . $atts['file'])){
        $html = $ci->load->view(get_template_directory(true). $atts['file'] , array(), true);
    }else{
        $html = $atts['file'] . ' File not found';
    }

    $html .= do_shortcode($content);
	return $html;
}


/*-------------------------------Emd GSDCP schortcodes------------------------------------------------*/