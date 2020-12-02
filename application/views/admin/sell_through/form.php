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
            <?php echo getModuleDetail()->module_icon; ?>
            <?php echo $this->module_title; ?>
            <small>Listing of <?php echo $this->module_title; ?>.</small>
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
    .table-controls .btn,.btn-add{
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
                <?php echo $this->module_title; ?> - Form <?php if($row->id > 0) { ?>(Invoice #: <?php echo $row->invoice_num; ?>) <?php } ?>
            </h6>
        </div>
        <?php
        echo get_form_actions($form_btns);
        echo '<pre>';print_r($row);echo '</pre>';
        ?>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Dealer : <span class="mandatory">*</span></label>

                <div class="col-sm-10">
                    <select name="customer_id" id="customer_id" class="select-search validate[required]">
                        <option value="">-- Select --</option>
                        <?php echo selectBox("SELECT id, business_name FROM dealers WHERE status='Active'",$row->customer_id); ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Transaction Date : <span class="mandatory">*</span></label>

                <div class="col-sm-2">
                    <input type="text" name="transaction_date" id="transaction_date" class="form-control  validate[required]  datepicker" readonly value="<?php echo $row->transaction_date ?>"/>
                </div>
            </div>


            <div class="form-group table-list">
                <div class="col-sm-12">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Item name</th>
                                <th width="100">Quantity</th>
                                <th width="35%">Product IMEI</th>
                                <th width="100" class="text-center">
                                    <a href="#" class="btn btn-success btn-add tip" title="" data-original-title="Add New"><i class="icon-plus"></i></a>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="product-list">
                            <?php
                            if(count($order_detail) == 0){
                                $order_detail[] = new stdClass();
                            }
                            $subtotal = $tax_amount = $total_amount = 0;
                            foreach($order_detail as $ord){

                                ?>
                                <tr pid="" class="clone">
                                    <td>
                                        <input type="hidden" name="dtl_ids[]" id="dtl_ids" value="<?php echo $ord->id; ?>" />
                                        <input  name="product_ids[]" id="product_ids" value="<?php echo $ord->product_id; ?>" product_name="<?php echo $ord->product_name; ?>" class="select-ajax" href="<?php echo admin_url('pos/AJAX/search');?>" />
                                    </td>
                                    <td align="center">
                                        <input type="text" name="qty[]" value="<?php echo $ord->qty; ?>" class="_qty form-control validate[required,custom[integer]]"/>
                                    </td>
                                    <td>
                                        <input type="text" name="IMEI[]" value="<?php echo $ord->IMEI; ?>" class="_IMEI form-control" placeholder="Comma separated IMEI numbers"/>
                                    </td>
                                    <td>
                                        <div class="table-controls">
                                            <a href="#" class="btn btn-success btn-add tip" title="" data-original-title="Add New"><i class="icon-plus"></i></a>
                                            <a href="#" class="btn btn-danger btn-delete tip" title="" data-original-title="Delete"><i class="icon-remove"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?
                            }

                            ?>

                            </tbody>
                        </table>
                    </div>
                    <br/>


                </div>
            </div>

        </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>

<script type="text/javascript">
    (function ($) {
        function recall_select(select_obj){
            select_obj.select2({
                placeholder: "Enter at least 2 character",
                minimumInputLength: 2,
                width: "100%",
                ajax: {
                    url: '<?php echo site_url('order/AJAX/search');?>',
                    dataType: 'json',
                    quietMillis: 250,
                    data: function (term, page) {
                        return {
                            term: term
                        };
                    },
                    results: function (data, page) {
                        return {
                            results: $.map(data, function (item) {

                                return {
                                    text: item.label,
                                    slug: item.value,
                                    id: item.id,
                                    product: item.product
                                }
                            })
                        };
                    },
                    cache: true
                }
                ,initSelection: function (element, callback) {
                    callback({ id: element.attr('value'), text: element.attr('product_name') });
                }
            }).on("select2-selecting", function (e) {
                var tr = $(e.target).parents('tr');
                /*tr.find('._tax').val(e.object.product.custom_tax);
                tr.find('input._price').val(e.object.product.price);
                tr.find('span._price').html(e.object.product.price);*/

            });
        }

        recall_select($('.select-ajax'));
        $(".select-box").select2({
            minimumResultsForSearch: "-1",
            width: '100%'
        });
        /* ------------ Clone ------------- */
        $(document).on('click', '.btn-add', function (e) {
            e.preventDefault();
            var tr = $('#product-list tr.clone:last');
            $('#product-list').append(tr.clone());

            var clone = $('#product-list tr.clone:last');
            clone.find('#dtl_ids,#product_ids,input._price,._qty,._tax_amount,._IMEI').val('');
            clone.find('.unit_total_price,span._price').html('0');
            clone.find('.select2-container,.select2-focusser').remove();
            clone.find('.select2-offscreen').removeClass('select2-offscreen');

            clone.find(".select-box").select2({
                minimumResultsForSearch: "-1",
                width: '100%'
            });

            recall_select(clone.find('.select-ajax'));

            calculate_amount();
        });

        /* ------------ calculate_amount ------------- */
        function calculate_amount(){
            var subtotal = 0;
            var total_tax = 0;
            var total_amount = 0;

            $('#product-list tr').each(function () {
                var tr = $(this);

                var qty = parseInt(tr.find('._qty').val());
                qty = ((isNaN(qty)) ? 0 : qty);

                var price = parseFloat(tr.find('input._price').val());
                price = ((isNaN(price)) ? 0 : price);

                var tax = parseFloat(tr.find('select._tax').val());
                tax = (isNaN(tax) ? 0 : tax);
                var _tax_amount = parseFloat(qty * ((price * tax) / 100));
                tr.find('._tax_amount').val(_tax_amount);

                total_tax += _tax_amount;
                subtotal += parseFloat(qty * price);

                total_amount = parseFloat(subtotal + total_tax);
            });

            $('.subtotal').html(numeral(subtotal).format());
            $('.total-tax').html(numeral(total_tax).format());
            $('.total-amount').html(numeral(total_amount).format());
        }
        /* ------------ calculate_amount ------------- */


        $(document).on('keyup', '._qty', function () {

            var tr_row = $(this).parents('tr');
            var _qty = parseInt(tr_row.find('._qty').val());
            _qty = ((isNaN(_qty)) ? 0 : _qty);

            var _price = parseFloat(tr_row.find('input._price').val());
            _price = ((isNaN(_price)) ? 0 : _price);

            tr_row.find('.unit_total_price').html(numeral((_qty) * _price).format());

            calculate_amount();
        });
        $(document).on('blur', '._qty,._price', function () {
            var tr = $(this).parents('tr');
            $('._qty', tr).trigger('keyup');
        });


        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var tr = $(this).parents('tr');
            <?php if($row->id > 0){ ?>
            var dtl_id = tr.find('[name^=dtl_ids]').val();
            $('form').append('<input type="hidden" name="del_dtl_ids[]" value="'+dtl_id+'">');
            <? } ?>
            tr.remove();
            calculate_amount();
        });
        /* ------------  ------------- */
    })(jQuery)
</script>