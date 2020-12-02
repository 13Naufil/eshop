<div class="container-fluid dept_bg">
    <div class="container">
        <h3>Departments</h3>
        <?php
        $_where = " AND parent_id='0' AND include_in_menu=1 AND status='Active' ORDER BY ordering ASC";
        $_main_cats = $this->db->query("SELECT * FROM `categories` WHERE 1 " . $_where)->result();
        if (count($_main_cats) > 0) {
            foreach ($_main_cats as $category) {
                $_url = $category->friendly_url . get_option('url_ext');
                echo '<div class="col-sm-3">
                        <div class="dept_name"><a href="'.site_url($_url).'">'.$category->title.'</a></div>
                    </div>';
            }
        }
        ?>
    </div>



    <!-- Beauty Bay Collective -->
    <?php echo $this->cms->get_block('beauty-bay');?>
</div>

<div class="gap"></div>