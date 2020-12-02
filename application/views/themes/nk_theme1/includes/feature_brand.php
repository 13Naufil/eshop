<div class="gap"></div>
<div class="container f_brands">
    <h3>Featured Brands</h3>
    <div class="carousel">
    <?php
    $_where = " AND status='Active' AND index_slider=1";
    $_brands = $this->db->query("SELECT * FROM `brands` WHERE 1 " . $_where)->result();
    if (count($_brands) > 0) {
        foreach ($_brands as $brand) {
            $_url = $brand->friendly_url . get_option('url_ext');
            echo '<div class="col-sm-3 carousel-cell"><div class="brand text-center"><a href="'.site_url($_url).'"><img class="img-responsive" src="'._img('assets/front/brands/' . $brand->logo, 500, 200).'" alt="'.$brand->title.'"></a></div></div>';
        }
    }
    ?>
    </div>
</div>
<div class="gap"></div>

