<?php
if(count($sub_categories) > 0){
?>
<div class="row category-block">
    <div class="col-sm-12">
        <strong>Categories: </strong>
        <ul class="brand-category-list">
            <?php
            foreach ($sub_categories as $sub_category) {
                $sub_category = array2object($sub_category);
                echo '<li><a href="'.site_url($parent_url . $sub_category->friendly_url . get_option('url_ext')).'">'.$sub_category->title.'</a></li>';
            }
            ?>
        </ul>
    </div>
</div>
<?php } ?>