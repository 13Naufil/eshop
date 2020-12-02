<!--<h4>FILTER BY</h4>-->
<form action="" method="get" class="product-filter-form">
    <?php
    $filters = getVar('filter', true, false);

    if (count($filtering_attributes) > 0) {


        echo '<div class="panel-group product-filter" id="accordion" role="tablist" aria-multiselectable="true">';
        foreach ($filtering_attributes as $k => $listing_attr) {

            echo '<div class="panel panel-default">';
            echo '<div class="panel-heading" role="tab" id="heading-' . $k . '">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" href="#collapse-' . $k . '" aria-expanded="true" aria-controls="collapse-' . $k . '">
                    ' . $listing_attr[0]->attr_label . '
                </a>
            </h4>
        </div>';

            echo '<div id="collapse-' . $k . '" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-' . $k . '">';
            ?>
            <div class="panel-body">
                <?php
                if (count($listing_attr) > 0) {
                    echo '<ul>';
                    foreach ($listing_attr as $attr_val) {
                        //$search_val = ($attr_val->attr_value_id > 0 ? $attr_val->attr_value_id : $attr_val->attr_value);
                        $search_val = ($attr_val->attr_value);
                        if (in_array(strtolower($listing_attr[0]->attr_label), array('color'))) {
                            echo '<li class="color-box">';
                            //echo '<a title="' . $attr_val->attr_value . '" style="background-color: ' . $attr_val->attr_value . '" href="' . generate_url('') . '">';
                            echo '<span class="color-'.url_title($attr_val->attr_value).'" title="' . $attr_val->attr_value . '" style="background-color: ' . $attr_val->attr_value . '">';
                            echo '<input type="checkbox" class="attribute" name="filter[' . $attr_val->type . '][' . $attr_val->id . '][]" value="' . $search_val . '" '._checkbox($filters[$attr_val->type][$attr_val->id],$attr_val->attr_value).'>
                            </span></li>';
                        } else {
                            echo '<li>';
                            echo '<label class="checkbox-inline checkbox-success"> <input type="checkbox" class="attribute styled" name="filter[' . $attr_val->type . '][' . $attr_val->id . '][]" value="' . $search_val . '" '._checkbox($filters[$attr_val->type][$attr_val->id],$attr_val->attr_value).'>';
                            //echo '<a title="'.$attr_val->attr_value.'" href="'.generate_url('').'">'.$attr_val->attr_value.' ('.number_format($attr_val->total_count).')</a>';
                            //echo '' . $attr_val->attr_value . ' (' . number_format($attr_val->total_count) . ')';
                            echo '' . $attr_val->attr_value;
                            echo '</label></li>';
                        }
                    }
                    echo '</ul>';
                }

                ?>
            </div>
            <?
            echo '</div>';
            //echo $listing_attr->attr_label . ' - ' . $listing_attr->attr_value . '<br/>';
            echo '</div>';
        }
        echo '</div>';


    }
    ?>
</form>
