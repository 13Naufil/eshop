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

<!-- START -->
<form id="validate" class="form-horizontal validate"
      action="<?php echo admin_url($this->module_route . (!empty($row->id) ? '/update/' . $row->id : '/add')); ?>"
      method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" class="id" value="<?php echo $row->id; ?>"/>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-bubble4"></i>
                <?php echo $this->module_title; ?> - Form
            </h6>
        </div>
        <?php
        echo get_form_actions($form_btns);
        ?>
        <div class="panel-body">

            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Promotion type : <span
                        class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <select name="coupon_type" id="coupon_type" class="select validate[required]">
                        <?=selectBox(get_enum_values($this->table, 'coupon_type'),$row->coupon_type); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Coupon Name : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="coupon_name" id="coupon_name" class="form-control  validate[required]" value="<?php echo $row->coupon_name ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Coupon Code : <span class="mandatory">*</span></label>

                <div class="col-sm-7">
                    <input type="text" name="coupon_code" id="coupon_code" class="form-control  validate[required]" value="<?php echo $row->coupon_code ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Discount Type : </label>

                <div class="col-sm-4">
                    <select name="discount_type" id="discount_type" class="select-full">
                        <?php echo selectBox(get_enum_values($this->table, 'discount_type'),$row->discount_type);?>
                    </select>
                </div>
                <label class="col-sm-2 control-label text-right">Discount : <span class="mandatory">*</span></label>

                <div class="col-sm-4">
                    <input type="text" name="discount" id="discount" class="form-control  validate[required,custom[number]]" value="<?php echo $row->discount ?>"/>
                </div>
            </div>

            <div class="form-group has-danger">
                <label class="col-sm-2 control-label text-right">Total Amount : <span class="mandatory">*</span></label>

                <div class="col-sm-2">
                    <input type="text" name="total_amount" id="total_amount" class="form-control  validate[required,custom[number]]" value="<?php echo $row->total_amount ?>"/>
                </div>
                <div class="clearfix"></div>
                <div class="control-label col-sm-2 ">&nbsp;</div>
                <div class="col-sm-10 help-block">This promotion apply on above amount.</div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Start Date : </label>

                <div class="col-sm-2">
                    <input type="text" name="start_date" id="start_date" class="form-control  medium datepicker" value="<?php echo $row->start_date ?>"/>
                </div>
                <label class="col-sm-4 control-label text-right">End Date : </label>

                <div class="col-sm-2">
                    <input type="text" name="end_date" id="end_date" class="form-control  medium datepicker" value="<?php echo $row->end_date ?>"/>
                </div>
            </div>
            <!--<div class="form-group">
                <label class="col-sm-2 control-label text-right">Customer Type : </label>

                <div class="col-sm-7">
                    <select name="customer_type" id="customer_type" class="select ">
                        <option value="">-- Select --</option>
                         <?/*=selectBox("select * from customer_type",$row->customer_type);*/?>
                    </select>
                </div>
            </div>-->
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Free Shipping : </label>

                <div class="col-sm-7">
                    <select name="free_shipping" id="free_shipping" class="select ">
                        <?php echo selectBox(get_enum_values($this->table, 'free_shipping'),$row->free_shipping);?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Usage Policy : </label>

                <div class="col-sm-7">
                    <select name="usage_policy" id="usage_policy" class="select ">
                        <?php echo selectBox(get_enum_values($this->table, 'usage_policy'),$row->usage_policy);?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Usage Limit : <span class="mandatory">*</span></label>

                <div class="col-sm-2">
                    <input type="text" name="usage_limit" id="usage_limit" class="form-control  validate[required,custom[integer]]" value="<?php echo $row->usage_limit ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">No Used : <span class="mandatory">*</span></label>

                <div class="col-sm-2">
                    <input disabled type="text" name="no_used" id="no_used" class="form-control  validate[required,custom[integer]]" value="<?php echo $row->no_used ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label text-right">Status : </label>

                <div class="col-sm-7">
                    <select name="status" id="status" class="select ">
                        <?php echo selectBox(get_enum_values($this->table, 'status'),$row->status);?>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <div class="form-actions text-right well">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn">Reset</button>
    </div>
</form>

<script>
    (function ($) {
        $(document).ready(function () {
            $(document).on('change', '#coupon_type', function () {
                var coupon_type = $(this).val();
                if(coupon_type == 'Coupon'){
                    $('#coupon_code').attr('disabled', false).parents('.form-group').show();
                }else{
                    $('#coupon_code').attr('disabled', true).parents('.form-group').hide();
                }
            });
            $('#coupon_type').trigger('change');

            $(document).on('change', '#usage_policy', function () {
                var usage_policy = $(this).val();
                if(usage_policy == 'Limited'){
                    $('#usage_limit').attr('disabled', false).parents('.form-group').show();
                }else{
                    $('#usage_limit').attr('disabled', true).parents('.form-group').hide();
                }
            });
            $('#usage_policy').trigger('change');
        });
    })(jQuery)
</script>