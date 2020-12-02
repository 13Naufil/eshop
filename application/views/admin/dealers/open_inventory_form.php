<?php
/**
 * Naufil khan
 * E: developer.systech@gmail.com
 * P: +923472565746
 * S: naufil_khan13@hotmail.com
 */
$form_btns = array('save', 'reset', 'back');
?>
<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3>
            <?php echo getModuleDetail()->module_icon; ?> Opening Inventory
            <?php echo $this->module_title; ?>
            <small>Listing product of <?php echo $this->module_title; ?> opening inventory.</small>
        </h3>
    </div>
</div>
<!-- /page header -->

<?php
include dirname(__FILE__) . "/../includes/breadcrumb.php";
?>

<?php
echo show_validation_errors();
?>
<style>
    ._table-controls{
        text-align: center;
    }
    ._table-controls .btn,.btn-add{
        padding: 7px 2px 7px 12px;
    }

</style>
<!-- START -->
<form id="validate" class="form-horizontal validate"
      action="<?php echo admin_url($this->module_route . (!empty($row->id) ? '/update/' . $row->id : '/add')); ?>"
      method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" class="id" value="<?php echo $row->id; ?>"/>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-bubble4"></i>
                <?php echo $dealer->business_name; ?>
            </h6>
        </div>
        <?php
        //echo get_form_actions($form_btns);
        ?>
        <div class="panel-body">


            <div class="form-group table-list">
                <div class="col-sm-12">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Item name</th>
                                <th width="100">Quantity</th>
                                <!--<th width="120">Item Price</th>
                                <th>Total</th>-->
                                <th width="100" class="text-center">
                                    <a href="#" class="btn btn-info btn-add tip" title="" data-original-title="Add New"><i class="icon-plus"></i></a>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="product-list">
                            <?php
                            if(count($opening_inventory) == 0){
                                $opening_inventory[] = new stdClass();
                            }
                            $subtotal = $tax_amount = $total_amount = 0;
                            foreach($opening_inventory as $ord){

                                /*$ord->qty = (!empty($ord->qty) ? $ord->qty : 1);
                                $subtotal += ($ord->price * $ord->qty);
                                $tax_amount += ((($ord->price * $ord->tax) / 100) * $ord->qty);*/
                                ?>
                                <tr pid="" class="clone">
                                    <td>
                                        <input type="hidden" name="dtl_ids[]" id="dtl_ids" value="<?php echo $ord->id; ?>" />
                                        <input  name="product_ids[]" id="product_ids" value="<?php echo $ord->product_id; ?>" product_name="<?php echo $ord->product_name; ?>" class="select-ajax" href="<?php echo admin_url('pos/AJAX/search');?>" />
                                    </td>
                                    <td align="center">
                                        <input type="text" name="qty[]" value="<?php echo $ord->qty; ?>" class="_qty form-control validate[required,custom[integer]]"/>
                                    </td>
                                    <!--<td>
                                        <input type="hidden" name="tax[]" value="<?php /*echo $ord->tax; */?>" class="_tax"/>
                                        <input type="hidden" name="tax_amount[]" value="<?php /*echo (($ord->price * $ord->tax) / 100); */?>" class="_tax_amount"/>
                                        <input type="text" name="price[]" value="<?php /*echo $ord->price; */?>" class="_price col-sm-12 form-control validate[required,custom[number]]"/>
                                    </td>
                                    <td align="center"><strong class="unit_total_price"><?php /*echo number_format($ord->price * $ord->qty,2); */?></strong></td>-->
                                    <td>
                                        <div class="_table-controls">
                                            <a href="#" class="btn btn-success btn-save tip" title="" data-original-title="Save"><i class="icon-disk"></i></a>
                                            <a href="#" class="btn btn-info btn-add tip" title="" data-original-title="Add New"><i class="icon-plus"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?
                            }
                            //$total_amount = ($subtotal + $tax_amount);
                            ?>

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>

        </div>
    </div>

</form>

<?php include dirname(__FILE__) . "/../includes/order_js.php"; ?>
<script>
    (function ($) {
        $(document).on('click', '.btn-save', function (e) {
            e.preventDefault();
            var tr = $(this).parents('tr');

            var product_id = tr.find('[name^=product_id]').val();
            var qty = tr.find('._qty').val();
            var price = tr.find('._price').val();
            var warehouse_id = tr.find('[name^=warehouse]').val();
            var dtl_id = tr.find('[name^=dtl_ids]').val();

            $.ajax({
                type: "POST",
                url: "<?php echo admin_url($this->module_route.'/AJAX/save_inventory')?>",
                dataType: 'json',
                data: {product_id: product_id, qty: qty, price: price, warehouse_id: warehouse_id, dealer_id: '<?php echo $dealer->id;?>', dtl_id: dtl_id},
                complete: function (data) {
                    var json = $.parseJSON(data.responseText);
                    console.log(json);
                    if(json.status == 'success'){
                        tr.find('[name^=dtl_ids]').val(json.dtl_id);
                        $.jGrowl('Succesfully saved!', { sticky: true, theme: 'growl-success', header: 'Success!' });
                    }else{
                        $.jGrowl('Error ocured!', { sticky: true, theme: 'growl-error', header: 'Error!' });
                    }
                }
            });
        });
    })(jQuery)
</script>