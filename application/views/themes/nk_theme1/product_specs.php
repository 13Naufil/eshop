<?php
if (count($attributes) > 0) {
    $attr_label = $set_title = '';
    echo '<ul class="specs">';
    foreach ($attributes as $i => $attr) {
        if($attr->is_visible_on_front != 'Yes') continue;
        if ($set_title != $attr->set_title && $i > 0 || (($i) == count($attributes))) {
            echo '</ul></li>';
        }

        if ($set_title != $attr->set_title) {
            $set_title = $attr->set_title;

            echo '<li class="specs-item">';
            //echo '<h4 class="specs-head">' . $attr->set_title . '</h4>';
            echo '<ul class="specs-details" tabindex="0">';
        }

        echo '<li class="specs-detail">';
        echo '<strong>' . $attr->attr_label . ' : </strong><span>' . $attr->attr_value . '</span>';
        echo '</li>';


    }
    echo '</ul>';
}
?>