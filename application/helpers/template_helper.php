<?php
/**
 * Naufil khan
 * Email: developer.systech@gmail.com
 */
/**
 * @property Catalog $catalog;
 */

function top_event(){
    $ci = & get_instance();
    $row = $ci->db->get_where('events', array('status' => 'Active', 'current' => '1'))->row();
    return $row;
}

function get_theme_templates()
{
    $page_temp = array();
    foreach (glob(get_template_directory() . '/page*.php') as $item) {

        $page_name = str_replace('.php', '', end(explode('/', $item)));
        $page_temp[$page_name] = ucwords(str_replace(array('-', '_'), array(' ', ' '), $page_name));
    }

    return $page_temp;
    return array(
        //'contact' => 'Contact Us',
        /*'100-width' => '100% Width',
        'blank' => 'Blank Page',
        'faqs' => 'FAQs',
        'full-width' => 'Full Width',*/
    );
}

function create_product_menu($menu_item, $selected = '', $html = ''){
        
    if(preg_match('/^#product/i', $menu_item['friendly_url'])){

        $_search = array('li-menu-' . $menu_item['id'], 'menu-item-' . $menu_item['id'], "id='menu-".$menu_item['id']."'", $menu_item['menu_title'] . '</a>');
        $_replace = array('dropdown yamm menu-product li-menu-' . $menu_item['id'], 'dropdown-toggle  menu-item-' . $menu_item['id'], "id='menu-".$menu_item['id']."' data-toggle='dropdown' ", $menu_item['menu_title'] . '<span class="caret"></span></a>');

        $html = str_ireplace($_search, $_replace, $html);
        $ci = & get_instance();

        //$_brands = $ci->catalog->get_brands();

        ob_start();
        ?>
        <ul class="dropdown-menu mega-dropdown-menu">
            <li>
            <div class="yamm-content">
                <div class="row">
                <div class="col-sm-4 cat-menu">
                <?php
                //foreach($_brands as $brand)
                $_where = " AND parent_id=0 AND include_in_menu=1 ORDER BY ordering ASC";
                $_categories = $ci->catalog->get_categories($_where);

                $i = 0;
                $p = 0;
                $VIEW_product = $NAV_Products = '';
                if (count($_categories) > 0) {
                    foreach ($_categories as $category) {
                        $i++;
                        $category = array2object($category);

                        $NAV_Products .= '<div id="nav-product-' . $category->id . '" style="display: ' . ($i == 1 ? 'block' : 'none') . ';">';
                        $products = $ci->catalog->get_products("AND product_cat_rel.category_id='{$category->id}'");

                        if(count($products) > 0){
                            foreach ($products as $product) {
                                $p++;
                                $product_url = $category->friendly_url . '/' . $product->friendly_url . get_option('url_ext');
                                $NAV_Products .= '<a data-product_id="'.$product->id.'" href="' . site_url($product_url) . '">' . trim($product->name) . '</a>';

                                $VIEW_product .= '<div class="menu-product" id="v-m-p-' . $product->id . '" style="display: ' . ($p == 1 ? 'block' : 'none') . ';">
                                <a href="' . site_url($product_url) . '">
                                    <img src="' . _img('assets/front/products/' . $product->feature_image,220,220) . '" alt="'.$product->name.'"/>
                                    <h3 class="text-center">'.$product->name.'</h3>
                                    <p class="text-center">'.$product->short_text.'</p>
                                    <p class="text-center text-uppercase text-blue">Learn More.</p>
                                </a>
                                </div>';
                            }
                        }
                        $NAV_Products .= '</div>';

                        //$sub_categories = $ci->catalog->get_categories(" AND parent_id='{$category->id}' AND include_in_menu=1 ");
                        ?>
                        <a data-cat_id="<?php echo $category->id; ?>" href="<?php echo site_url($category->friendly_url . get_option('url_ext')); ?>">
                            <img src="<?php echo asset_url('admin/img/' . $category->icon);?>" alt="<?php echo $category->title; ?>" class="pull-left">
                            <?php echo $category->title; ?>
                        </a>
                        <?php
                    }
                }
                ?>
                </div>
                <div class="col-sm-4 product-menu"> <?php echo $NAV_Products;?> </div>
                <div class="col-sm-4 product-menu-view"><?php echo $VIEW_product;?></div>
            </div>
        </div>
        </li>
        </ul>
        <?
        $html .= ob_get_clean();
    }
    return $html;
}

/**
 * @param $product_id
 */
function get_product_rating($product_id){
    $ci = & get_instance();
    $product_rating = $ci->catalog->get_product_reviews_rating($product_id);
    return $product_rating['product_ratting'];
}

/**
 * @param $product_id
 */
function get_product_url($product){
    $ci = & get_instance();
    if (IS_BRAND) {
        $brands = $ci->catalog->get_brands("AND id=" . intval($product->brand_id));
        $data['brand'] = $brands[0];
    }

    $_product_cats = explode(',', $product->catagories_ids);
    $_cat_id = end($_product_cats);
    $data['category'] = $ci->db->get_where('categories', array('id' => $_cat_id), 1)->row();

    $_parent_cats = array();
    $ci->catalog->get_parent_categories($_cat_id, $_parent_cats,1);
    $data['parent_categories'] = $_parent_cats;

    $parent_url = get_parent_url($data);

    return $parent_url . $product->friendly_url . get_option('url_ext');
}

function get_parent_url($data){

    $parent_cat_url = '';
    if (count($data['parent_categories']) > 0) {
        foreach ($data['parent_categories'] as $parent_cat) {
            $parent_cat_url .= $parent_cat->friendly_url . '/';
        }
        $parent_cat_url .= $data['category']->friendly_url . '/';

        $_cat_url = $data['brand']->friendly_url . '/' . $parent_cat_url;
    }elseif($data['category']){
        $_cat_url = $data['brand']->friendly_url . '/' . $data['category']->friendly_url . '/';
    }else{
        $_cat_url = $data['brand']->friendly_url . '/';
    }
    return $_cat_url;

}


function get_lat($address,$col){

    $lat_lang = getLatLng($address);
    if($col == 'lat')
        return $lat_lang->lat;
    else{
        return $lat_lang->lng;
    }
}

function get_cities($city = 'Karachi', $data = array()){

    $html = '';
    /*$html .='<option value="Karachi">Karachi</option>
            <option value="Lahore">Lahore</option>
            <option value="Islamabad">Islamabad</option>
            <option value="Rawalpindi">Rawalpindi</option>
            <option disabled="">-----</option>';*/

    $html .=selectBox('SELECT city, city AS city_name FROM cities ORDER BY `city`', $city);
    return $html;
}