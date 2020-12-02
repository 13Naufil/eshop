<?php
$_configurable_attrs = $this->catalog->get_product_attributes($product->id, "AND attributes.used_in_configurable='Yes' AND attributes.frontend_input IN('select', 'multiselect')");
if (count($_configurable_attrs) > 0) {
    if($row->id > 0){
        $config_attrs = $this->db->query("SELECT attributes.id
        , attributes.admin_label as value
        FROM product_configurable_rel
        INNER JOIN attributes ON attributes.id = product_configurable_rel.attr_id
        WHERE 1 AND product_configurable_rel.product_id='{$row->id}'
        GROUP BY attributes.id")->result();

        $where = '';
        $_config_attrs = array();
        $_custom_func = array();
        if (count($config_attrs) > 0) {
            foreach ($config_attrs as $_attr) {
                $_config_attrs[$_attr->id] = $_attr->value;
            }
            $where .= " AND attributes.id IN(" . join(',', array_keys($_config_attrs)) . ")";
        }
    }

    ?>
    <div class="associated_products-block">
    <?
    foreach ($_configurable_attrs as $_attrs) {
        ?>
        <div class="col-sm-3 configurable-attrs">
            <label class="checkbox-inline checkbox-success">
              <input type="checkbox" <?php echo _checkbox($_config_attrs[$_attrs->id], $_attrs->attr_label);?> class="styled" name="config_attrs[<?php echo $_attrs->id;?>]" value="<?php echo $_attrs->attr_label;?>"> <?php echo $_attrs->attr_label;?>
            </label>
        </div>
        <?php
    }
    ?>
        <div class="form-group ">
            <div class="col-sm-4 col-sm-offset-4">
                <button class="btn btn-success srearch-product">Search Products</button>
            </div>
        </div>
    </div>
    <div class="associated-products-container">
        <?php
        if($row->id > 0) {

            $SQL = "SELECT
          CONCAT(\"<label class='-checkbox-inline'><input type='checkbox' name='assoc_products[]' value='\", products.id ,\"' \", IF(product_configurable_rel.product_id IS NOT NULL, 'checked', '') ,\" class='styled'></label>\") AS `check`
          , products.id
          , products.name
          , products.SKU
          , products.price
          , products.is_in_stock";

            foreach ($_config_attrs as $attr_id => $_attr) {
                $_attr = url_title($_attr, '_');
                $_custom_func[$_attr] = 'attr_value_field';
                $SQL .= " , $attr_id AS '" . $_attr . "'";
            }

            $SQL .= " FROM products
          INNER JOIN product_attributes_rel ON product_attributes_rel.product_id = products.id
          INNER JOIN attributes ON attributes.id = product_attributes_rel.attribute_id
          INNER JOIN attributes_option_values_rel ON attributes_option_values_rel.attribute_id = product_attributes_rel.attribute_id AND product_attributes_rel.attr_value_id=attributes_option_values_rel.attr_value_id
          LEFT JOIN product_configurable_rel ON attributes.id = product_configurable_rel.attr_id
          WHERE 1 {$where}
          GROUP BY products.id";
echo '<pre>';print_r($SQL);echo '</pre>';
            $grid = new grid();
            $grid->query = $SQL;
            $grid->title = ' Associated Products';
            $grid->limit = 999999;
            $grid->sorting = false;
            $grid->search_box = false;
            $grid->selectAllCheckbox = false;
            $grid->search_box = false;
            $grid->show_paging_bar = false;

            $grid->id_field = $this->id_field;
            $grid->custom_func = $_custom_func;

            $grid->center_fields = array('ordering', 'status','check');

            echo '<div class="table-responsive"><table class="xgrid table table-bordered table-checks table-striped">';
            echo $grid->getTHead();
            echo $grid->getTBody();
            echo '</table></div>';
        }
        ?>
    </div>


    <script>
        (function ($) {

            $(document).ready(function () {

                $(document).on('click', '.srearch-product', function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: module_route_url + '/AJAX/associated_products',
                        dataType: 'json',
                        data: $('select,input','.configurable-attrs').serialize(),
                        complete: function (data) {
                            var json = $.parseJSON(data.responseText);
                            console.log(json);
                            $('.associated-products-container').html(json.html);

                            //$(".validate").validationEngine();
                        }
                    });

                });
            });
        })(jQuery)
    </script>
    <?php
}
?>


